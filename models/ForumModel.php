<?php

class ForumModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeeds($limit = 10) {
        // Simple query for now, joining members and categories if needed in future
        $stmt = $this->db->prepare("SELECT * FROM feeds ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
