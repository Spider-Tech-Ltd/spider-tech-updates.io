<link rel="stylesheet" href="<?= BASE_URL ?>/css/project-detail.css?v=<?= filemtime(ROOT_PATH . '/css/project-detail.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= htmlspecialchars(stripslashes($project['project_name'] ?? 'Project')); ?> <span>Case Study</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/projects">Projects</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Case Study
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Project Detail Showcase ====== -->
<section class="section-padding project-detail-section">
    <div class="container">
        <?php if ($project): ?>
            <?php
            $rawPic = trim($project['project_pic'] ?? '');
            $hasPic = false;
            $finalPic = '';
            if ($rawPic !== '') {
                if (preg_match('#^https?://#i', $rawPic)) {
                    $finalPic = $rawPic;
                    $hasPic = true;
                } else {
                    $relPath = ltrim($rawPic, './');
                    if (file_exists(ROOT_PATH . '/' . $relPath)) {
                        $finalPic = BASE_URL . '/' . $relPath;
                        $hasPic = true;
                    }
                }
            }
            $pTitle = trim(stripslashes($project['project_name'] ?? 'Project'));
            $pService = trim(stripslashes($project['service_name'] ?? 'Technology Solution'));
            ?>

            <div class="reading-flow">
                <!-- Hero Visual -->
                <div class="project-hero-wrap">
                    <?php if ($hasPic): ?>
                        <img src="<?= htmlspecialchars($finalPic) ?>"
                             alt="<?= htmlspecialchars($pTitle); ?>"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <?php endif; ?>
                    <div class="project-hero-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true">
                        <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                            <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="2.5"/>
                            <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="project-hero-overlay">
                        <span class="project-hero-badge"><?= htmlspecialchars($pService); ?></span>
                        <h2 class="project-main-title"><?= htmlspecialchars($pTitle); ?></h2>
                    </div>
                </div>

                <!-- Metadata Strip -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Client</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">workspace_premium</span>
                            <span>Spider Tech Partners</span>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">category</span>
                            <span><?= htmlspecialchars($pService); ?></span>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Delivery</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">verified</span>
                            <span>Production Ready</span>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Sector</span>
                        <span class="meta-value">
                            <span class="material-symbols-outlined">public</span>
                            <span>Digital Engineering</span>
                        </span>
                    </div>
                </div>

                <!-- Project Content -->
                <div class="project-narrative-card">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        </svg>
                        <span class="eyebrow-label-text">Project Overview</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <div class="project-narrative">
                        <?= stripslashes($project['project_description']); ?>
                    </div>
                </div>

                <?php if (!empty($project_media)): ?>
                <div class="media-gallery-section">
                    <div class="mb-4">
                        <span class="section-eyebrow">
                            <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                                <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            </svg>
                            <span class="eyebrow-label-text">Visual Highlights</span>
                            <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                                <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            </svg>
                        </span>
                        <br>
                        <h3 class="section-title">Project <span>Gallery</span></h3>
                    </div>
                    <div class="gallery-grid">
                        <?php foreach ($project_media as $media): ?>
                        <?php $mediaImg = resolvePath($media['project_pics_name']); ?>
                        <a href="<?= $mediaImg; ?>" class="gallery-item popup-box" data-lightbox="project-gallery" rel="lightbox[project-gallery]" title="<?= htmlspecialchars($pTitle) ?>">
                            <img src="<?= $mediaImg; ?>" alt="Project gallery photo" loading="lazy" onerror="this.closest('a').style.display='none';">
                            <div class="gallery-overlay">
                                <span class="material-symbols-outlined">zoom_in</span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Bottom CTA -->
                <div class="showcase-cta">
                    <h2 class="showcase-cta-title">Have a Similar <span>Challenge?</span></h2>
                    <p class="showcase-cta-desc">
                        We specialize in solving complex operational problems through reliable software engineering. Let's discuss your next breakthrough.
                    </p>
                    <div class="showcase-cta-actions">
                        <a href="<?= BASE_URL ?>/contact" class="btn-pill btn-orange">
                            <span>Start a Project</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="<?= BASE_URL ?>/projects" class="btn-pill btn-outline-light-subtle">
                            <span class="material-symbols-outlined">grid_view</span>
                            <span>Back to Showcase</span>
                        </a>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-5">
                <h2 class="text-muted">Project not found.</h2>
                <a href="<?= BASE_URL ?>/projects" class="btn-pill btn-orange mt-3">Back to Showcase</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
