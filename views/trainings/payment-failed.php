<?php
/**
 * Payment Failed / Cancelled View — Spider Tech
 */
$breadcrumb_current = 'Payment Incomplete';
$programId = $application['program_id'] ?? 0;
$cohortId = $application['cohort_id'] ?? 0;
$retryUrl = BASE_URL . "/trainings/register?id=" . $programId . ($cohortId ? "&cohort=" . $cohortId : "");
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center">
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #450a0a 0%, #1e1b4b 100%); border-bottom: 4px solid #ef4444;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger text-white mb-3" style="width: 64px; height: 64px; box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);">
                        <span class="material-symbols-outlined" style="font-size: 38px;">error_outline</span>
                    </div>
                    <h2 class="h3 fw-bold mb-1 text-white">Payment Was Not Completed</h2>
                    <p class="text-white-50 mb-0 small">Your transaction could not be verified or was cancelled.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-danger d-inline-block text-start rounded-3 mb-4 w-100" role="alert">
                        <div class="fw-semibold mb-1">Reason:</div>
                        <div class="small"><?= htmlspecialchars($error ?? 'The payment transaction was not approved by the payment gateway.') ?></div>
                        <?php if (!empty($reference)): ?>
                            <div class="small text-muted mt-2 font-monospace">Reference: <?= htmlspecialchars($reference) ?></div>
                        <?php endif; ?>
                    </div>

                    <p class="text-muted small mb-4">
                        Don't worry! Your registration details are preserved. You can retry with a different card, bank transfer, or USSD code.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="<?= htmlspecialchars($retryUrl) ?>" class="btn-primary-custom py-3 px-4 rounded-3 text-white text-decoration-none">
                            <span class="material-symbols-outlined fs-5">refresh</span>
                            <span class="fw-semibold">Retry Payment</span>
                        </a>
                        <a href="<?= BASE_URL ?>/contact" class="btn btn-outline-secondary py-3 px-4 rounded-3 d-inline-flex align-items-center justify-content-center gap-2">
                            <span class="material-symbols-outlined fs-5">support_agent</span>
                            <span class="fw-semibold">Contact Support</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
