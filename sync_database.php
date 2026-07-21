<?php
/**
 * Spider Tech - Definitive CMS Schema Synchronization & Database Repair Tool
 * Use this tool to align your database with the new High-Fidelity CMS.
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

header('Content-Type: text/html; charset=utf-8');

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Database connection failed.");

    echo "<h2>CMS Database Sync Tool</h2>";
    echo "<hr><ul style='font-family: monospace; line-height: 1.6;'>";

    $tables = ['services_tb', 'projects_tb', 'events', 'trainings_tb'];
    foreach ($tables as $table) {
        echo "<li>Processing <strong>$table</strong>... ";

        // 1. Show on Home
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'show_on_home'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN show_on_home TINYINT(1) DEFAULT 1");
            echo "[Added show_on_home] ";
        } else {
            $db->exec("UPDATE $table SET show_on_home = 1 WHERE show_on_home IS NULL");
        }

        // 2. Sort Order
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'sort_order'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN sort_order INT DEFAULT 0");
            echo "[Added sort_order] ";
        }
        echo "<span style='color:green;'>DONE</span></li>";
    }

    echo "<li>Ensuring projects_media table exists... ";
    $stmt = $db->query("SHOW TABLES LIKE 'projects_media'");
    if ($stmt->rowCount() == 0) {
        $db->exec("CREATE TABLE IF NOT EXISTS `projects_media` (
          `project_pics_id` int NOT NULL AUTO_INCREMENT,
          `project_id` int NOT NULL,
          `project_pics_name` varchar(255) NOT NULL,
          PRIMARY KEY (`project_pics_id`),
          KEY `project_id` (`project_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        echo "[Created projects_media] ";
    }
    echo "<span style='color:green;'>DONE</span></li>";

    echo "<li>Expanding Column Lengths (Fixes Truncated Paths)... ";
    $db->exec("ALTER TABLE projects_tb MODIFY COLUMN project_pic VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE services_tb MODIFY COLUMN service_icon VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE events MODIFY COLUMN event_img VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE projects_media MODIFY COLUMN project_pics_name VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE trainings_tb MODIFY COLUMN training_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE banners_tb MODIFY COLUMN banner_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE admin_tb MODIFY COLUMN admin_password VARCHAR(255) NOT NULL");
    echo "<span style='color:green;'>DONE</span></li>";

    echo "<li>Finalizing members table... ";
    $stmt = $db->query("SHOW COLUMNS FROM members LIKE 'status'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE members ADD COLUMN status ENUM('Active', 'Suspended') DEFAULT 'Active' AFTER is_verified");
    }
    echo "<span style='color:green;'>DONE</span></li>";

    echo "</ul><hr>";
    echo "<h3 style='color:green;'>Synchronization Successful!</h3>";
    echo "<p>Your dashboard and website are now fully synchronized.</p>";
    echo "<p style='color:red;'><strong>Security Note:</strong> Please delete <code>sync_database.php</code> and <code>repair_database.php</code> after use.</p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Sync Failed:</h3><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
