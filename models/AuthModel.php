<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function findByEmail($email)
    {
        $query = "SELECT * FROM `members` WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function sendVerificationEmail($email, $name, $token)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = MAIL_AUTH;
            $mail->Username   = MAIL_USER;
            $mail->Password   = MAIL_PASS;

            if (defined('MAIL_ENCRYPTION') && strtolower(MAIL_ENCRYPTION) === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port = MAIL_PORT;
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            $verificationLink = BASE_URL . '/forum/verify?token=' . urlencode($token);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - Spider Tech Forum';
            $mail->Body = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 8px;'>
                    <h2 style='color: #333;'>Welcome to Spider Tech Forum</h2>
                    <p>Hello {$name},</p>
                    <p>Thank you for joining our community. Please verify your email address by clicking the button below:</p>
                    <p style='text-align: center;'>
                        <a href='{$verificationLink}' style='background:#007bff;color:#fff;padding:12px 22px;text-decoration:none;border-radius:5px;display:inline-block;'>Verify Email</a>
                    </p>
                    <p>If the button does not work, paste this link into your browser:</p>
                    <p><a href='{$verificationLink}'>{$verificationLink}</a></p>
                    <p>This link expires in 24 hours.</p>
                </div>";
            $mail->AltBody = "Please verify your email by visiting: {$verificationLink}";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Verification email failed: {$e->getMessage()}");
            return false;
        }
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
