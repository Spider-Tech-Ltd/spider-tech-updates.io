<?php
class TrainingModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTrainings() {
        $query = "SELECT * FROM `trainings_tb`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function submitRegistration($program_id, $user_data_json) {
        $query = "INSERT INTO `training_registrations` (program_id, user_data) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$program_id, $user_data_json]);
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>