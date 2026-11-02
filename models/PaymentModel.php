<?php

/**
 * PaymentModel - Financial ledger and payment transaction persistence
 * Interacts with payment_transactions and training_registrations
 */
class PaymentModel
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $database = new Database();
            $this->db = $database->getConnection();
        }
    }

    /**
     * Create an initial pending transaction attempt
     */
    public function createTransaction(
        int $applicationId,
        int $programId,
        ?int $cohortId,
        string $reference,
        int $amountKobo,
        string $customerEmail,
        array $metadata = []
    ): int|false {
        $sql = "INSERT INTO `payment_transactions` (
            `application_id`, `program_id`, `cohort_id`, `reference`,
            `amount`, `currency`, `status`, `customer_email`, `metadata`, `created_at`
        ) VALUES (
            :application_id, :program_id, :cohort_id, :reference,
            :amount, 'NGN', 'pending', :customer_email, :metadata, NOW()
        )";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':application_id' => $applicationId,
            ':program_id'     => $programId,
            ':cohort_id'      => $cohortId,
            ':reference'      => $reference,
            ':amount'         => $amountKobo,
            ':customer_email' => $customerEmail,
            ':metadata'       => !empty($metadata) ? json_encode($metadata) : null,
        ]);

        return $result ? (int)$this->db->lastInsertId() : false;
    }

    /**
     * Retrieve transaction row by internal reference
     */
    public function getTransactionByReference(string $reference): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `payment_transactions` WHERE `reference` = ? LIMIT 1");
        $stmt->execute([$reference]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Atomically mark a transaction as successful.
     * Returns true ONLY if this thread transitioned status from pending -> success (idempotency guard).
     */
    public function markTransactionSuccess(
        string $reference,
        ?string $paystackRef = null,
        ?string $channel = null,
        ?string $gatewayResponse = null,
        ?string $paidAt = null
    ): bool {
        $paidTime = $paidAt ? date('Y-m-d H:i:s', strtotime($paidAt)) : date('Y-m-d H:i:s');

        $sql = "UPDATE `payment_transactions` 
                SET `status` = 'success', 
                    `paystack_reference` = :paystack_ref,
                    `channel` = :channel,
                    `gateway_response` = :gateway_resp,
                    `paid_at` = :paid_at
                WHERE `reference` = :reference 
                  AND `status` != 'success'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':paystack_ref' => $paystackRef,
            ':channel'      => $channel,
            ':gateway_resp' => $gatewayResponse,
            ':paid_at'      => $paidTime,
            ':reference'    => $reference
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Mark transaction as failed
     */
    public function markTransactionFailed(string $reference, ?string $gatewayResponse = null): bool
    {
        $sql = "UPDATE `payment_transactions` 
                SET `status` = 'failed', 
                    `gateway_response` = :gateway_resp
                WHERE `reference` = :reference 
                  AND `status` = 'pending'";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':gateway_resp' => $gatewayResponse,
            ':reference'    => $reference
        ]);
    }

    /**
     * Generate standard invoice number for an application
     */
    public function generateInvoiceNumber(int $applicationId): string
    {
        return 'STP-INV-' . date('Ym') . '-' . str_pad((string)$applicationId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update application status to paid with invoice reference
     */
    public function updateApplicationPaymentSuccess(
        int $applicationId,
        string $reference,
        int $amountKobo,
        string $invoiceNumber,
        ?string $paidAt = null
    ): bool {
        $paidTime = $paidAt ? date('Y-m-d H:i:s', strtotime($paidAt)) : date('Y-m-d H:i:s');

        $sql = "UPDATE `training_registrations`
                SET `payment_status` = 'success',
                    `payment_reference` = :reference,
                    `amount_paid` = :amount,
                    `currency` = 'NGN',
                    `invoice_number` = :invoice_number,
                    `paid_at` = :paid_at
                WHERE `id` = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':reference'      => $reference,
            ':amount'         => $amountKobo,
            ':invoice_number' => $invoiceNumber,
            ':paid_at'        => $paidTime,
            ':id'             => $applicationId
        ]);
    }

    /**
     * Record that the invoice email was delivered (send-once guard)
     */
    public function markInvoiceSent(int $applicationId): bool
    {
        $sql = "UPDATE `training_registrations` 
                SET `invoice_sent_at` = NOW() 
                WHERE `id` = :id AND `invoice_sent_at` IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $applicationId]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Fetch complete application details by reference (for callback and invoice views)
     */
    public function getApplicationByReference(string $reference): ?array
    {
        $sql = "SELECT tr.*, 
                       t.training_name, t.training_image, t.training_description,
                       tc.cohort_name, tc.cohort_number, tc.start_date, tc.end_date,
                       pt.channel, pt.gateway_response, pt.paystack_reference, pt.paid_at as tx_paid_at
                FROM `training_registrations` tr
                JOIN `trainings_tb` t ON t.id = tr.program_id
                LEFT JOIN `training_cohorts` tc ON tc.id = tr.cohort_id
                LEFT JOIN `payment_transactions` pt ON pt.reference = tr.payment_reference
                WHERE tr.payment_reference = :reference
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':reference' => $reference]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Fetch complete application details by application ID
     */
    public function getApplicationById(int $id): ?array
    {
        $sql = "SELECT tr.*, 
                       t.training_name, t.training_image, t.training_description,
                       tc.cohort_name, tc.cohort_number, tc.start_date, tc.end_date,
                       pt.channel, pt.gateway_response, pt.paystack_reference, pt.paid_at as tx_paid_at
                FROM `training_registrations` tr
                JOIN `trainings_tb` t ON t.id = tr.program_id
                LEFT JOIN `training_cohorts` tc ON tc.id = tr.cohort_id
                LEFT JOIN `payment_transactions` pt ON pt.reference = tr.payment_reference
                WHERE tr.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Aggregate payment revenue and counts for Admin dashboard
     */
    public function getPaymentSummaryStats(): array
    {
        $stmt = $this->db->query("
            SELECT 
                SUM(CASE WHEN payment_status = 'success' THEN amount_paid ELSE 0 END) AS total_revenue_kobo,
                COUNT(CASE WHEN payment_status = 'success' THEN 1 END) AS total_paid_count,
                COUNT(CASE WHEN payment_status = 'pending' THEN 1 END) AS total_pending_count,
                COUNT(CASE WHEN payment_status = 'failed' THEN 1 END) AS total_failed_count
            FROM `training_registrations`
        ");
        $stats = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'total_revenue_kobo'  => (int)($stats['total_revenue_kobo'] ?? 0),
            'total_revenue_naira' => round(((int)($stats['total_revenue_kobo'] ?? 0)) / 100, 2),
            'total_paid_count'    => (int)($stats['total_paid_count'] ?? 0),
            'total_pending_count' => (int)($stats['total_pending_count'] ?? 0),
            'total_failed_count'  => (int)($stats['total_failed_count'] ?? 0),
        ];
    }
}
