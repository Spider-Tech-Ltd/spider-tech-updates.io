<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/utils/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->query("SHOW CREATE TABLE feeds");
    $feed_schema = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Feeds:\n";
    print_r($feed_schema);

    $stmt = $db->query("SHOW CREATE TABLE members");
    $members_schema = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\nMembers:\n";
    print_r($members_schema);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
