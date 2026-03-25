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
        // Sample query, update with real table name if known
        return [];
    }
}
?>