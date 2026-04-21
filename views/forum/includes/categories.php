<?php
/**
 * Forum Categories Grid
 */
?>

<section class="forum-categories-section">
  <div class="container">
    <div class="category-grid-header">
      <h2 class="category-grid-title">Explore Categories</h2>
      <p class="category-grid-subtitle">Browse discussions by topic and find your community.</p>
    </div>

    <div class="row">
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <a href="<?= BASE_URL ?>/forum/feed?category=<?= urlencode($cat['slug'] ?? $cat['uuid']); ?>" class="forum-category-card p-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="forum-icon-wrapper">
                  <span class="material-symbols-outlined"><?= htmlspecialchars($cat['icon'] ?? 'forum') ?></span>
                </div>
                <span class="forum-topic-badge"><?= $cat['topic_count'] ?? '0'; ?> Topics</span>
              </div>
              <h3 class="h5 font-weight-bold text-dark mb-2"><?= htmlspecialchars($cat['name']); ?></h3>
              <p class="text-muted small mb-4"><?= htmlspecialchars($cat['description'] ?? 'Join the conversation and share insights.'); ?></p>
              <div class="forum-view-link">
                View Topics <span class="material-symbols-outlined">arrow_forward</span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Default Fallback Categories if none provided -->
        <div class="col-lg-4 col-md-6 mb-4">
          <a href="#" class="forum-category-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="forum-icon-wrapper">
                <span class="material-symbols-outlined">settings</span>
              </div>
              <span class="forum-topic-badge">1.2k Topics</span>
            </div>
            <h3 class="h5 font-weight-bold text-dark mb-2">Manufacturing</h3>
            <p class="text-muted small mb-4">Discuss industrial processes, production efficiency, and factory automation.</p>
            <div class="forum-view-link">
              View Topics <span class="material-symbols-outlined">arrow_forward</span>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <a href="#" class="forum-category-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="forum-icon-wrapper">
                <span class="material-symbols-outlined">bolt</span>
              </div>
              <span class="forum-topic-badge">850 Topics</span>
            </div>
            <h3 class="h5 font-weight-bold text-dark mb-2">Energy & Utilities</h3>
            <p class="text-muted small mb-4">Power generation, distribution, and sustainable energy solutions.</p>
            <div class="forum-view-link">
              View Topics <span class="material-symbols-outlined">arrow_forward</span>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <a href="#" class="forum-category-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="forum-icon-wrapper">
                <span class="material-symbols-outlined">smart_toy</span>
              </div>
              <span class="forum-topic-badge">610 Topics</span>
            </div>
            <h3 class="h5 font-weight-bold text-dark mb-2">AI & Robotics</h3>
            <p class="text-muted small mb-4">Machine learning, autonomous systems, and advanced robotics in industry.</p>
            <div class="forum-view-link">
              View Topics <span class="material-symbols-outlined">arrow_forward</span>
            </div>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
