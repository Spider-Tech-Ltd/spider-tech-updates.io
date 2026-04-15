<style>
    :root {
        --primary-orange: #f48221;
        --primary-dark: #262626;
        --text-body: #374151;
        --text-muted: #797979;
    }

    .project-detail-main {
        padding-top: 120px;
        padding-bottom: 100px;
    }

    /* Hero Header */
    .hero-wrap {
        position: relative;
        height: 450px;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .hero-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,24,39,0.9), transparent);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    .hero-overlay h1 {
        color: #fff;
        font-size: 48px;
        font-weight: 700;
        line-height: 1.2;
        max-width: 900px;
    }
    .hero-overlay .badge {
        background: var(--primary-orange);
        color: #fff;
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        width: fit-content;
        margin-bottom: 20px;
    }

    /* Centralized Reading Flow */
    .reading-container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* Project Info Grid */
    .project-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
        padding: 30px;
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 20px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .info-item .label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }
    .info-item .value {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-dark);
    }
    .info-item i {
        color: var(--primary-orange);
        margin-right: 5px;
    }

    /* Article Content */
    .project-content {
        font-size: 18px;
        line-height: 1.8;
        color: var(--text-body);
    }
    .project-content p {
        margin-bottom: 25px;
    }
    .project-content h2, .project-content h3, .project-content h4 {
        font-weight: 700;
        color: var(--primary-dark);
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .btn-back {
        background: #f3f4f6;
        color: var(--text-body);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .btn-back:hover {
        background: #e5e7eb;
        color: var(--primary-dark);
        transform: translateX(-5px);
    }

    /* CTA Section */
    .detail-cta {
        margin-top: 80px;
        padding: 60px;
        background: #f9fafb;
        border-radius: 30px;
        text-align: center;
    }
    .detail-cta h4 {
        font-weight: 800;
        margin-bottom: 15px;
        color: var(--primary-dark);
    }
    .btn-project-cta {
        background-color: var(--primary-orange);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 14px 40px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
        text-decoration: none !important;
        margin-top: 20px;
    }
    .btn-project-cta:hover {
        background-color: #db7015;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(244, 130, 33, 0.35);
        color: #fff;
    }

    @media (max-width: 768px) {
        .hero-overlay h1 { font-size: 32px; }
        .hero-wrap { height: 350px; }
        .detail-cta { padding: 40px 20px; }
    }
</style>

<main class="project-detail-main">
    <div class="container">
        <?php if($project): ?>

        <!-- Hero Section -->
        <div class="hero-wrap">
            <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="<?= htmlspecialchars($project['project_name']) ?>">
            <div class="hero-overlay">
                <span class="badge"><?= htmlspecialchars($project['service_name']) ?></span>
                <h1><?= stripslashes($project['project_name']) ?></h1>
            </div>
        </div>

        <!-- Reading Container -->
        <div class="reading-container">

            <!-- Breadcrumb / Back link -->
            <div class="mb-5">
                <a href="<?= BASE_URL ?>/projects" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Showcase
                </a>
            </div>

            <!-- Info Grid -->
            <div class="project-info-grid">
                <div class="info-item">
                    <span class="label">Client</span>
                    <span class="value"><i class="fas fa-user-tie"></i> Spider Tech Partners</span>
                </div>
                <div class="info-item">
                    <span class="label">Category</span>
                    <span class="value"><i class="fas fa-layer-group"></i> <?= htmlspecialchars($project['service_name']) ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Launch Date</span>
                    <span class="value"><i class="far fa-calendar-check"></i> 2024</span>
                </div>
                <div class="info-item">
                    <span class="label">Location</span>
                    <span class="value"><i class="fas fa-globe"></i> Global Research</span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="project-content">
                <?= stripslashes($project['project_description']) ?>
            </div>

            <!-- CTA -->
            <div class="detail-cta">
                <h4>Interested in similar solutions?</h4>
                <p class="text-muted">Let's discuss how our expertise can help you achieve your digital transformation goals.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn-project-cta">
                    Get in Touch <i class="fas fa-paper-plane"></i>
                </a>
            </div>

        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <h3>Project not found</h3>
            <p>The project you are looking for does not exist or has been moved.</p>
            <a href="<?= BASE_URL ?>/projects" class="btn-project-cta">Return to Showcase</a>
        </div>
        <?php endif; ?>
    </div>
</main>
