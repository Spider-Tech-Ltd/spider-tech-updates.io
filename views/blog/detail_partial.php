<!-- Reading Progress Bar -->
<div id="progress-bar-inner" class="reading-progress w-0"></div>

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
                    <!-- Use loadArticle for SPA navigation -->
                    <div class="related-card" @click="loadArticle('<?= $related['slug'] ?>')" class="cursor-pointer">
                        <span class="tag"><?= htmlspecialchars($related['category_name']) ?></span>
                        <h5><?= htmlspecialchars($related['title']) ?></h5>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Back Link -->
        <div class="mt-5 text-center">
             <button @click="view = 'index'; history.pushState({view: 'index'}, '', '<?= BASE_URL ?>/blog')" class="btn-insights-back">
                <span class="material-symbols-outlined">arrow_back</span> Back to Insights
             </button>
        </div>

    </div>
</div>
