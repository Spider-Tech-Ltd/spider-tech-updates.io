<?php
class ProjectModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProjects($onlyFeatured = false)
    {
        try {
            $whereClause = $onlyFeatured ? " WHERE p.show_on_home = 1 " : "";
            $query = "SELECT p.*, s.service_name 
                      FROM projects_tb p 
                      LEFT JOIN services_tb s ON p.service_id = s.id 
                      $whereClause
                      ORDER BY p.sort_order ASC, p.project_id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error to debug if migration is missing columns
            error_log("ProjectModel::getAllProjects database query error: " . $e->getMessage());

            // Fallback for when sort_order or show_on_home might be missing from schema
            return $this->conn->query("SELECT p.*, s.service_name FROM projects_tb p LEFT JOIN services_tb s ON p.service_id = s.id ORDER BY p.project_id DESC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getProjectById($id)
    {
        $query = "SELECT p.*, s.service_name FROM projects_tb p LEFT JOIN services_tb s ON p.service_id = s.id WHERE p.project_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
