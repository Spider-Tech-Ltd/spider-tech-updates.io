<?php
// Manual DB connection to avoid class loading issues in standalone script
$host = 'localhost';
$dbname = 'spider_tech_updated_db'; // Adjust if different
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "--- DATABASE MIGRATION START ---\n";

    // 1. Check if parent_uuid exists in feed_replies
    $res = $pdo->query("SHOW COLUMNS FROM feed_replies LIKE 'parent_uuid'");
    if (!$res->fetch()) {
        echo "Adding parent_uuid column to feed_replies...\n";
        $pdo->exec("ALTER TABLE feed_replies ADD COLUMN parent_uuid CHAR(36) DEFAULT NULL");
        echo "Success: Column added.\n";
    } else {
        echo "Info: parent_uuid column already exists.\n";
    }

    // 2. Clear out any previous integer member_id data that might cause FK failures
    // (Optional/Dangerous, but useful if the table is currently filled with invalid test data)
    // $pdo->exec("DELETE FROM feed_likes WHERE member_id REGEXP '^[0-9]+$'");
    // $pdo->exec("DELETE FROM feed_replies WHERE member_id REGEXP '^[0-9]+$'");

    echo "--- MIGRATION COMPLETE ---\n";

} catch (PDOException $e) {
    die("CRITICAL ERROR: " . $e->getMessage() . "\n");
}
