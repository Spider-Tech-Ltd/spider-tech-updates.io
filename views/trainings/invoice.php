<?php
/**
 * Official Printable Invoice & Payment Receipt — Spider Tech
 */
$userData = json_decode($application['user_data'] ?? '{}', true) ?: [];
$applicantName = trim(($userData['first_name'] ?? $userData['firstname'] ?? '') . ' ' . ($userData['last_name'] ?? $userData['lastname'] ?? ''));
if (empty($applicantName)) $applicantName = $userData['full_name'] ?? 'Candidate';

$applicantEmail = $userData['email'] ?? ($userData['email_address'] ?? 'Not provided');
$applicantPhone = $userData['phone'] ?? ($userData['phone_no'] ?? ($userData['phone_number'] ?? 'Not provided'));

$invoiceNumber = $application['invoice_number'] ?? 'STP-INV-0000';
$formattedAmount = PaystackService::formatKobo((int)($application['amount_paid'] ?? 0));
$paidDate = !empty($application['paid_at']) ? date('F j, Y \a\t g:i A', strtotime($application['paid_at'])) : date('F j, Y');
$issueDate = date('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Invoice - <?= htmlspecialchars($invoiceNumber) ?> - Spider Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root {
            --primary: #f48221;
            --dark: #110f0d;
            --gray-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f1f5f9;
            color: var(--text-dark);
            margin: 0;
            padding: 40px 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        .invoice-card {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            overflow: hidden;
            position: relative;
        }
        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .btn-print {
            background: var(--dark);
            color: #ffffff;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-print:hover {
            background: #27272a;
        }
        .btn-back {
            background: #ffffff;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }
        .invoice-header {
            background: var(--dark);
            padding: 36px 40px;
            color: #ffffff;
            border-bottom: 4px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .brand-logo {
            height: 42px;
            max-width: 200px;
        }
        .invoice-body {
            padding: 40px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 36px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 28px;
        }
        .meta-col h6 {
            margin: 0 0 6px 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 700;
        }
        .meta-col p {
            margin: 0;
            font-size: 14px;
            color: var(--text-dark);
        }
        .meta-col .client-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }
        .paid-stamp {
            display: inline-block;
            border: 2px solid #10b981;
            color: #10b981;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            padding: 3px 12px;
            border-radius: 6px;
            letter-spacing: 1px;
            transform: rotate(-3deg);
            background: rgba(16, 185, 129, 0.05);
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }
        .items-table th {
            text-align: left;
            background: var(--gray-bg);
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .items-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }
        .total-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 36px;
        }
        .total-card {
            width: 300px;
            background: var(--gray-bg);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 16px 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .total-row.grand-total {
            border-top: 1px dashed #cbd5e1;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .total-row.grand-total span:last-child {
            color: var(--primary);
        }
        .tx-details {
            background: var(--gray-bg);
            border-radius: 8px;
            padding: 16px;
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.6;
        }
        .invoice-footer {
            background: #f8fafc;
            border-top: 1px solid var(--border-color);
            padding: 24px 40px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Print Specific Styling */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print-bar {
                display: none !important;
            }
            .invoice-card {
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            .invoice-header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <a href="<?= BASE_URL ?>/trainings" class="btn-back">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Trainings Catalog</span>
        </a>
        <button onclick="window.print()" class="btn-print">
            <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
            <span>Print Receipt / Save as PDF</span>
        </button>
    </div>

    <div class="invoice-card">
        <!-- Header -->
        <div class="invoice-header">
            <div>
                <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" class="brand-logo">
                <div style="font-size: 12px; color: #cbd5e1; margin-top: 6px;">Plot 120, Innovation Drive, Kano / Abuja, Nigeria</div>
                <div style="font-size: 12px; color: #cbd5e1;">admissions@spidertech.com.ng | +234 (0) 800 SPIDER</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--primary); font-weight: 700;">Payment Receipt</div>
                <div style="font-size: 22px; font-weight: 800; font-family: monospace;"><?= htmlspecialchars($invoiceNumber) ?></div>
                <div style="margin-top: 6px;"><span class="paid-stamp">&bull; PAID & SECURED</span></div>
            </div>
        </div>

        <div class="invoice-body">
            <!-- Meta Grid -->
            <div class="meta-grid">
                <div class="meta-col">
                    <h6>Billed To (Applicant):</h6>
                    <div class="client-name"><?= htmlspecialchars($applicantName) ?></div>
                    <p><?= htmlspecialchars($applicantEmail) ?></p>
                    <p><?= htmlspecialchars($applicantPhone) ?></p>
                </div>
                <div class="meta-col" style="text-align: right;">
                    <h6>Invoice Details:</h6>
                    <p><strong>Receipt Date:</strong> <?= $paidDate ?></p>
                    <p><strong>Payment Status:</strong> Successful (Verified)</p>
                    <p><strong>Currency:</strong> Nigerian Naira (NGN)</p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 55%;">Item & Description</th>
                        <th style="width: 25%;">Cohort Session</th>
                        <th style="width: 20%; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong style="color: var(--text-dark); font-size: 15px;"><?= htmlspecialchars($application['training_name'] ?? 'Training Track') ?></strong>
                            <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                                Technical Instruction, Curriculum Materials, Lab Exercises, & Certification Fee
                            </div>
                        </td>
                        <td>
                            <span style="display: inline-block; padding: 3px 8px; background: #e2e8f0; border-radius: 4px; font-weight: 600; font-size: 12px;">
                                <?= htmlspecialchars($application['cohort_name'] ?? 'Cohort') ?>
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 700; font-size: 15px;">
                            <?= $formattedAmount ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Box -->
            <div class="total-box">
                <div class="total-card">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span><?= $formattedAmount ?></span>
                    </div>
                    <div class="total-row">
                        <span>Tax / Gateway Processing</span>
                        <span>₦0.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total Paid</span>
                        <span><?= $formattedAmount ?></span>
                    </div>
                </div>
            </div>

            <!-- Transaction Audit Trail -->
            <div class="tx-details">
                <strong style="color: var(--text-dark);">Electronic Verification & Gateway Audit Record:</strong><br>
                <span>Gateway: Paystack | Channel: <?= htmlspecialchars(ucfirst($application['channel'] ?? 'card')) ?></span><br>
                <span>Transaction Reference: <code style="color: var(--text-dark);"><?= htmlspecialchars($application['payment_reference'] ?? $reference) ?></code></span><br>
                <?php if (!empty($application['paystack_reference'])): ?>
                    <span>Paystack ID: <code style="color: var(--text-dark);"><?= htmlspecialchars($application['paystack_reference']) ?></code></span><br>
                <?php endif; ?>
                <span>Settled At: <?= $paidDate ?></span>
            </div>
        </div>

        <div class="invoice-footer">
            Thank you for enrolling with Spider Tech. This document serves as your official payment receipt and proof of enrollment.<br>
            For support or inquiries, please email <strong>support@spidertech.com.ng</strong>.
        </div>
    </div>

</body>
</html>
