<?php
class ProjectModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProjects() {
        $query = "SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectById($id) {
        $query = "SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id WHERE p.project_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>