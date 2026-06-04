<?php
define('ROOT_PATH', dirname(dirname(__DIR__)));
require_once ROOT_PATH . '/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS `banners_tb` (
        `banner_id` INT AUTO_INCREMENT PRIMARY KEY,
        `banner_title` VARCHAR(255) NOT NULL,
        `banner_image` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $db->exec($sql);
    echo "Table 'banners_tb' created successfully.\n";

    // Seed data
    $checkSql = "SELECT COUNT(*) FROM `banners_tb`";
    $count = $db->query($checkSql)->fetchColumn();

    if ($count == 0) {
        $seedSql = "INSERT INTO `banners_tb` (`banner_title`, `banner_image`) VALUES
            ('Give Wings to your <span>Business</span>', 'banner-1.jpg'),
            ('Innovating the <span>Future of Tech</span>', 'banner-2.jpg'),
            ('Empowering <span>Digital Transformation</span>', 'banner-3.jpg')";
        $db->exec($seedSql);
        echo "Seeded initial banners.\n";
    } else {
        echo "Table already has data. Skipping seeding.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
