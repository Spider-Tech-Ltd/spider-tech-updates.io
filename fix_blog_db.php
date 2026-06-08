<?php
/**
 * Spider Tech - Blog Database Fix
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

header('Content-Type: text/html; charset=utf-8');

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Could not connect to database.");

    echo "<h2>Spider Tech Blog Database Fix</h2>";
    echo "<ul style='font-family: monospace; font-size: 14px;'>";

    // 1. Check blogs table structure
    echo "<li>Checking blogs table... ";
    $stmt = $db->query("DESCRIBE blogs");
    $categoryIdType = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Field'] === 'category_id') {
            $categoryIdType = $row['Type'];
        }
    }
    echo "category_id type: <strong>$categoryIdType</strong></li>";

    // 2. Fetch categories
    echo "<li>Fetching categories... ";
    $categories = $db->query("SELECT id, uuid, name FROM blog_categories")->fetchAll(PDO::FETCH_ASSOC);
    echo "Found " . count($categories) . " categories.</li>";

    // 3. Migration logic
    foreach ($categories as $cat) {
        echo "<li>Processing: <strong>" . htmlspecialchars($cat['name']) . "</strong> (ID: {$cat['id']}, UUID: {$cat['uuid']})... ";

        // Update blogs where category_id matches the UUID
        $updateStmt = $db->prepare("UPDATE blogs SET category_id = ? WHERE category_id = ?");
        $updateStmt->execute([$cat['id'], $cat['uuid']]);
        $count = $updateStmt->rowCount();

        echo "Updated $count blog(s).</li>";
    }

    // 4. Update AdminModel for consistency
    echo "<li>Database migration complete.</li>";
    echo "</ul>";
    echo "<h3 style='color:green;'>Blog Database Fix Completed!</h3>";
    echo "<p><a href='" . BASE_URL . "/admin/blog'>Go back to Blogs</a></p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Fix Failed:</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
