<?php
/**
 * Automated Verification Test Suite for Paystack Payment Integration
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/utils/Env.php';
require_once dirname(__DIR__) . '/utils/PaystackService.php';
require_once dirname(__DIR__) . '/models/TrainingModel.php';
require_once dirname(__DIR__) . '/models/CohortModel.php';
require_once dirname(__DIR__) . '/models/PaymentModel.php';

$passed = 0;
$failed = 0;

function assertTest($description, $condition) {
    global $passed, $failed;
    if ($condition) {
        echo "[PASS] {$description}\n";
        $passed++;
    } else {
        echo "[FAIL] {$description}\n";
        $failed++;
    }
}

echo "========================================================\n";
echo "SPIDER TECH - PAYSTACK PAYMENT INTEGRATION TEST SUITE\n";
echo "========================================================\n\n";

// --- 1. Test Env Loader ---
Env::load(dirname(__DIR__) . '/.env.example');
assertTest("Env loader reads PAYSTACK_CURRENCY as NGN", Env::get('PAYSTACK_CURRENCY') === 'NGN');
assertTest("Env loader returns default value if key not set", Env::get('NON_EXISTENT_KEY_12345', 'default_val') === 'default_val');

// --- 2. Test PaystackService Helpers ---
assertTest("PaystackService::formatKobo formats 2500000 kobo to '₦25,000.00'", PaystackService::formatKobo(2500000) === '₦25,000.00');
assertTest("PaystackService::formatKobo formats 0 kobo to '₦0.00'", PaystackService::formatKobo(0) === '₦0.00');
assertTest("PaystackService::nairaToKobo converts 35000 to 3500000", PaystackService::nairaToKobo(35000) === 3500000);
assertTest("PaystackService::koboToNaira converts 3500000 to 35000.0", PaystackService::koboToNaira(3500000) === 35000.0);

// --- 3. Test HMAC Webhook Signature Verification ---
putenv("PAYSTACK_SECRET_KEY=sk_test_mock_secret_key_12345");
$_ENV['PAYSTACK_SECRET_KEY'] = 'sk_test_mock_secret_key_12345';
$_SERVER['PAYSTACK_SECRET_KEY'] = 'sk_test_mock_secret_key_12345';

$payload = json_encode(['event' => 'charge.success', 'data' => ['reference' => 'TEST_REF_001', 'amount' => 500000]]);
$validSignature = hash_hmac('sha512', $payload, 'sk_test_mock_secret_key_12345');
$invalidSignature = 'fake_signature_abc123';

assertTest("PaystackService validates authentic webhook signature", PaystackService::verifyWebhookSignature($payload, $validSignature) === true);
assertTest("PaystackService rejects forged/tampered webhook signature", PaystackService::verifyWebhookSignature($payload, $invalidSignature) === false);
assertTest("PaystackService rejects empty signature", PaystackService::verifyWebhookSignature($payload, '') === false);

// --- 4. Test Printable Invoice Cryptographic Tokens ---
$testRef = 'STP_8_1_1730000000_abcd';
$invoiceToken = PaystackService::generateInvoiceToken($testRef);
assertTest("PaystackService generates invoice security token", !empty($invoiceToken));
assertTest("PaystackService validates authentic invoice token", PaystackService::validateInvoiceToken($testRef, $invoiceToken) === true);
assertTest("PaystackService rejects forged invoice token", PaystackService::validateInvoiceToken($testRef, 'wrong_token') === false);
assertTest("PaystackService rejects token for mismatched reference", PaystackService::validateInvoiceToken('STP_DIFFERENT_REF', $invoiceToken) === false);

// --- 5. Test Database Ledger & Idempotency ---
try {
    $db = (new Database())->getConnection();
    $trainingModel = new TrainingModel($db);
    $cohortModel = new CohortModel($db);
    $payModel = new PaymentModel($db);

    // 5.1 Test Fee Resolution
    $trainings = $trainingModel->getAllTrainings();
    if (!empty($trainings)) {
        $firstTraining = $trainings[0];
        $eff = $trainingModel->getEffectivePaymentAmount($firstTraining['id']);
        assertTest("Effective payment amount resolves correctly for training", isset($eff['payments_enabled']) && isset($eff['amount_kobo']));
    }

    // 5.2 Test Submission with Payment Metadata
    $testUserData = json_encode([
        'firstname' => 'Test',
        'lastname'  => 'Candidate',
        'email'     => 'test_candidate_' . time() . '@spidertech.com.ng',
        'phone_no'  => '08012345678'
    ]);

    $uniqueRef = 'STP_TEST_' . time() . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
    $testAppId = $trainingModel->submitRegistration(
        $firstTraining['id'] ?? 1,
        $testUserData,
        'training',
        null,
        [
            'payment_status'    => 'pending',
            'payment_reference' => $uniqueRef,
            'amount_paid'       => 0,
            'currency'          => 'NGN'
        ]
    );

    assertTest("Registration successfully saved with payment_status 'pending'", (bool)$testAppId);

    // 5.3 Test Companion Transaction Creation
    $txId = $payModel->createTransaction(
        $testAppId,
        $firstTraining['id'] ?? 1,
        null,
        $uniqueRef,
        2500000,
        'test_candidate@spidertech.com.ng',
        ['note' => 'automated test suite']
    );

    assertTest("Companion transaction record created with ID in payment_transactions", (bool)$txId);

    $txRow = $payModel->getTransactionByReference($uniqueRef);
    assertTest("Transaction retrieved by reference has status 'pending'", $txRow && $txRow['status'] === 'pending');

    // 5.4 Test Atomic Success State Transition (Idempotency)
    $firstSuccess = $payModel->markTransactionSuccess($uniqueRef, 'PAYSTACK_ID_9999', 'card', 'Approved');
    assertTest("First execution of markTransactionSuccess returns TRUE", $firstSuccess === true);

    $secondSuccess = $payModel->markTransactionSuccess($uniqueRef, 'PAYSTACK_ID_9999', 'card', 'Approved');
    assertTest("Subsequent execution of markTransactionSuccess returns FALSE (Idempotent Guard)", $secondSuccess === false);

    // 5.5 Test Application Status Update & Invoice Number Generation
    $invNumber = $payModel->generateInvoiceNumber($testAppId);
    assertTest("Invoice number follows STP-INV-YYYYMM-XXXX format", str_starts_with($invNumber, 'STP-INV-' . date('Ym') . '-'));

    $appUpdated = $payModel->updateApplicationPaymentSuccess($testAppId, $uniqueRef, 2500000, $invNumber);
    assertTest("Application record updated to success with invoice number", $appUpdated === true);

    // 5.6 Test Send-Once Invoice Guard
    $firstSent = $payModel->markInvoiceSent($testAppId);
    assertTest("First markInvoiceSent returns TRUE", $firstSent === true);

    $secondSent = $payModel->markInvoiceSent($testAppId);
    assertTest("Second markInvoiceSent returns FALSE (Send-Once Guard)", $secondSent === false);

    // 5.7 Test Payment Summary Statistics
    $summary = $payModel->getPaymentSummaryStats();
    assertTest("Payment summary stats contains total_revenue_kobo >= 0", isset($summary['total_revenue_kobo']) && $summary['total_revenue_kobo'] >= 0);
    assertTest("Payment summary stats contains total_paid_count >= 1", isset($summary['total_paid_count']) && $summary['total_paid_count'] >= 1);

    // Cleanup test record
    $db->prepare("DELETE FROM `payment_transactions` WHERE `reference` = ?")->execute([$uniqueRef]);
    $db->prepare("DELETE FROM `training_registrations` WHERE `id` = ?")->execute([$testAppId]);
    echo "[CLEANUP] Test transactions and registrations purged successfully.\n";

} catch (Exception $e) {
    echo "[ERROR] Database test exception: " . $e->getMessage() . "\n";
    $failed++;
}

echo "\n========================================================\n";
echo "TEST RESULTS: {$passed} PASSED, {$failed} FAILED\n";
echo "========================================================\n";

exit($failed > 0 ? 1 : 0);
