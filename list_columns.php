<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "--- Table: feeds ---\n";
    $stmt = $conn->query("SHOW COLUMNS FROM feeds");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . "\n";
    }
    
    echo "\n--- Table: feed_replies ---\n";
    $stmt = $conn->query("SHOW COLUMNS FROM feed_replies");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
