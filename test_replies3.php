<?php
require_once 'config/config.php';
require_once 'config/db_config.php';
require_once 'config/Database.php';

$db = (new Database())->getConnection();

$stmt = $db->query("SELECT feed_uuid, COUNT(*) as c FROM feed_replies GROUP BY feed_uuid");
$counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Replies by feed_uuid:\n";
echo json_encode($counts, JSON_PRETTY_PRINT) . "\n";
