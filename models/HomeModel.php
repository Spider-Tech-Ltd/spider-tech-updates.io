<?php
class HomeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBanners() {
        $query = "SELECT * FROM `banners_tb` WHERE banner_id IN (1, 2, 3, 4)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAboutInfo() {
        $query = "SELECT * FROM `about_info` WHERE id BETWEEN 1 AND 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServices() {
        $query = "SELECT * FROM `services_tb`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjects() {
        $query = "SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingEvents() {
        $query = "SELECT * FROM `events` WHERE `event_status` = 'upcoming'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLatestEvents() {
        $query = "SELECT * FROM `events` ORDER BY `event_date` DESC LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestimonials() {
        $query = "SELECT * FROM `testimonials_tb` LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStats() {
        $stats = [
            'clients' => 0,
            'hours' => 10000, // Default/Static if no table
            'projects' => 0,
            'locations' => 1
        ];

        // Get members count for "Happy Clients"
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM members");
        $stmt->execute();
        $stats['clients'] = $stmt->fetchColumn();

        // Get actual projects count
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM projects_tb");
        $stmt->execute();
        $stats['projects'] = $stmt->fetchColumn();

        // If counts are very low, we might want to add a base number to make it look established
        // but the prompt says database driven.

        return $stats;
    }
}
?>