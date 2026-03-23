<?php
/**
 * Authentication Helper Class
 * Handles registration, login, and secure user data storage.
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
     * Validates and registers a new user
     */
    public function registerUser($username, $email, $password) {
        // Simple input validation
        if (empty($username) || empty($email) || empty($password)) {
            return ["status" => "error", "message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Invalid email format."];
        }

        if (strlen($password) < 6) {
            return ["status" => "error", "message" => "Password must be at least 6 characters."];
        }

        try {
            // Check if user or email already exists
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                return ["status" => "error", "message" => "Username or Email already taken."];
            }

            // Securely hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $uuid = $this->generateUUID();

            // Insert into the database using PDO prepared statements
            $insertStmt = $this->db->prepare("INSERT INTO users (id, username, email, password) VALUES (?, ?, ?, ?)");
            $insertStmt->execute([$uuid, $username, $email, $hashedPassword]);

            return ["status" => "success", "message" => "Registration successful! You can now login."];
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }

    /**
     * Authenticates a user by email/username and password
     */
    public function loginUser($identifier, $password) {
        if (empty($identifier) || empty($password)) {
            return ["status" => "error", "message" => "Please enter your credentials."];
        }

        try {
            // Handle both email and username logins
            $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE $field = ?");
            $stmt->execute([$identifier]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Set session variables securely
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                return ["status" => "success", "redirect" => "pages/forum/feed.php"];
            }

            return ["status" => "error", "message" => "Invalid username/email or password."];
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }
}
