<style>
    /* Global Overrides for modern feel */
    .text-orange { color: #f48221 !important; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }

    .projects-hero {
        position: relative;
        background-color: #f4f4f4;
        padding: 140px 16px 80px;
        overflow: hidden;
        text-align: center;
    }

    .projects-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(244, 130, 33, 0.08) 0%, transparent 68%);
        pointer-events: none;
        z-index: 0;
    }

    .hero-blob {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(244, 130, 33, 0.06);
        filter: blur(60px);
        pointer-events: none;
    }

    .hero-blob-left { width: 280px; height: 280px; top: 20%; left: -80px; }
    .hero-blob-right { width: 320px; height: 320px; bottom: 15%; right: -80px; }

    .hero-inner { position: relative; z-index: 1; }

    .hero-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 18px;
        border-radius: 50px;
        background-color: rgba(244, 130, 33, 0.12);
        border: 1px solid rgba(244, 130, 33, 0.25);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #f48221;
        margin-bottom: 28px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin: 0 auto 1.5rem;
        color: #111111;
        max-width: 800px;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #555555;
        max-width: 600px;
        margin: 0 auto 24px;
        line-height: 1.7;
    }

    .hero-btn-primary {
        height: 52px;
        padding: 0 32px;
        background-color: #f48221;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        border-radius: 50px;
        white-space: nowrap;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(244, 130, 33, 0.28);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
    }

    .hero-btn-primary:hover {
        background-color: #e6751c;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(244, 130, 33, 0.35);
    }

    /* Project Card Styles */
    .project-card {
        background-color: #ffffff;
        border-radius: 1.5rem;
        padding: 0.25rem;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .card-img-wrap {
        aspect-ratio: 16/9;
        border-radius: 1.25rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .project-card:hover .card-img-wrap img {
        transform: scale(1.05);
    }

    .card-content {
        padding: 0 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-category {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #f48221;
        margin-bottom: 8px;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #111111;
        line-height: 1.3;
        transition: color 0.3s;
    }

    .project-card:hover .card-title {
        color: #f48221;
    }

    .view-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #f48221;
        font-weight: 700;
        text-decoration: none !important;
        font-size: 0.9rem;
        transition: gap 0.3s;
    }

    .view-btn:hover { gap: 12px; }

    /* CTA Section */
    .projects-cta-section {
        background: linear-gradient(135deg, #f48221 0%, #ff9d4d 100%);
        border-radius: 40px;
        padding: 80px 40px;
        margin: 60px 0 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(244, 130, 33, 0.15);
    }

    .cta-blob {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.15);
        filter: blur(80px);
        border-radius: 50%;
        z-index: 0;
    }

    .cta-content {
        position: relative;
        z-index: 1;
    }

    .cta-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .cta-text {
        color: #ffffff;
        font-size: 1.1rem;
        max-width: 650px;
        margin: 0 auto 40px;
        line-height: 1.6;
        opacity: 0.95;
    }

    .btn-cta-white {
        background-color: #ffffff;
        color: #f48221;
        padding: 16px 48px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-cta-white:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        color: #e6751c;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .projects-hero { padding: 100px 16px 60px; }
        .cta-title { font-size: 1.8rem; }
        .projects-cta-section { padding: 60px 20px; border-radius: 30px; }
    }
</style>

<!-- ====== Hero Section Start ====== -->
<section class="projects-hero">
    <div class="hero-blob hero-blob-left"></div>
    <div class="hero-blob hero-blob-right"></div>
    <div class="container hero-inner">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <span class="hero-eyebrow-pill">
                    <i class="fas fa-rocket"></i>
                    Innovations & Impact
                </span>
                <h1 class="hero-title">Our Projects</h1>
                <p class="hero-subtitle">Exploring the next frontier of digital solutions. From AI-driven platforms to sustainable tech, see how we are building the future.</p>

                <div class="row justify-content-center mt-4 mb-5">
                    <div class="col-md-8 col-lg-4 text-center">
                        <a href="#projects-grid" class="hero-btn-primary w-100">View Showcase</a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-5 d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-orange" aria-current="page">Projects</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ====== Hero Section End ====== -->

<!-- ====== Projects Showcase Start ====== -->
<section id="projects-grid" class="padding">
    <div class="container">
        <div class="row">
            <?php foreach($projects as $project): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="card-img-wrap">
                        <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="<?= htmlspecialchars($project['project_name']); ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-category"><?= htmlspecialchars($project['service_name']); ?></span>
                        <h3 class="card-title"><?= stripslashes($project['project_name']); ?></h3>
                        <a href="<?= BASE_URL ?>/projects/detail?id=<?= $project['project_id']; ?>" class="view-btn">
                            View Project Details
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA Section -->
        <div class="projects-cta-section">
            <div class="cta-blob" style="top: -100px; right: -100px;"></div>
            <div class="cta-blob" style="bottom: -100px; left: -100px;"></div>

            <div class="cta-content">
                <h2 class="cta-title">Have a Visionary Idea?</h2>
                <p class="cta-text">We specialize in turning complex challenges into elegant digital realities. Let's collaborate to build something extraordinary together.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn-cta-white">
                    Start a Project
                    <i class="fas fa-paper-plane"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- ====== Projects Showcase End ====== -->
