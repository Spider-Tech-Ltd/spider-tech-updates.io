<?php
/**
 * Forum Categories Grid — Tailored Compact Hardware Hub
 */
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-categories.css?v=<?= filemtime(ROOT_PATH . '/css/forum-categories.css') ?>" />

<section class="forum-categories-section">
  <div class="container">
    <div class="category-grid-header text-center mb-3">
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
      <h2 class="category-grid-title mt-2">Explore <span>Specialized Hubs</span></h2>
      <p class="category-grid-subtitle">Browse discussions by technical specialization and connect with engineering peers.</p>
    </div>

    <div class="row g-3">
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $index => $cat): ?>
          <div class="col-lg-4 col-md-6 mb-3 d-flex">
            <a href="<?= BASE_URL ?>/forum/feed?category=<?= urlencode($cat['slug'] ?? $cat['uuid']); ?>" class="forum-category-card">
              
              <!-- Card Top Row: Icon + Title + Serial -->
              <div class="category-card-top">
                <div class="category-card-identity">
                  <div class="forum-icon-wrapper">
                    <span class="material-symbols-outlined"><?= htmlspecialchars($cat['icon'] ?? 'forum') ?></span>
                  </div>
                  <h3 class="category-card-title"><?= htmlspecialchars($cat['name']); ?></h3>
                </div>
                <span class="hub-serial">HUB-<?= sprintf('%02d', $index + 1) ?></span>
              </div>

              <!-- Compact Description -->
              <p class="category-card-desc"><?= htmlspecialchars($cat['description'] ?? 'Join the conversation, explore case studies, and share technical insights.'); ?></p>

              <!-- Footer: Pill Topics Badge + Explore Link -->
              <div class="category-card-footer">
                <span class="forum-topic-badge"><?= $cat['topic_count'] ?? '0'; ?> Topics</span>
                <span class="forum-view-link">
                  <span>Explore</span>
                  <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                </span>
              </div>

            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback Category -->
        <div class="col-lg-4 col-md-6 mb-3 d-flex">
          <a href="<?= BASE_URL ?>/forum/feed" class="forum-category-card">
            <div class="category-card-top">
              <div class="category-card-identity">
                <div class="forum-icon-wrapper">
                  <span class="material-symbols-outlined">precision_manufacturing</span>
                </div>
                <h3 class="category-card-title">Industrial Systems</h3>
              </div>
              <span class="hub-serial">HUB-01</span>
            </div>
            <p class="category-card-desc">Discuss industrial processes, production efficiency, control hardware, and factory automation.</p>
            <div class="category-card-footer">
              <span class="forum-topic-badge">1.2k Topics</span>
              <span class="forum-view-link">
                <span>Explore</span>
                <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
              </span>
            </div>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
