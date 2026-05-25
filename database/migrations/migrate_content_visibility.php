<?php
/**
 * Migration to add visibility and ordering columns to content tables
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = (new Database())->getConnection();

    $tables = ['services_tb', 'projects_tb', 'events', 'trainings_tb'];
    foreach ($tables as $table) {
        // Add show_on_home
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'show_on_home'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN show_on_home TINYINT(1) DEFAULT 1");
            echo "Added 'show_on_home' to $table.\n";
        }

        // Add sort_order
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'sort_order'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN sort_order INT DEFAULT 0");
            echo "Added 'sort_order' to $table.\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
