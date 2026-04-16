<?php
require_once 'config/config.php';
require_once 'config/db_config.php';
require_once 'config/Database.php';
require_once 'models/ForumModel.php';

$db = (new Database())->getConnection();
$forumModel = new ForumModel($db);

$stmt = $db->query("SELECT uuid FROM feeds LIMIT 1");
$feed = $stmt->fetch();

$replies = $forumModel->getReplies($feed['uuid'], null); // TEST WITH NULL
echo count($replies) . "\n";
