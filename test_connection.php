<?php
require_once 'config/database.php';
try {
    $db = (new Database())->getConnection();
    if ($db) {
        echo "Connected successfully\n";
        $stmt = $db->query("SHOW TABLES");
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo $row[0] . "\n";
        }
    } else {
        echo "Connection failed\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
