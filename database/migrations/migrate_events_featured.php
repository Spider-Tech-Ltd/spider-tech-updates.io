<?php
/**
 * Migration to add video_url and is_featured columns to the events table
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Database connection failed.");

    echo "Updating events table schema...\n";

    // Add video_url
    $stmt = $db->query("SHOW COLUMNS FROM events LIKE 'video_url'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE events ADD COLUMN video_url VARCHAR(255) DEFAULT NULL AFTER event_detail");
        echo " - Added 'video_url' column.\n";
    }

    // Add is_featured
    $stmt = $db->query("SHOW COLUMNS FROM events LIKE 'is_featured'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE events ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER video_url");
        echo " - Added 'is_featured' column.\n";
    }

    echo "\nMigration completed successfully!\n";

} catch (Exception $e) {
    echo "\nError: " . $e->getMessage() . "\n";
}
