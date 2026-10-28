<?php
/**
 * Feed Category Tab Switcher (Matching Events Page Design)
 * Displays unified capsule tab switcher with category badges + sort select
 */
$currentCat = $_GET['category'] ?? 'all';
$currentSort = $_GET['sort'] ?? 'latest';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed-filter-bar.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed-filter-bar.css') ?>" />

<div class="forum-tabs-section" id="feedSection">
  <div class="container">
    <div class="forum-tabs-bar-inner">

      <!-- Category Tab Switcher (Unified Capsule matching Events) -->
      <div class="forum-tab-switcher-wrap">
        <div class="forum-tab-switcher" role="tablist" aria-label="Discussion Categories">
          <a href="<?= BASE_URL ?>/forum?category=all&sort=<?= urlencode($currentSort) ?>#feedSection"
             class="forum-tab-btn <?= ($currentCat === 'all' || empty($currentCat)) ? 'active' : '' ?>">
            <span class="material-symbols-outlined tab-icon">grid_view</span>
            <span>All Topics</span>
            <span class="tab-badge"><?= $global_stats['total_discussions'] ?? count($feeds ?? []) ?></span>
          </a>

          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
              <?php $catKey = $cat['slug'] ?? $cat['uuid']; ?>
              <?php $isActive = ($currentCat === $catKey); ?>
              <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($catKey) ?>&sort=<?= urlencode($currentSort) ?>#feedSection"
                 class="forum-tab-btn <?= $isActive ? 'active' : '' ?>">
                <span class="material-symbols-outlined tab-icon"><?= htmlspecialchars($cat['icon'] ?? 'label') ?></span>
                <span><?= htmlspecialchars($cat['name']) ?></span>
                <span class="tab-badge"><?= $cat['topic_count'] ?? '0' ?></span>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sort Filter Controls -->
      <div class="forum-sort-pill-wrap">
        <label for="feedSortSelect" class="forum-sort-label">Sort By:</label>
        <div class="sort-select-box">
          <span class="material-symbols-outlined sort-icon">sort</span>
          <select id="feedSortSelect" class="forum-sort-select" onchange="window.location.href=this.value;" aria-label="Sort discussions">
            <option value="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=latest#feedSection" <?= ($currentSort === 'latest') ? 'selected' : '' ?>>Latest First</option>
            <option value="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=hottest#feedSection" <?= ($currentSort === 'hottest') ? 'selected' : '' ?>>Trending / Hot</option>
          </select>
        </div>
      </div>

    </div>
  </div>
</div>
