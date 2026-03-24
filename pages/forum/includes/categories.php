<?php
/**
 * Dynamic Forum Categories Grid Component
 * Fetches and displays categories from the database.
 */
require_once __DIR__ . '/../../../config/db.php';

try {
    // Fetch all categories
    $stmt = $conn->prepare("
        SELECT c.*, (SELECT COUNT(*) FROM feeds WHERE category_uuid = c.uuid AND status = 'published') as topic_count
        FROM categories c
        ORDER BY c.name ASC
    ");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Category Fetch Error: " . $e->getMessage());
    $categories = [];
}

// Icon mapping based on slug
$icon_map = [
    'tech' => 'computer',
    'entrepreneurship' => 'rocket_launch',
    'logistics' => 'local_shipping',
    'finance' => 'payments',
    'lifestyle' => 'diversity_3',
    'automation' => 'robot_2',
    'energy' => 'bolt',
];
?>

<style>
  /* ====== Categories Grid Styles ====== */
  .forum-categories-section { padding: 40px 0 60px; }
  .forum-category-card {
    background-color: #f8f9fa;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    text-decoration: none !important;
  }
  .forum-category-card:hover {
    border-color: #f48221;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transform: translateY(-5px);
  }

  .forum-icon-wrapper {
    width: 64px;
    height: 64px;
    background-color: rgba(244, 130, 33, 0.1);
    color: #f48221;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
  }
  .forum-icon-wrapper .material-symbols-outlined { font-size: 32px; }

  .forum-topic-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 16px;
    background-color: #ffffff;
    color: #64748b;
    border-radius: 50px;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
  }

  .cat-card-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #1e293b;
    margin-bottom: 12px;
  }
  .cat-card-desc {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 24px;
  }

  .forum-view-link {
    margin-top: auto;
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .forum-view-link .material-symbols-outlined { font-size: 20px; transition: transform 0.3s; }
  .forum-category-card:hover .forum-view-link .material-symbols-outlined { transform: translateX(5px); }
</style>

<section class="forum-categories-section">
  <div class="container">
    <div class="row">

      <?php foreach ($categories as $cat):
          $icon = $icon_map[$cat['slug']] ?? 'grid_view';
      ?>
      <!-- Category Item -->
      <div class="col-lg-4 col-md-6 mb-4">
        <a href="pages/forum/category.php?slug=<?php echo $cat['slug']; ?>" class="forum-category-card">
          <div class="forum-icon-wrapper">
            <span class="material-symbols-outlined"><?php echo $icon; ?></span>
          </div>

          <span class="forum-topic-badge"><?php echo $cat['topic_count']; ?> Topics</span>

          <h3 class="cat-card-title"><?php echo htmlspecialchars($cat['name']); ?></h3>

          <p class="cat-card-desc">
            <?php echo htmlspecialchars($cat['description']); ?>
          </p>

          <span class="forum-view-link">
            Explore Category
            <span class="material-symbols-outlined">arrow_forward</span>
          </span>
        </a>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>
