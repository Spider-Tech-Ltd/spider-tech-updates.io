<?php
class EventModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllEvents() {
        $query = "SELECT * FROM `events` ORDER BY event_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingEvents() {
        $query = "SELECT * FROM `events` WHERE `event_status` = 'upcoming' ORDER BY event_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPastEvents() {
        $query = "SELECT * FROM `events` WHERE `event_status` = 'past' ORDER BY event_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventById($id) {
        $query = "SELECT * FROM `events` WHERE event_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>