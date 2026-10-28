<?php
/**
 * Feed Filter Bar (Phase 2)
 * Horizontally scrollable category pill filter + Sort by dropdown.
 * Sticks below the main header on scroll.
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed-filter-bar.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed-filter-bar.css') ?>" />

<div class="container" x-data="{ currentCat: '<?= $_GET['category'] ?? 'all' ?>', currentSort: 'latest' }">
  <div class="filter-bar-inner">

    <!-- Category Pills -->
    <div class="filter-pills-group" id="filterPills">
      <button type="button" 
              class="filter-pill" 
              :class="{ 'active': currentCat === 'all' }"
              @click="currentCat = 'all'; window.dispatchEvent(new CustomEvent('filter-changed', { detail: { category: 'all' } }))">
        <span class="material-symbols-outlined">grid_view</span>
        All Topics
      </button>
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
          <button type="button" 
                  class="filter-pill" 
                  :class="{ 'active': currentCat === '<?= $cat['slug'] ?>' }"
                  @click="currentCat = '<?= $cat['slug'] ?>'; window.dispatchEvent(new CustomEvent('filter-changed', { detail: { category: '<?= $cat['slug'] ?>' } }))">
            <span class="material-symbols-outlined"><?= htmlspecialchars($cat['icon'] ?? 'label') ?></span>
            <?= htmlspecialchars($cat['name']) ?>
          </button>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Sort By -->
    <div class="filter-sort-group">
      <label class="filter-sort-label" for="feedSortSelect">Sort by</label>
      <select class="filter-sort-select" id="feedSortSelect" 
              x-model="currentSort"
              @change="window.dispatchEvent(new CustomEvent('filter-changed', { detail: { sort: currentSort } }))"
              aria-label="Sort discussions">
        <option value="latest">Latest</option>
        <option value="hottest">Hottest</option>
        <option value="my-topics">My Topics</option>
      </select>
    </div>

  </div>
</div>
