<?php
class ProjectModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProjects() {
        try {
            $query = "SELECT p.*, s.service_name FROM projects_tb p LEFT JOIN services_tb s ON p.service_id = s.id ORDER BY p.sort_order ASC, p.project_id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $this->conn->query("SELECT p.*, s.service_name FROM projects_tb p LEFT JOIN services_tb s ON p.service_id = s.id ORDER BY p.project_id DESC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getProjectById($id) {
        $query = "SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id WHERE p.project_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>