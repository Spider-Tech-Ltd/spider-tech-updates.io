<?php
/**
 * Migration to add status column to members table for suspension feature
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = (new Database())->getConnection();

    // Check if column exists
    $stmt = $db->query("SHOW COLUMNS FROM members LIKE 'status'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE members ADD COLUMN status ENUM('Active', 'Suspended') DEFAULT 'Active' AFTER is_verified");
        echo "Successfully added 'status' column to members table.\n";
    } else {
        echo "Column 'status' already exists in members table.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
