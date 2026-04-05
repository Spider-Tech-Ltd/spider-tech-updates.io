<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PasswordResetController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        parent::__construct();
        $this->authModel = new AuthModel($this->db);
    }

    public function forgotPassword()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $email = $_POST['email'] ?? '';
                $member = $this->authModel->findByEmail($email);

                if ($member) {
                    $code = sprintf("%06d", mt_rand(100000, 999999));
                    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    if ($this->authModel->storeResetCode($email, $code, $expiry)) {
                        if ($this->sendResetEmail($email, $member['name'], $code)) {
                            $_SESSION['reset_email'] = $email;
                            $this->redirect('forum/verify-reset-code');
                        } else {
                            $error = "Failed to send reset code. Please try again later.";
                        }
                    } else {
                        $error = "An error occurred. Please try again.";
                    }
                } else {
                    // Security: don't reveal if email exists, but we'll show success for consistency
                    $error = "If your email is in our system, you will receive a 6-digit reset code.";
                }
            }
        }

        $this->render('forum/forgot-password', [
            'title' => 'Forgot Password - Spider Tech Forum',
            'error' => $error,
            'success' => $success,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function verifyResetCode()
    {
        $email = $_SESSION['reset_email'] ?? '';
        if (empty($email)) {
            $this->redirect('forum/forgot-password');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $code = $_POST['code'] ?? '';
                if ($this->authModel->verifyResetCode($email, $code)) {
                    $_SESSION['reset_verified'] = true;
                    $this->redirect('forum/reset-password');
                } else {
                    $error = "Invalid or expired reset code.";
                }
            }
        }

        $this->render('forum/verify-reset-code', [
            'title' => 'Verify Reset Code - Spider Tech Forum',
            'error' => $error,
            'email' => $email,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function resetPassword()
    {
        $email = $_SESSION['reset_email'] ?? '';
        $verified = $_SESSION['reset_verified'] ?? false;

        if (empty($email) || !$verified) {
            $this->redirect('forum/forgot-password');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $password = $_POST['password'] ?? '';
                $confirm = $_POST['confirm_password'] ?? '';

                $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/';

                if (empty($password)) {
                    $error = "New password is required.";
                } elseif ($password !== $confirm) {
                    $error = "Passwords do not match.";
                } elseif (!preg_match($regex, $password)) {
                    $error = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    if ($this->authModel->updatePassword($email, $hash)) {
                        unset($_SESSION['reset_email']);
                        unset($_SESSION['reset_verified']);
                        $_SESSION['success_message'] = "Your password has been successfully reset. You can now sign in.";
                        $this->redirect('forum/sign-in');
                    } else {
                        $error = "Failed to update password. Please try again.";
                    }
                }
            }
        }

        $this->render('forum/reset-password', [
            'title' => 'Reset Password - Spider Tech Forum',
            'error' => $error,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    private function sendResetEmail($email, $name, $code)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = MAIL_AUTH;
            $mail->Username   = MAIL_USER;
            $mail->Password   = MAIL_PASS;
            $mail->SMTPSecure = (defined('MAIL_ENCRYPTION') && strtolower(MAIL_ENCRYPTION) === 'ssl') ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = MAIL_PORT;

            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            $logoUrl = BASE_URL . "/images/spider-tech.png";

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code - Spider Tech Forum';

            $mail->Body = "
                <div style=\"font-family: 'Poppins', 'Open Sans', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 40px 20px; background-color: #f8f9fa;\">
                    <div style=\"background-color: #ffffff; border-radius: 20px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e9ecef;\">
                        <div style=\"text-align: center; margin-bottom: 30px;\">
                            <img src=\"$logoUrl\" alt=\"Spider Tech\" style=\"max-width: 180px; height: auto;\">
                        </div>
                        <h2 style=\"color: #111111; font-size: 24px; font-weight: 700; margin-bottom: 15px; text-align: center;\">Password Reset</h2>
                        <p style=\"color: #555555; font-size: 16px; line-height: 1.6; margin-bottom: 25px; text-align: center;\">Hello <strong>$name</strong>,</p>
                        <p style=\"color: #555555; font-size: 16px; line-height: 1.6; margin-bottom: 30px; text-align: center;\">You requested to reset your password. Use the 6-digit code below to proceed:</p>
                        <div style=\"text-align: center; margin: 35px 0;\">
                            <span style=\"background-color: #f1f3f5; color: #f48221; padding: 16px 35px; border-radius: 12px; font-weight: 800; font-size: 32px; display: inline-block; letter-spacing: 5px; border: 1px dashed #f48221;\">$code</span>
                        </div>
                        <p style=\"color: #797979; font-size: 14px; line-height: 1.6; margin-top: 30px; text-align: center;\">This code will expire in 1 hour. If you did not request this, please ignore this email.</p>
                        <hr style=\"border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;\">
                        <p style=\"font-size: 12px; color: #999999; text-align: center; line-height: 1.5;\">&copy; " . date('Y') . " Spider Tech Limited. All rights reserved.</p>
                    </div>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Reset email failed: {$e->getMessage()}");
            return false;
        }
    }
}
