<?php
/**
 * Official Payment Receipt & Enrollment Confirmation View — Spider Tech
 * Standalone brand-styled receipt page with print/PDF support.
 */

$userData = json_decode($application['user_data'] ?? '{}', true) ?: [];

$firstName = $userData['first_name'] ?? ($userData['firstname'] ?? '');
$lastName  = $userData['last_name'] ?? ($userData['lastname'] ?? '');
$applicantName = trim($firstName . ' ' . $lastName);
if (empty($applicantName)) {
    $applicantName = $userData['full_name'] ?? ($userData['fullname'] ?? 'Candidate');
}

$applicantEmail = $userData['email'] ?? ($userData['email_address'] ?? ($application['customer_email'] ?? 'Not provided'));
$applicantPhone = $userData['phone'] ?? ($userData['phone_no'] ?? ($userData['phone_number'] ?? ''));

$invoiceNumber = $application['invoice_number'] ?? ($invoice_number ?? 'STP-INV-0000');
$formattedAmount = PaystackService::formatKobo((int)($amount_kobo ?? $application['amount_paid'] ?? 0));
$paidDate = !empty($application['paid_at']) ? date('F j, Y \a\t g:i A', strtotime($application['paid_at'])) : date('F j, Y \a\t g:i A');

$programName = $application['training_name'] ?? 'Professional Training Track';
$cohortName  = $application['cohort_name'] ?? 'Upcoming Cohort';
$trainingTime = !empty($application['training_time']) ? $application['training_time'] : '09:00 AM – 02:00 PM';
$channelName = !empty($application['channel']) ? ucfirst($application['channel']) : 'Paystack Checkout';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - <?= htmlspecialchars($invoiceNumber) ?> — Spider Tech</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/images/spider-tech.png">
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        :root {
            --primary-orange: #f48221;
            --primary-orange-hover: #e6751c;
            --primary-orange-light: rgba(244, 130, 33, 0.08);
            --primary-orange-border: rgba(244, 130, 33, 0.25);
            --dark-navy: #0f172a;
            --darker-bg: #090d16;
            --canvas-bg: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --text-main: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --success-green: #10b981;
            --success-green-light: rgba(16, 185, 129, 0.09);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--canvas-bg);
            color: var(--text-body);
            min-height: 100vh;
            padding: 36px 16px 60px 16px;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Bar Actions */
        .receipt-action-bar {
            max-width: 860px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-nav-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        .btn-nav-back:hover {
            background: #f1f5f9;
            color: var(--primary-orange);
            border-color: #cbd5e1;
            transform: translateX(-2px);
        }

        .btn-print-receipt {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-orange);
            color: #ffffff !important;
            border: 1px solid var(--primary-orange);
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(244, 130, 33, 0.28);
        }

        .btn-print-receipt:hover {
            background: var(--primary-orange-hover);
            border-color: var(--primary-orange-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(244, 130, 33, 0.35);
        }

        /* Main Receipt Sheet */
        .receipt-sheet {
            max-width: 860px;
            margin: 0 auto;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            position: relative;
        }

        /* Top Brand Accent Bar */
        .receipt-top-stripe {
            height: 6px;
            background: linear-gradient(90deg, #f48221 0%, #ff9e42 60%, #0f172a 100%);
        }

        /* Header Block */
        .receipt-header {
            padding: 36px 40px 28px 40px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 24px;
        }

        .brand-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .brand-logo-img {
            height: 46px;
            width: auto;
            max-width: 220px;
            object-fit: contain;
        }

        .company-meta {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-top: 2px;
        }

        .company-meta strong {
            color: var(--text-main);
            font-weight: 600;
        }

        .receipt-header-right {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .receipt-type-pill {
            display: inline-block;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--primary-orange);
            font-weight: 700;
            background: var(--primary-orange-light);
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid var(--primary-orange-border);
        }

        .invoice-code {
            font-family: 'Space Grotesk', monospace;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .paid-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--success-green-light);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            margin-top: 4px;
        }

        .paid-badge-pill .material-symbols-outlined {
            font-size: 15px;
            color: var(--success-green);
        }

        /* Success Strip Banner */
        .confirmation-banner {
            margin: 28px 40px 0 40px;
            padding: 14px 18px;
            background: var(--success-green-light);
            border: 1px solid rgba(16, 185, 129, 0.28);
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .confirmation-banner .status-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #10b981;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .confirmation-banner .status-icon .material-symbols-outlined {
            font-size: 20px;
        }

        .confirmation-banner .banner-text {
            font-size: 0.83rem;
            color: #065f46;
            line-height: 1.45;
        }

        .confirmation-banner .banner-text strong {
            font-weight: 600;
            color: #044e39;
        }

        /* Receipt Body */
        .receipt-body {
            padding: 28px 40px 36px 40px;
        }

        /* 2-Column Meta Grid */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 28px;
        }

        .meta-block-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-block-title .material-symbols-outlined {
            font-size: 15px;
            color: var(--primary-orange);
        }

        .meta-value-main {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .meta-sub-row {
            font-size: 0.82rem;
            color: var(--text-body);
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-sub-row .label {
            color: var(--text-muted);
            min-width: 65px;
        }

        /* Line Items Table */
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
        }

        .items-table th {
            background: #f1f5f9;
            color: var(--text-muted);
            font-size: 0.74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            padding: 12px 18px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .items-table td {
            padding: 18px;
            font-size: 0.88rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .item-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .item-desc {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .cohort-badge-tag {
            display: inline-block;
            background: rgba(244, 130, 33, 0.08);
            color: #c25e00;
            border: 1px solid rgba(244, 130, 33, 0.25);
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 10px;
            white-space: nowrap;
        }

        .item-price {
            text-align: right;
            font-weight: 700;
            font-size: 0.98rem;
            color: var(--text-main);
            white-space: nowrap;
        }

        /* Totals Block */
        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 28px;
        }

        .totals-card {
            width: 320px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px 20px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .totals-row.grand-total {
            border-top: 1px dashed #cbd5e1;
            padding-top: 10px;
            margin-top: 8px;
            margin-bottom: 0;
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .totals-row.grand-total .amount-highlight {
            color: var(--primary-orange);
            font-size: 1.3rem;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
        }

        /* Audit Box */
        .audit-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 20px;
            font-size: 0.77rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .audit-header {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .audit-header .material-symbols-outlined {
            font-size: 16px;
            color: var(--primary-orange);
        }

        .audit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 8px 16px;
            margin-top: 8px;
        }

        .audit-item strong {
            color: var(--text-body);
        }

        .audit-item code {
            font-family: 'Space Grotesk', monospace;
            background: #f1f5f9;
            padding: 1px 6px;
            border-radius: 4px;
            color: #0f172a;
            font-size: 0.76rem;
        }

        /* Receipt Footer */
        .receipt-footer {
            background: #f8fafc;
            border-top: 1px solid var(--border-color);
            padding: 20px 40px;
            text-align: center;
            font-size: 0.76rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .receipt-footer strong {
            color: var(--text-body);
        }

        /* Bottom Controls */
        .bottom-actions {
            max-width: 860px;
            margin: 24px auto 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 12px;
            }

            .no-print {
                display: none !important;
            }

            .receipt-sheet {
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                margin: 0 !important;
            }

            .receipt-header {
                padding: 24px 28px 18px 28px !important;
            }

            .confirmation-banner {
                margin: 16px 28px 0 28px !important;
                padding: 10px 14px !important;
            }

            .receipt-body {
                padding: 18px 28px 24px 28px !important;
            }

            .meta-grid {
                padding: 14px 18px !important;
                margin-bottom: 18px !important;
            }

            .items-table td, .items-table th {
                padding: 10px 14px !important;
            }

            .receipt-footer {
                padding: 14px 28px !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 16px 10px;
            }

            .receipt-header {
                padding: 24px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .receipt-header-right {
                text-align: left;
                align-items: flex-start;
            }

            .confirmation-banner {
                margin: 16px 20px 0 20px;
            }

            .receipt-body {
                padding: 20px;
            }

            .meta-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 16px;
            }

            .totals-card {
                width: 100%;
            }

            .receipt-footer {
                padding: 16px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Toolbar (Hidden in Print) -->
    <div class="receipt-action-bar no-print">
        <a href="<?= BASE_URL ?>/trainings" class="btn-nav-back">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Back to Programs</span>
        </a>

        <button onclick="window.print()" class="btn-print-receipt">
            <span class="material-symbols-outlined" style="font-size: 19px;">print</span>
            <span>Download / Print Receipt (PDF)</span>
        </button>
    </div>

    <!-- Main Official Receipt Sheet -->
    <div class="receipt-sheet">
        <div class="receipt-top-stripe"></div>

        <!-- Receipt Header with Brand Logo -->
        <div class="receipt-header">
            <div class="brand-info">
                <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Technologies Limited" class="brand-logo-img">
                <div class="company-meta">
                    <strong>Spider Technologies Limited</strong><br>
                    Plot 120, Innovation Drive, Kano / Abuja, Nigeria<br>
                    admissions@spidertech.com.ng &bull; +234 (0) 800 SPIDER &bull; www.spidertech.com.ng
                </div>
            </div>

            <div class="receipt-header-right">
                <div class="receipt-type-pill">Official Payment Receipt</div>
                <div class="invoice-code"><?= htmlspecialchars($invoiceNumber) ?></div>
                <div class="paid-badge-pill">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>PAID &amp; VERIFIED</span>
                </div>
            </div>
        </div>

        <!-- Success Status Banner -->
        <div class="confirmation-banner">
            <div class="status-icon">
                <span class="material-symbols-outlined">verified</span>
            </div>
            <div class="banner-text">
                <strong>Enrollment Confirmed &amp; Seat Secured!</strong><br>
                An official copy of this payment receipt and your onboarding details have been dispatched to <strong><?= htmlspecialchars($applicantEmail) ?></strong>.
            </div>
        </div>

        <!-- Receipt Main Details -->
        <div class="receipt-body">
            
            <!-- Metadata Grid: Candidate & Program -->
            <div class="meta-grid">
                <div>
                    <div class="meta-block-title">
                        <span class="material-symbols-outlined">person</span>
                        <span>Candidate (Billed To)</span>
                    </div>
                    <div class="meta-value-main"><?= htmlspecialchars($applicantName) ?></div>
                    <div class="meta-sub-row">
                        <span class="label">Email:</span>
                        <span><?= htmlspecialchars($applicantEmail) ?></span>
                    </div>
                    <?php if (!empty($applicantPhone)): ?>
                        <div class="meta-sub-row">
                            <span class="label">Phone:</span>
                            <span><?= htmlspecialchars($applicantPhone) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="meta-sub-row">
                        <span class="label">App ID:</span>
                        <span>#<?= (int)$application['id'] ?></span>
                    </div>
                </div>

                <div>
                    <div class="meta-block-title">
                        <span class="material-symbols-outlined">school</span>
                        <span>Enrolled Training Program</span>
                    </div>
                    <div class="meta-value-main"><?= htmlspecialchars($programName) ?></div>
                    <div class="meta-sub-row">
                        <span class="label">Cohort:</span>
                        <strong><?= htmlspecialchars($cohortName) ?></strong>
                    </div>
                    <div class="meta-sub-row">
                        <span class="label">Schedule:</span>
                        <span><?= htmlspecialchars($trainingTime) ?></span>
                    </div>
                    <div class="meta-sub-row">
                        <span class="label">Date Paid:</span>
                        <span><?= $paidDate ?></span>
                    </div>
                </div>
            </div>

            <!-- Itemized Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 55%;">Item &amp; Description</th>
                        <th style="width: 25%;">Cohort Session</th>
                        <th style="width: 20%; text-align: right;">Amount (NGN)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="item-title"><?= htmlspecialchars($programName) ?></div>
                            <div class="item-desc">
                                Comprehensive Curriculum Access, Hands-on Technical Labs, Project Mentorship, Cohort Seat Reservation, and Official Certificate of Completion.
                            </div>
                        </td>
                        <td>
                            <span class="cohort-badge-tag"><?= htmlspecialchars($cohortName) ?></span>
                        </td>
                        <td class="item-price">
                            <?= $formattedAmount ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Summary Totals -->
            <div class="totals-container">
                <div class="totals-card">
                    <div class="totals-row">
                        <span>Tuition &amp; Enrollment Fee</span>
                        <strong><?= $formattedAmount ?></strong>
                    </div>
                    <div class="totals-row">
                        <span>Gateway &amp; Processing Fee</span>
                        <span>₦0.00 (Waived)</span>
                    </div>
                    <div class="totals-row grand-total">
                        <span>Total Paid</span>
                        <span class="amount-highlight"><?= $formattedAmount ?></span>
                    </div>
                </div>
            </div>

            <!-- Electronic Audit & Payment Gateway Record -->
            <div class="audit-box">
                <div class="audit-header">
                    <span class="material-symbols-outlined">lock</span>
                    <span>Electronic Gateway Settlement Record</span>
                </div>
                <div class="audit-grid">
                    <div class="audit-item">
                        <span>Gateway:</span> <strong>Paystack Secure Checkout</strong>
                    </div>
                    <div class="audit-item">
                        <span>Payment Channel:</span> <strong><?= htmlspecialchars($channelName) ?></strong>
                    </div>
                    <div class="audit-item">
                        <span>Transaction Reference:</span><br>
                        <code><?= htmlspecialchars($reference) ?></code>
                    </div>
                    <?php if (!empty($application['paystack_reference'])): ?>
                        <div class="audit-item">
                            <span>Paystack Auth ID:</span><br>
                            <code><?= htmlspecialchars($application['paystack_reference']) ?></code>
                        </div>
                    <?php endif; ?>
                    <div class="audit-item">
                        <span>Settlement Status:</span> <strong style="color: #059669;">100% Cleared &amp; Confirmed</strong>
                    </div>
                    <div class="audit-item">
                        <span>Verified At:</span> <strong><?= $paidDate ?></strong>
                    </div>
                </div>
            </div>

        </div>

        <!-- Receipt Footer Note -->
        <div class="receipt-footer">
            This is an electronically generated official payment receipt. No physical signature or stamp is required.<br>
            Please retain this receipt for cohort orientation check-in. For inquiries, contact <strong>admissions@spidertech.com.ng</strong>.<br>
            &copy; <?= date('Y') ?> <strong>Spider Technologies Limited</strong>. All rights reserved.
        </div>
    </div>

    <!-- Bottom Action Controls (Hidden in Print) -->
    <div class="bottom-actions no-print">
        <button onclick="window.print()" class="btn-print-receipt">
            <span class="material-symbols-outlined" style="font-size: 19px;">print</span>
            <span>Download / Print Receipt (PDF)</span>
        </button>
        <a href="<?= BASE_URL ?>/trainings" class="btn-nav-back">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Back to Programs</span>
        </a>
    </div>

</body>
</html>
