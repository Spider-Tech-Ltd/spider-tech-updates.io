<?php
/**
 * Dynamic Forum Categories Grid Component
 * Fetches and displays categories from the database.
 * Matches original CSS structure defined in index.php.
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

<section class="forum-categories-grid py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($categories as $cat):
                $icon = $icon_map[$cat['slug']] ?? 'grid_view';
            ?>
            <!-- Category Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="pages/forum/category.php?slug=<?php echo $cat['slug']; ?>" class="forum-category-card d-block p-4">
                    <div class="forum-icon-wrapper mb-3">
                        <span class="material-symbols-outlined"><?php echo $icon; ?></span>
                    </div>

                    <span class="forum-topic-badge mb-3"><?php echo $cat['topic_count']; ?> Topics</span>

                    <h3 class="h5 font-weight-bold text-dark mb-2"><?php echo htmlspecialchars($cat['name']); ?></h3>

                    <p class="text-muted small mb-4">
                        <?php echo htmlspecialchars($cat['description']); ?>
                    </p>

                    <div class="forum-view-link font-weight-bold">
                        View Discussions
                        <span class="material-symbols-outlined align-middle">arrow_forward</span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
