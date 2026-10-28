<?php
/**
 * Feed Category Tab Switcher (Matching Events Page Design)
 * Displays unified capsule tab switcher with category badges + custom sort dropdown
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

      <!-- Custom Sort Filter Dropdown (Replaces default OS browser select) -->
      <div class="forum-sort-pill-wrap" x-data="{ sortOpen: false }" @click.outside="sortOpen = false">
        <span class="forum-sort-label">Sort By:</span>
        <div class="custom-sort-dropdown">
          <button type="button" 
                  class="custom-sort-btn" 
                  @click="sortOpen = !sortOpen" 
                  :aria-expanded="sortOpen.toString()" 
                  aria-label="Sort discussions">
            <span class="material-symbols-outlined sort-icon">sort</span>
            <span><?= ($currentSort === 'hottest') ? 'Trending / Hot' : 'Latest First' ?></span>
            <span class="material-symbols-outlined chevron-icon" :class="{ 'is-rotated': sortOpen }">expand_more</span>
          </button>

          <div class="custom-sort-menu" x-show="sortOpen" x-transition.origin.top.right x-cloak style="display: none;">
            <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=latest#feedSection"
               class="custom-sort-item <?= ($currentSort === 'latest') ? 'active' : '' ?>">
              <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined item-icon">schedule</span>
                <span>Latest First</span>
              </div>
              <?php if ($currentSort === 'latest'): ?>
                <span class="material-symbols-outlined check-mark">check</span>
              <?php endif; ?>
            </a>

            <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($currentCat) ?>&sort=hottest#feedSection"
               class="custom-sort-item <?= ($currentSort === 'hottest') ? 'active' : '' ?>">
              <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined item-icon">local_fire_department</span>
                <span>Trending / Hot</span>
              </div>
              <?php if ($currentSort === 'hottest'): ?>
                <span class="material-symbols-outlined check-mark">check</span>
              <?php endif; ?>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
