<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-muted: #888888;
        --card-bg: #ffffff;
    }

    /* Page Header High-Fidelity */
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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
        font-size: clamp(2.2rem, 5vw, 3.2rem);
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -1.2px;
        line-height: 1.2;
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
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255, 255, 255, 0.5);
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
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }

    /* Showcase Content */
    .section-padding {
        padding: 100px 0;
    }

    .project-hero-wrap {
        position: relative;
        height: 550px;
        border-radius: 40px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
    }

    .project-hero-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 60%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 60px;
    }

    .project-main-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: clamp(2rem, 5vw, 3.8rem);
        color: #fff;
        line-height: 1.1;
        margin-bottom: 0;
    }

    /* Info Meta Grid */
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
        padding: 40px;
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 30px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.03);
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .meta-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--text-muted);
    }

    .meta-value {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dark-bg);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .meta-value i,
    .meta-value .material-symbols-outlined {
        color: var(--primary-orange);
        font-size: 1.2rem;
    }

    /* Reading Content */
    .reading-flow {
        max-width: 900px;
        margin: 0 auto;
    }

    .project-narrative {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #444;
        margin-bottom: 80px;
    }

    .project-narrative h2,
    .project-narrative h3 {
        font-weight: 800;
        margin-top: 50px;
        margin-bottom: 25px;
        color: var(--dark-bg);
    }

    /* Bottom CTA Box */
    .showcase-cta {
        background: var(--dark-bg);
        padding: 80px;
        border-radius: 40px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;

        >h2 {
            color: #f0f0f0;
        }
    }

    .showcase-cta::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(244, 130, 33, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .btn-pill {
        padding: 16px 45px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.95rem;
        letter-spacing: 1px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    .btn-orange {
        background: var(--primary-orange);
        color: #fff;
        border: 2px solid var(--primary-orange);
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.3);
    }

    .btn-orange:hover {
        background: #e6751c;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.4);
        color: #fff;
    }

    @media (max-width: 991px) {
        .project-hero-wrap {
            height: 400px;
        }

        .project-hero-overlay {
            padding: 30px;
        }

        .showcase-cta {
            padding: 60px 30px;
        }

        .meta-grid {
            padding: 30px;
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

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