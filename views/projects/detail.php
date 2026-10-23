<link rel="stylesheet" href="<?= BASE_URL ?>/css/project-detail.css" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= htmlspecialchars($project['service_name']); ?> <span>Detail</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/projects">Projects</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Case Study
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Project Detail Showcase ====== -->
<section class="section-padding">
    <div class="container">
        <?php if ($project): ?>

            <!-- Hero Visual -->
            <div class="project-hero-wrap">
                <?php
                    $pic = $project['project_pic'];
                    $finalPic = (empty($pic)) ? BASE_URL . '/images/placeholder-banner.jpg' : ( (preg_match('#^https?://#i', $pic)) ? $pic : BASE_URL . '/' . ltrim($pic, './') );
                ?>
                <img src="<?= $finalPic ?>" alt="<?= htmlspecialchars($project['project_name']); ?>">
                <div class="project-hero-overlay">
                    <h2 class="project-main-title"><?= stripslashes($project['project_name']); ?></h2>
                </div>
            </div>

            <div class="reading-flow">
                <!-- Metadata Grid -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Client</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">workspace_premium</span>
                            Spider Tech Partners
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">category</span>
                            <?= htmlspecialchars($project['service_name']); ?>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Launch Date</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">event_available</span>
                            2024
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Industry</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">public</span>
                            Tech Innovation
                        </span>
                    </div>
                </div>

                <!-- Project Content -->
                <div class="project-narrative">
                    <?= stripslashes($project['project_description']); ?>
                </div>

                <?php if (!empty($project_media)): ?>
                <div class="media-gallery-section">
                    <div class="mb-5">
                        <span class="tag-eyebrow">Visual Highlights</span>
                        <h3 class="section-title">Project <span>Gallery</span></h3>
                    </div>
                    <div class="gallery-grid">
                        <?php foreach ($project_media as $media): ?>
                        <?php $mediaImg = resolvePath($media['project_pics_name']); ?>
                        <a href="<?= $mediaImg; ?>" class="gallery-item popup-box" data-lightbox="project-gallery" rel="lightbox[project-gallery]" title="<?= htmlspecialchars($project['project_name']) ?>">
                            <img src="<?= $mediaImg; ?>" alt="Project gallery photo" loading="lazy" onerror="this.closest('a').style.display='none';">
                            <div class="gallery-overlay">
                                <span class="material-symbols-outlined" style="font-size: 32px;">zoom_in</span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Bottom CTA -->
                <div class="showcase-cta">
                    <h2 style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 2.5rem; margin-bottom: 1.5rem;">Have a Similar <span>Challenge?</span></h2>
                    <p style="color: rgba(255,255,255,0.6); line-height: 1.8; font-size: 1.1rem; margin-bottom: 2.5rem;">
                        We specialize in solving complex industrial problems through advanced digital engineering. Let's discuss your next breakthrough.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <a href="<?= BASE_URL ?>/contact" class="btn-pill btn-orange">
                            Start a Project
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </a>
                        <a href="<?= BASE_URL ?>/projects" class="btn-pill" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1);">
                            <span class="material-symbols-outlined" style="margin-right: 8px;">grid_view</span>
                            Back to Showcase
                        </a>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-5">
                <h2 class="text-muted">Project not found.</h2>
                <a href="<?= BASE_URL ?>/projects" class="btn-pill btn-orange mt-4">Back to Showcase</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>