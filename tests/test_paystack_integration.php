<?php
/**
 * Automated Verification Test Suite for Paystack Payment Integration
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/utils/Env.php';
require_once dirname(__DIR__) . '/utils/PaystackService.php';
require_once dirname(__DIR__) . '/utils/InvoiceRenderer.php';
require_once dirname(__DIR__) . '/models/TrainingModel.php';
require_once dirname(__DIR__) . '/models/CohortModel.php';
require_once dirname(__DIR__) . '/models/PaymentModel.php';
require_once dirname(__DIR__) . '/models/AdminModel.php';

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
assertTest("PaystackService::resolveCaBundlePath resolves a valid existing CA bundle file", PaystackService::resolveCaBundlePath() !== null && file_exists(PaystackService::resolveCaBundlePath()));

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

    // 5.8 Test AdminModel Training Store & Payment Gating
    $adminModel = new AdminModel();
    $testTrainingName = "Test Payment Gated Track " . time();
    $insertData = [
        "action_mode" => "store",
        "training_name" => $testTrainingName,
        "training_description" => "Test description for paystack gating",
        "training_details" => "Detailed syllabus",
        "training_icon" => "fas fa-code",
        "show_on_home" => 0,
        "sort_order" => 999,
        "registration_available" => 1,
        "payments_enabled" => 1,
        "payment_amount" => "75000", // 75,000 NGN entered by admin
        "start_date" => date("Y-m-d"),
        "end_date" => date("Y-m-d", strtotime("+30 days")),
        "training_time" => "9am - 1pm",
        "certified_count" => 0
    ];

    $storeRes = $adminModel->storeRecord("training", $insertData);
    assertTest("AdminModel::storeRecord creates training with payments enabled", $storeRes === true);

    $testTrRow = $db->query("SELECT * FROM `trainings_tb` WHERE `training_name` = " . $db->quote($testTrainingName))->fetch(PDO::FETCH_ASSOC);
    $createdTrId = $testTrRow ? (int)$testTrRow["id"] : 0;
    assertTest("Training payments_enabled saved as 1", $testTrRow && (int)$testTrRow["payments_enabled"] === 1);
    assertTest("Training payment_amount saved as 7,500,000 kobo (75,000 NGN)", $testTrRow && (int)$testTrRow["payment_amount"] === 7500000);

    // Test validation failure when enabled with fee <= 0
    $validationFailedAsExpected = false;
    try {
        $invalidData = $insertData;
        $invalidData["id"] = $createdTrId;
        $invalidData["action_mode"] = "update";
        $invalidData["payments_enabled"] = 1;
        $invalidData["payment_amount"] = "0"; // Invalid
        $adminModel->storeRecord("training", $invalidData);
    } catch (Exception $e) {
        $validationFailedAsExpected = (strpos($e->getMessage(), "fee greater than 0 is required") !== false);
    }
    assertTest("AdminModel rejects payments enabled with zero fee", $validationFailedAsExpected === true);

    // Test toggle off preserves saved fee
    $disableData = $insertData;
    $disableData["id"] = $createdTrId;
    $disableData["action_mode"] = "update";
    $disableData["payments_enabled"] = 0; // Disabled
    $disableData["payment_amount"] = "75000"; // Existing fee kept
    $disableRes = $adminModel->storeRecord("training", $disableData);
    assertTest("AdminModel::storeRecord updates training to disabled", $disableRes === true);

    $disabledTrRow = $db->query("SELECT * FROM `trainings_tb` WHERE `id` = {$createdTrId}")->fetch(PDO::FETCH_ASSOC);
    assertTest("Training payments_enabled updated to 0", $disabledTrRow && (int)$disabledTrRow["payments_enabled"] === 0);
    assertTest("Training payment_amount preserved as 7,500,000 kobo while inactive", $disabledTrRow && (int)$disabledTrRow["payment_amount"] === 7500000);

    if ($createdTrId > 0) {
        $db->prepare("DELETE FROM `trainings_tb` WHERE `id` = ?")->execute([$createdTrId]);
    }

    // Cleanup test record
    $db->prepare("DELETE FROM `payment_transactions` WHERE `reference` = ?")->execute([$uniqueRef]);
    $db->prepare("DELETE FROM `training_registrations` WHERE `id` = ?")->execute([$testAppId]);
    echo "[CLEANUP] Test transactions and registrations purged successfully.\n";

} catch (Exception $e) {
    echo "[ERROR] Database test exception: " . $e->getMessage() . "\n";
    $failed++;
}

// --- 6. Test InvoiceRenderer Engine ---
echo "\n--- 6. Testing InvoiceRenderer Engine ---\n";
$issuer = InvoiceRenderer::getIssuerDetails();
assertTest("InvoiceRenderer returns configured issuer name", $issuer['name'] === 'Spider Technologies Limited');
assertTest("InvoiceRenderer returns configured issuer address", strpos($issuer['address'], 'Abinsa House') !== false);
assertTest("InvoiceRenderer returns configured issuer email", $issuer['email'] === 'info@spidertech.com.ng');
assertTest("InvoiceRenderer returns configured issuer phone", $issuer['phone'] === '+234 911 626 5708');

assertTest("InvoiceRenderer::formatNaira formats 5000000 kobo to '₦50,000.00'", InvoiceRenderer::formatNaira(5000000) === '₦50,000.00');
assertTest("InvoiceRenderer::formatNaira HTML entity formats 5000000 kobo to '&#8358;50,000.00'", InvoiceRenderer::formatNaira(5000000, true) === '&#8358;50,000.00');

$mockAppData = [
    'id' => 99,
    'user_data' => json_encode(['first_name' => 'Amina', 'last_name' => 'Bello', 'email' => 'amina@example.com', 'phone' => '08099887766']),
    'training_name' => 'Full-Stack Web Engineering',
    'cohort_name' => 'Cohort 2026-Alpha',
    'start_date' => '2026-04-15',
    'training_time' => '10:00 AM – 02:00 PM',
    'amount_paid' => 4500000,
    'invoice_number' => 'STP-INV-202604-0099',
    'payment_reference' => 'STP_TEST_REF_99',
    'channel' => 'card',
    'paid_at' => '2026-04-01 11:30:00'
];

$normalized = InvoiceRenderer::normalizeData($mockAppData);
assertTest("InvoiceRenderer::normalizeData extracts payer full name", $normalized['payer']['name'] === 'Amina Bello');
assertTest("InvoiceRenderer::normalizeData extracts payer email", $normalized['payer']['email'] === 'amina@example.com');
assertTest("InvoiceRenderer::normalizeData extracts amount_kobo as 4500000", $normalized['amount_kobo'] === 4500000);
assertTest("InvoiceRenderer::normalizeData formats start_date to readable format", $normalized['program']['start_date'] === 'Apr 15, 2026');

$receiptHtml = InvoiceRenderer::renderReceiptHtml($normalized);
assertTest("InvoiceRenderer HTML contains brand orange top accent (#f48221)", strpos($receiptHtml, '#f48221') !== false);
assertTest("InvoiceRenderer HTML contains dark header band (#110f0d)", strpos($receiptHtml, '#110f0d') !== false);
assertTest("InvoiceRenderer HTML contains centered PAYMENT RECEIPT uppercase label", strpos($receiptHtml, 'PAYMENT RECEIPT') !== false);
assertTest("InvoiceRenderer HTML contains summary strip with INVOICE NO.", strpos($receiptHtml, 'INVOICE NO.') !== false);
assertTest("InvoiceRenderer HTML contains restrained PAID badge", strpos($receiptHtml, 'PAID') !== false);
assertTest("InvoiceRenderer HTML contains FROM issuer name", strpos($receiptHtml, 'Spider Technologies Limited') !== false);
assertTest("InvoiceRenderer HTML contains BILLED TO payer name", strpos($receiptHtml, 'Amina Bello') !== false);
assertTest("InvoiceRenderer HTML contains program title and cohort line", strpos($receiptHtml, 'Full-Stack Web Engineering') !== false && strpos($receiptHtml, 'Cohort 2026-Alpha') !== false);
assertTest("InvoiceRenderer HTML contains Totals table with Balance Due ₦0.00", strpos($receiptHtml, 'Balance Due') !== false && strpos($receiptHtml, '0.00') !== false);
assertTest("InvoiceRenderer HTML contains Payment Details audit table with transaction reference", strpos($receiptHtml, 'STP_TEST_REF_99') !== false);
assertTest("InvoiceRenderer HTML contains computer-generated receipt disclaimer", strpos($receiptHtml, 'This is a computer-generated receipt') !== false);

$standaloneHtml = InvoiceRenderer::renderStandalonePage($normalized);
assertTest("InvoiceRenderer standalone page contains print button", strpos($standaloneHtml, 'Print / Save as PDF') !== false);
assertTest("InvoiceRenderer standalone page contains back to programs link", strpos($standaloneHtml, 'Back to Programs') !== false);
assertTest("InvoiceRenderer standalone page contains A4 portrait @page print style", strpos($standaloneHtml, '@page') !== false && strpos($standaloneHtml, 'size: A4 portrait') !== false);

$plainText = InvoiceRenderer::renderPlainText($normalized);
assertTest("InvoiceRenderer plain text contains issuer name", strpos($plainText, 'Spider Technologies Limited') !== false);
assertTest("InvoiceRenderer plain text contains invoice number", strpos($plainText, 'STP-INV-202604-0099') !== false);
assertTest("InvoiceRenderer plain text contains total amount", strpos($plainText, '₦45,000.00') !== false);


echo "\n========================================================\n";
echo "TEST RESULTS: {$passed} PASSED, {$failed} FAILED\n";
echo "========================================================\n";

exit($failed > 0 ? 1 : 0);
