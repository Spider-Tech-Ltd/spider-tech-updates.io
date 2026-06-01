<?php
/**
 * Migration to fix content tables for Home Page visibility and prevent truncation
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $db = (new Database())->getConnection();

    $contentTables = ['services_tb', 'projects_tb', 'events', 'trainings_tb'];

    foreach ($contentTables as $table) {
        echo "Updating table: $table...\n";

        // Add show_on_home if missing
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'show_on_home'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN show_on_home TINYINT(1) DEFAULT 1");
            echo " - Added 'show_on_home' column.\n";
        }

        // Add sort_order if missing
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'sort_order'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN sort_order INT DEFAULT 0");
            echo " - Added 'sort_order' column.\n";
        }
    }

    // Fix Truncation Issues (VARCHAR 64 is often too short for timestamped files)
    echo "\nEnsuring image/icon columns are long enough...\n";

    // Refined Truncation Fixes
    echo "Ensuring image/icon columns are long enough...\n";
    $db->exec("ALTER TABLE projects_tb MODIFY COLUMN project_pic VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE services_tb MODIFY COLUMN service_icon VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE events MODIFY COLUMN event_img VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE trainings_tb MODIFY COLUMN training_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE banners_tb MODIFY COLUMN banner_image VARCHAR(255) NOT NULL");

    echo " - Expanded image/icon column lengths to 255.\n";

    echo "\nMigration completed successfully!\n";

} catch (Exception $e) {
    echo "\nError: " . $e->getMessage() . "\n";
}
