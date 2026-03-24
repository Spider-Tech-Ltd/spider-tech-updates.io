<?php
/**
 * AJAX Action Handler for Feed Likes and Replies
 */
require_once '../../config/db.php';
require_once '../../auth/FeedActions.php';
require_once '../../auth/middleware.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(["status" => "error", "message" => "Authentication required."]);
    die();
}

$actions = new FeedActions($conn);
$memberId = $_SESSION['member_id'];
$action = $_POST['action'] ?? '';
$feedUuid = $_POST['feed_uuid'] ?? '';

if (empty($feedUuid)) {
    echo json_encode(["status" => "error", "message" => "Feed ID missing."]);
    die();
}

switch ($action) {
    case 'toggle_like':
        $result = $actions->toggleLike($feedUuid, $memberId);
        echo json_encode($result);
        break;

    case 'add_reply':
        $content = $_POST['content'] ?? '';
        $result = $actions->addReply($feedUuid, $memberId, $content);
        echo json_encode($result);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action."]);
        break;
}
