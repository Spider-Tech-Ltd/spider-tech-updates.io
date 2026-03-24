<?php
/**
 * Dynamic Feed Filter Bar
 * Fetches categories from database and handles filtering logic.
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
?>

<style>
  /* ============================
     FEED FILTER BAR
     ============================ */
  .feed-filter-bar {
    padding: 12px 0;
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
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 4px;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  .filter-pills-group::-webkit-scrollbar { display: none; }

  .filter-pill {
    padding: 8px 18px;
    border-radius: 50px;
    border: 1.5px solid #e9ecef;
    background-color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    color: #555555;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none !important;
    display: inline-block;
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

<div class="container">
  <div class="filter-bar-inner">

    <!-- Dynamic Category Pills -->
    <div class="filter-pills-group" id="filterPills">
      <a href="pages/forum/feed.php" class="filter-pill <?php echo $currentFilter === 'all' ? 'active' : ''; ?>">All Topics</a>

      <?php foreach ($dbCategories as $cat): ?>
        <a href="pages/forum/feed.php?category=<?php echo urlencode($cat['slug']); ?>"
           class="filter-pill <?php echo $currentFilter === $cat['slug'] ? 'active' : ''; ?>">
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
