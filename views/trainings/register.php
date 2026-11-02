<?php

/**
 * Modern Technical Training Registration View — Spider Tech
 * Progressive Multi-Step Application Portal
 */

$breadcrumb_current = 'Register' . (isset($training['training_name']) ? ' - ' . htmlspecialchars(strip_tags($training['training_name'])) : '');

$success_msg = "";
$error_msg = "";
$errors = $_SESSION['registration_errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];

if (isset($_SESSION['registration_success'])) {
    $success_msg = $_SESSION['registration_success'];
    unset($_SESSION['registration_success']);
}
if (isset($_SESSION['registration_error'])) {
    $error_msg = $_SESSION['registration_error'];
    unset($_SESSION['registration_error']);
}
unset($_SESSION['registration_errors']);
unset($_SESSION['old_input']);

$isPaidProgram = !empty($payment_info['payments_enabled']) && ((int)($payment_info['amount_kobo'] ?? 0) > 0);
$programFeeKobo = (int)($payment_info['amount_kobo'] ?? 0);
$programFeeFormatted = format_naira($programFeeKobo);

// Step calculations: Paid programs include a 5th "Payment" step
$sectionKeys = !empty($sections) ? array_keys($sections) : ['Basic Info'];
$formStepsCount = count($sectionKeys);
$totalStepsCount = $isPaidProgram ? ($formStepsCount + 1) : $formStepsCount;

// Thumbnail resolution
$rawThumb = trim($training['image_url'] ?? $training['training_image'] ?? '');
$hasThumb = false;
$thumbPic = '';
if (!empty($rawThumb)) {
    if (preg_match('#^https?://#i', $rawThumb)) {
        $thumbPic = $rawThumb;
        $hasThumb = true;
    } else {
        $cleanPath = ltrim(preg_replace('#^(\.\./)+#', '', $rawThumb), './');
        if (file_exists(ROOT_PATH . '/' . $cleanPath) && !is_dir(ROOT_PATH . '/' . $cleanPath)) {
            $thumbPic = BASE_URL . '/' . $cleanPath;
            $hasThumb = true;
        } elseif (file_exists(ROOT_PATH . '/images/pictures/' . basename($cleanPath)) && !is_dir(ROOT_PATH . '/images/pictures/' . basename($cleanPath))) {
            $thumbPic = BASE_URL . '/images/pictures/' . basename($cleanPath);
            $hasThumb = true;
        } else {
            $thumbPic = BASE_URL . '/' . $cleanPath;
            $hasThumb = true;
        }
    }
}


?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/training-register.css?v=<?= filemtime(ROOT_PATH . '/css/training-register.css') ?>" />

<div x-data="registrationHandler()">
    <?php if (!$training) : ?>
        <section class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-title">Program <span>Not Found</span></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                                <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/">Home</a></li>
                                <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/trainings">Trainings</a></li>
                                <li class="breadcrumb-item-custom active" aria-current="page">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="registration-content">
            <div class="container">
                <div class="form-section-card text-center py-5" style="max-width: 680px; margin: 0 auto;">
                    <span class="material-symbols-outlined" style="font-size: 3.5rem; color: var(--primary-orange); margin-bottom: 16px;">school</span>
                    <h3 style="font-weight: 700; color: #0f172a;">Program Unavailable</h3>
                    <p class="text-muted mb-4">The training program you requested is not currently open for registration or may have been archived.</p>
                    <a class="btn-cancel-step d-inline-flex w-auto px-4 py-2 border rounded-pill" href="<?= BASE_URL ?>/trainings">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Back to All Programs</span>
                    </a>
                </div>
            </div>
        </section>
    <?php else : ?>
        <!-- ====== Page Header ====== -->
        <section class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-title">Program <span>Registration</span></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                                <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/">Home</a></li>
                                <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/trainings">Trainings</a></li>
                                <li class="breadcrumb-item-custom">
                                    <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $training['id']; ?>">
                                        <?= htmlspecialchars(mb_strimwidth(strip_tags($training['training_name']), 0, 26, '…')); ?>
                                    </a>
                                </li>
                                <li class="breadcrumb-item-custom active" aria-current="page">Application</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="registration-content">
            <div class="container">
                <!-- Full-Width Multi-Step Interactive Progress Tracker -->
                <?php if ($totalStepsCount > 1): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="registration-progress-bar-wrap mb-4">
                                <div class="progress-steps-flex">
                                    <?php
                                    $sIndex = 1;
                                    foreach ($sections as $sTitle => $fields):
                                    ?>
                                        <div class="progress-step-node"
                                             :class="{
                                                 'completed': currentStep > <?= $sIndex ?>,
                                                 'active': currentStep === <?= $sIndex ?>,
                                                 'upcoming': currentStep < <?= $sIndex ?>
                                             }"
                                             @click="goToStep(<?= $sIndex ?>)">
                                            <div class="step-node-bubble">
                                                <template x-if="currentStep > <?= $sIndex ?>">
                                                    <span class="material-symbols-outlined" style="font-size: 17px; font-weight: bold;">check</span>
                                                </template>
                                                <template x-if="currentStep <= <?= $sIndex ?>">
                                                    <span><?= $sIndex ?></span>
                                                </template>
                                            </div>
                                            <span class="step-node-label"><?= htmlspecialchars($sTitle) ?></span>
                                        </div>
                                        <?php if ($sIndex < $totalStepsCount): ?>
                                            <div class="step-node-connector" :class="{ 'active': currentStep > <?= $sIndex ?> }"></div>
                                        <?php endif; ?>
                                    <?php
                                        $sIndex++;
                                    endforeach;
                                    ?>
                                    <?php if ($isPaidProgram): ?>
                                        <div class="progress-step-node"
                                             :class="{
                                                 'completed': currentStep > <?= $totalStepsCount ?>,
                                                 'active': currentStep === <?= $totalStepsCount ?>,
                                                 'upcoming': currentStep < <?= $totalStepsCount ?>
                                             }"
                                             @click="goToStep(<?= $totalStepsCount ?>)">
                                            <div class="step-node-bubble">
                                                <template x-if="currentStep > <?= $totalStepsCount ?>">
                                                    <span class="material-symbols-outlined" style="font-size: 17px; font-weight: bold;">check</span>
                                                </template>
                                                <template x-if="currentStep <= <?= $totalStepsCount ?>">
                                                    <span><?= $totalStepsCount ?></span>
                                                </template>
                                            </div>
                                            <span class="step-node-label">Payment</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row g-4 align-items-start">
                    <!-- Left: Multi-Step Application Form (col-lg-8) -->
                    <div class="col-lg-8">
                        <!-- Registration Form Wizard -->
                        <form @submit.prevent="submitForm" id="registrationForm" enctype="multipart/form-data">
                            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
                            <input type="hidden" name="cohort_id" value="<?= !empty($cohort['id']) ? (int)$cohort['id'] : ''; ?>">
                            <input type="hidden" name="registration_type" value="<?= $registration_type ?? 'training'; ?>">
                            <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">

                            <?php if (!empty($sections)) : ?>
                                <?php
                                $stepNumber = 1;
                                foreach ($sections as $section_name => $fields) :
                                    $stepPad = str_pad((string)$stepNumber, 2, '0', STR_PAD_LEFT);

                                    // Contextual iconography and description
                                    $sIcon = 'assignment';
                                    $sDesc = 'Please supply the required details below.';

                                    switch ($section_name) {
                                        case 'Basic Info':
                                            $sIcon = 'badge';
                                            $sDesc = 'Candidate identity credentials and primary contact channels.';
                                            break;
                                        case 'Demographic Info':
                                            $sIcon = 'location_on';
                                            $sDesc = 'Regional location profile, origin, and demographic background.';
                                            break;
                                        case 'Professional / Business Info':
                                            $sIcon = 'domain';
                                            $sDesc = 'Enterprise venture standing, vocational track, and industry experience.';
                                            break;
                                        case 'Additional Info':
                                            $sIcon = 'tune';
                                            $sDesc = 'Supplementary verifications, document attachments, and cohort checks.';
                                            break;
                                        default:
                                            $sIcon = 'checklist';
                                            $sDesc = 'Please complete the program requirements below.';
                                    }

                                    // Next step title
                                    if ($stepNumber < $formStepsCount) {
                                        $nextStepTitle = $sectionKeys[$stepNumber] ?? 'Next Step';
                                    } elseif ($stepNumber === $formStepsCount && $isPaidProgram) {
                                        $nextStepTitle = 'Review & Payment';
                                    } else {
                                        $nextStepTitle = '';
                                    }
                                ?>
                                    <!-- Step Card Container -->
                                    <div class="form-step-container"
                                         data-step="<?= $stepNumber ?>"
                                         x-show="currentStep === <?= $stepNumber ?>"
                                         x-cloak>
                                        <div class="form-section-card">
                                            <div class="form-section-header">
                                                <div class="section-step-pill" title="Phase <?= $stepPad ?>">
                                                    <span class="material-symbols-outlined"><?= $sIcon ?></span>
                                                </div>
                                                <div class="section-header-text">
                                                    <span class="section-phase-tag">Phase <?= $stepPad ?> of <?= str_pad((string)$totalStepsCount, 2, '0', STR_PAD_LEFT) ?></span>
                                                    <h3><?= htmlspecialchars($section_name); ?></h3>
                                                    <p><?= $sDesc ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <?php foreach ($fields as $field) : ?>
                                                    <?= FormBuilder::render_form_field($field, $errors, $old_input); ?>
                                                <?php endforeach; ?>
                                            </div>

                                            <?php if ($stepNumber === $totalStepsCount): ?>
                                                <!-- Data Protection Pledge on Final Step -->
                                                <div class="data-protection-pledge">
                                                    <span class="material-symbols-outlined pledge-icon">shield_lock</span>
                                                    <div>
                                                        <span class="pledge-title">Privacy &amp; Data Protection Pledge</span>
                                                        <p class="pledge-desc">Spider Tech complies with Nigerian Data Protection Regulations (NDPR). Your information is strictly encrypted and used for registration verification and cohort scheduling.</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Step Navigation Footer -->
                                            <div class="step-nav-footer d-flex flex-wrap align-items-center justify-content-between gap-3">
                                                <!-- Left Action: Cancel or Previous -->
                                                <?php if ($stepNumber === 1): ?>
                                                    <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $program_id; ?>" class="btn-cancel-step">
                                                        <span class="material-symbols-outlined" style="font-size: 16px;">keyboard_backspace</span>
                                                        <span>Cancel Application</span>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" class="btn-prev-step" @click="prevStep()">
                                                        <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                                                        <span>Previous Step</span>
                                                    </button>
                                                <?php endif; ?>

                                                <!-- Right Action: Next or Submit -->
                                                <?php if ($stepNumber < $formStepsCount): ?>
                                                    <button type="button" class="btn-next-step" @click="nextStep()">
                                                        <span>Continue to <?= htmlspecialchars($nextStepTitle) ?></span>
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                                                    </button>
                                                <?php elseif ($stepNumber === $formStepsCount && $isPaidProgram): ?>
                                                    <button type="button" class="btn-next-step" @click="nextStep()">
                                                        <span>Continue to Review &amp; Payment</span>
                                                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn-submit-registration" :disabled="loading">
                                                        <template x-if="!loading">
                                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                                <span class="material-symbols-outlined" style="font-size: 20px;">send</span>
                                                                <span>Submit Application</span>
                                                            </div>
                                                        </template>
                                                        <template x-if="loading">
                                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                                <div class="spinner-border spinner-border-sm" role="status" style="width: 1rem; height: 1rem; border-width: 2px;"></div>
                                                                <span>Processing Submission...</span>
                                                            </div>
                                                        </template>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $stepNumber++;
                                endforeach;
                                ?>

                                <?php if ($isPaidProgram): ?>
                                    <!-- Step 5: Order Summary & Paystack Payment -->
                                    <div class="form-step-container"
                                         data-step="<?= $totalStepsCount ?>"
                                         x-show="currentStep === <?= $totalStepsCount ?>"
                                         x-cloak>
                                        <div class="form-section-card">
                                            <div class="form-section-header">
                                                <div class="section-step-pill" title="Phase <?= str_pad((string)$totalStepsCount, 2, '0', STR_PAD_LEFT) ?>">
                                                    <span class="material-symbols-outlined">payments</span>
                                                </div>
                                                <div class="section-header-text">
                                                    <span class="section-phase-tag">Phase <?= str_pad((string)$totalStepsCount, 2, '0', STR_PAD_LEFT) ?> of <?= str_pad((string)$totalStepsCount, 2, '0', STR_PAD_LEFT) ?></span>
                                                    <h3>Order Summary &amp; Payment</h3>
                                                    <p>Review your training reservation and proceed with secure online payment.</p>
                                                </div>
                                            </div>

                                            <!-- Order Summary Card -->
                                            <div class="order-summary-card mb-4">
                                                <div class="order-summary-header d-flex justify-content-between align-items-center">
                                                    <span class="order-summary-title">Enrollment Summary</span>
                                                    <span class="order-badge-secure">
                                                        <span class="material-symbols-outlined" style="font-size: 14px;">lock</span>
                                                        <span>Paystack Secured</span>
                                                    </span>
                                                </div>
                                                
                                                <div class="order-summary-body">
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Training Program</span>
                                                        <span class="order-item-val fw-bold"><?= htmlspecialchars(strip_tags($training['training_name'] ?? '')) ?></span>
                                                    </div>
                                                    <?php if (!empty($cohort['cohort_name'])): ?>
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Cohort Track</span>
                                                        <span class="order-item-val"><?= htmlspecialchars($cohort['cohort_name']) ?></span>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php
                                                    $sStart = !empty($cohort['start_date']) ? $cohort['start_date'] : ($training['start_date'] ?? '');
                                                    if (!empty($sStart)):
                                                    ?>
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Classes Begin</span>
                                                        <span class="order-item-val"><?= date('F j, Y', strtotime($sStart)) ?></span>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Reserved Seats</span>
                                                        <span class="order-item-val">1 Candidate</span>
                                                    </div>
                                                    <div class="order-divider"></div>
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Tuition Fee</span>
                                                        <span class="order-item-val"><?= $programFeeFormatted ?></span>
                                                    </div>
                                                    <div class="order-item-row">
                                                        <span class="order-item-label">Processing &amp; Gateway Fee</span>
                                                        <span class="order-item-val text-success">₦0 (Waived)</span>
                                                    </div>
                                                    <div class="order-total-row">
                                                        <span class="order-total-label">Total Payable</span>
                                                        <span class="order-total-amount"><?= $programFeeFormatted ?></span>
                                                    </div>
                                                </div>

                                                <div class="order-summary-footer">
                                                    <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.82rem;">
                                                        <span class="material-symbols-outlined text-orange" style="font-size: 18px;">verified_user</span>
                                                        <span>Official Spider Tech receipt generated immediately upon transaction confirmation.</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Data Protection Pledge -->
                                            <div class="data-protection-pledge">
                                                <span class="material-symbols-outlined pledge-icon">shield_lock</span>
                                                <div>
                                                    <span class="pledge-title">Encrypted Payment Guarantee</span>
                                                    <p class="pledge-desc">Transactions are processed through Paystack's PCI-DSS Level 1 certified gateway. Spider Technologies never stores your card credentials.</p>
                                                </div>
                                            </div>

                                            <!-- Step Navigation Footer -->
                                            <div class="step-nav-footer d-flex flex-wrap align-items-center justify-content-between gap-3">
                                                <button type="button" class="btn-prev-step" @click="prevStep()">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                                                    <span>Previous Step</span>
                                                </button>

                                                <button type="submit" class="btn-submit-registration btn-pay-now" :disabled="loading">
                                                    <template x-if="!loading">
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <span class="material-symbols-outlined" style="font-size: 20px;">credit_card</span>
                                                            <span>Pay <?= $programFeeFormatted ?></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="loading">
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <div class="spinner-border spinner-border-sm" role="status" style="width: 1rem; height: 1rem; border-width: 2px;"></div>
                                                            <span>Redirecting to Paystack...</span>
                                                        </div>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <!-- Clean Fallback -->
                                <div class="form-step-container" data-step="1">
                                    <div class="form-section-card">
                                        <div class="form-section-header">
                                            <div class="section-step-pill">
                                                <span class="material-symbols-outlined">person</span>
                                            </div>
                                            <div class="section-header-text">
                                                <span class="section-phase-tag">Phase 01 of 01</span>
                                                <h3>Basic Info</h3>
                                                <p>Candidate identity credentials and primary contact channels.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-4">
                                                <div class="form-group-modern">
                                                    <label class="form-label-modern">First Name <span class="req-star">*</span></label>
                                                    <div class="input-wrapper-modern">
                                                        <span class="material-symbols-outlined input-leading-icon">person</span>
                                                        <input type="text" name="firstname" class="form-control-modern" placeholder="Enter first name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3 mb-md-4">
                                                <div class="form-group-modern">
                                                    <label class="form-label-modern">Last Name <span class="req-star">*</span></label>
                                                    <div class="input-wrapper-modern">
                                                        <span class="material-symbols-outlined input-leading-icon">person</span>
                                                        <input type="text" name="lastname" class="form-control-modern" placeholder="Enter last name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3 mb-md-4">
                                                <div class="form-group-modern">
                                                    <label class="form-label-modern">Email Address <span class="req-star">*</span></label>
                                                    <div class="input-wrapper-modern">
                                                        <span class="material-symbols-outlined input-leading-icon">mail</span>
                                                        <input type="email" name="email" class="form-control-modern" placeholder="Enter email address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3 mb-md-4">
                                                <div class="form-group-modern">
                                                    <label class="form-label-modern">Phone Number <span class="req-star">*</span></label>
                                                    <div class="input-wrapper-modern">
                                                        <span class="material-symbols-outlined input-leading-icon">call</span>
                                                        <input type="tel" name="phone_no" class="form-control-modern" placeholder="Enter phone number" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="step-nav-footer d-flex align-items-center justify-content-between gap-3">
                                            <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $program_id; ?>" class="btn-cancel-step">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">keyboard_backspace</span>
                                                <span>Cancel Application</span>
                                            </a>
                                            <button type="submit" class="btn-submit-registration" :disabled="loading">
                                                <span><?= $isPaidProgram ? 'Proceed to Payment (' . $programFeeFormatted . ')' : 'Submit Application' ?></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Right: Sticky Program Overview Card (col-lg-4) -->
                    <div class="col-lg-4">
                        <div class="program-summary-sticky-card">
                            <!-- Program Thumbnail -->
                            <div class="sidebar-thumb-wrap">
                                <?php if ($hasThumb): ?>
                                    <img src="<?= htmlspecialchars($thumbPic) ?>"
                                         alt="<?= htmlspecialchars(strip_tags($training['training_name'])) ?>"
                                         class="sidebar-thumb-img"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <?php endif; ?>
                                <div class="sidebar-thumb-fallback" style="display: <?= $hasThumb ? 'none' : 'flex' ?>;" aria-hidden="true">
                                    <svg width="44" height="44" viewBox="0 0 64 64" fill="none">
                                        <rect x="6" y="10" width="52" height="44" rx="8" stroke="#cbd5e1" stroke-width="2.5" stroke-dasharray="4 3"/>
                                        <path d="M32 20L16 28L32 36L48 28L32 20Z" stroke="#f48221" stroke-width="2.5" stroke-linejoin="round"/>
                                        <path d="M22 31V40C22 42.5 26.5 45 32 45C37.5 45 42 42.5 42 40V31" stroke="#cbd5e1" stroke-width="2.5" stroke-linecap="round"/>
                                    </svg>
                                    <span style="font-size: 0.72rem; font-weight: 600; color: #94a3b8;">Spider Tech Academy</span>
                                </div>
                            </div>

                            <?php
                            $badgeData = resolve_training_status_badge($training, $cohort);
                            ?>
                            <span class="badge-enrollment-active <?= htmlspecialchars($badgeData['status_class']) ?>">
                                <span class="<?= htmlspecialchars($badgeData['dot_class']) ?>"></span>
                                <span><?= htmlspecialchars($badgeData['badge_text']) ?></span>
                            </span>

                            <h3 class="sidebar-program-title"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></h3>
                            <p class="sidebar-program-desc"><?= htmlspecialchars(mb_strimwidth(strip_tags($training['training_description'] ?? ''), 0, 130, '…')); ?></p>

                            <!-- Course Metrics -->
                            <ul class="sidebar-meta-list">
                                <li class="sidebar-meta-item">
                                    <div class="sidebar-meta-icon" style="<?= $isPaidProgram ? 'background: rgba(244, 130, 33, 0.12); color: #f48221;' : 'background: rgba(16, 185, 129, 0.12); color: #059669;' ?>">
                                        <span class="material-symbols-outlined"><?= $isPaidProgram ? 'payments' : 'card_giftcard' ?></span>
                                    </div>
                                    <div class="sidebar-meta-info">
                                        <span class="meta-label">Enrollment Fee</span>
                                        <span class="meta-value" style="font-size: 1rem; font-weight: 800; color: <?= $isPaidProgram ? '#f48221' : '#059669' ?>;">
                                            <?= $isPaidProgram ? $programFeeFormatted : 'Free Registration' ?>
                                        </span>
                                        <?php if ($isPaidProgram): ?>
                                            <span style="font-size: 0.72rem; color: #64748b;">Secured via Paystack</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li class="sidebar-meta-item">
                                    <div class="sidebar-meta-icon">
                                        <span class="material-symbols-outlined">calendar_today</span>
                                    </div>
                                    <div class="sidebar-meta-info">
                                        <span class="meta-label"><?= !empty($cohort['cohort_name']) ? htmlspecialchars($cohort['cohort_name']) : 'Cohort Schedule' ?></span>
                                        <span class="meta-value">
                                            <?php
                                            $sStart = !empty($cohort['start_date']) ? $cohort['start_date'] : ($training['start_date'] ?? '');
                                            $sEnd   = !empty($cohort['end_date']) ? $cohort['end_date'] : ($training['end_date'] ?? '');
                                            if (!empty($sStart)) {
                                                echo date('M d, Y', strtotime($sStart));
                                                if (!empty($sEnd)) {
                                                    echo ' &ndash; ' . date('M d, Y', strtotime($sEnd));
                                                }
                                            } else {
                                                echo "Flexible / Immediate";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </li>

                                <?php if (!empty($training['training_time'])): ?>
                                <li class="sidebar-meta-item">
                                    <div class="sidebar-meta-icon">
                                        <span class="material-symbols-outlined">schedule</span>
                                    </div>
                                    <div class="sidebar-meta-info">
                                        <span class="meta-label">Session Time</span>
                                        <span class="meta-value"><?= htmlspecialchars(stripslashes($training['training_time'])) ?></span>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <li class="sidebar-meta-item">
                                    <div class="sidebar-meta-icon">
                                        <span class="material-symbols-outlined">verified</span>
                                    </div>
                                    <div class="sidebar-meta-info">
                                        <span class="meta-label">Accreditation</span>
                                        <span class="meta-value">Certificate of Completion</span>
                                    </div>
                                </li>

                                <li class="sidebar-meta-item">
                                    <div class="sidebar-meta-icon">
                                        <span class="material-symbols-outlined">group</span>
                                    </div>
                                    <div class="sidebar-meta-info">
                                        <span class="meta-label">Alumni Network</span>
                                        <span class="meta-value"><?= number_format($training['certified_count'] ?? 0) ?> Certified Graduates</span>
                                    </div>
                                </li>
                            </ul>

                            <!-- Admissions Hotline Box -->
                            <div class="sidebar-support-box">
                                <span class="support-box-title">
                                    <span class="material-symbols-outlined">headset_mic</span>
                                    <span>Registration Assistance</span>
                                </span>
                                <?php if (!empty($contact['phone'])): ?>
                                    <a href="tel:<?= htmlspecialchars($contact['phone']) ?>" class="support-contact-link">
                                        <span class="material-symbols-outlined">call</span>
                                        <span><?= htmlspecialchars($contact['phone']) ?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($contact['email'])): ?>
                                    <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="support-contact-link">
                                        <span class="material-symbols-outlined">mail</span>
                                        <span><?= htmlspecialchars($contact['email']) ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Trust Badges -->
                            <div class="trust-badges-wrapper">
                                <div class="trust-badge-item" title="SSL Encrypted Submission">
                                    <span class="material-symbols-outlined">lock</span>
                                    <span>256-bit SSL</span>
                                </div>
                                <div class="trust-badge-item" title="Verified Spider Tech Institute">
                                    <span class="material-symbols-outlined">verified</span>
                                    <span>Official Program</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Toast Notification -->
    <div class="pd-toast" :class="toast.type" x-show="toast.show" x-transition style="display: none;">
        <span class="material-symbols-outlined" x-text="toast.type === 'success' ? 'check_circle' : 'error'"></span>
        <span x-text="toast.message"></span>
    </div>
</div>

<script>
    function registrationHandler() {
        return {
            currentStep: 1,
            totalSteps: <?= $totalStepsCount ?>,
            loading: false,
            toast: {
                show: false,
                message: '',
                type: 'success'
            },

            init() {
                const err = '<?= addslashes($error_msg) ?>';
                const scs = '<?= addslashes($success_msg) ?>';
                if (err) this.showToast(err, 'error');
                if (scs) this.showToast(scs, 'success');
            },

            showToast(message, type = 'success') {
                this.toast.message = message;
                this.toast.type = type;
                this.toast.show = true;
                setTimeout(() => {
                    this.toast.show = false;
                }, 4500);
            },

            goToStep(step) {
                if (step < 1 || step > this.totalSteps) return;
                // Allow jumping back to any previously completed step
                if (step < this.currentStep) {
                    this.currentStep = step;
                    this.scrollToFormTop();
                } else if (step === this.currentStep + 1) {
                    this.nextStep();
                }
            },

            nextStep() {
                if (!this.validateCurrentStep()) {
                    this.showToast('Please fill in the required fields before continuing.', 'error');
                    return;
                }
                if (this.currentStep < this.totalSteps) {
                    this.currentStep++;
                    this.scrollToFormTop();
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.scrollToFormTop();
                }
            },

            validateCurrentStep() {
                const stepEl = document.querySelector(`[data-step="${this.currentStep}"]`);
                if (!stepEl) return true;

                const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;
                let firstInvalid = null;

                requiredInputs.forEach(input => {
                    let filled = false;
                    if (input.type === 'radio') {
                        const group = stepEl.querySelectorAll(`input[name="${input.name}"]`);
                        filled = Array.from(group).some(r => r.checked);
                    } else if (input.type === 'checkbox') {
                        const group = stepEl.querySelectorAll(`input[name="${input.name}"]`);
                        filled = Array.from(group).some(c => c.checked);
                    } else if (input.type === 'file') {
                        filled = input.files && input.files.length > 0;
                    } else {
                        filled = input.value.trim() !== '';
                        if (input.type === 'email' && filled) {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(input.value.trim())) {
                                filled = false;
                            }
                        }
                    }

                    const wrapper = input.closest('.input-wrapper-modern') || input.closest('.compact-file-upload') || input.closest('.form-group-modern');

                    if (!filled) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        if (wrapper) wrapper.classList.add('has-error');
                        if (!firstInvalid) firstInvalid = input;
                    } else {
                        input.classList.remove('is-invalid');
                        if (wrapper) wrapper.classList.remove('has-error');
                    }
                });

                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }

                return isValid;
            },

            scrollToFormTop() {
                const formEl = document.getElementById('registrationForm');
                if (formEl) {
                    const y = formEl.getBoundingClientRect().top + window.pageYOffset - 90;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            },

            async submitForm(e) {
                if (!this.validateCurrentStep()) {
                    this.showToast('Please correct the highlighted fields before submitting.', 'error');
                    return;
                }

                this.loading = true;
                const form = e.target;
                const formData = new FormData(form);

                try {
                    const response = await fetch('<?= BASE_URL ?>/trainings/submit', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    // Clear previous errors
                    document.querySelectorAll('.invalid-feedback-modern').forEach(el => el.remove());
                    document.querySelectorAll('.has-error').forEach(el => el.classList.remove('has-error'));
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                    if (result.success) {
                        this.showToast(result.message, 'success');
                        if (result.redirect_url) {
                            setTimeout(() => {
                                window.location.href = result.redirect_url;
                            }, 800);
                        } else if (result.redirect) {
                            setTimeout(() => {
                                window.location.href = result.redirect;
                            }, 2000);
                        }
                    } else {
                        this.showToast(result.message || 'Please correct the highlighted fields.', 'error');

                        if (result.errors) {
                            let firstErrorInput = null;
                            Object.keys(result.errors).forEach(key => {
                                const input = form.querySelector(`[name="${key}"]`) || form.querySelector(`[name="${key}[]"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const wrapper = input.closest('.input-wrapper-modern') || input.closest('.compact-file-upload') || input.closest('.form-group-modern');
                                    if (wrapper) wrapper.classList.add('has-error');

                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'invalid-feedback-modern';
                                    errorDiv.innerHTML = '<span class="material-symbols-outlined" style="font-size: 14px;">error</span><span>' + result.errors[key] + '</span>';
                                    
                                    const formGroup = input.closest('.form-group-modern');
                                    if (formGroup) formGroup.appendChild(errorDiv);

                                    if (!firstErrorInput) firstErrorInput = input;
                                }
                            });

                            if (firstErrorInput) {
                                // Jump to the step containing the error
                                const errorStep = firstErrorInput.closest('[data-step]');
                                if (errorStep) {
                                    const stepNum = parseInt(errorStep.getAttribute('data-step'), 10);
                                    if (stepNum) this.currentStep = stepNum;
                                }
                                firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    }
                } catch (error) {
                    this.showToast('A network connection error occurred. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }
    }

    // Space-efficient compact file input handlers
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('compact-file-input')) {
            const uploadWrap = e.target.closest('.compact-file-upload');
            if (!uploadWrap) return;

            const file = e.target.files[0];
            const idleState = uploadWrap.querySelector('.compact-file-idle');
            const activeState = uploadWrap.querySelector('.compact-file-active');
            const nameEl = uploadWrap.querySelector('.compact-file-name');

            if (file) {
                if (nameEl) nameEl.textContent = file.name;
                if (idleState) idleState.style.display = 'none';
                if (activeState) activeState.style.display = 'flex';
                uploadWrap.classList.remove('has-error');
            } else {
                if (idleState) idleState.style.display = 'flex';
                if (activeState) activeState.style.display = 'none';
            }
        }
    });

    document.addEventListener('click', function(e) {
        const clearBtn = e.target.closest('.btn-compact-clear');
        if (clearBtn) {
            e.preventDefault();
            e.stopPropagation();
            const uploadWrap = clearBtn.closest('.compact-file-upload');
            if (uploadWrap) {
                const input = uploadWrap.querySelector('.compact-file-input');
                if (input) input.value = '';
                const idleState = uploadWrap.querySelector('.compact-file-idle');
                const activeState = uploadWrap.querySelector('.compact-file-active');
                if (idleState) idleState.style.display = 'flex';
                if (activeState) activeState.style.display = 'none';
            }
        }
    });
</script>
