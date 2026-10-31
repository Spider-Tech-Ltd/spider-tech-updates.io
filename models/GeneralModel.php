<?php
class GeneralModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAboutInfo() {
        $query = "SELECT * FROM `about_info` WHERE id BETWEEN 1 AND 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFaqs() {
        try {
            $stmt = $this->conn->query("SELECT * FROM faq_tb ORDER BY faq_id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getMission() {
        $query = "SELECT * FROM `about_mission` ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVision() {
        $query = "SELECT * FROM `about_vision` ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getValues() {
        $query = "SELECT * FROM `about_value` ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBlogs() {
        return [];
    }

    public function getSocialLinks() {
        try {
            $stmt = $this->conn->query("SELECT * FROM social_links ORDER BY platform ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPartners() {
        try {
            $stmt = $this->conn->query("SELECT * FROM partners_tb WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getActiveCohortAnnouncements() {
        try {
            $stmt = $this->conn->query("
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
