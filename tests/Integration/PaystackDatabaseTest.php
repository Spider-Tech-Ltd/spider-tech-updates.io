<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Database;
use TrainingModel;
use CohortModel;
use PaymentModel;
use PDO;

class PaystackDatabaseTest extends TestCase
{
    private ?PDO $db = null;

    protected function setUp(): void
    {
        try {
            $this->db = (new Database())->getConnection();
        } catch (\Throwable $e) {
            $this->db = null;
        }

        if (!$this->db instanceof PDO) {
            $this->markTestSkipped('Database connection unavailable for integration test.');
        }
    }

    public function testEffectivePaymentAmountResolution(): void
    {
        $trainingModel = new TrainingModel($this->db);
        $trainings = $trainingModel->getAllTrainings();

        if (empty($trainings)) {
            $this->markTestSkipped('No trainings records present in database.');
        }

        $firstTraining = $trainings[0];
        $eff = $trainingModel->getEffectivePaymentAmount($firstTraining['id']);

        $this->assertArrayHasKey('payments_enabled', $eff);
        $this->assertArrayHasKey('amount_kobo', $eff);
    }

    public function testTransactionCreationAndIdempotency(): void
    {
        $payModel = new PaymentModel($this->db);
        $uniqueRef = 'STP_TEST_' . time() . '_' . substr(bin2hex(random_bytes(3)), 0, 6);

        $txId = $payModel->createTransaction(
            999999, // mock app id
            1,
            null,
            $uniqueRef,
            2500000,
            'test_ci@spidertech.com.ng',
            ['note' => 'CI PHPUnit test']
        );

        $this->assertNotEmpty($txId);

        $txRow = $payModel->getTransactionByReference($uniqueRef);
        $this->assertNotNull($txRow);
        $this->assertSame('pending', $txRow['status']);

        // Test idempotency: First marks success, second returns false
        $firstSuccess = $payModel->markTransactionSuccess($uniqueRef, 'PAYSTACK_ID_9999', 'card', 'Approved');
        $this->assertTrue($firstSuccess);

        $secondSuccess = $payModel->markTransactionSuccess($uniqueRef, 'PAYSTACK_ID_9999', 'card', 'Approved');
        $this->assertFalse($secondSuccess, 'Subsequent execution of markTransactionSuccess must be idempotent');
    }
}
