<?php
/**
 * Migration to create admin_notifications table
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Database connection failed.");

    $sql = "CREATE TABLE IF NOT EXISTS admin_notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        link VARCHAR(255) DEFAULT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $db->exec($sql);
    echo "Successfully created 'admin_notifications' table.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
