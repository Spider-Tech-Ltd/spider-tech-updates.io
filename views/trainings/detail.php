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

        // Resolve dynamic cohort and training schedule
        $cohortDates = !empty($active_cohort) ? $active_cohort : (!empty($upcoming_cohort) ? $upcoming_cohort : null);
        $effectiveStartDate = !empty($cohortDates['start_date']) ? $cohortDates['start_date'] : ($training['start_date'] ?? '');
        $effectiveEndDate   = !empty($cohortDates['end_date']) ? $cohortDates['end_date'] : ($training['end_date'] ?? '');

        // Dynamic schedule strings
        if (!empty($effectiveStartDate)) {
            $scheduleSidebar = date('M d, Y', strtotime($effectiveStartDate));
            $scheduleDetails = date('jS F, Y', strtotime($effectiveStartDate));
            if (!empty($effectiveEndDate)) {
                $scheduleSidebar .= ' – ' . date('M d, Y', strtotime($effectiveEndDate));
                $scheduleDetails .= ' – ' . date('jS F, Y', strtotime($effectiveEndDate));
            }
        } else {
            $scheduleSidebar = "Flexible / TBD";
            $scheduleDetails = "Flexible / TBD";
        }

        // Dynamic duration string
        $durationText = "Self-Paced / Cohort";
        if (!empty($effectiveStartDate) && !empty($effectiveEndDate)) {
            $start = new DateTime($effectiveStartDate);
            $end = new DateTime($effectiveEndDate);
            $interval = $start->diff($end);
            $days = (int) $interval->days + 1;
            $weeks = intdiv($days, 7);
            $remDays = $days % 7;
            $parts = [];
            if ($weeks > 0) $parts[] = $weeks . ' ' . ($weeks === 1 ? 'Week' : 'Weeks');
            if ($remDays > 0) $parts[] = $remDays . ' ' . ($remDays === 1 ? 'Day' : 'Days');
            $durationText = !empty($parts) ? implode(', ', $parts) : '1 Day';
        } elseif (!empty($effectiveStartDate)) {
            $durationText = "1 Day";
        }

        // Dynamic Session Time
        $sessionTime = !empty($training['training_time']) ? htmlspecialchars(stripslashes($training['training_time'])) : '08:00AM – 01:00PM';

        // Cohort Label
        $cohortBadgeLabel = !empty($active_cohort['cohort_name']) ? $active_cohort['cohort_name'] : (!empty($upcoming_cohort['cohort_name']) ? $upcoming_cohort['cohort_name'] : 'Cohort Intake');
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
                            <?php
                            $rawDetails = stripslashes($training['training_details']);

                            $detailsBoxHtml = '<div class="program-details-minimal">
                                <h4 class="details-heading">Program Details</h4>
                                <div class="program-details-table-wrap">
                                    <table class="program-details-table">
                                        <tbody>
                                            <tr>
                                                <td class="detail-key">Date:</td>
                                                <td class="detail-val">' . htmlspecialchars($scheduleDetails) . '</td>
                                                <td class="detail-key">Duration:</td>
                                                <td class="detail-val">' . htmlspecialchars($durationText) . '</td>
                                            </tr>
                                            <tr>
                                                <td class="detail-key">Days:</td>
                                                <td class="detail-val">Mondays – Thursdays</td>
                                                <td class="detail-key">Time:</td>
                                                <td class="detail-val">' . $sessionTime . ' daily</td>
                                            </tr>
                                            <tr>
                                                <td class="detail-key">Location:</td>
                                                <td class="detail-val" colspan="3">Flat 3, Abinsa House, Zaria road, Kano</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>';

                            if (preg_match('/<p><strong>Programm?e Details:<\/strong><\/p>\s*<ul>.*?<\/ul>/si', $rawDetails)) {
                                $processedDetails = preg_replace('/<p><strong>Programm?e Details:<\/strong><\/p>\s*<ul>.*?<\/ul>/si', $detailsBoxHtml, $rawDetails);
                            } else {
                                $processedDetails = $rawDetails . "\n" . $detailsBoxHtml;
                            }
                            ?>
                            <div class="training-rich-content rich-text-content">
                                <?= $processedDetails; ?>
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
                                    <span class="info-value"><?= htmlspecialchars($scheduleSidebar) ?></span>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">schedule</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Session Time</span>
                                    <span class="info-value"><?= $sessionTime ?></span>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined">hourglass_empty</span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Duration</span>
                                    <span class="info-value"><?= htmlspecialchars($durationText) ?></span>
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
                            <li class="info-item">
                                <span class="info-icon-box">
                                    <span class="material-symbols-outlined"><?= !empty($payment_info['payments_enabled']) ? 'payments' : 'card_giftcard' ?></span>
                                </span>
                                <div class="info-meta">
                                    <span class="info-label">Tuition Fee</span>
                                    <span class="info-value" style="font-weight: 700; color: <?= !empty($payment_info['payments_enabled']) ? '#f48221' : '#047857' ?>;">
                                        <?= !empty($payment_info['payments_enabled']) ? format_naira($payment_info['amount_kobo'] ?? 0) : 'Free' ?>
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <?php if (!empty($training['registration_available']) && !empty($active_cohort)): ?>
                            <?php
                            $badgeData = resolve_training_status_badge($training, $active_cohort);
                            $btnLabel = resolve_enroll_button_label($training['training_name'] ?? '', $active_cohort['cohort_name'] ?? null);
                            ?>
                            <div class="cohort-callout-panel">
                                <div class="cohort-callout-header">
                                    <span class="cohort-status-pill <?= htmlspecialchars($badgeData['status_class']) ?>">
                                        <span class="cohort-status-dot"></span>
                                        <?= htmlspecialchars($badgeData['badge_text']) ?>
                                    </span>
                                </div>
                                <h6 class="cohort-panel-name"><?= htmlspecialchars($active_cohort['cohort_name']) ?></h6>
                                <div class="cohort-panel-meta">
                                    <div class="cohort-meta-line">
                                        <span class="material-symbols-outlined">calendar_month</span>
                                        <span>Classes start <strong><?= date('M d, Y', strtotime($active_cohort['start_date'])) ?></strong></span>
                                    </div>
                                    <?php if (!empty($active_cohort['registration_deadline'])): ?>
                                        <div class="cohort-meta-line deadline">
                                            <span class="material-symbols-outlined">alarm</span>
                                            <span>Deadline: <strong><?= date('M d, Y', strtotime($active_cohort['registration_deadline'])) ?></strong></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <a href="<?= BASE_URL ?>/trainings/register?id=<?= (int) $training['id']; ?>&cohort=<?= (int) $active_cohort['id']; ?>" class="register-btn-large">
                                <span><?= htmlspecialchars($btnLabel) ?></span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        <?php elseif (!empty($upcoming_cohort)): ?>
                            <div class="registration-closed-box">
                                <span class="material-symbols-outlined">event_upcoming</span>
                                <div>
                                    <div class="fw-600"><?= htmlspecialchars($upcoming_cohort['cohort_name']) ?></div>
                                    <span class="fs-085 text-muted">Registration opens soon. Classes begin <?= date('M d, Y', strtotime($upcoming_cohort['start_date'])) ?>.</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="registration-closed-box">
                                <span class="material-symbols-outlined">info</span>
                                <span>Registration is currently closed for this program</span>
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
