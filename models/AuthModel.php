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
        $uuid = Utils::generateUUID();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `members` (uuid, username, email, password_hash, name) VALUES (:uuid, :username, :email, :password_hash, :name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $hashedPassword);
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

    public function storeVerificationToken($uuid, $token, $expiry)
    {
        $query = "UPDATE `members` SET verification_token = :token, token_expiry = :expiry WHERE uuid = :uuid";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->bindParam(':uuid', $uuid);
        return $stmt->execute();
    }

    public function verifyUserByToken($token)
    {
        $query = "UPDATE `members` SET is_verified = 1, verification_token = NULL, token_expiry = NULL WHERE verification_token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    public function isAccountVerified($identifier)
    {
        $query = "SELECT is_verified FROM `members` WHERE email = :identifier OR username = :identifier LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['is_verified'] == 1;
    }

    public function getMemberByToken($token)
    {
        $query = "SELECT * FROM `members` WHERE verification_token = :token LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
