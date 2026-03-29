<?php

/**
 * Forum View
 */
?>
<style>
  /* Global Overrides for modern feel */
  body {
    font-family: 'Work Sans', sans-serif;
  }
</style>

<?php
// Include the hero section
include ROOT_PATH . '/views/forum/includes/hero.php';
?>

<style>
  /* ====== Explore Categories Styles ====== */
  .forum-categories-section {
    background-color: #f8f9fa;
    padding: 80px 0;
  }

  .section-header-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 40px;
    gap: 16px;
  }

  .section-title-group {
    flex: 1;
  }

  .section-heading {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.8rem;
    color: #111111;
    margin-bottom: 8px;
    line-height: 1.2;
  }

  .section-subtitle {
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    color: #555555;
    margin-bottom: 0;
  }

  .view-all-link {
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
    color: #f48221;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s ease;
    white-space: nowrap;
    margin-bottom: 6px;
  }

  .view-all-link:hover {
    opacity: 0.8;
    color: #f48221;
    text-decoration: none;
  }

  /* Category Card */
  .category-card {
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none !important;
  }

  .category-card:hover {
    transform: translateY(-5px);
    border-color: #f48221;
    box-shadow: 0 10px 20px rgba(244, 130, 33, 0.1);
  }

  /* Icon Wrapper */
  .category-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background-color: rgba(244, 130, 33, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    transition: background-color 0.3s ease;
  }

  .category-icon-wrap .material-symbols-outlined {
    color: #f48221;
    font-size: 24px;
    transition: color 0.3s ease;
  }

  .category-card:hover .category-icon-wrap {
    background-color: #f48221;
  }

  .category-card:hover .category-icon-wrap .material-symbols-outlined {
    color: #ffffff;
  }

  .category-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    color: #111111;
    margin-bottom: 12px;
  }

  .category-desc {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.9rem;
    color: #555555;
    line-height: 1.6;
    margin-bottom: 24px;
    flex-grow: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Card Footer */
  .category-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid #f1f1f1;
  }

  .topic-count-badge {
    background-color: #f1f1f1;
    color: #555555;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
  }

  .view-topics-btn {
    color: #f48221;
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    transition: text-decoration 0.2s;
  }

  .category-card:hover .view-topics-btn {
    text-decoration: underline;
  }
</style>

<section class="forum-categories-section">
  <div class="container">

    <!-- Section Header -->
    <div class="section-header-row">
      <div class="section-title-group">
        <h2 class="section-heading">Explore Categories</h2>
        <p class="section-subtitle">Browse discussions by topic and find your community.</p>
      </div>
      <a href="#" class="view-all-link">
        View All <span class="material-symbols-outlined">arrow_forward</span>
      </a>
    </div>

    <!-- Categories Grid -->
    <div class="row">
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
          <?php
          // Simple icon map based on memory or defaults
          $icon_map = [
            'startup' => 'rocket_launch',
            'developer' => 'terminal',
            'general' => 'dynamic_feed',
            'introductions' => 'waving_hand',
            'hardware' => 'memory',
            'news' => 'newspaper'
          ];
          $icon = '';
          foreach ($icon_map as $key => $val) {
            if (stripos($category['name'], $key) !== false) {
              $icon = $val;
              break;
            }
          }
          ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <a href="<?= BASE_URL ?>/forum?category=<?= $category['uuid']; ?>" class="category-card">
              <div class="category-icon-wrap">
                <span class="material-symbols-outlined"><?= $icon; ?></span>
              </div>
              <h3 class="category-name"><?= htmlspecialchars($category['name']); ?></h3>
              <p class="category-desc"><?= htmlspecialchars($category['description'] ?? 'Join the conversation.'); ?></p>
              <div class="category-card-footer">
                <span class="topic-count-badge">Topics</span>
                <span class="view-topics-btn">View Topics →</span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p>No categories found.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>