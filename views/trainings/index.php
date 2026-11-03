<link rel="stylesheet" href="<?= BASE_URL ?>/css/trainings.css?v=<?= file_exists(ROOT_PATH . '/css/trainings.css') ? filemtime(ROOT_PATH . '/css/trainings.css') : 1 ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Training <span>Programs</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Trainings
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Trainings Section ====== -->
<?php
if (!function_exists('truncateTrainingDescWordAware')) {
    function truncateTrainingDescWordAware($text, $limit = 118) {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags(stripslashes($text))));
        if ($text === '' || mb_strlen($text) <= $limit) {
            return $text;
        }
        $truncated = mb_substr($text, 0, $limit);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }
        return rtrim($truncated, ".,;:- ") . '...';
    }
}
?>
<section id="services" class="section-padding trainings-page-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Upskill With Confidence</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>
                <br>
                <h2 class="section-title">Practical Tech <span>Training Programs</span></h2>
                <p class="section-subtitle">Fast-track your engineering and digital career with hands-on curriculum vetted by Spider Technologies and enterprise partners.</p>
                <div class="training-trust-pill">
                    <span class="material-symbols-outlined trust-icon">verified</span>
                    <span>Industry Standard Curriculum &bull; Recognized by Enterprise Partners</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($trainings)): ?>
                <?php foreach ($trainings as $index => $training):
                    $isFeatured = ($index === 0);
                    $rawImg = trim($training['image_url'] ?? $training['training_image'] ?? '');
                    $imageSrc = $rawImg !== '' ? resolvePath($rawImg) : '';
                    $hasImg = ($rawImg !== '');
                    $tName = trim(strip_tags(stripslashes($training['training_name'] ?? 'Training Program')));
                    $tDesc = truncateTrainingDescWordAware($training['training_description'] ?? '', 118);
                    $certifiedCount = (int) ($training['certified_count'] ?? 0);

                    // Resolve payment fee badge according to spec
                    $feeInfo = $training['effective_fee'] ?? null;
                    $paymentsEnabled = !empty($feeInfo['payments_enabled']);
                    $feeKobo = (int)($feeInfo['amount_kobo'] ?? 0);

                    $feeBadgeText = null;
                    $feeBadgeClass = null;

                    if ($paymentsEnabled) {
                        if ($feeKobo > 0) {
                            $feeBadgeText = format_naira($feeKobo);
                            $feeBadgeClass = 'paid';
                        } else {
                            // Misconfigured fee: log warning, hide badge, do NOT show Free
                            error_log(sprintf(
                                "[TRAINING PAYMENT MISCONFIG] Training ID %d ('%s') has payments_enabled=1 but resolved fee is %d kobo.",
                                $training['id'],
                                $training['training_name'] ?? 'Unknown',
                                $feeKobo
                            ));
                            $feeBadgeText = null;
                        }
                    } else {
                        $feeBadgeText = 'Free';
                        $feeBadgeClass = 'free';
                    }

                    // Resolve data-backed dynamic status badge
                    $selectedCohort = (!empty($training['active_cohort']) && is_array($training['active_cohort']))
                        ? $training['active_cohort']
                        : ((!empty($training['upcoming_cohort']) && is_array($training['upcoming_cohort'])) ? $training['upcoming_cohort'] : null);
                    $statusBadge = resolve_training_status_badge($training, $selectedCohort);
                ?>
                <div class="col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="research-card">
                        <div class="card-img-wrap">
                            <span class="card-category"><?= $isFeatured ? 'Featured Program' : 'Certification Track' ?></span>
                            <?php if ($feeBadgeText !== null): ?>
                                <span class="card-fee-badge <?= $feeBadgeClass ?>" aria-label="Fee: <?= htmlspecialchars($feeBadgeText) ?>">
                                    <?= htmlspecialchars($feeBadgeText) ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($hasImg): ?>
                                <img src="<?= htmlspecialchars($imageSrc) ?>"
                                     alt="<?= htmlspecialchars($tName) ?>"
                                     loading="lazy"
                                     decoding="async"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <?php endif; ?>
                            <div class="training-img-fallback" style="display: <?= $hasImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                                <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                    <path d="M32 20L16 28L32 36L48 28L32 20Z" stroke="#f48221" stroke-width="2.5" stroke-linejoin="round"/>
                                    <path d="M22 31V40C22 42.5 26.5 45 32 45C37.5 45 42 42.5 42 40V31" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                </svg>
                                <span class="fallback-label">Training Track</span>
                            </div>
                        </div>
                        <div class="card-body-content">
                            <div class="card-cohort-wrap mb-2">
                                <span class="card-cohort-badge <?= htmlspecialchars($statusBadge['status_class']) ?>">
                                    <span class="<?= htmlspecialchars($statusBadge['dot_class']) ?>"></span>
                                    <span><?= htmlspecialchars($statusBadge['badge_text']) ?></span>
                                </span>
                            </div>
                            <a href="<?= BASE_URL ?>/trainings/detail?id=<?= (int) $training['id']; ?>" class="card-title-link">
                                <h3><?= htmlspecialchars($tName) ?></h3>
                            </a>
                            <p class="training-card-desc"><?= htmlspecialchars($tDesc) ?></p>

                            <div class="training-stats-row">
                                <span class="training-stats-item">
                                    <span class="material-symbols-outlined">verified</span>
                                    <span><?= number_format($certifiedCount) ?> Certified</span>
                                </span>
                                <span class="training-stats-item">
                                    <span class="material-symbols-outlined">language</span>
                                    <span>English</span>
                                </span>
                            </div>

                            <a href="<?= BASE_URL ?>/trainings/detail?id=<?= (int) $training['id']; ?>" class="read-link">
                                <span>Explore Program</span>
                                <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <span class="material-symbols-outlined">school</span>
                        <h4>No Training Programs Available Yet</h4>
                        <p>New cohorts and technical bootcamps are being scheduled. Check back soon!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Corporate Training CTA Banner -->
        <div class="premium-cta">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 mb-3 mb-lg-0 text-lg-left text-center">
                    <h2 class="premium-cta-title">Need Custom <span>Corporate Training?</span></h2>
                    <p class="premium-cta-desc">
                        We design tailored engineering bootcamps, cybersecurity workshops, and digital transformation programs for teams and organizations.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-right text-center">
                    <a href="<?= BASE_URL ?>/contact" class="cta-button">
                        <span>Request Team Training</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
