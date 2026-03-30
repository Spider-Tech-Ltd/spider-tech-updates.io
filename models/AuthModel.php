<?php
class AuthModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $email, $password, $name = null)
    {
        $uuid = $this->generateUUID();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `members` (uuid, username, email, password, name) VALUES (:uuid, :username, :email, :password, :name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':name', $name);

        if ($stmt->execute()) {
            return $uuid;
        }
        return false;
    }

    public function findByEmailOrUsername($identifier)
    {
        $query = "SELECT * FROM `members` WHERE email = :identifier OR username = :identifier LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMemberByUUID($uuid)
    {
        $query = "SELECT * FROM `members` WHERE uuid = :uuid LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
