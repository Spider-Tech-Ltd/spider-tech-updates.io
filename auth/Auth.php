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
     * Clear and regenerate session securely
     */
    private function startFreshSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Empty old session data
        $_SESSION = [];
        // Regenerate ID and delete old session file
        session_regenerate_id(true);
    }

    /**
     * Validates and registers a new member
     */
    public function registerUser($username, $email, $password) {
        if (empty($username) || empty($email) || empty($password)) {
            return ["status" => "error", "message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Please enter a valid email address."];
        }

        if (strlen($password) < 6) {
            return ["status" => "error", "message" => "Password must be at least 6 characters."];
        }

        try {
            $stmtUser = $this->db->prepare("SELECT COUNT(*) FROM members WHERE username = ?");
            $stmtUser->execute([$username]);
            if ($stmtUser->fetchColumn() > 0) {
                return ["status" => "error", "message" => "This username is already taken."];
            }

            $stmtEmail = $this->db->prepare("SELECT COUNT(*) FROM members WHERE email = ?");
            $stmtEmail->execute([$email]);
            if ($stmtEmail->fetchColumn() > 0) {
                return ["status" => "error", "message" => "This email is already registered."];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $uuid = $this->generateUUID();

            $insertStmt = $this->db->prepare("INSERT INTO members (uuid, username, email, password_hash) VALUES (?, ?, ?, ?)");
            $insertStmt->execute([$uuid, $username, $email, $hashedPassword]);

            return ["status" => "success", "message" => "Registration successful! You can now sign in."];
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }

    /**
     * Authenticates a member by email/username and password
     */
    public function loginUser($identifier, $password) {
        if (empty($identifier) || empty($password)) {
            return ["status" => "error", "message" => "Please enter your credentials."];
        }

        try {
            $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $stmt = $this->db->prepare("SELECT id, uuid, username, password_hash FROM members WHERE $field = ?");
            $stmt->execute([$identifier]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Securely start a new session
                $this->startFreshSession();

                $_SESSION['user_id'] = $user['uuid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['member_id'] = $user['id'];
                $_SESSION['member_uuid'] = $user['uuid'];

                // Explicitly save session data before redirect
                session_write_close();

                return ["status" => "success", "redirect" => "feed.php"];
            }

            return ["status" => "error", "message" => "Invalid username/email or password."];
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return ["status" => "error", "message" => "A server error occurred. Please try again later."];
        }
    }
}
