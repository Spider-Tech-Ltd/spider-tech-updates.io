<?php

/**
 * InvoiceRenderer
 * 
 * Centralized SaaS-Style Receipt & Invoice Engine — Spider Tech
 * - Single shared template for on-site printable web page and Dompdf PDF generation.
 * - Generates email-safe Typeform-style notification emails with PDF attachment.
 * - Generates plain-text fallbacks.
 */

use Dompdf\Dompdf;
use Dompdf\Options;

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
     * Format clean track title combining program name and cohort without awkward repetition
     */
    public static function formatTrackTitle(string $programName, string $cohortName): string
    {
        $programName = trim($programName);
        $cohortName  = trim($cohortName);

        if (empty($cohortName) || $cohortName === 'Upcoming Cohort' || $cohortName === 'Current Cohort') {
            return $programName;
        }

        if (stripos($cohortName, $programName) !== false) {
            return $cohortName;
        }

        return "{$programName} – {$cohortName}";
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
        $payerPhone = $overrides['payer_phone'] ?? ($overrides['phone'] ?? ($userData['phone'] ?? ($userData['phone_no'] ?? ($userData['phone_number'] ?? 'Not provided'))));
        if (empty($payerPhone)) {
            $payerPhone = 'Not provided';
        }

        $amountKobo = (int)($overrides['amount_kobo'] ?? ($application['amount_paid'] ?? 0));
        $invoiceNumber = $overrides['invoice_number'] ?? ($application['invoice_number'] ?? 'STP-INV-0000');
        $reference = $overrides['reference'] ?? ($application['payment_reference'] ?? '');

        // Standard date format: "2 Nov 2026"
        $rawPaidAt = $overrides['paid_at'] ?? ($application['paid_at'] ?? '');
        $paidTimestamp = !empty($rawPaidAt) ? strtotime($rawPaidAt) : time();
        $datePaidStandard = date('j M Y', $paidTimestamp);
        $datePaidAudit    = date('j M Y \a\t g:i A', $paidTimestamp);

        $startDateFormatted = 'To Be Announced';
        $rawStartDate = $overrides['start_date'] ?? ($application['start_date'] ?? '');
        if (!empty($rawStartDate)) {
            $startDateFormatted = date('j M Y', strtotime($rawStartDate));
        }

        $baseUrl = defined('BASE_URL') ? BASE_URL : '';
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);

        $receiptUrl = $overrides['receipt_url'] ?? '';
        $receiptDownloadUrl = '';
        if (empty($receiptUrl) && !empty($reference)) {
            $token = class_exists('PaystackService') ? PaystackService::generateInvoiceToken($reference) : '';
            $receiptUrl = $baseUrl . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($token);
            $receiptDownloadUrl = $baseUrl . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($token) . "&download=pdf";
        } elseif (!empty($receiptUrl)) {
            $receiptDownloadUrl = $receiptUrl . (str_contains($receiptUrl, '?') ? '&' : '?') . 'download=pdf';
        }

        // Logo files
        $logoPath = $rootPath . "/images/spider-tech.png";
        $logoUrl  = $baseUrl . "/images/spider-tech.png";
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $programName = $overrides['program_name'] ?? ($application['training_name'] ?? 'Training Program');
        $cohortName  = $overrides['cohort_name'] ?? ($application['cohort_name'] ?? 'Upcoming Cohort');
        $trainingTime = $overrides['training_time'] ?? ($application['training_time'] ?? '');

        $channelRaw = $overrides['channel'] ?? ($application['channel'] ?? 'Paystack Checkout');
        $channel = !empty($channelRaw) ? ucfirst($channelRaw) : 'Online Payment';

        $backUrl = $overrides['receipt_url_back'] ?? ($baseUrl . '/trainings');
        $applicantId = (int)($application['id'] ?? ($overrides['applicant_id'] ?? 0));

        return [
            'invoice_number'       => $invoiceNumber,
            'receipt_number'       => $invoiceNumber,
            'reference'            => $reference,
            'paystack_reference'   => $application['paystack_reference'] ?? ($overrides['paystack_reference'] ?? ''),
            'amount_kobo'          => $amountKobo,
            'date_paid_standard'   => $datePaidStandard,
            'date_paid_audit'      => $datePaidAudit,
            'issuer'               => self::getIssuerDetails(),
            'payer'                => [
                'name'         => $payerName,
                'first_name'   => $firstName ?: $payerName,
                'email'        => $payerEmail,
                'phone'        => $payerPhone,
                'applicant_id' => $applicantId
            ],
            'program'              => [
                'name'        => $programName,
                'cohort'      => $cohortName,
                'track_title' => self::formatTrackTitle($programName, $cohortName),
                'start_date'  => $startDateFormatted,
                'time'        => $trainingTime
            ],
            'channel'              => $channel,
            'status'               => 'PAID',
            'receipt_url'          => $receiptUrl,
            'receipt_url_download' => $receiptDownloadUrl,
            'receipt_url_back'     => $backUrl,
            'logo_url'             => $logoUrl,
            'logo_base64'          => $logoBase64,
            'logo_path'            => $logoPath,
            'logo_cid'             => $overrides['logo_cid'] ?? ''
        ];
    }

    /**
     * Render the core shared receipt card template (HTML table-based)
     * Used for both on-site printable page and Dompdf PDF generation.
     */
    public static function renderReceiptHtml(array $d, bool $isPdf = false): string
    {
        $amountFormatted = self::formatNaira((int)$d['amount_kobo'], false);
        $issuer = $d['issuer'];
        $payer  = $d['payer'];
        $prog   = $d['program'];

        // In PDF context, use DejaVu Sans so the Naira glyph (₦) renders cleanly
        $fontStack = $isPdf
            ? "'DejaVu Sans', sans-serif"
            : "'Poppins', 'DejaVu Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";

        $monoFontStack = $isPdf
            ? "'DejaVu Sans', monospace"
            : "'Space Grotesk', 'DejaVu Sans', monospace";

        // Logo src: base64 Data URI for PDF to guarantee instant offline loading without cURL
        $logoSrc = ($isPdf && !empty($d['logo_base64'])) ? $d['logo_base64'] : $d['logo_url'];

        // Option A Header: Clean white background, unaltered full-color logo (width 220px, height auto, no filter)
        // Spacing: 34px above, 24px below logo to label, 30px bottom
        $applicantIdDisplay = !empty($payer['applicant_id']) ? "Applicant ID: #{$payer['applicant_id']}" : "Applicant ID: Pending";

        $html = <<<HTML
<!-- RECEIPT CONTAINER (Width 680px) -->
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 680px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: separate; font-family: {$fontStack}; color: #374151; font-size: 13px; line-height: 1.5;">

    <!-- 1. TOP ACCENT BAR (4px brand orange) -->
    <tr>
        <td style="height: 4px; background-color: #f48221; font-size: 0; line-height: 0; padding: 0; border: 0;">&nbsp;</td>
    </tr>

    <!-- 2. OPTION A: CLEAN LIGHT HEADER BAND (Original Full-Color Logo, Larger, Centered, No Border) -->
    <tr>
        <td align="center" style="background-color: #ffffff; padding: 36px 20px 26px 20px; text-align: center; border-bottom: 1px solid #e5e7eb;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; text-align: center;">
                <tr>
                    <td align="center" style="text-align: center;">
                        <img src="{$logoSrc}" alt="{$issuer['name']}" width="220" style="width: 220px; max-width: 70%; height: auto; display: block; margin: 0 auto; border: 0; outline: none;" />
                        <div style="font-family: {$fontStack}; font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: #6b7280; margin-top: 22px;">
                            PAYMENT RECEIPT
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- RECEIPT BODY CONTENT -->
    <tr>
        <td style="padding: 26px 28px;">

            <!-- 3. SUMMARY STRIP (4 Equal Bordered Columns + Large Amount Paid Banner) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; background-color: #ffffff; border-collapse: collapse; margin-bottom: 22px;">
                <tr>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top; width: 25%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">RECEIPT NO.</div>
                        <div style="font-size: 13px; font-weight: 700; color: #111827; font-family: {$monoFontStack};">{$d['invoice_number']}</div>
                    </td>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top; width: 25%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">DATE PAID</div>
                        <div style="font-size: 13px; font-weight: 600; color: #111827;">{$d['date_paid_standard']}</div>
                    </td>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; border-right: 1px solid #e5e7eb; vertical-align: top; width: 25%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 4px;">PAYMENT REF</div>
                        <div style="font-size: 11px; font-weight: 600; color: #111827; font-family: {$monoFontStack}; word-break: break-all;">{$d['reference']}</div>
                    </td>
                    <td width="25%" class="stack-col" style="padding: 12px 14px; vertical-align: top; width: 25%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 5px;">STATUS</div>
                        <div>
                            <span style="display: inline-block; padding: 2px 8px; font-size: 11px; font-weight: 700; color: #047857; background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 3px; letter-spacing: 0.5px;">PAID</span>
                        </div>
                    </td>
                </tr>
                <!-- Amount Paid Large Banner -->
                <tr>
                    <td colspan="4" style="border-top: 1px solid #e5e7eb; background-color: #f9fafb; padding: 13px 16px;">
                        <span style="font-size: 19px; font-weight: 700; color: #111827; font-family: {$monoFontStack};">
                            {$amountFormatted}
                        </span>
                        <span style="font-size: 13px; font-weight: 500; color: #4b5563; margin-left: 6px;">
                            paid on {$d['date_paid_standard']}
                        </span>
                    </td>
                </tr>
            </table>

            <!-- 4. PARTIES ROW (2 Equal Bordered Columns: FROM vs BILLED TO) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 22px;">
                <tr>
                    <!-- FROM (Issuer) -->
                    <td width="50%" class="stack-col" style="padding: 14px 16px; border-right: 1px solid #e5e7eb; vertical-align: top; width: 50%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 6px;">FROM</div>
                        <div style="font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 3px;">{$issuer['name']}</div>
                        <div style="color: #4b5563; font-size: 12px; line-height: 1.45; margin-bottom: 4px;">
                            {$issuer['address']}
                        </div>
                        <div style="color: #4b5563; font-size: 12px; line-height: 1.45;">
                            Email: {$issuer['email']}<br>
                            Phone: {$issuer['phone']}
                        </div>
                    </td>
                    <!-- BILLED TO (Payer) -->
                    <td width="50%" class="stack-col" style="padding: 14px 16px; vertical-align: top; width: 50%;">
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 6px;">BILLED TO</div>
                        <div style="font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 3px;">{$payer['name']}</div>
                        <div style="color: #4b5563; font-size: 12px; line-height: 1.45; margin-bottom: 2px;">
                            Email: {$payer['email']}
                        </div>
                        <div style="color: #4b5563; font-size: 12px; line-height: 1.45; margin-bottom: 4px;">
                            Phone: {$payer['phone']}
                        </div>
                        <div style="font-size: 11px; font-weight: 600; color: #6b7280; font-family: {$monoFontStack};">
                            {$applicantIdDisplay}
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 5. ITEMS TABLE (Training | Cohort | Start Date | Seats | Amount) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th align="left" style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; width: 34%;">TRAINING</th>
                        <th align="left" style="padding: 10px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; width: 22%;">COHORT</th>
                        <th align="left" style="padding: 10px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; width: 18%;">START DATE</th>
                        <th align="center" style="padding: 10px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; width: 8%; text-align: center;">SEATS</th>
                        <th align="right" style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; width: 18%; text-align: right;">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 12px 14px; font-size: 13px; font-weight: 600; color: #111827; vertical-align: top; border-bottom: 1px solid #e5e7eb;">
                            {$prog['name']}
                        </td>
                        <td style="padding: 12px 12px; font-size: 12px; color: #374151; vertical-align: top; border-bottom: 1px solid #e5e7eb;">
                            {$prog['cohort']}
                        </td>
                        <td style="padding: 12px 12px; font-size: 12px; color: #374151; vertical-align: top; border-bottom: 1px solid #e5e7eb;">
                            {$prog['start_date']}
                        </td>
                        <td align="center" style="padding: 12px 10px; font-size: 12px; color: #111827; font-weight: 600; vertical-align: top; text-align: center; border-bottom: 1px solid #e5e7eb;">
                            1
                        </td>
                        <td align="right" style="padding: 12px 14px; font-size: 13px; font-weight: 700; color: #111827; vertical-align: top; text-align: right; font-family: {$monoFontStack}; border-bottom: 1px solid #e5e7eb;">
                            {$amountFormatted}
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- 6. TOTALS BLOCK (Right-Aligned Bordered Table, No Empty Left Cell) -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">
                <tr>
                    <td class="stack-hide" width="50%">&nbsp;</td>
                    <td width="50%" align="right" class="stack-full">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 300px; border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-left: auto;">
                            <tr>
                                <td style="padding: 9px 12px; font-size: 12px; color: #4b5563; font-weight: 500; border-bottom: 1px solid #e5e7eb;">Subtotal</td>
                                <td align="right" style="padding: 9px 12px; font-size: 12px; font-weight: 600; color: #111827; text-align: right; font-family: {$monoFontStack}; border-bottom: 1px solid #e5e7eb;">{$amountFormatted}</td>
                            </tr>
                            <tr style="background-color: #fafbfc;">
                                <td style="padding: 9px 12px; font-size: 13px; color: #111827; font-weight: 700; border-bottom: 1px solid #e5e7eb;">Total</td>
                                <td align="right" style="padding: 9px 12px; font-size: 13px; font-weight: 700; color: #111827; text-align: right; font-family: {$monoFontStack}; border-bottom: 1px solid #e5e7eb;">{$amountFormatted}</td>
                            </tr>
                            <tr>
                                <td style="padding: 9px 12px; font-size: 12px; color: #047857; font-weight: 600; border-bottom: 1px solid #e5e7eb;">Amount Paid</td>
                                <td align="right" style="padding: 9px 12px; font-size: 12px; font-weight: 700; color: #047857; text-align: right; font-family: {$monoFontStack}; border-bottom: 1px solid #e5e7eb;">{$amountFormatted}</td>
                            </tr>
                            <tr>
                                <td style="padding: 9px 12px; font-size: 12px; color: #6b7280; font-weight: 600;">Balance Due</td>
                                <td align="right" style="padding: 9px 12px; font-size: 12px; font-weight: 700; color: #111827; text-align: right; font-family: {$monoFontStack};">₦0.00</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- 7. PAYMENT DETAILS TABLE (Bordered Label/Value Audit Rows) -->
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 6px;">
                PAYMENT AUDIT TRAIL
            </div>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; border-collapse: collapse; margin-bottom: 10px;">
                <tr>
                    <td width="35%" style="padding: 8px 14px; background-color: #f9fafb; font-size: 12px; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">Payment Method</td>
                    <td style="padding: 8px 14px; font-size: 12px; color: #111827; border-bottom: 1px solid #e5e7eb;">Paystack ({$d['channel']})</td>
                </tr>
                <tr>
                    <td width="35%" style="padding: 8px 14px; background-color: #f9fafb; font-size: 12px; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">Transaction Reference</td>
                    <td style="padding: 8px 14px; font-size: 12px; font-family: {$monoFontStack}; color: #111827; border-bottom: 1px solid #e5e7eb;">{$d['reference']}</td>
                </tr>
                <tr>
                    <td width="35%" style="padding: 8px 14px; background-color: #f9fafb; font-size: 12px; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">Date & Time Paid</td>
                    <td style="padding: 8px 14px; font-size: 12px; color: #111827; border-bottom: 1px solid #e5e7eb;">{$d['date_paid_audit']}</td>
                </tr>
                <tr>
                    <td width="35%" style="padding: 8px 14px; background-color: #f9fafb; font-size: 12px; font-weight: 600; color: #4b5563; border-right: 1px solid #e5e7eb;">Gateway Status</td>
                    <td style="padding: 8px 14px; font-size: 12px; color: #047857; font-weight: 600;">Success (Verified)</td>
                </tr>
            </table>

        </td>
    </tr>

    <!-- 8. FOOTER BLOCK -->
    <tr>
        <td style="background-color: #fafbfc; border-top: 1px solid #e5e7eb; padding: 22px 28px; text-align: center; font-size: 11px; color: #6b7280; line-height: 1.6;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 3px;">
                Thank you for your payment to {$issuer['name']}.
            </div>
            <div>
                Questions? Contact <a href="mailto:{$issuer['email']}" style="color: #f48221; text-decoration: none;">{$issuer['email']}</a> or {$issuer['phone']}
            </div>
            <div style="margin-top: 3px;">
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
     * Render a complete standalone web page for printable invoice and success callback view
     */
    public static function renderStandalonePage(array $d, array $options = []): string
    {
        $receiptHtml = self::renderReceiptHtml($d, false);
        $showActions = $options['show_actions'] ?? true;
        $pageTitle = "Payment Receipt - " . htmlspecialchars($d['invoice_number']) . " — " . htmlspecialchars($d['issuer']['name']);

        $actionsHtml = '';
        if ($showActions) {
            $downloadBtn = '';
            if (!empty($d['receipt_url_download'])) {
                $downloadBtn = <<<HTML
            <a href="{$d['receipt_url_download']}" class="btn-invoice-download" style="display: inline-flex; align-items: center; gap: 6px; background-color: #f48221; color: #ffffff; border: 1px solid #f48221; border-radius: 4px; padding: 8px 18px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.15s ease;">
                <span>Download PDF</span>
            </a>
HTML;
            }

            $actionsHtml = <<<HTML
    <!-- ACTION TOOLBAR (Hidden in Print) -->
    <div class="no-print" style="max-width: 680px; margin: 0 auto 18px auto; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
        <a href="{$d['receipt_url_back']}" class="btn-invoice-back" style="display: inline-flex; align-items: center; gap: 6px; background-color: #ffffff; color: #111827; border: 1px solid #d1d5db; border-radius: 4px; padding: 8px 16px; font-size: 13px; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.15s ease;">
            &larr; Back to Programs
        </a>

        <div style="display: flex; align-items: center; gap: 10px;">
            {$downloadBtn}
            <button onclick="window.print()" class="btn-invoice-print" style="display: inline-flex; align-items: center; gap: 6px; background-color: #110f0d; color: #ffffff; border: 1px solid #110f0d; border-radius: 4px; padding: 8px 18px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.15s ease;">
                <span>Print Receipt</span>
            </button>
        </div>
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
        .btn-invoice-download:hover {
            background-color: #e6751c !important;
            border-color: #e6751c !important;
        }
        .btn-invoice-print:hover {
            background-color: #27272a !important;
            border-color: #27272a !important;
        }

        /* Responsive rules */
        @media only screen and (max-width: 540px) {
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
     * Generate Receipt PDF binary using Dompdf (A4 portrait, full-bleed header)
     */
    public static function generatePdf(array $d): string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        // Core receipt markup generated with $isPdf = true
        $receiptCardHtml = self::renderReceiptHtml($d, true);

        // Zero page margin with inner padding for full-bleed orange bar and header
        $pdfHtml = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt {$d['invoice_number']}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0mm;
        }
        body {
            margin: 0mm;
            padding: 15mm;
            background-color: #ffffff;
            font-family: 'DejaVu Sans', sans-serif;
            color: #374151;
            font-size: 12px;
            line-height: 1.45;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    {$receiptCardHtml}
</body>
</html>
HTML;

        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Save Receipt PDF to secure storage directory and return path
     */
    public static function savePdf(array $d, ?string $destinationPath = null): string
    {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);
        $storageDir = $rootPath . '/storage/receipts';
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        if (empty($destinationPath)) {
            $cleanInv = preg_replace('/[^A-Za-z0-9_-]/', '', $d['invoice_number']);
            $destinationPath = $storageDir . "/invoice_{$cleanInv}.pdf";
        }

        $pdfBytes = self::generatePdf($d);
        file_put_contents($destinationPath, $pdfBytes);

        return $destinationPath;
    }

    /**
     * Render Typeform-style short HTML email body with key facts and PDF notice
     */
    public static function renderEmailHtml(array $d): string
    {
        $amountFormatted = self::formatNaira((int)$d['amount_kobo'], true);
        $issuer = $d['issuer'];
        $payer  = $d['payer'];
        $prog   = $d['program'];

        $firstName = htmlspecialchars($payer['first_name'] ?: 'Applicant');
        $greeting = !empty($firstName) && $firstName !== 'Candidate' ? "Hi {$firstName}," : "Hello,";

        // Clean track title (e.g. "we Digitize - Cohort 1")
        $trackTitle = htmlspecialchars($prog['track_title'] ?? self::formatTrackTitle($prog['name'], $prog['cohort']));

        // Start date clause
        $hasStartDate = !empty($prog['start_date']) && $prog['start_date'] !== 'To Be Announced';
        $startDateClause = $hasStartDate ? " starting on <strong>" . htmlspecialchars($prog['start_date']) . "</strong>" : "";

        // Logo src: CID inline attachment for email clients, base64 or URL fallback for browser previews
        $logoSrc = !empty($d['logo_cid'])
            ? 'cid:' . $d['logo_cid']
            : (!empty($d['logo_base64']) ? $d['logo_base64'] : $d['logo_url']);

        $startDateRow = '';
        if ($hasStartDate) {
            $startDateRow = <<<HTML
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #e5e7eb; width: 38%;">Start date</td>
                        <td style="padding: 10px 14px; font-size: 13px; font-weight: 600; color: #111827; border-bottom: 1px solid #e5e7eb;">{$prog['start_date']}</td>
                    </tr>
HTML;
        }

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your payment receipt</title>
</head>
<body style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 24px 12px; color: #374151; font-size: 14px; line-height: 1.6;">

    <!-- EMAIL CONTAINER (Max width 600px) -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden;">

        <!-- 1. TOP ACCENT BAR -->
        <tr>
            <td style="height: 4px; background-color: #f48221; font-size: 0; line-height: 0; padding: 0;">&nbsp;</td>
        </tr>

        <!-- 2. OPTION A LIGHT HEADER WITH CENTERED ORIGINAL LOGO -->
        <tr>
            <td align="center" style="background-color: #ffffff; padding: 32px 20px 22px 20px; text-align: center; border-bottom: 1px solid #e5e7eb;">
                <img src="{$logoSrc}" alt="{$issuer['name']}" width="220" style="width: 220px; max-width: 75%; height: auto; display: block; margin: 0 auto; border: 0;" />
                <div style="font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: #6b7280; margin-top: 18px;">
                    PAYMENT RECEIPT
                </div>
            </td>
        </tr>

        <!-- 3. EMAIL BODY -->
        <tr>
            <td style="padding: 30px 28px;">

                <h2 style="font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 16px 0;">
                    Here's your payment receipt
                </h2>

                <p style="margin: 0 0 14px 0; color: #374151; font-size: 14px;">
                    {$greeting}
                </p>

                <p style="margin: 0 0 22px 0; color: #4b5563; font-size: 14px; line-height: 1.6;">
                    Thank you for your payment. Your enrollment for <strong>{$trackTitle}</strong>{$startDateClause} has been confirmed, and your official payment receipt is attached to this email as a PDF for your records.
                </p>

                <!-- STACKED KEY FACTS BOX (Typeform Style) -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #e5e7eb; border-radius: 4px; background-color: #fafbfc; border-collapse: collapse; margin-bottom: 24px;">
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #e5e7eb; width: 38%;">Receipt number</td>
                        <td style="padding: 10px 14px; font-size: 13px; font-weight: 700; color: #111827; font-family: monospace; border-bottom: 1px solid #e5e7eb;">{$d['invoice_number']}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Program & Cohort</td>
                        <td style="padding: 10px 14px; font-size: 13px; font-weight: 600; color: #111827; border-bottom: 1px solid #e5e7eb;">{$trackTitle}</td>
                    </tr>
                    {$startDateRow}
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Amount paid</td>
                        <td style="padding: 10px 14px; font-size: 14px; font-weight: 700; color: #111827; border-bottom: 1px solid #e5e7eb;">{$amountFormatted}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Status</td>
                        <td style="padding: 10px 14px; font-size: 13px; font-weight: 700; color: #047857; border-bottom: 1px solid #e5e7eb;">Paid</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 14px; font-size: 12px; color: #6b7280;">Date paid</td>
                        <td style="padding: 10px 14px; font-size: 13px; font-weight: 600; color: #111827;">{$d['date_paid_standard']}</td>
                    </tr>
                </table>

                <div style="text-align: center; margin-bottom: 26px;">
                    <a href="{$d['receipt_url']}" target="_blank" style="display: inline-block; background-color: #f48221; color: #ffffff; text-decoration: none; padding: 11px 26px; border-radius: 4px; font-weight: 600; font-size: 13px;">
                        View receipt online
                    </a>
                </div>

                <p style="margin: 0 0 18px 0; color: #4b5563; font-size: 13px;">
                    Thanks for being part of our community.
                </p>

                <!-- HELP BLOCK -->
                <div style="border-top: 1px solid #f0f2f5; padding-top: 16px; margin-bottom: 18px;">
                    <div style="font-weight: 700; font-size: 13px; color: #111827; margin-bottom: 4px;">
                        Need help with your registration?
                    </div>
                    <div style="font-size: 13px; color: #4b5563;">
                        Contact us at <a href="mailto:{$issuer['email']}" style="color: #f48221; text-decoration: none;">{$issuer['email']}</a> or {$issuer['phone']}.
                    </div>
                </div>

            </td>
        </tr>

        <!-- 4. LIGHT GREY FOOTER BOX -->
        <tr>
            <td style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 18px 24px; text-align: center; font-size: 11px; color: #6b7280; line-height: 1.5;">
                <div style="font-weight: 600; color: #374151; margin-bottom: 2px;">
                    {$issuer['name']}
                </div>
                <div>
                    {$issuer['address']}
                </div>
                <div style="margin-top: 6px; font-style: italic; color: #9ca3af;">
                    This is an automated message.
                </div>
            </td>
        </tr>

    </table>

</body>
</html>
HTML;

        return $html;
    }

    /**
     * Render Typeform-style plain text alternative for applicant email
     */
    public static function renderEmailPlainText(array $d): string
    {
        $amount = self::formatNaira((int)$d['amount_kobo'], false);
        $issuer = $d['issuer'];
        $payer  = $d['payer'];
        $prog   = $d['program'];

        $firstName = $payer['first_name'] ?: 'Applicant';
        $greeting = !empty($firstName) && $firstName !== 'Candidate' ? "Hi {$firstName}," : "Hello,";

        $trackTitle = $prog['track_title'] ?? self::formatTrackTitle($prog['name'], $prog['cohort']);
        $hasStartDate = !empty($prog['start_date']) && $prog['start_date'] !== 'To Be Announced';
        $startDateClause = $hasStartDate ? " starting on {$prog['start_date']}" : "";

        $out  = "HERE'S YOUR PAYMENT RECEIPT\n\n";
        $out .= "{$greeting}\n\n";
        $out .= "Thank you for your payment. Your enrollment for {$trackTitle}{$startDateClause} has been confirmed, and your official payment receipt is attached to this email as a PDF for your records.\n\n";
        $out .= "KEY FACTS:\n";
        $out .= "- Receipt number:    {$d['invoice_number']}\n";
        $out .= "- Program & Cohort:  {$trackTitle}\n";
        if ($hasStartDate) {
            $out .= "- Start date:        {$prog['start_date']}\n";
        }
        $out .= "- Amount paid:       {$amount}\n";
        $out .= "- Status:            Paid\n";
        $out .= "- Date paid:         {$d['date_paid_standard']}\n\n";
        if (!empty($d['receipt_url'])) {
            $out .= "View receipt online: {$d['receipt_url']}\n\n";
        }
        $out .= "Thanks for being part of our community.\n\n";
        $out .= "Need help with your registration?\n";
        $out .= "Contact us at {$issuer['email']} or {$issuer['phone']}.\n\n";
        $out .= "--------------------------------------------------------\n";
        $out .= "{$issuer['name']}\n";
        $out .= "{$issuer['address']}\n";
        $out .= "This is an automated message.\n";

        return $out;
    }

    /**
     * Render ASCII plain-text receipt for complete fallback
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

        $out .= "RECEIPT NO:        {$d['invoice_number']}\n";
        $out .= "DATE PAID:         {$d['date_paid_standard']}\n";
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
        $out .= "Applicant ID: #{$payer['applicant_id']}\n";
        $out .= "--------------------------------------------------------\n\n";

        $out .= "ITEM DETAILS:\n";
        $out .= "Training:          {$prog['name']}\n";
        $out .= "Cohort:            {$prog['cohort']}\n";
        $out .= "Start Date:        {$prog['start_date']}\n";
        $out .= "Seats:             1\n";
        $out .= "Amount:            {$amount}\n\n";

        $out .= "TOTALS:\n";
        $out .= "Subtotal:          {$amount}\n";
        $out .= "Total:             {$amount}\n";
        $out .= "Amount Paid:       {$amount}\n";
        $out .= "Balance Due:       NGN 0.00\n\n";

        $out .= "PAYMENT AUDIT:\n";
        $out .= "Gateway:           Paystack ({$d['channel']})\n";
        $out .= "Reference:         {$d['reference']}\n";
        $out .= "Paid At:           {$d['date_paid_audit']}\n\n";

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
