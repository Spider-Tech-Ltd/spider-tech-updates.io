<?php

/**
 * Dynamic Feed Filter Bar
 * Fetches categories from database and handles filtering logic.
 * Enhanced with Icons and improved vertical spacing.
 */
require_once __DIR__ . '/../../../config/db.php';

try {
  $stmtCats = $conn->query("SELECT name, slug FROM categories ORDER BY name ASC");
  $dbCategories = $stmtCats->fetchAll();
} catch (PDOException $e) {
  error_log("Filter Bar Categories Error: " . $e->getMessage());
  $dbCategories = [];
}

$currentFilter = $_GET['category'] ?? 'all';

// Icon mapping for categories
$icon_map = [
  'tech' => 'laptop_mac',
  'entrepreneurship' => 'lightbulb',
  'logistics' => 'local_shipping',
  'finance' => 'account_balance',
  'lifestyle' => 'self_improvement',
  'automation' => 'precision_manufacturing',
  'energy' => 'bolt',
  'manufacturing' => 'factory',
  'ai' => 'psychology',
  'infrastructure' => 'architecture',
  'ai-robotics' => 'smart_toy'
];
?>

<style>
  /* ============================
     FEED FILTER BAR
     ============================ */
  .feed-filter-bar {
    padding: 24px 0;
    /* Increased vertical spacing */
    background: #ffffff;
  }

  .filter-bar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }

  .filter-pills-group {
    display: flex;
    align-items: center;
    gap: 12px;
    overflow-x: auto;
    padding-block: .75rem;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  .filter-pills-group::-webkit-scrollbar {
    display: none;
  }

  .filter-pill {
    padding: 10px 22px;
    border-radius: 50px;
    border: 1.5px solid #e2e8f0;
    background-color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #475569;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .filter-pill:hover {
    border-color: #f48221;
    color: #f48221;
    background-color: rgba(244, 130, 33, 0.04);
    transform: translateY(-1px);
  }

  .filter-pill.active {
    background-color: #f48221;
    border-color: #f48221;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(244, 130, 33, 0.25);
  }

  .filter-pill .material-symbols-outlined {
    font-size: 18px;
  }

  .filter-sort-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }

  .filter-sort-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #64748b;
    white-space: nowrap;
  }

  .filter-sort-select {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #1e293b;
    background-color: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    padding: 8px 38px 8px 18px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    transition: all 0.2s;
    outline: none;
  }

  .filter-sort-select:focus {
    border-color: #f48221;
    box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1);
  }

  @media (max-width: 991px) {
    .filter-bar-inner {
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }

    .filter-sort-group {
      width: 100%;
      justify-content: space-between;
    }
  }
</style>

<div class="container">
  <div class="filter-bar-inner">

    <!-- Dynamic Category Pills with Icons -->
    <div class="filter-pills-group" id="filterPills">
      <a href="pages/forum/feed.php?category=all" class="filter-pill <?php echo $currentFilter === 'all' ? 'active' : ''; ?>">
        <span class="material-symbols-outlined">grid_view</span>
        All Topics
      </a>

      <?php foreach ($dbCategories as $cat):
        $icon = $icon_map[$cat['slug']] ?? 'label';
      ?>
        <a href="pages/forum/feed.php?category=<?php echo urlencode($cat['slug']); ?>"
          class="filter-pill <?php echo $currentFilter === $cat['slug'] ? 'active' : ''; ?>">
          <span class="material-symbols-outlined"><?php echo $icon; ?></span>
          <?php echo htmlspecialchars($cat['name']); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Sort By -->
    <div class="filter-sort-group">
      <label class="filter-sort-label" for="feedSortSelect">Sort by</label>
      <select class="filter-sort-select" id="feedSortSelect" aria-label="Sort discussions">
        <option value="latest" selected>Latest</option>
        <option value="hottest">Hottest</option>
        <option value="my-topics">My Topics</option>
      </select>
    </div>

  </div>
</div>