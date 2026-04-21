<?php

/**
 * Training Detail View
 */
?>


<!-- ====== Hero Section Start ====== -->
<section class="training-hero">
    <div class="hero-blob hero-blob-left"></div>
    <div class="hero-blob hero-blob-right"></div>
    <div class="container hero-inner">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <span class="hero-eyebrow-pill">
                    <span class="material-symbols-outlined" class="fs-16">school</span>
                    Training Course
                </span>
                <h1 class="hero-title"><?= $training ? htmlspecialchars($training['training_name']) : 'Training Detail'; ?></h1>

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
<!-- ====== Hero Section End ====== -->

<section class="detail-section">
    <?php if ($training): ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="project_screen">
                        <?php
                        $detailImage = '';
                        if (!empty($training['image_url'])) {
                            $detailImage = $training['image_url'];
                        } elseif (!empty($training['training_image'])) {
                            $detailImage = $training['training_image'];
                        }
                        if (!empty($detailImage)) {
                            $detailImage = str_replace('\\', '/', $detailImage);
                            if (preg_match('#^https?://#i', $detailImage)) {
                                $detailImage = htmlspecialchars($detailImage);
                            } else {
                                $detailImage = BASE_URL . '/' . ltrim($detailImage, '/.');
                            }
                        }
                        ?>
                        <?php if (!empty($detailImage)): ?>
                            <img src="<?= $detailImage ?>" alt="Training" />
                        <?php endif; ?>
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
                                <span class="material-symbols-outlined">schedule</span>
                                <div><strong>Duration:</strong> 24 Weeks</div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">group</span>
                                <div><strong>Enrolled:</strong> 41,000+ Students</div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">star</span>
                                <div><strong>Rating:</strong> 4.9/5.0</div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">verified</span>
                                <div><strong>Certified:</strong> Yes, upon completion</div>
                            </li>
                            <li class="info-item">
                                <span class="material-symbols-outlined">language</span>
                                <div><strong>Language:</strong> English</div>
                            </li>
                        </ul>
                        <a href="<?= BASE_URL ?>/trainings/register?id=<?= $training['id']; ?>" class="register-btn-large">
                            <span class="material-symbols-outlined">how_to_reg</span>
                            Enroll Now
                        </a>
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