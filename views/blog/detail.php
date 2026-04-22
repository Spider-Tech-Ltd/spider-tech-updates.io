<!-- Reading Progress Bar -->
<div id="progress-bar" class="reading-progress"></div>

<!-- Material Symbols for Blog UI -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

<style>
    :root {
        --primary-orange: #f48221;
        --primary-dark: #262626;
        --text-body: #374151;
        --text-muted: #797979;
    }

    .reading-progress {
        height: 4px;
        background: var(--primary-orange);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        width: 0%;
        transition: width 0.1s ease-out;
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

    .article-main {
        padding-top: 80px;
        padding-bottom: 100px;
    }

    /* Article Featured Image */
    .article-featured-image {
        position: relative;
        height: 500px;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    }

    .article-featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-badge {
        position: absolute;
        top: 30px;
        left: 30px;
        background: var(--primary-orange);
        color: #fff;
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(244, 130, 33, 0.3);
    }

    /* Centralized Reading Flow */
    .reading-container {
        max-width: 850px;
        margin: 0 auto;
        margin-block-start: 6rem !important;
    }

    /* Article Meta */
    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 50px;
    }

    .author-box {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-icon {
        width: 45px;
        height: 45px;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-orange);
    }

    .author-info h6 {
        margin: 0;
        font-weight: 700;
        font-size: 14px;
    }

    .author-info span {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
    }

    .meta-stats {
        display: flex;
        gap: 30px;
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Article Content */
    .article-content {
        font-size: 18px;
        line-height: 1.8;
        color: var(--text-body);
    }

    .article-content p {
        margin-bottom: 25px;
    }

    .article-content h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-top: 50px;
        margin-bottom: 20px;
    }

    .abstract {
        font-size: 20px;
        color: #4b5563;
        font-style: italic;
        border-left: 4px solid #eee;
        padding-left: 25px;
        margin-bottom: 40px;
        font-weight: 300;
    }

    .callout {
        background: #fffcf9;
        border-left: 4px solid var(--primary-orange);
        padding: 35px;
        border-radius: 0 15px 15px 0;
        margin: 40px 0;
    }

    .callout h5 {
        color: var(--primary-orange);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .article-img {
        width: 100%;
        border-radius: 20px;
        margin: 40px 0;
    }

    /* Related Footer */
    .related-section {
        margin-top: 80px;
        padding-top: 60px;
        border-top: 1px solid #eee;
    }

    .related-section h4 {
        margin-bottom: 30px;
        font-weight: 700;
    }

    .related-card {
        border: 1px solid #eee;
        padding: 30px;
        border-radius: 20px;
        transition: all 0.3s;
        height: 100%;
        display: block;
        text-decoration: none !important;
    }

    .related-card:hover {
        border-color: rgba(244, 130, 33, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transform: translateY(-5px);
    }

    .related-card .tag {
        color: var(--primary-orange);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 12px;
        display: block;
    }

    .related-card h5 {
        font-size: 18px;
        color: var(--primary-dark);
        font-weight: 700;
    }

    /* Back Button Branding */
    .btn-insights-back {
        background-color: var(--primary-orange);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 12px 35px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
        text-decoration: none !important;
    }

    .btn-insights-back:hover {
        background-color: #db7015;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(244, 130, 33, 0.35);
        color: #fff;
    }

    .hero-wrap {
        position: relative;
        margin-block: 2rem;
        max-width: 100%;
        height: 65vh;

        >img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 2rem;
        }

        >div:first-of-type>h1 {
            margin-block-end: 1rem;
        }
    }
</style>

<main class="article-main">
    <div class="container">

        <!-- Hero Section -->
        <div class="hero-wrap">
            <img src="<?= $blog['image_path'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
            <div class="hero-overlay">
                <span class="badge"><?= htmlspecialchars($blog['category_name']) ?></span>
                <h1><?= htmlspecialchars($blog['title']) ?></h1>
            </div>
        </div>

        <!-- Reading Container -->
        <div class="reading-container">

            <!-- Metadata Area -->
            <div class="article-meta">
                <div class="author-box">
                    <div class="author-icon">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div class="author-info">
                        <h6>Global Research Unit</h6>
                        <span>Lead Architect</span>
                    </div>
                </div>
                <div class="meta-stats">
                    <span><?= date('M j, Y', strtotime($blog['created_at'])) ?></span>
                    <span>8 min read</span>
                </div>
            </div>

            <!-- Article Content -->
            <div class="article-content">
                <?= $blog['content'] ?>
            </div>

            <!-- Related Area -->
            <?php if (!empty($related_blogs)): ?>
                <div class="related-section">
                    <h4>Related Research</h4>
                    <div class="row">
                        <?php foreach ($related_blogs as $related): ?>
                            <div class="col-md-6 mb-4">
                                <a href="<?= BASE_URL ?>/blog/<?= $related['slug'] ?>" class="related-card">
                                    <span class="tag"><?= htmlspecialchars($related['category_name']) ?></span>
                                    <h5><?= htmlspecialchars($related['title']) ?></h5>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Back Link -->
            <div class="mt-5 text-center">
                <a href="<?= BASE_URL ?>/blog" class="btn-insights-back">
                    <span class="material-symbols-outlined">arrow_back</span> Back to Insights
                </a>
            </div>

        </div>
    </div>
</main>

<script>
    // Reading Progress Tracking (Legacy support for direct visits)
    (function() {
        const progressBar = document.getElementById('progress-bar');
        if (!progressBar) return;

        const updateProgress = () => {
            const h = document.documentElement,
                b = document.body,
                st = 'scrollTop',
                sh = 'scrollHeight';
            const percent = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            progressBar.style.width = percent + '%';
        };

        window.addEventListener('scroll', updateProgress, {
            passive: true
        });
        updateProgress();
    })();
</script>