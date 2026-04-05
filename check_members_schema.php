<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db_obj = new Database();
    $db = $db_obj->getConnection();
    if (!$db) {
        // Fallback to mock behavior or just stop if we're in a real environment
        die("Connection failed\n");
    }
    $stmt = $db->query("DESCRIBE members");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    // If DB fails, we might be using the mock. Let's check AuthModel then.
    echo "Error: " . $e->getMessage() . "\n";
}
