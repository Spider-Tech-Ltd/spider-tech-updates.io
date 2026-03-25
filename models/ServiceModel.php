<?php
class ServiceModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllServices() {
        $query = "SELECT * FROM `services_tb`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceById($id) {
        $query = "SELECT * FROM `services_tb` WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>