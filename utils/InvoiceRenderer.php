<?php

/**
 * InvoiceRenderer
 * 
 * Centralized SaaS-Style Receipt & Invoice Template Engine
 * Generates email-safe HTML, standalone printable web pages, and plain-text receipts.
 */
class InvoiceRenderer
{
    /**
     * Retrieve centralized company / issuer details
     */
    public static function getIssuerDetails(): array
    {
        return [
            'name'    => defined('INVOICE_COMPANY_NAME') ? INVOICE_COMPANY_NAME : 'Spider Technologies Limited',
            'address' => defined('INVOICE_COMPANY_ADDRESS') ? INVOICE_COMPANY_ADDRESS : 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano',
            'email'   => defined('INVOICE_COMPANY_EMAIL') ? INVOICE_COMPANY_EMAIL : 'info@spidertech.com.ng',
            'phone'   => defined('INVOICE_COMPANY_PHONE') ? INVOICE_COMPANY_PHONE : '+234 911 626 5708',
            'website' => defined('INVOICE_COMPANY_WEBSITE') ? INVOICE_COMPANY_WEBSITE : 'www.spidertech.com.ng',
        ];
    }

    /**
     * Format currency amount with thousands separators and 2 decimals
     */
    public static function formatNaira(int $amountKobo, bool $htmlEntity = false): string
    {
        $symbol = $htmlEntity ? '&#8358;' : '₦';
        return $symbol . number_format($amountKobo / 100, 2);
    }

    /**
     * Normalize raw application and transaction records into a unified invoice payload
     */
    public static function normalizeData(array $application = [], array $overrides = []): array
    {
        $userData = json_decode($application['user_data'] ?? '{}', true) ?: [];

        $firstName = $userData['first_name'] ?? ($userData['firstname'] ?? '');
        $lastName  = $userData['last_name'] ?? ($userData['lastname'] ?? '');
        $payerName = trim($firstName . ' ' . $lastName);
        if (empty($payerName)) {
            $payerName = $userData['full_name'] ?? ($userData['fullname'] ?? ($application['applicant_name'] ?? ($overrides['payer_name'] ?? ($overrides['name'] ?? 'Candidate'))));
        }
        if (!empty($overrides['payer_name'])) {
            $payerName = $overrides['payer_name'];
        } elseif (!empty($overrides['name'])) {
            $payerName = $overrides['name'];
        }

        $payerEmail = $overrides['payer_email'] ?? ($overrides['email'] ?? ($userData['email'] ?? ($userData['email_address'] ?? ($application['customer_email'] ?? ''))));
        $payerPhone = $overrides['payer_phone'] ?? ($overrides['phone'] ?? ($userData['phone'] ?? ($userData['phone_no'] ?? ($userData['phone_number'] ?? ''))));

        $amountKobo = (int)($overrides['amount_kobo'] ?? ($application['amount_paid'] ?? 0));
        $invoiceNumber = $overrides['invoice_number'] ?? ($application['invoice_number'] ?? 'STP-INV-0000');
        $reference = $overrides['reference'] ?? ($application['payment_reference'] ?? '');

        $rawPaidAt = $overrides['paid_at'] ?? ($application['paid_at'] ?? '');
        $paidTimestamp = !empty($rawPaidAt) ? strtotime($rawPaidAt) : time();
        $datePaidShort = date('j M Y', $paidTimestamp);
        $datePaidFull  = date('F j, Y \a\t g:i A', $paidTimestamp);

        $startDateFormatted = '';
        $rawStartDate = $overrides['start_date'] ?? ($application['start_date'] ?? '');
        if (!empty($rawStartDate)) {
            $startDateFormatted = date('M d, Y', strtotime($rawStartDate));
        }

        $receiptUrl = $overrides['receipt_url'] ?? '';
        if (empty($receiptUrl) && !empty($reference)) {
            $token = class_exists('PaystackService') ? PaystackService::generateInvoiceToken($reference) : '';
            $baseUrl = defined('BASE_URL') ? BASE_URL : '';
            $receiptUrl = $baseUrl . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($token);
        }

        $baseUrl = defined('BASE_URL') ? BASE_URL : '';
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);
        $logoUrl = $baseUrl . "/images/spider-tech.png";
        $logoWhitePath = $rootPath . "/images/spider-tech-white.png";
        $hasWhiteLogo = file_exists($logoWhitePath);
        if ($hasWhiteLogo) {
            $logoUrl = $baseUrl . "/images/spider-tech-white.png";
        }

        $programName = $overrides['program_name'] ?? ($application['training_name'] ?? 'Training Program');
        $cohortName  = $overrides['cohort_name'] ?? ($application['cohort_name'] ?? 'Cohort');
        $trainingTime = $overrides['training_time'] ?? ($application['training_time'] ?? '');

        $channelRaw = $overrides['channel'] ?? ($application['channel'] ?? 'Paystack Checkout');
        $channel = !empty($channelRaw) ? ucfirst($channelRaw) : 'Paystack Checkout';

        $backUrl = $overrides['receipt_url_back'] ?? ($baseUrl . '/trainings');

        return [
            'invoice_number'     => $invoiceNumber,
            'reference'          => $reference,
            'paystack_reference' => $application['paystack_reference'] ?? ($overrides['paystack_reference'] ?? ''),
            'amount_kobo'        => $amountKobo,
            'date_paid_short'    => $datePaidShort,
            'date_paid_full'     => $datePaidFull,
            'issuer'             => self::getIssuerDetails(),
            'payer'              => [
                'name'  => $payerName,
                'email' => $payerEmail,
                'phone' => $payerPhone,
                'id'    => (int)($application['id'] ?? 0)
            ],
            'program'            => [
                'name'       => $programName,
                'cohort'     => $cohortName,
                'start_date' => $startDateFormatted,
                'time'       => $trainingTime
            ],
            'channel'            => $channel,
            'status'             => 'PAID',
            'receipt_url'        => $receiptUrl,
            'receipt_url_back'   => $backUrl,
            'logo_url'           => $logoUrl,
            'has_white_logo'     => $hasWhiteLogo
        ];
    }

    /**
     * Render the core email-safe HTML receipt card
     */
    public static function renderReceiptHtml(array $d, bool $isEmail = false): string
    {
        $amountFormatted = self::formatNaira((int)$d['amount_kobo'], $isEmail);
        $issuer = $d['issuer'];
        $payer  = $d['payer'];
        $prog   = $d['program'];

        // Secondary description line
        $secondaryDesc = htmlspecialchars($prog['cohort']);
        if (!empty($prog['start_date'])) {
            $secondaryDesc .= ' &bull; Starts ' . htmlspecialchars($prog['start_date']);
        }

        // Logo style: if no white logo asset exists, apply CSS filter for dark header
        $logoFilter = $d['has_white_logo'] ? '' : 'filter: brightness(0) invert(1); -webkit-filter: brightness(0) invert(1);';

        $html = <<<HTML
<!-- RECEIPT CONTAINER (Max width 680px) -->
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 680px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: separate; font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #374151; font-size: 13px; line-height: 1.5;">

    <!-- 1. TOP ACCENT BAR -->
    <tr>
        <td style="height: 4px; background-color: #f48221; font-size: 0; line-height: 0; padding: 0;">&nbsp;</td>
    </tr>

    <!-- 2. DARK HEADER BAND WITH CENTERED LOGO -->
    <tr>
        <td align="center" style="background-color: #110f0d; padding: 34px 20px 28px 20px; text-align: center;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
                <tr>
                    <td align="center" style="text-align: center;">
                        <img src="{$d['logo_url']}" alt="{$issuer['name']}" height="42" style="height: 42px; max-height: 48px; width: auto; display: block; border: 0; outline: none; margin: 0 auto; {$logoFilter}" />
                        <div style="font-family: 'Poppins', Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: #cbd5e1; margin-top: 12px;">
                            PAYMENT RECEIPT
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- RECEIPT BODY CONTENT -->
    <tr>
        <td style="padding: 28px 30px;">

            <!-- 3. SUMMARY STRIP (4-COLUMN TABULAR GRID) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; background-color: #fcfdfd; border-collapse: collapse; margin-bottom: 24px;">
                <tr>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">INVOICE NO.</div>
                        <div style="font-size: 13px; font-weight: 700; color: #111827; font-family: 'Space Grotesk', monospace;">{$d['invoice_number']}</div>
                    </td>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">DATE PAID</div>
                        <div style="font-size: 13px; font-weight: 600; color: #111827;">{$d['date_paid_short']}</div>
                    </td>
                    <td width="30%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">PAYMENT REF</div>
                        <div style="font-size: 12px; font-weight: 500; color: #374151; font-family: 'Space Grotesk', monospace; word-break: break-all;">{$d['reference']}</div>
                    </td>
                    <td width="20%" class="stack-col" style="padding: 12px 14px; vertical-align: top; text-align: right;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">STATUS</div>
                        <span style="display: inline-block; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 3px; padding: 2px 8px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">PAID</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 14px 16px; border-top: 1px solid #e5e7eb; background-color: #ffffff;">
                        <div style="font-size: 22px; font-weight: 700; color: #111827; letter-spacing: -0.3px;">
                            {$amountFormatted} <span style="font-size: 13px; font-weight: 400; color: #6b7280;">paid on {$d['date_paid_short']}</span>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 4. PARTIES ROW (TWO EQUAL COLUMNS: FROM / BILLED TO) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 24px;">
                <tr>
                    <td width="50%" class="stack-col" style="padding: 16px 18px; border-right: 1px solid #e5e7eb; vertical-align: top; background-color: #ffffff;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #9ca3af; margin-bottom: 6px;">FROM</div>
                        <div style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 4px;">{$issuer['name']}</div>
                        <div style="font-size: 12px; color: #4b5563; line-height: 1.5;">
                            {$issuer['address']}<br>
                            {$issuer['email']}<br>
                            {$issuer['phone']}
                        </div>
                    </td>
                    <td width="50%" class="stack-col" style="padding: 16px 18px; vertical-align: top; background-color: #ffffff;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #9ca3af; margin-bottom: 6px;">BILLED TO</div>
                        <div style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 4px;">{$payer['name']}</div>
                        <div style="font-size: 12px; color: #4b5563; line-height: 1.5;">
                            {$payer['email']}
HTML;

        if (!empty($payer['phone'])) {
            $html .= '<br>' . htmlspecialchars($payer['phone']);
        }
        if (!empty($payer['id'])) {
            $html .= '<br><span style="color: #9ca3af;">Candidate ID: #' . (int)$payer['id'] . '</span>';
        }

        $html .= <<<HTML
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 5. ITEMS TABLE (TABULAR BREAKDOWN) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #f9fafb;">
                        <th align="left" style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #4b5563; border-bottom: 1px solid #e5e7eb;">Description</th>
                        <th align="right" width="60" style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #4b5563; border-bottom: 1px solid #e5e7eb; text-align: right;">Qty</th>
                        <th align="right" width="120" style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #4b5563; border-bottom: 1px solid #e5e7eb; text-align: right;">Unit Price</th>
                        <th align="right" width="120" style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #4b5563; border-bottom: 1px solid #e5e7eb; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; vertical-align: top;">
                            <div style="font-weight: 600; font-size: 13px; color: #111827; margin-bottom: 3px;">{$prog['name']}</div>
                            <div style="font-size: 12px; color: #6b7280;">{$secondaryDesc}</div>
                        </td>
                        <td align="right" style="padding: 14px; border-bottom: 1px solid #e5e7eb; vertical-align: top; text-align: right; font-weight: 500; color: #111827;">1</td>
                        <td align="right" style="padding: 14px; border-bottom: 1px solid #e5e7eb; vertical-align: top; text-align: right; font-weight: 500; color: #111827;">{$amountFormatted}</td>
                        <td align="right" style="padding: 14px; border-bottom: 1px solid #e5e7eb; vertical-align: top; text-align: right; font-weight: 600; color: #111827;">{$amountFormatted}</td>
                    </tr>
                </tbody>
            </table>

            <!-- 6. TOTALS TABLE (RIGHT-ALIGNED BLOCK) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">
                <tr>
                    <td class="stack-hide" width="40%">&nbsp;</td>
                    <td width="60%" class="stack-full" style="vertical-align: top;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; background-color: #fcfdfd;">
                            <tr>
                                <td style="padding: 9px 14px; border-bottom: 1px solid #e5e7eb; color: #4b5563; font-size: 12px;">Subtotal</td>
                                <td align="right" style="padding: 9px 14px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600; color: #111827; font-size: 13px;">{$amountFormatted}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 14px; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 13px; font-weight: 700;">Total</td>
                                <td align="right" style="padding: 10px 14px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 700; color: #111827; font-size: 14px;">{$amountFormatted}</td>
                            </tr>
                            <tr>
                                <td style="padding: 9px 14px; border-bottom: 1px solid #e5e7eb; color: #4b5563; font-size: 12px;">Amount Paid</td>
                                <td align="right" style="padding: 9px 14px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600; color: #111827; font-size: 13px;">({$amountFormatted})</td>
                            </tr>
                            <tr style="background-color: #f3f4f6;">
                                <td style="padding: 10px 14px; color: #111827; font-size: 13px; font-weight: 700;">Balance Due</td>
                                <td align="right" style="padding: 10px 14px; text-align: right; font-weight: 700; color: #111827; font-size: 14px;">&#8358;0.00</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- 7. PAYMENT DETAILS TABLE -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 24px;">
                <tr>
                    <td colspan="2" style="padding: 10px 14px; background-color: #f9fafb; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #4b5563; border-bottom: 1px solid #e5e7eb;">
                        Payment Details
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 12px;">Payment Method</td>
                    <td style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; font-weight: 600; color: #111827; font-size: 12px;">Paystack ({$d['channel']})</td>
                </tr>
                <tr>
                    <td style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 12px;">Transaction Reference</td>
                    <td style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; font-family: 'Space Grotesk', monospace; color: #111827; font-size: 12px;">{$d['reference']}</td>
                </tr>
                <tr>
                    <td style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 12px;">Date &amp; Time Paid</td>
                    <td style="padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 12px;">{$d['date_paid_full']}</td>
                </tr>
                <tr>
                    <td style="padding: 9px 14px; color: #6b7280; font-size: 12px;">Payment Status</td>
                    <td style="padding: 9px 14px; color: #047857; font-weight: 600; font-size: 12px;">Successful (Cleared)</td>
                </tr>
            </table>

HTML;

        // If email, show online view button
        if ($isEmail && !empty($d['receipt_url'])) {
            $html .= <<<HTML
            <!-- ONLINE RECEIPT BUTTON FOR EMAIL -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">
                <tr>
                    <td align="center" style="text-align: center; padding: 6px 0;">
                        <a href="{$d['receipt_url']}" target="_blank" style="display: inline-block; background-color: #110f0d; color: #ffffff; text-decoration: none; padding: 11px 24px; border-radius: 4px; font-weight: 600; font-size: 13px; letter-spacing: 0.2px;">
                            View Official Online Receipt
                        </a>
                    </td>
                </tr>
            </table>
HTML;
        }

        $html .= <<<HTML
        </td>
    </tr>

    <!-- 8. FOOTER BLOCK -->
    <tr>
        <td style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 22px 30px; text-align: center; font-size: 11px; color: #6b7280; line-height: 1.6;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 3px;">
                Thank you for your payment to {$issuer['name']}.
            </div>
            <div>
                Questions? Contact <a href="mailto:{$issuer['email']}" style="color: #f48221; text-decoration: none;">{$issuer['email']}</a> or {$issuer['phone']}
            </div>
            <div style="margin-top: 4px;">
                {$issuer['address']}
            </div>
            <div style="font-size: 10px; color: #9ca3af; margin-top: 8px; font-style: italic;">
                This is a computer-generated receipt and does not require a signature.
            </div>
        </td>
    </tr>

</table>
HTML;

        return $html;
    }

    /**
     * Render a complete, standalone web page for printable invoice and callback view
     */
    public static function renderStandalonePage(array $d, array $options = []): string
    {
        $receiptHtml = self::renderReceiptHtml($d, false);
        $showActions = $options['show_actions'] ?? true;
        $pageTitle = "Official Payment Receipt - " . htmlspecialchars($d['invoice_number']) . " — " . htmlspecialchars($d['issuer']['name']);

        $actionsHtml = '';
        if ($showActions) {
            $actionsHtml = <<<HTML
    <!-- ACTION TOOLBAR (Hidden in Print) -->
    <div class="no-print" style="max-width: 680px; margin: 0 auto 18px auto; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
        <a href="{$d['receipt_url_back']}" class="btn-invoice-back" style="display: inline-flex; align-items: center; gap: 6px; background-color: #ffffff; color: #111827; border: 1px solid #d1d5db; border-radius: 4px; padding: 8px 16px; font-size: 13px; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.15s ease;">
            &larr; Back to Programs
        </a>

        <button onclick="window.print()" class="btn-invoice-print" style="display: inline-flex; align-items: center; gap: 6px; background-color: #110f0d; color: #ffffff; border: 1px solid #110f0d; border-radius: 4px; padding: 8px 18px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.15s ease;">
            <span>Print / Save as PDF</span>
        </button>
    </div>
HTML;
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$pageTitle}</title>
    <link rel="icon" type="image/png" href="{$d['logo_url']}">

    <!-- Google Fonts: Poppins & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f3f4f6;
            color: #374151;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            padding: 32px 14px 60px 14px;
            -webkit-font-smoothing: antialiased;
        }

        .btn-invoice-back:hover {
            background-color: #f9fafb !important;
            border-color: #9ca3af !important;
            color: #f48221 !important;
        }
        .btn-invoice-print:hover {
            background-color: #27272a !important;
            border-color: #27272a !important;
        }

        /* Responsive rules */
        @media only screen and (max-width: 520px) {
            body {
                padding: 16px 8px 36px 8px;
            }
            .stack-col {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                border-right: none !important;
                border-bottom: 1px solid #e5e7eb !important;
            }
            .stack-col:last-child {
                border-bottom: none !important;
            }
            .stack-hide {
                display: none !important;
            }
            .stack-full {
                width: 100% !important;
            }
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 12px !important;
            }
            .no-print {
                display: none !important;
            }
            table {
                box-shadow: none !important;
                border: 1px solid #d1d5db !important;
                border-radius: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    {$actionsHtml}

    {$receiptHtml}

</body>
</html>
HTML;
    }

    /**
     * Render ASCII plain-text receipt for email fallback
     */
    public static function renderPlainText(array $d): string
    {
        $issuer = $d['issuer'];
        $payer  = $d['payer'];
        $prog   = $d['program'];
        $amount = self::formatNaira((int)$d['amount_kobo'], false);

        $out  = "========================================================\n";
        $out .= "             {$issuer['name']}\n";
        $out .= "                  PAYMENT RECEIPT\n";
        $out .= "========================================================\n\n";

        $out .= "INVOICE NO:        {$d['invoice_number']}\n";
        $out .= "DATE PAID:         {$d['date_paid_short']}\n";
        $out .= "STATUS:            PAID (Verified)\n";
        $out .= "TOTAL PAID:        {$amount}\n\n";

        $out .= "--------------------------------------------------------\n";
        $out .= "FROM:\n";
        $out .= "{$issuer['name']}\n";
        $out .= "{$issuer['address']}\n";
        $out .= "Email: {$issuer['email']} | Phone: {$issuer['phone']}\n\n";

        $out .= "BILLED TO:\n";
        $out .= "{$payer['name']}\n";
        $out .= "Email: {$payer['email']}\n";
        if (!empty($payer['phone'])) {
            $out .= "Phone: {$payer['phone']}\n";
        }
        $out .= "--------------------------------------------------------\n\n";

        $out .= "ITEM DETAILS:\n";
        $out .= "Program:           {$prog['name']}\n";
        $out .= "Cohort:            {$prog['cohort']}\n";
        if (!empty($prog['start_date'])) {
            $out .= "Start Date:        {$prog['start_date']}\n";
        }
        $out .= "Quantity:          1\n";
        $out .= "Price / Amount:    {$amount}\n\n";

        $out .= "TOTALS:\n";
        $out .= "Subtotal:          {$amount}\n";
        $out .= "Total Paid:        {$amount}\n";
        $out .= "Balance Due:       NGN 0.00\n\n";

        $out .= "PAYMENT AUDIT:\n";
        $out .= "Gateway:           Paystack ({$d['channel']})\n";
        $out .= "Reference:         {$d['reference']}\n";
        $out .= "Paid At:           {$d['date_paid_full']}\n\n";

        if (!empty($d['receipt_url'])) {
            $out .= "View Online Receipt: {$d['receipt_url']}\n\n";
        }

        $out .= "--------------------------------------------------------\n";
        $out .= "Thank you for your payment to {$issuer['name']}.\n";
        $out .= "Questions? Contact {$issuer['email']} or {$issuer['phone']}\n";
        $out .= "This is a computer-generated receipt and does not require a signature.\n";
        $out .= "========================================================\n";

        return $out;
    }
}
