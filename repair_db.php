<?php
/**
 * Spider Tech - Critical Database Repair & Migration Script
 * Purpose: Ensures all content tables have visibility/ordering columns and correct data lengths.
 * Run this script by navigating to: your-domain.com/repair_db.php
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Could not connect to database.");

    echo "<h3>Starting Database Repair...</h3>";
    echo "<ul>";

    $tables = ['services_tb', 'projects_tb', 'events', 'trainings_tb'];
    foreach ($tables as $table) {
        echo "<li>Processing table: <b>$table</b>...";

        // Add show_on_home
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'show_on_home'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN show_on_home TINYINT(1) DEFAULT 1");
            echo " [Added show_on_home]";
        }

        // Add sort_order
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'sort_order'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN sort_order INT DEFAULT 0");
            echo " [Added sort_order]";
        }
        echo " OK</li>";
    }

    echo "<li>Ensuring projects_media table exists...";
    $stmt = $db->query("SHOW TABLES LIKE 'projects_media'");
    if ($stmt->rowCount() == 0) {
        $db->exec("CREATE TABLE IF NOT EXISTS `projects_media` (
          `project_pics_id` int NOT NULL AUTO_INCREMENT,
          `project_id` int NOT NULL,
          `project_pics_name` varchar(255) NOT NULL,
          PRIMARY KEY (`project_pics_id`),
          KEY `project_id` (`project_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        echo " [Created projects_media]";
    }
    echo " OK</li>";

    // Fix Truncation Issues (Expanding lengths to 255)
    echo "<li>Expanding column lengths to prevent path truncation...";
    $db->exec("ALTER TABLE projects_tb MODIFY COLUMN project_pic VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE services_tb MODIFY COLUMN service_icon VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE events MODIFY COLUMN event_img VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE projects_media MODIFY COLUMN project_pics_name VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE trainings_tb MODIFY COLUMN training_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE banners_tb MODIFY COLUMN banner_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE admin_tb MODIFY COLUMN admin_password VARCHAR(255) NOT NULL");
    echo " OK</li>";

    echo "</ul>";
    echo "<h3 style='color:green;'>Database Repair Completed Successfully!</h3>";
    echo "<p>Please delete this file (<code>repair_db.php</code>) from your server for security.</p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Repair Failed:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
}
