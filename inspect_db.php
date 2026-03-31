<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/utils/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "=== TABLE: feed_replies ===\n";
    $stmt = $db->query("DESCRIBE feed_replies");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
