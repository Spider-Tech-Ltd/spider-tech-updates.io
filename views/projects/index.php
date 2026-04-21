
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Project <span>Showcase</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Projects
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Projects Section ====== -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Innovation in Action</span>
                <h2 class="section-title">Building the <span>Future</span></h2>
                <p class="section-subtitle">Explore our portfolio of cutting-edge digital solutions, enterprise platforms, and transformative tech projects across Africa.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach($projects as $project): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-img-wrap">
                        <span class="project-category-tag"><?= htmlspecialchars($project['service_name']); ?></span>
                        <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="<?= htmlspecialchars($project['project_name']); ?>">
                    </div>
                    <div class="project-body">
                        <h3 class="project-title"><?= stripslashes($project['project_name']); ?></h3>
                        <div class="project-desc"><?= strip_tags(stripslashes($project['project_description'])); ?></div>
                        <a href="<?= BASE_URL ?>/projects/detail?id=<?= $project['project_id']; ?>" class="project-link">
                            View Case Study 
                            <span class="material-symbols-outlined arrow-icon">trending_flat</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Premium CTA Section -->
        <div class="premium-cta">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="section-title text-white">Have a Visionary <span>Idea?</span></h2>
                    <p class="text-white-70 mb-5 fs-18">
                        We specialize in turning complex challenges into elegant digital realities. Let's collaborate to build something extraordinary together.
                    </p>
                    <a href="<?= BASE_URL ?>/contact" class="cta-button">
                        Start a Project
                        <span class="material-symbols-outlined">rocket_launch</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
