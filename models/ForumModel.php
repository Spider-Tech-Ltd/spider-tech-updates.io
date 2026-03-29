<?php
class ForumModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = "SELECT * FROM `categories` ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeeds($limit = 10)
    {
        $query = "SELECT f.*, m.username, c.name
                  FROM `feeds` f
                  JOIN `members` m ON f.uuid = m.uuid
                  JOIN `categories` c ON f.uuid = c.uuid
                  ORDER BY f.created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContactDetails()
    {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
