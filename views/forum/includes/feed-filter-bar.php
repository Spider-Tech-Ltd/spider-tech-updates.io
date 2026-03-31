<?php
/**
 * Feed Filter Bar (Phase 2)
 * Horizontally scrollable category pill filter + Sort by dropdown.
 * Sticks below the main header on scroll.
 */
?>

<style>
  /* ============================
     FILTER BAR
     ============================ */
  .filter-bar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 12px 0;
  }

  /* Pills group */
  .filter-pills-group {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 2px; /* space for scrollbar */
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    flex: 1;
  }
  .filter-pills-group::-webkit-scrollbar { display: none; }

  .filter-pill {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    padding: 8px 22px;
    border-radius: 50px;
    border: 1.5px solid #e9ecef;
    background-color: #ffffff;
    color: #555555;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 10px;
  }

  .filter-pill .material-symbols-outlined {
    font-size: 1.05rem;
    font-variation-settings: 'FILL' 0, 'wght' 600, 'GRAD' 0, 'opsz' 20;
  }

  .filter-pill:hover {
    border-color: #f48221;
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.05);
  }

  .filter-pill.active {
    background-color: #f48221;
    border-color: #f48221;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(244, 130, 33, 0.2);
  }

  /* Sort By dropdown */
  .filter-sort-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }

  .filter-sort-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    color: #797979;
    white-space: nowrap;
  }

  .filter-sort-select {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    color: #111111;
    background-color: #f8f9fa;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    padding: 7px 36px 7px 16px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23555555' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    transition: border-color 0.2s;
    outline: none;
  }

  .filter-sort-select:focus {
    border-color: #f48221;
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
  }

  @media (max-width: 767px) {
    .filter-sort-label { display: none; }
    .filter-bar-inner { gap: 10px; }
  }
</style>

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
