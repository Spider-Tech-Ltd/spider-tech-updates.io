<?php
/**
 * Migration Runner: Create Social Links Table & Update Admin Schema
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Could not connect to database.");

    echo "Running migrations for Site Settings...\n";

    // 1. Create social_links
    echo "Creating social_links table...\n";
    $db->exec("CREATE TABLE IF NOT EXISTS social_links (
        id INT AUTO_INCREMENT PRIMARY KEY,
        platform VARCHAR(50) NOT NULL UNIQUE,
        url VARCHAR(255) DEFAULT NULL,
        icon_class VARCHAR(100) DEFAULT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 2. Seed data
    echo "Seeding social links...\n";
    $links = [
        ['Facebook', 'https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/', 'fab fa-facebook-f'],
        ['Twitter', 'https://twitter.com/', 'fab fa-twitter'],
        ['Youtube', 'https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw', 'fab fa-youtube'],
        ['Linkedin', 'https://linkedin.com/', 'fab fa-linkedin-in'],
        ['Instagram', 'https://www.instagram.com/spidertech.hub', 'fab fa-instagram']
    ];

    $stmt = $db->prepare("INSERT INTO social_links (platform, url, icon_class) VALUES (?, ?, ?)
                          ON DUPLICATE KEY UPDATE url=VALUES(url), icon_class=VALUES(icon_class)");
    foreach ($links as $link) {
        $stmt->execute($link);
    }

    // 3. Admin profile_pic
    echo "Ensuring profile_pic column exists in admin_tb...\n";
    $stmt = $db->query("SHOW COLUMNS FROM admin_tb LIKE 'profile_pic'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE admin_tb ADD COLUMN profile_pic VARCHAR(255) DEFAULT NULL AFTER privilege");
        echo "[Added profile_pic column]\n";
    }

    echo "\nMigration completed successfully!\n";

} catch (Exception $e) {
    echo "\nMigration FAILED:\n";
    echo $e->getMessage() . "\n";
}
