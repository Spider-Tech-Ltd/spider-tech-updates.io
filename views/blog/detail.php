<!-- Reading Progress Bar -->
<div id="progress-bar" class="reading-progress"></div>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/blog-detail.css?v=<?= filemtime(ROOT_PATH . '/css/blog-detail.css') ?>" />

<main class="article-main">
    <div class="container">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="<?= BASE_URL ?>/blog" class="back-nav-link">
                <span class="material-symbols-outlined">keyboard_backspace</span>
                <span>Back to Research &amp; Insights</span>
            </a>
        </div>

        <!-- Hero Section -->
        <div class="hero-wrap">
            <img src="<?= $blog['image_path'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="blog-detail-img-fallback" style="display: none;" aria-hidden="true">
                <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                    <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
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
                        <span class="material-symbols-outlined">engineering</span>
                    </div>
                    <div class="author-info">
                        <h6>Spider Tech Engineering</h6>
                        <span>Technical Intelligence Group</span>
                    </div>
                </div>
                <div class="meta-stats">
                    <span class="meta-stat-item">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span><?= date('M j, Y', strtotime($blog['created_at'])) ?></span>
                    </span>
                    <span class="meta-stat-item">
                        <span class="material-symbols-outlined">schedule</span>
                        <span>5 min read</span>
                    </span>
                </div>
            </div>

            <!-- Article Content -->
            <article class="article-content rich-text-content">
                <?= $blog['content'] ?>
            </article>

            <!-- Related Area -->
            <?php if (!empty($related_blogs)): ?>
                <div class="related-section">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        </svg>
                        <span class="eyebrow-label-text">Further Reading</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <h4 class="related-heading">Related <span>Research</span></h4>
                    <div class="row g-3">
                        <?php foreach ($related_blogs as $related): ?>
                            <div class="col-md-6 mb-3">
                                <a href="<?= BASE_URL ?>/blog/<?= $related['slug'] ?>" class="related-card">
                                    <span class="tag"><?= htmlspecialchars($related['category_name']) ?></span>
                                    <h5><?= htmlspecialchars($related['title']) ?></h5>
                                    <span class="related-link-arrow">
                                        <span>Read Analysis</span>
                                        <span class="material-symbols-outlined">arrow_forward</span>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Back Link -->
            <div class="mt-5 text-center">
                <a href="<?= BASE_URL ?>/blog" class="btn-insights-back">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Back to Research &amp; Insights</span>
                </a>
            </div>

        </div>
    </div>
</main>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>

<script>
    (function() {
        const progressBar = document.getElementById('progress-bar');
        if (!progressBar) return;

        const updateProgress = () => {
            const h = document.documentElement,
                b = document.body,
                st = 'scrollTop',
                sh = 'scrollHeight';
            const percent = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            progressBar.style.width = Math.min(100, Math.max(0, percent)) + '%';
        };

        window.addEventListener('scroll', updateProgress, {
            passive: true
        });
        updateProgress();
    })();
</script>
