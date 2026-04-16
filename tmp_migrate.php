<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/utils/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Check if column exists
    $check = $db->query("SHOW COLUMNS FROM feed_replies LIKE 'parent_uuid'");
    if (!$check->fetch()) {
        $db->exec("ALTER TABLE feed_replies ADD COLUMN parent_uuid VARCHAR(255) DEFAULT NULL");
        echo "Migration successful: Column parent_uuid added to feed_replies.\n";
    } else {
        echo "Migration unnecessary: Column parent_uuid already exists.\n";
    }
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
