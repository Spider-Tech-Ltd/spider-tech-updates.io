<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class VerificationController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        parent::__construct();
        $this->authModel = new AuthModel($this->db);
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

            // Recipients
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            // Content
            $verificationLink = BASE_URL . "/forum/verify?token=" . $token;
            $logoUrl = BASE_URL . "/images/spider-tech.png";

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - Spider Tech Forum';

            // Branded HTML Template
            $mail->Body    = "
                <div style=\"font-family: 'Poppins', 'Open Sans', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 40px 20px; background-color: #f8f9fa;\">
                    <div style=\"background-color: #ffffff; border-radius: 20px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e9ecef;\">
                        <div style=\"text-align: center; margin-bottom: 30px;\">
                            <img src=\"$logoUrl\" alt=\"Spider Tech\" style=\"max-width: 180px; height: auto;\">
                        </div>
                        <h2 style=\"color: #111111; font-size: 24px; font-weight: 700; margin-bottom: 15px; text-align: center;\">Verify Your Email</h2>
                        <p style=\"color: #555555; font-size: 16px; line-height: 1.6; margin-bottom: 25px; text-align: center;\">Hello <strong>$name</strong>,</p>
                        <p style=\"color: #555555; font-size: 16px; line-height: 1.6; margin-bottom: 30px; text-align: center;\">Thank you for joining the Spider Tech Community. To complete your registration and start discussing, please verify your email address by clicking the button below:</p>
                        <div style=\"text-align: center; margin: 35px 0;\">
                            <a href=\"$verificationLink\" style=\"background-color: #f48221; color: #ffffff; padding: 16px 35px; text-decoration: none; border-radius: 50px; font-weight: 700; font-size: 16px; display: inline-block; box-shadow: 0 4px 10px rgba(244,130,33,0.3);\">Verify Email Address</a>
                        </div>
                        <p style=\"color: #797979; font-size: 14px; line-height: 1.6; margin-top: 30px; text-align: center;\">If the button doesn't work, copy and paste this link into your browser:</p>
                        <p style=\"text-align: center; margin-bottom: 30px;\"><a href=\"$verificationLink\" style=\"color: #f48221; text-decoration: none; word-break: break-all; font-size: 14px;\">$verificationLink</a></p>
                        <hr style=\"border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;\">
                        <p style=\"font-size: 12px; color: #999999; text-align: center; line-height: 1.5;\">This link will expire in 24 hours. If you did not create an account, you can safely ignore this email.</p>
                    </div>
                    <div style=\"text-align: center; margin-top: 20px; color: #797979; font-size: 12px;\">
                        &copy; " . date('Y') . " Spider Tech Limited. All rights reserved.
                    </div>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function verify()
    {
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
