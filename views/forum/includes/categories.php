<?php
/**
 * Forum Categories Grid — Synchronized Engineering Hub
 */
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-categories.css?v=<?= filemtime(ROOT_PATH . '/css/forum-categories.css') ?>" />

<section class="forum-categories-section">
  <div class="container">
    <div class="category-grid-header text-center mb-4">
      <span class="section-eyebrow">
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
          <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
        </svg>
        <span class="eyebrow-label-text">Topic Hubs</span>
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
          <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
        </svg>
      </span>
      <br>
      <h2 class="category-grid-title">Explore <span>Discussion Categories</span></h2>
      <p class="category-grid-subtitle">Browse discussions by technical specialization and connect with engineering peers.</p>
    </div>

    <div class="row g-4">
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $index => $cat): ?>
          <div class="col-lg-4 col-md-6 mb-4 d-flex">
            <a href="<?= BASE_URL ?>/forum/feed?category=<?= urlencode($cat['slug'] ?? $cat['uuid']); ?>" class="forum-category-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="forum-icon-wrapper">
                  <span class="material-symbols-outlined"><?= htmlspecialchars($cat['icon'] ?? 'forum') ?></span>
                </div>
                <div class="category-meta-chips">
                  <span class="hub-serial">HUB-<?= sprintf('%02d', $index + 1) ?></span>
                  <span class="forum-topic-badge"><?= $cat['topic_count'] ?? '0'; ?> Topics</span>
                </div>
              </div>
              <h3 class="category-card-title"><?= htmlspecialchars($cat['name']); ?></h3>
              <p class="category-card-desc"><?= htmlspecialchars($cat['description'] ?? 'Join the conversation, explore case studies, and share technical insights.'); ?></p>
              <div class="forum-view-link">
                <span>Explore Hub Topics</span>
                <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Default Fallback Categories -->
        <div class="col-lg-4 col-md-6 mb-4 d-flex">
          <a href="<?= BASE_URL ?>/forum/feed" class="forum-category-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="forum-icon-wrapper">
                <span class="material-symbols-outlined">precision_manufacturing</span>
              </div>
              <div class="category-meta-chips">
                <span class="hub-serial">HUB-01</span>
                <span class="forum-topic-badge">1.2k Topics</span>
              </div>
            </div>
            <h3 class="category-card-title">Industrial Systems</h3>
            <p class="category-card-desc">Discuss industrial processes, production efficiency, control hardware, and factory automation.</p>
            <div class="forum-view-link">
              <span>Explore Hub Topics</span>
              <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
            </div>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
