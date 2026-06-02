<?php
class ServiceModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllServices() {
        try {
            // Include show_on_home if it exists, otherwise fallback via catch
            $query = "SELECT * FROM `services_tb` WHERE `show_on_home` = 1 ORDER BY sort_order ASC, id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $this->conn->query("SELECT * FROM `services_tb` ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getServiceById($id) {
        $query = "SELECT * FROM `services_tb` WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>