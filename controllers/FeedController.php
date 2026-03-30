<?php

class FeedController extends BaseController {
    private $forumModel;

    public function __construct() {
        parent::__construct();
        $this->forumModel = new ForumModel($this->db);
    }

    public function like() {
        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to upvote.']);
            return;
        }

        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
            return;
        }

        $feed_uuid = $_POST['feed_uuid'] ?? '';
        $member_uuid = $_SESSION['member_uuid'];

        if ($this->forumModel->toggleLike($feed_uuid, $member_uuid)) {
            // Fetch updated count
            $stmt = $this->db->prepare("SELECT COUNT(*) as upvotes FROM feed_likes WHERE feed_uuid = :uuid");
            $stmt->execute([':uuid' => $feed_uuid]);
            $result = $stmt->fetch();

            // Check if now liked
            $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = :uuid AND member_uuid = :member");
            $stmt->execute([':uuid' => $feed_uuid, ':member' => $member_uuid]);
            $is_liked = $stmt->fetch() ? true : false;

            echo json_encode([
                'success' => true,
                'upvotes' => $result['upvotes'],
                'is_liked' => $is_liked
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action failed.']);
        }
    }

    public function reply() {
        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to reply.']);
            return;
        }

        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
            return;
        }

        $feed_uuid = $_POST['feed_uuid'] ?? '';
        $content = $_POST['content'] ?? '';
        $member_uuid = $_SESSION['member_uuid'];

        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Reply cannot be empty.']);
            return;
        }

        if ($this->forumModel->addReply($feed_uuid, $member_uuid, $content)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to post reply.']);
        }
    }
}
