<?php

/**
 * Training Detail View
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/training-detail.css" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    $title = $training ? htmlspecialchars($training['training_name']) : 'Training Detail';
                    $words = explode(' ', $title);
                    if (count($words) > 1) {
                        $lastWord = array_pop($words);
                        $displayTitle = implode(' ', $words) . ' <span>' . $lastWord . '</span>';
                    } else {
                        $displayTitle = '<span>' . $title . '</span>';
                    }
                ?>
                <h1 class="page-title"><?= $displayTitle; ?></h1>

                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/" title="Home">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Detail
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== Page Header End ====== -->

<section class="detail-section">
    <?php if ($training): ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="project_screen">
                        <?php $detailImage = resolvePath($training['image_url'] ?? $training['training_image'] ?? ''); ?>
                        <img src="<?= $detailImage ?>" alt="Training" />
                    </div>
                    <div class="project_description">
                        <h3 class="mb-4">About this Program</h3>
                        <div class="mb-4"><?= nl2br(htmlspecialchars($training['training_description'])); ?></div>
                        <div class="training-rich-content">
                            <?= $training['training_details']; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-card">
                        <h5 class="sidebar-title">Course Information</h5>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="material-symbols-outlined">calendar_today</span>
                                <div>
                                    <strong>Schedule:</strong>
                                    <?php
                                    if (!empty($training['start_date'])) {
                                        echo date('M d, Y', strtotime($training['start_date']));
                                        if (!empty($training['end_date'])) {
                                            echo ' - ' . date('M d, Y', strtotime($training['end_date']));
                                        }
                                    } else {
                                        echo "TBD";
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php if (!empty($training['training_time'])): ?>
                            <li class="info-item">
                                <span class="material-symbols-outlined">access_time</span>
                                <div><strong>Time:</strong> <?= htmlspecialchars($training['training_time']) ?></div>
                            </li>
                            <?php endif; ?>
                            <li class="info-item">
                                <span class="material-symbols-outlined">hourglass_empty</span>
                                <div>
                                    <strong>Duration:</strong>
                                    <?php
                                    if (!empty($training['start_date']) && !empty($training['end_date'])) {
                                        $start = new DateTime($training['start_date']);
                                        $end = new DateTime($training['end_date']);
                                        $interval = $start->diff($end);
                                        $days = $interval->days + 1; // Include both start and end day

                                        $weeks = floor($days / 7);
                                        $remaining_days = $days % 7;

                                        $duration = "";
                                        if ($weeks > 0) $duration .= $weeks . " " . ($weeks == 1 ? "Week" : "Weeks");
                                        if ($remaining_days > 0) $duration .= ($duration ? ", " : "") . $remaining_days . " " . ($remaining_days == 1 ? "Day" : "Days");

                                        echo htmlspecialchars($duration ?: "1 Day");
                                    } elseif (!empty($training['start_date'])) {
                                        echo "1 Day";
                                    } else {
                                        echo "TBD";
                                    }
                                    ?>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">verified</span>
                                <div><strong>Certified:</strong> <?= number_format($training['certified_count'] ?? 0) ?> Candidates</div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">language</span>
                                <div><strong>Language:</strong> English Only</div>
                            </li>
                        </ul>
                        <?php if ($training['registration_available']): ?>
                            <a href="<?= BASE_URL ?>/trainings/register?id=<?= $training['id']; ?>" class="register-btn-large">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                Enroll Now
                            </a>
                        <?php else: ?>
                            <div class="alert alert-light border text-center small py-3 rounded-4">
                                <span class="material-symbols-outlined align-middle fs-5 text-muted">info</span>
                                <span class="text-muted">Registration currently closed</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container text-center">
            <h3 class="mb-4">Training program not found.</h3>
            <a href="<?= BASE_URL ?>/trainings" class="btn-header-cta d-inline-flex">Back to Trainings</a>
        </div>
    <?php endif; ?>
</section>