<?php
define('ROOT_PATH', dirname(dirname(__DIR__)));
require_once ROOT_PATH . '/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // 1. Create table
    $sql = "CREATE TABLE IF NOT EXISTS `partners_tb` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(150) NOT NULL,
        `logo` VARCHAR(255) NOT NULL,
        `website_url` VARCHAR(255) DEFAULT NULL,
        `sort_order` INT DEFAULT 0,
        `is_active` TINYINT(1) DEFAULT 1,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $db->exec($sql);
    echo "Table 'partners_tb' created successfully.\n";

    // 2. Check and seed initial partner records
    $checkSql = "SELECT COUNT(*) FROM `partners_tb`";
    $count = (int)$db->query($checkSql)->fetchColumn();

    if ($count === 0) {
        $seedStmt = $db->prepare("INSERT INTO `partners_tb` (`name`, `logo`, `website_url`, `sort_order`, `is_active`) VALUES (?, ?, ?, ?, ?)");
        
        $initialPartners = [
            ['NITDA Nigeria', 'images/partners/nitda-partner.svg', 'https://nitda.gov.ng', 1, 1],
            ['Google for Startups', 'images/partners/google-startups.svg', 'https://startup.google.com', 2, 1],
            ['Microsoft Tech Impact', 'images/partners/microsoft-partner.svg', 'https://www.microsoft.com/nonprofits', 3, 1],
            ['Edo Innovates', 'images/partners/edo-innovates.svg', 'https://edoinnovates.ng', 4, 1],
            ['Jobberman Nigeria', 'images/partners/jobberman.svg', 'https://www.jobberman.com', 5, 1],
            ['GitHub Education', 'images/partners/github-partner.svg', 'https://education.github.com', 6, 1],
        ];

        foreach ($initialPartners as $partner) {
            $seedStmt->execute($partner);
        }
        echo "Seeded 6 initial official partner records.\n";
    } else {
        echo "Table 'partners_tb' already has data ($count records). Skipping seeding.\n";
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    exit(1);
}
