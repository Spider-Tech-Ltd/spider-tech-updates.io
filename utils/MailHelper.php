<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT_PATH . '/vendor/autoload.php';

class MailHelper
{
    /**
     * Send transactional admission confirmation email for training cohort registration
     */
    public static function sendCohortRegistrationConfirmation($email, $name, $programName, $cohort = null)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = defined('MAIL_HOST') ? MAIL_HOST : 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = defined('MAIL_AUTH') ? MAIL_AUTH : true;
            $mail->Username   = defined('MAIL_USER') ? MAIL_USER : '';
            $mail->Password   = defined('MAIL_PASS') ? MAIL_PASS : '';
            $mail->Port       = defined('MAIL_PORT') ? MAIL_PORT : 2525;
            $mail->CharSet    = 'UTF-8';

            if (defined('MAIL_ENCRYPTION') && strtolower(MAIL_ENCRYPTION) === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            // Sender & Recipient
            $fromAddress = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'admissions@spidertech.com.ng';
            $fromName    = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Spider Tech Admissions';
            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($email, $name ?: 'Applicant');

            // Cohort metadata
            $cohortName = !empty($cohort['cohort_name']) ? $cohort['cohort_name'] : 'Upcoming Cohort';
            $startDate = !empty($cohort['start_date']) ? date('F j, Y', strtotime($cohort['start_date'])) : 'To Be Announced';
            $endDate = !empty($cohort['end_date']) ? date('F j, Y', strtotime($cohort['end_date'])) : '';
            $dateRange = $endDate ? "{$startDate} &ndash; {$endDate}" : $startDate;

            $mail->isHTML(true);
            $mail->Subject = "Application Received: {$programName} ({$cohortName})";

            $logoUrl = BASE_URL . "/images/spider-tech.png";
            $portalUrl = BASE_URL . "/trainings";
            $currentYear = date('Y');

            $mail->Body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application Received</title>
</head>
<body style="font-family: 'Poppins', 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 30px 15px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <!-- Header -->
        <div style="background: #110f0d; padding: 28px 24px; text-align: center; border-bottom: 3px solid #f48221;">
            <img src="{$logoUrl}" alt="Spider Tech" style="height: 38px; max-width: 180px;">
        </div>

        <!-- Body -->
        <div style="padding: 32px 28px;">
            <div style="display: inline-block; padding: 4px 12px; background: rgba(244, 130, 33, 0.1); color: #f48221; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                Application Confirmed
            </div>
            <h2 style="color: #0f172a; margin: 0 0 14px 0; font-size: 22px; font-weight: 700;">
                Hello, {$name}!
            </h2>
            <p style="color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                Thank you for applying to <strong>{$programName}</strong>. Your registration has been successfully logged into our admissions database.
            </p>

            <!-- Cohort Details Box -->
            <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 24px;">
                <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px; margin-bottom: 6px;">Enrolled Session</div>
                <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">{$cohortName}</div>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; color: #334155;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; width: 40%;">Program Dates:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">{$dateRange}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Instruction Track:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">Hands-On Technical Workshop</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Verification Status:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #10b981;">&bull; Pending Orientation Notice</td>
                    </tr>
                </table>
            </div>

            <!-- Next Steps -->
            <h3 style="color: #0f172a; font-size: 16px; font-weight: 700; margin: 0 0 10px 0;">What Happens Next?</h3>
            <ol style="color: #475569; font-size: 14px; line-height: 1.6; padding-left: 20px; margin-bottom: 28px;">
                <li>Our technical admissions committee verifies candidate submissions.</li>
                <li>You will receive your official timetable and orientation schedule prior to the start date.</li>
                <li>Make sure to check your inbox (and spam folder) for further updates from Spider Tech.</li>
            </ol>

            <div style="text-align: center;">
                <a href="{$portalUrl}" style="display: inline-block; background: #f48221; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                    Visit Trainings Portal
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f1f5f9; padding: 18px 24px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            &copy; {$currentYear} Spider Technologies Ltd. All rights reserved.<br>
            Plot 120, Innovation Drive, Kano / Abuja, Nigeria.
        </div>
    </div>
</body>
</html>
HTML;

            $mail->AltBody = "Hello {$name},\n\nThank you for applying to {$programName} ({$cohortName}). Your application has been received.\nProgram Dates: {$dateRange}\nWe will contact you with orientation details.\n\nSpider Technologies Admissions";

            return $mail->send();
        } catch (Exception $e) {
            error_log("MailHelper Error: Could not send cohort confirmation email to {$email}. Error: " . $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * Send official payment receipt & enrollment confirmation email
     */
    public static function sendPaymentReceipt(string $email, string $name, array $paymentDetails): bool
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = defined('MAIL_HOST') ? MAIL_HOST : 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = defined('MAIL_AUTH') ? MAIL_AUTH : true;
            $mail->Username   = defined('MAIL_USER') ? MAIL_USER : '';
            $mail->Password   = defined('MAIL_PASS') ? MAIL_PASS : '';
            $mail->Port       = defined('MAIL_PORT') ? MAIL_PORT : 2525;
            $mail->CharSet    = 'UTF-8';

            if (defined('MAIL_ENCRYPTION') && strtolower(MAIL_ENCRYPTION) === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            // Sender & Recipient
            $fromAddress = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'admissions@spidertech.com.ng';
            $fromName    = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Spider Tech Admissions';
            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($email, $name ?: 'Applicant');

            $invoiceNumber   = htmlspecialchars($paymentDetails['invoice_number'] ?? 'INV-0000');
            $programName     = htmlspecialchars($paymentDetails['program_name'] ?? 'Training Program');
            $cohortName      = htmlspecialchars($paymentDetails['cohort_name'] ?? 'Current Cohort');
            $amountFormatted = htmlspecialchars(PaystackService::formatKobo((int)($paymentDetails['amount_kobo'] ?? 0)));
            $channel         = htmlspecialchars(ucfirst($paymentDetails['channel'] ?? 'Online Card/Transfer'));
            $reference       = htmlspecialchars($paymentDetails['reference'] ?? '');
            $paidDate        = !empty($paymentDetails['paid_at']) ? date('F j, Y \a\t g:i A', strtotime($paymentDetails['paid_at'])) : date('F j, Y \a\t g:i A');
            $receiptUrl      = htmlspecialchars($paymentDetails['receipt_url'] ?? (BASE_URL . '/trainings'));

            $logoUrl = BASE_URL . "/images/spider-tech.png";
            $currentYear = date('Y');

            $mail->isHTML(true);
            $mail->Subject = "Payment Receipt & Admission Confirmed: {$programName} ({$invoiceNumber})";

            $mail->Body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
</head>
<body style="font-family: 'Poppins', 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 30px 15px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <!-- Header -->
        <div style="background: #110f0d; padding: 28px 24px; text-align: center; border-bottom: 3px solid #f48221;">
            <img src="{$logoUrl}" alt="Spider Tech" style="height: 38px; max-width: 180px;">
        </div>

        <!-- Body -->
        <div style="padding: 32px 28px;">
            <div style="display: inline-block; padding: 4px 12px; background: rgba(16, 185, 129, 0.1); color: #059669; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                &bull; Payment Successful & Admission Confirmed
            </div>
            <h2 style="color: #0f172a; margin: 0 0 10px 0; font-size: 22px; font-weight: 700;">
                Hello, {$name}!
            </h2>
            <p style="color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                Your enrollment payment for <strong>{$programName}</strong> has been received and verified. Your candidate seat is now officially secured.
            </p>

            <!-- Receipt Box -->
            <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 24px;">
                <div style="border-bottom: 1px dashed #cbd5e1; padding-bottom: 12px; margin-bottom: 12px;">
                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8;">Official Invoice</div>
                    <div style="font-size: 16px; font-weight: 700; color: #0f172a;">{$invoiceNumber}</div>
                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; margin-top: 8px;">Amount Paid</div>
                    <div style="font-size: 20px; font-weight: 800; color: #f48221;">{$amountFormatted}</div>
                </div>

                <table style="width: 100%; border-collapse: collapse; font-size: 14px; color: #334155;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; width: 40%;">Program:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">{$programName}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Cohort:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">{$cohortName}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Transaction Ref:</td>
                        <td style="padding: 6px 0; font-family: monospace; font-size: 13px; color: #0f172a;">{$reference}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Payment Method:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">Paystack ({$channel})</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Date & Time:</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">{$paidDate}</td>
                    </tr>
                </table>
            </div>

            <!-- Action Button -->
            <div style="text-align: center; margin-bottom: 28px;">
                <a href="{$receiptUrl}" target="_blank" style="display: inline-block; background: #f48221; color: #ffffff; text-decoration: none; padding: 13px 30px; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(244, 130, 33, 0.25);">
                    View & Print Official Receipt
                </a>
            </div>

            <!-- Next Steps -->
            <div style="background: #fdf6ec; border-left: 4px solid #f48221; padding: 14px 18px; border-radius: 4px; margin-bottom: 20px;">
                <div style="font-weight: 700; color: #9a3412; font-size: 13px; margin-bottom: 4px;">Important Next Steps:</div>
                <p style="margin: 0; color: #7c2d12; font-size: 13px; line-height: 1.5;">
                    Please retain this receipt for your records. You will receive an invitation link to the private cohort workspace prior to class commencement.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f1f5f9; padding: 18px 24px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            &copy; {$currentYear} Spider Technologies Ltd. All rights reserved.<br>
            Plot 120, Innovation Drive, Kano / Abuja, Nigeria. | support@spidertech.com.ng
        </div>
    </div>
</body>
</html>
HTML;

            $mail->AltBody = "Hello {$name},\n\nYour payment of {$amountFormatted} for {$programName} ({$cohortName}) has been received.\nInvoice: {$invoiceNumber}\nReference: {$reference}\nDate: {$paidDate}\nView Receipt: {$receiptUrl}\n\nSpider Technologies Admissions";

            return $mail->send();
        } catch (Exception $e) {
            error_log("MailHelper Error: Could not send payment receipt to {$email}. Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
