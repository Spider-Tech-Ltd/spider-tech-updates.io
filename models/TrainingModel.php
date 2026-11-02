<?php

class TrainingModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTrainings() {
        try {
            $query = "SELECT * FROM `trainings_tb`
                      WHERE `show_on_home` = 1
                      ORDER BY sort_order ASC, id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $this->conn->query("SELECT * FROM `trainings_tb` ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getTrainingById($id) {
        $query = "SELECT * FROM `trainings_tb` WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFormFieldsByProgramId($program_id) {
        $query = "SELECT * FROM `training_form_fields` WHERE program_id = ? ORDER BY field_section ASC, field_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$program_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function submitRegistration($program_id, $user_data_json, $type = 'training', $cohort_id = null, array $paymentData = []) {
        $paymentStatus = $paymentData['payment_status'] ?? 'not_required';
        $paymentReference = $paymentData['payment_reference'] ?? null;
        $amountPaid = !empty($paymentData['amount_paid']) ? (int)$paymentData['amount_paid'] : 0;
        $currency = $paymentData['currency'] ?? 'NGN';

        if ($cohort_id) {
            $query = "INSERT INTO `training_registrations` (program_id, cohort_id, user_data, registration_type, payment_status, payment_reference, amount_paid, currency) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $success = $stmt->execute([$program_id, $cohort_id, $user_data_json, $type, $paymentStatus, $paymentReference, $amountPaid, $currency]);
            return $success ? (int)$this->conn->lastInsertId() : false;
        }
        $query = "INSERT INTO `training_registrations` (program_id, user_data, registration_type, payment_status, payment_reference, amount_paid, currency) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute([$program_id, $user_data_json, $type, $paymentStatus, $paymentReference, $amountPaid, $currency]);
        return $success ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Toggle payment gating for a training
     */
    public function togglePayments($programId, $enabled) {
        $stmt = $this->conn->prepare("UPDATE `trainings_tb` SET payments_enabled = ? WHERE id = ?");
        return $stmt->execute([!empty($enabled) ? 1 : 0, $programId]);
    }

    /**
     * Update default enrollment fee for a training (stored in kobo)
     */
    public function updatePaymentAmount($programId, $amountKobo) {
        $stmt = $this->conn->prepare("UPDATE `trainings_tb` SET payment_amount = ? WHERE id = ?");
        return $stmt->execute([(int)$amountKobo, $programId]);
    }

    /**
     * Resolve effective payment settings: cohort override > training default
     */
    public function getEffectivePaymentAmount($programId, $cohortId = null): array {
        $training = $this->getTrainingById($programId);
        if (!$training) {
            return [
                'payments_enabled'    => false,
                'amount_kobo'         => 0,
                'amount_naira'        => 0.0,
                'is_cohort_override'  => false
            ];
        }

        $paymentsEnabled = !empty($training['payments_enabled']);
        $trainingFeeKobo = (int)($training['payment_amount'] ?? 0);
        $effectiveKobo = $trainingFeeKobo;
        $isCohortOverride = false;

        if ($cohortId) {
            $stmt = $this->conn->prepare("SELECT payment_amount FROM `training_cohorts` WHERE id = ? LIMIT 1");
            $stmt->execute([$cohortId]);
            $cohortFee = $stmt->fetchColumn();
            if ($cohortFee !== false && $cohortFee !== null && (int)$cohortFee > 0) {
                $effectiveKobo = (int)$cohortFee;
                $isCohortOverride = true;
            }
        }

        return [
            'payments_enabled'   => $paymentsEnabled,
            'amount_kobo'        => $effectiveKobo,
            'amount_naira'       => round($effectiveKobo / 100, 2),
            'is_cohort_override' => $isCohortOverride
        ];
    }

    public function isEmailRegistered($email, $program_id, $cohort_id = null) {
        // When cohort_id is specified, email uniqueness is checked within that cohort
        $cohortClause = $cohort_id ? "AND cohort_id = ?" : "";
        $query = "SELECT id FROM `training_registrations` WHERE program_id = ? $cohortClause AND (
                    JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.email')) = ? OR
                    JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.email_address')) = ?
                  ) LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $params = $cohort_id ? [$program_id, $cohort_id, $email, $email] : [$program_id, $email, $email];
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    public function isPhoneRegistered($phone, $program_id, $cohort_id = null) {
        $cohortClause = $cohort_id ? "AND cohort_id = ?" : "";
        $query = "SELECT id FROM `training_registrations` WHERE program_id = ? $cohortClause AND (
                    JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.phone')) = ? OR
                    JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.phone_no')) = ? OR
                    JSON_UNQUOTE(JSON_EXTRACT(user_data, '$.phone_number')) = ?
                  ) LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $params = $cohort_id ? [$program_id, $cohort_id, $phone, $phone, $phone] : [$program_id, $phone, $phone, $phone];
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    public function getActiveCohort($program_id) {
        require_once __DIR__ . '/CohortModel.php';
        $cohortModel = new CohortModel($this->conn);
        return $cohortModel->getActiveCohort($program_id);
    }

    public function getUpcomingCohort($program_id) {
        require_once __DIR__ . '/CohortModel.php';
        $cohortModel = new CohortModel($this->conn);
        return $cohortModel->getUpcomingCohort($program_id);
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
