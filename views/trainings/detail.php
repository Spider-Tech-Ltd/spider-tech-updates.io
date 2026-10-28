<?php
/**
 * Training Detail View
 */
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/training-detail.css?v=<?= filemtime(ROOT_PATH . '/css/training-detail.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    $title = $training ? htmlspecialchars(strip_tags(stripslashes($training['training_name']))) : 'Training Detail';
                    $words = explode(' ', $title);
                    if (count($words) > 1) {
                        $lastWord = array_pop($words);
                        $displayTitle = implode(' ', $words) . ' <span>' . $lastWord . '</span>';
                    } else {
                        $displayTitle = '<span>' . $title . '</span>';
                    }
                ?>
                <h1 class="page-title"><?= $displayTitle; ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/" title="Home">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            <?= htmlspecialchars(mb_strimwidth($title, 0, 36, '…')) ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="detail-section">
    <?php if ($training):
        $rawDetailImg = trim($training['image_url'] ?? $training['training_image'] ?? '');
        $detailImage = $rawDetailImg !== '' ? resolvePath($rawDetailImg) : '';
        $hasDetailImg = ($rawDetailImg !== '');
    ?>
        <div class="container">
            <div class="mb-4">
                <a href="<?= BASE_URL ?>/trainings" class="back-nav-link">
                    <span class="material-symbols-outlined">keyboard_backspace</span>
                    <span>Back to Training Programs</span>
                </a>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="project_screen">
                        <?php if ($hasDetailImg): ?>
                            <img src="<?= htmlspecialchars($detailImage) ?>"
                                 alt="<?= $title ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                        <?php endif; ?>
                        <div class="detail-img-fallback" style="display: <?= $hasDetailImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                            <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                <path d="M32 20L16 28L32 36L48 28L32 20Z" stroke="#f48221" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M22 31V40C22 42.5 26.5 45 32 45C37.5 45 42 42.5 42 40V31" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                            <span class="fallback-label">Program Preview</span>
                        </div>
                    </div>

                    <div class="project_description">
                        <span class="section-eyebrow">
                            <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                                <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            </svg>
                            <span class="eyebrow-label-text">Program Overview</span>
                            <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                                <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            </svg>
                        </span>
                        <br>
                        <h3>About this <span>Program</span></h3>
                        <div class="program-lead-text"><?= nl2br(htmlspecialchars(stripslashes($training['training_description'] ?? ''))); ?></div>
                        <?php if (!empty($training['training_details'])): ?>
                            <div class="training-rich-content">
                                <?= stripslashes($training['training_details']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-card">
                        <div class="sidebar-header">
                            <span class="sidebar-badge">Enrollment Details</span>
                            <h5 class="sidebar-title">Course Information</h5>
                        </div>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">calendar_today</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Schedule</span>
                                    <span class="info-value">
                                        <?php
                                        if (!empty($training['start_date'])) {
                                            echo date('M d, Y', strtotime($training['start_date']));
                                            if (!empty($training['end_date'])) {
                                                echo ' – ' . date('M d, Y', strtotime($training['end_date']));
                                            }
                                        } else {
                                            echo "Flexible / TBD";
                                        }
                                        ?>
                                    </span>
                                </div>
                            </li>
                            <?php if (!empty($training['training_time'])): ?>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">schedule</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Session Time</span>
                                    <span class="info-value"><?= htmlspecialchars(stripslashes($training['training_time'])) ?></span>
                                </div>
                            </li>
                            <?php endif; ?>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">hourglass_empty</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Duration</span>
                                    <span class="info-value">
                                        <?php
                                        if (!empty($training['start_date']) && !empty($training['end_date'])) {
                                            $start = new DateTime($training['start_date']);
                                            $end = new DateTime($training['end_date']);
                                            $interval = $start->diff($end);
                                            $days = $interval->days + 1;

                                            $weeks = floor($days / 7);
                                            $remaining_days = $days % 7;

                                            $duration = "";
                                            if ($weeks > 0) $duration .= $weeks . " " . ($weeks == 1 ? "Week" : "Weeks");
                                            if ($remaining_days > 0) $duration .= ($duration ? ", " : "") . $remaining_days . " " . ($remaining_days == 1 ? "Day" : "Days");

                                            echo htmlspecialchars($duration ?: "1 Day");
                                        } elseif (!empty($training['start_date'])) {
                                            echo "1 Day";
                                        } else {
                                            echo "Self-Paced / Cohort";
                                        }
                                        ?>
                                    </span>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">verified</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Graduates</span>
                                    <span class="info-value"><?= number_format($training['certified_count'] ?? 0) ?> Certified Candidates</span>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">language</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Instruction Language</span>
                                    <span class="info-value">English</span>
                                </div>
                            </li>
                        </ul>

                        <?php if (!empty($training['registration_available'])): ?>
                            <a href="<?= BASE_URL ?>/trainings/register?id=<?= (int) $training['id']; ?>" class="register-btn-large">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                <span>Enroll in Program</span>
                            </a>
                        <?php else: ?>
                            <div class="registration-closed-box">
                                <span class="material-symbols-outlined">info</span>
                                <span>Registration is currently closed for this cohort</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container text-center py-5">
            <div class="empty-detail-box">
                <span class="material-symbols-outlined empty-icon">school</span>
                <h3>Training Program Not Found</h3>
                <p>The program you are looking for may have been archived or moved.</p>
                <a href="<?= BASE_URL ?>/trainings" class="register-btn-large d-inline-flex w-auto px-4">
                    <span>Back to Trainings</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
