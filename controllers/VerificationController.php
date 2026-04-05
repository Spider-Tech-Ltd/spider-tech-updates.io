<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class VerificationController extends BaseController {
    private $authModel;

    public function __construct() {
        parent::__construct();
        $this->authModel = new AuthModel($this->db);
    }

    public function sendVerificationEmail($email, $name, $token) {
        $mail = new PHPMailer(true);

        try {
            // Server settings - Replace with actual SMTP config if available
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your_email@example.com';
            $mail->Password   = 'your_password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('noreply@spidertech.com', 'Spider Tech Forum');
            $mail->addAddress($email, $name);

            // Content
            $verificationLink = BASE_URL . "/forum/verify?token=" . $token;

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - Spider Tech Forum';

            // Minimalist HTML Template
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                    <h2 style='color: #333;'>Welcome to Spider Tech Forum!</h2>
                    <p>Hello $name,</p>
                    <p>Thank you for joining our community. Please click the button below to verify your email address and activate your account.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='$verificationLink' style='background-color: #ff5722; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Verify Email Address</a>
                    </div>
                    <p>Or copy and paste this link into your browser:</p>
                    <p><a href='$verificationLink'>$verificationLink</a></p>
                    <p>This link will expire in 24 hours.</p>
                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #888;'>If you did not create an account, no further action is required.</p>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function verify() {
        $token = $_GET['token'] ?? '';
        $message = '';
        $success = false;

        if (empty($token)) {
            $message = "Invalid verification link.";
        } else {
            $member = $this->authModel->getMemberByToken($token);

            if (!$member) {
                $message = "Invalid or expired verification token.";
            } else {
                $expiry = strtotime($member['token_expiry']);
                if (time() > $expiry) {
                    $message = "Verification token has expired. Please request a new one.";
                } else {
                    if ($this->authModel->verifyUserByToken($token)) {
                        $message = "Your email has been successfully verified! You can now sign in.";
                        $success = true;
                    } else {
                        $message = "An error occurred during verification. Please try again.";
                    }
                }
            }
        }

        $this->render('forum/verify', [
            'title' => 'Email Verification - Spider Tech Forum',
            'message' => $message,
            'success' => $success
        ], false);
    }
}
