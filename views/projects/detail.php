
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
        <?php if($project): ?>
        
        <!-- Hero Visual -->
        <div class="project-hero-wrap">
             <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="<?= htmlspecialchars($project['project_name']); ?>">
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

            <!-- Bottom CTA -->
            <div class="premium-cta">
                 <h2 class="section-title text-white">Have a Similar <span>Challenge?</span></h2>
                 <p class="text-white-70 mb-5 fs-18">
                     We specialize in solving complex industrial problems through advanced digital engineering. Let's discuss your next breakthrough.
                 </p>
                 <div class="d-flex-center flex-wrap gap-4">
                     <a href="<?= BASE_URL ?>/contact" class="cta-button">
                         Start a Project
                         <span class="material-symbols-outlined">rocket_launch</span>
                     </a>
                     <a href="<?= BASE_URL ?>/projects" class="cta-button cta-button-outline">
                         <span class="material-symbols-outlined" class="mr-2">grid_view</span>
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
