<?php
/**
 * Authentication Helper Class
 * Handles registration, login, and secure user data storage.
 * Updated to use 'members' table and column names.
 */

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Generate a secure UUID (v4)
     */
    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Validates and registers a new member
     */
    public function registerUser($name, $email, $password) {
        if (empty($name) || empty($email) || empty($password)) {
            return ["status" => "error", "message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Invalid email format."];
        }

        if (strlen($password) < 6) {
            return ["status" => "error", "message" => "Password must be at least 6 characters."];
        }

        try {
            // Check if email already exists in 'members' table
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM members WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                return ["status" => "error", "message" => "Email already registered."];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $uuid = $this->generateUUID();

            $insertStmt = $this->db->prepare("INSERT INTO members (uuid, name, email, password_hash) VALUES (?, ?, ?, ?)");
            $insertStmt->execute([$uuid, $name, $email, $hashedPassword]);

            return ["status" => "success", "message" => "Registration successful! You can now sign in."];
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }

    /**
     * Authenticates a member by email and password
     */
    public function loginUser($email, $password) {
        if (empty($email) || empty($password)) {
            return ["status" => "error", "message" => "Please enter your credentials."];
        }

        try {
            $stmt = $this->db->prepare("SELECT id, uuid, name, password_hash FROM members WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['uuid']; // Store UUID for tracking
                $_SESSION['username'] = $user['name'];
                $_SESSION['member_id'] = $user['id']; // Store PK for relationships

                return ["status" => "success", "redirect" => "pages/forum/feed.php"];
            }

            return ["status" => "error", "message" => "Invalid email or password."];
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }
}
