<?php
/**
 * Payment Confirmation & Admission Success View — Spider Tech
 */
$breadcrumb_current = 'Payment Confirmed';
$userData = json_decode($application['user_data'] ?? '{}', true) ?: [];
$applicantName = trim(($userData['first_name'] ?? $userData['firstname'] ?? '') . ' ' . ($userData['last_name'] ?? $userData['lastname'] ?? ''));
if (empty($applicantName)) $applicantName = $userData['full_name'] ?? 'Applicant';

$formattedAmount = PaystackService::formatKobo((int)($amount_kobo ?? $application['amount_paid'] ?? 0));
$invoiceUrl = BASE_URL . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($invoice_token ?? '');
$paidAt = !empty($application['paid_at']) ? date('F j, Y \a\t g:i A', strtotime($application['paid_at'])) : date('F j, Y \a\t g:i A');
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Top Status Header -->
                <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-bottom: 4px solid #f48221;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3" style="width: 64px; height: 64px; box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);">
                        <span class="material-symbols-outlined" style="font-size: 38px;">check</span>
                    </div>
                    <h2 class="h3 fw-bold mb-1 text-white">Payment Confirmed!</h2>
                    <p class="text-white-50 mb-0 small">Your enrollment is officially verified and your seat is secured.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 mb-4" role="alert">
                        <span class="material-symbols-outlined fs-2 text-success">verified_user</span>
                        <div>
                            <div class="fw-semibold">Receipt & Orientation Notice Dispatched</div>
                            <div class="small">An official payment receipt has been sent to <strong><?= htmlspecialchars($userData['email'] ?? ($userData['email_address'] ?? 'your email')) ?></strong>.</div>
                        </div>
                    </div>

                    <!-- Payment Receipt Summary Card -->
                    <div class="bg-light rounded-4 p-4 mb-4 border">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <span class="text-muted small text-uppercase fw-semibold">Invoice Number</span>
                                <h5 class="mb-0 fw-bold font-monospace text-dark"><?= htmlspecialchars($invoice_number ?? $application['invoice_number'] ?? 'INV-0000') ?></h5>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small text-uppercase fw-semibold">Total Paid</span>
                                <h4 class="mb-0 fw-bold" style="color: #f48221;"><?= $formattedAmount ?></h4>
                            </div>
                        </div>

                        <div class="row g-3 small">
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Candidate Name</span>
                                <strong class="text-dark fs-6"><?= htmlspecialchars($applicantName) ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Enrolled Program</span>
                                <strong class="text-dark fs-6"><?= htmlspecialchars($application['training_name'] ?? 'Training Track') ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Cohort Session</span>
                                <span class="badge bg-secondary-subtle text-secondary fs-7"><?= htmlspecialchars($application['cohort_name'] ?? 'Assigned Cohort') ?></span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Transaction Reference</span>
                                <span class="font-monospace text-muted"><?= htmlspecialchars($reference) ?></span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Payment Date & Time</span>
                                <span class="text-dark"><?= $paidAt ?></span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Gateway Status</span>
                                <span class="badge bg-success-subtle text-success">&bull; Successful</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="<?= $invoiceUrl ?>" target="_blank" class="btn btn-dark d-inline-flex align-items-center justify-content-center gap-2 py-3 px-4 rounded-3 shadow-sm">
                            <span class="material-symbols-outlined fs-5">receipt_long</span>
                            <span class="fw-semibold">Print Official Invoice</span>
                        </a>
                        <a href="<?= BASE_URL ?>/trainings" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center gap-2 py-3 px-4 rounded-3">
                            <span class="material-symbols-outlined fs-5">home</span>
                            <span class="fw-semibold">Back to Programs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
