<?php

/**
 * CohortModel - Manages training cohorts, lifecycle states, enrollment limits, and cohort fees
 */
class CohortModel
{
    private $db;

    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $database = new Database();
            $this->db = $database->getConnection();
        }
    }

    /**
     * Get all cohorts for a specific training program
     */
    public function getCohortsByTrainingId($training_id)
    {
        if (!$this->db) {
            return [];
        }
        try {
            $stmt = $this->db->prepare("
                SELECT tc.*, 
                       COUNT(CASE WHEN tr.payment_status != 'failed' AND tr.payment_status != 'abandoned' THEN tr.id END) AS total_registrations
                FROM training_cohorts tc
                LEFT JOIN training_registrations tr ON tr.cohort_id = tc.id
                WHERE tc.training_id = ?
                GROUP BY tc.id
                ORDER BY tc.cohort_number DESC
            ");
            $stmt->execute([$training_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            try {
                $stmt = $this->db->prepare("
                    SELECT tc.*, 0 AS total_registrations
                    FROM training_cohorts tc
                    WHERE tc.training_id = ?
                    ORDER BY tc.cohort_number DESC
                ");
                $stmt->execute([$training_id]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $e2) {
                error_log("CohortModel::getCohortsByTrainingId error: " . $e2->getMessage());
                return [];
            }
        }
    }

    /**
     * Get single cohort by ID with registration metrics
     */
    public function getCohortById($id)
    {
        if (!$this->db) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("
                SELECT tc.*, 
                       t.training_name,
                       t.payments_enabled as program_payments_enabled,
                       t.payment_amount as program_default_fee,
                       COUNT(CASE WHEN tr.payment_status != 'failed' AND tr.payment_status != 'abandoned' THEN tr.id END) AS total_registrations
                FROM training_cohorts tc
                JOIN trainings_tb t ON t.id = tc.training_id
                LEFT JOIN training_registrations tr ON tr.cohort_id = tc.id
                WHERE tc.id = ?
                GROUP BY tc.id
                LIMIT 1
            ");
            $stmt->execute([$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ?: null;
        } catch (\Throwable $e) {
            try {
                $stmt = $this->db->prepare("
                    SELECT tc.*, 
                           t.training_name,
                           0 as program_payments_enabled,
                           0 as program_default_fee,
                           0 AS total_registrations
                    FROM training_cohorts tc
                    JOIN trainings_tb t ON t.id = tc.training_id
                    WHERE tc.id = ?
                    LIMIT 1
                ");
                $stmt->execute([$id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                return $res ?: null;
            } catch (\Throwable $e2) {
                error_log("CohortModel::getCohortById error: " . $e2->getMessage());
                return null;
            }
        }
    }

    /**
     * Get cohort by training and cohort number
     */
    public function getCohortByNumber($training_id, $cohort_number)
    {
        if (!$this->db) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM training_cohorts 
                WHERE training_id = ? AND cohort_number = ? 
                LIMIT 1
            ");
            $stmt->execute([$training_id, $cohort_number]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ?: null;
        } catch (\Throwable $e) {
            error_log("CohortModel::getCohortByNumber error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the currently active/open cohort for enrollment
     */
    public function getActiveCohort($training_id)
    {
        if (!$this->db) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("
                SELECT tc.*,
                       COUNT(CASE WHEN tr.payment_status != 'failed' AND tr.payment_status != 'abandoned' THEN tr.id END) AS total_registrations
                FROM training_cohorts tc
                LEFT JOIN training_registrations tr ON tr.cohort_id = tc.id
                WHERE tc.training_id = ?
                  AND tc.registration_open = 1
                  AND tc.status IN ('open', 'upcoming')
                  AND (tc.registration_deadline IS NULL OR tc.registration_deadline >= NOW())
                GROUP BY tc.id
                HAVING (tc.capacity = 0 OR tc.capacity IS NULL OR total_registrations < tc.capacity)
                ORDER BY tc.registration_deadline ASC, tc.cohort_number DESC
                LIMIT 1
            ");
            $stmt->execute([$training_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ?: null;
        } catch (\Throwable $e) {
            try {
                $stmt = $this->db->prepare("
                    SELECT tc.*, 0 AS total_registrations
                    FROM training_cohorts tc
                    WHERE tc.training_id = ?
                      AND tc.registration_open = 1
                      AND tc.status IN ('open', 'upcoming')
                      AND (tc.registration_deadline IS NULL OR tc.registration_deadline >= NOW())
                    ORDER BY tc.registration_deadline ASC, tc.cohort_number DESC
                    LIMIT 1
                ");
                $stmt->execute([$training_id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                return $res ?: null;
            } catch (\Throwable $e2) {
                error_log("CohortModel::getActiveCohort error: " . $e2->getMessage());
                return null;
            }
        }
    }

    /**
     * Get next upcoming cohort when no cohort is actively open
     */
    public function getUpcomingCohort($training_id)
    {
        if (!$this->db) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM training_cohorts
                WHERE training_id = ?
                  AND status = 'upcoming'
                  AND start_date >= CURDATE()
                ORDER BY start_date ASC
                LIMIT 1
            ");
            $stmt->execute([$training_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ?: null;
        } catch (\Throwable $e) {
            error_log("CohortModel::getUpcomingCohort error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get latest completed cohort (for alumni/recap displays)
     */
    public function getLatestCompletedCohort($training_id)
    {
        if (!$this->db) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM training_cohorts
                WHERE training_id = ?
                  AND status = 'completed'
                ORDER BY cohort_number DESC
                LIMIT 1
            ");
            $stmt->execute([$training_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ?: null;
        } catch (\Throwable $e) {
            error_log("CohortModel::getLatestCompletedCohort error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new cohort
     */
    public function createCohort($data)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $paymentAmount = null;
            if (isset($data['payment_amount']) && $data['payment_amount'] !== '' && $data['payment_amount'] !== null) {
                $paymentAmount = (int)$data['payment_amount'];
            }

            $sql = "INSERT INTO training_cohorts (
                training_id, cohort_number, cohort_name, slug,
                start_date, end_date, registration_open, show_topbar_banner, custom_announcement,
                registration_deadline, capacity, payment_amount, status
            ) VALUES (
                :training_id, :cohort_number, :cohort_name, :slug,
                :start_date, :end_date, :registration_open, :show_topbar_banner, :custom_announcement,
                :registration_deadline, :capacity, :payment_amount, :status
            )";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':training_id'            => $data['training_id'],
                ':cohort_number'          => $data['cohort_number'],
                ':cohort_name'            => $data['cohort_name'],
                ':slug'                   => $data['slug'],
                ':start_date'             => $data['start_date'],
                ':end_date'               => $data['end_date'],
                ':registration_open'      => !empty($data['registration_open']) ? 1 : 0,
                ':show_topbar_banner'     => !empty($data['show_topbar_banner']) ? 1 : 0,
                ':custom_announcement'    => !empty($data['custom_announcement']) ? trim($data['custom_announcement']) : null,
                ':registration_deadline'  => !empty($data['registration_deadline']) ? $data['registration_deadline'] : null,
                ':capacity'               => !empty($data['capacity']) ? (int)$data['capacity'] : 0,
                ':payment_amount'         => $paymentAmount,
                ':status'                 => $data['status'] ?? 'upcoming',
            ]);

            return $result ? (int)$this->db->lastInsertId() : false;
        } catch (\Throwable $e) {
            error_log("CohortModel::createCohort error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing cohort
     */
    public function updateCohort($id, $data)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $paymentAmount = null;
            if (isset($data['payment_amount']) && $data['payment_amount'] !== '' && $data['payment_amount'] !== null) {
                $paymentAmount = (int)$data['payment_amount'];
            }

            $sql = "UPDATE training_cohorts SET
                cohort_number = :cohort_number,
                cohort_name = :cohort_name,
                slug = :slug,
                start_date = :start_date,
                end_date = :end_date,
                registration_open = :registration_open,
                show_topbar_banner = :show_topbar_banner,
                custom_announcement = :custom_announcement,
                registration_deadline = :registration_deadline,
                capacity = :capacity,
                payment_amount = :payment_amount,
                status = :status
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':cohort_number'          => $data['cohort_number'],
                ':cohort_name'            => $data['cohort_name'],
                ':slug'                   => $data['slug'],
                ':start_date'             => $data['start_date'],
                ':end_date'               => $data['end_date'],
                ':registration_open'      => !empty($data['registration_open']) ? 1 : 0,
                ':show_topbar_banner'     => !empty($data['show_topbar_banner']) ? 1 : 0,
                ':custom_announcement'    => !empty($data['custom_announcement']) ? trim($data['custom_announcement']) : null,
                ':registration_deadline'  => !empty($data['registration_deadline']) ? $data['registration_deadline'] : null,
                ':capacity'               => !empty($data['capacity']) ? (int)$data['capacity'] : 0,
                ':payment_amount'         => $paymentAmount,
                ':status'                 => $data['status'] ?? 'upcoming',
                ':id'                     => $id
            ]);
        } catch (\Throwable $e) {
            error_log("CohortModel::updateCohort error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update cohort payment override fee (in kobo)
     */
    public function updatePaymentAmount($id, $amountKoboOrNull)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $amount = ($amountKoboOrNull !== null && $amountKoboOrNull !== '' && (int)$amountKoboOrNull >= 0)
                ? (int)$amountKoboOrNull
                : null;

            $stmt = $this->db->prepare("UPDATE training_cohorts SET payment_amount = ? WHERE id = ?");
            return $stmt->execute([$amount, $id]);
        } catch (\Throwable $e) {
            error_log("CohortModel::updatePaymentAmount error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Toggle registration open state for a cohort
     */
    public function toggleRegistration($id)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("
                UPDATE training_cohorts 
                SET registration_open = IF(registration_open = 1, 0, 1),
                    status = IF(registration_open = 1, 'upcoming', 'open')
                WHERE id = ?
            ");
            return $stmt->execute([$id]);
        } catch (\Throwable $e) {
            error_log("CohortModel::toggleRegistration error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a cohort (if no registrations exist)
     */
    public function deleteCohort($id)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM training_registrations WHERE cohort_id = ?");
            $checkStmt->execute([$id]);
            if ($checkStmt->fetchColumn() > 0) {
                return false; // Prevent deletion if registrations exist
            }

            $stmt = $this->db->prepare("DELETE FROM training_cohorts WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Throwable $e) {
            error_log("CohortModel::deleteCohort error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a cohort has reached its capacity limit
     */
    public function isCohortFull($cohort_id)
    {
        try {
            $cohort = $this->getCohortById($cohort_id);
            if (!$cohort || empty($cohort['capacity']) || (int)$cohort['capacity'] <= 0) {
                return false;
            }

            return (int)($cohort['total_registrations'] ?? 0) >= (int)$cohort['capacity'];
        } catch (\Throwable $e) {
            error_log("CohortModel::isCohortFull error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all cohorts with program names for admin filters
     */
    public function getAllCohortsForAdmin()
    {
        if (!$this->db) {
            return [];
        }
        try {
            $stmt = $this->db->query("
                SELECT tc.id, tc.cohort_number, tc.cohort_name, tc.status, tc.registration_open, tc.payment_amount,
                       t.id as training_id, t.training_name, t.payments_enabled as program_payments_enabled, t.payment_amount as program_default_fee,
                       COUNT(CASE WHEN tr.payment_status != 'failed' AND tr.payment_status != 'abandoned' THEN tr.id END) as applicant_count
                FROM training_cohorts tc
                JOIN trainings_tb t ON t.id = tc.training_id
                LEFT JOIN training_registrations tr ON tr.cohort_id = tc.id
                GROUP BY tc.id
                ORDER BY t.training_name ASC, tc.cohort_number DESC
            ");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (\Throwable $e) {
            try {
                $stmt = $this->db->query("
                    SELECT tc.id, tc.cohort_number, tc.cohort_name, tc.status, tc.registration_open, 0 as payment_amount,
                           t.id as training_id, t.training_name, 0 as program_payments_enabled, 0 as program_default_fee,
                           0 as applicant_count
                    FROM training_cohorts tc
                    JOIN trainings_tb t ON t.id = tc.training_id
                    ORDER BY t.training_name ASC, tc.cohort_number DESC
                ");
                return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            } catch (\Throwable $e2) {
                error_log("CohortModel::getAllCohortsForAdmin error: " . $e2->getMessage());
                return [];
            }
        }
    }

    /**
     * Toggle topbar announcement banner display for a cohort
     */
    public function toggleTopbarBanner($id)
    {
        if (!$this->db) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("
                UPDATE training_cohorts 
                SET show_topbar_banner = IF(show_topbar_banner = 1, 0, 1)
                WHERE id = ?
            ");
            return $stmt->execute([$id]);
        } catch (\Throwable $e) {
            error_log("CohortModel::toggleTopbarBanner error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get active cohort announcements for top utility bar
     */
    public function getTopbarAnnouncements()
    {
        if (!$this->db) {
            return [];
        }
        try {
            $stmt = $this->db->prepare("
                SELECT tc.*, 
                       t.training_name,
                       t.id as training_id
                FROM training_cohorts tc
                JOIN trainings_tb t ON t.id = tc.training_id
                WHERE tc.show_topbar_banner = 1
                  AND tc.registration_open = 1
                  AND tc.status IN ('open', 'upcoming')
                  AND (tc.registration_deadline IS NULL OR tc.registration_deadline >= NOW())
                ORDER BY tc.cohort_number DESC, tc.id DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            error_log("CohortModel::getTopbarAnnouncements error: " . $e->getMessage());
            return [];
        }
    }
}
