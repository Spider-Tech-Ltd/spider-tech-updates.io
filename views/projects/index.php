<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-muted: #888888;
        --card-bg: #ffffff;
    }

    /* Page Header High-Fidelity */
    .page-header {
        background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .page-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(244, 130, 33, 0.05) 0%, transparent 60%);
        pointer-events: none;
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 3.8rem);
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }

    .page-title span {
        color: var(--primary-orange);
    }

    /* Professional Breadcrumbs */
    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 15px;
    }

    .breadcrumb-item-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item-custom a:hover {
        color: var(--primary-orange);
    }

    .breadcrumb-item-custom.active {
        color: var(--primary-orange);
    }

    .breadcrumb-separator {
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
    }

    /* Section Styles */
    .section-padding {
        padding: 120px 0;
    }

    .tag-eyebrow {
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    /* Project Cards High-Fidelity */
    .project-card {
        background: var(--card-bg);
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .project-img-wrap {
        position: relative;
        height: 260px;
        overflow: hidden;
        margin: 10px;
        border-radius: 24px;
    }

    .project-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img-wrap img {
        transform: scale(1.1);
    }

    .project-category-tag {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #ffffff;
        color: var(--dark-bg);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        z-index: 2;
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    .project-body {
        padding: 30px 35px 35px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .project-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        color: var(--dark-bg);
        margin-bottom: 12px;
        line-height: 1.3;
        transition: color 0.3s;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-card:hover .project-title {
        color: var(--primary-orange);
    }

    .project-desc {
        color: var(--text-muted);
        line-height: 1.7;
        font-size: 0.95rem;
        margin-bottom: 25px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-link {
        color: var(--dark-bg);
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: auto;
    }

    .project-link .arrow-icon {
        font-size: 1.2rem;
        transition: transform 0.3s;
    }

    .project-card:hover .project-link {
        color: var(--primary-orange);
    }

    .project-card:hover .project-link .arrow-icon {
        transform: translateX(5px);
    }

    /* CTA Section Upgrade */
    .premium-cta {
        background: var(--dark-bg);
        border-radius: 40px;
        padding: 60px 40px;
        margin-top: 60px;
        position: relative;
        overflow: hidden;
        text-align: center;
        color: #fff;
    }

    .premium-cta h2 {
        color: #fff;
    }

    .premium-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 10% 20%, rgba(244, 130, 33, 0.1) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(244, 130, 33, 0.1) 0%, transparent 40%);
        pointer-events: none;
    }

    .cta-button {
        background: var(--primary-orange);
        color: #fff;
        padding: 16px 40px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 1rem;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s;
        text-decoration: none !important;
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.3);
    }

    .cta-button:hover {
        background: #e6751c;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.4);
        color: #fff;
    }

    @media (max-width: 991px) {
        .section-padding { padding: 80px 0; }
        .page-header { padding: 120px 0 60px; }
        .premium-cta { padding: 60px 30px; }
    }

    @media (max-width: 768px) {
        .section-padding { padding: 40px 0; }
    }
</style>

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
                <h2 class="section-title" style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 2.8rem; color: var(--dark-bg);">Building the <span>Future</span></h2>
                <p class="section-subtitle">Explore our portfolio of cutting-edge digital solutions, enterprise platforms, and transformative tech projects across Africa.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach($projects as $project): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-img-wrap">
                        <span class="project-category-tag"><?= htmlspecialchars($project['service_name']); ?></span>
                        <?php
                            $pic = $project['project_pic'];
                            $finalPic = (empty($pic)) ? BASE_URL . '/images/placeholder-banner.jpg' : ( (preg_match('#^https?://#i', $pic)) ? $pic : BASE_URL . '/' . ltrim($pic, './') );
                        ?>
                        <img src="<?= $finalPic ?>" alt="<?= htmlspecialchars($project['project_name']); ?>">
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
                    <h2 style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 2.5rem; margin-bottom: 1.5rem;">Have a Visionary <span>Idea?</span></h2>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.8; font-size: 1.1rem; margin-bottom: 2.5rem;">
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
