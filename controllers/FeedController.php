<?php

class FeedController extends BaseController
{
    private $forumModel;

    public function __construct()
    {
        parent::__construct();
        $this->forumModel = new ForumModel($this->db);
    }

    public function like()
    {
        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to upvote.']);
            return;
        }

        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
            return;
        }

        $feed_uuid = $_POST['feed_uuid'] ?? '';
        $member_id = $_SESSION['member_id'] ?? null;

        if (!$member_id) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to upvote.']);
            return;
        }

        if ($this->forumModel->toggleLike($feed_uuid, $member_id)) {
            // Fetch updated count
            $stmt = $this->db->prepare("SELECT COUNT(*) as upvotes FROM feed_likes WHERE feed_uuid = :uuid");
            $stmt->execute([':uuid' => $feed_uuid]);
            $result = $stmt->fetch();

            // Check if now liked
            $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = :uuid AND member_id = :member");
            $stmt->execute([':uuid' => $feed_uuid, ':member' => $member_id]);
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

    public function reply()
    {
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
        $parent_uuid = $_POST['parent_uuid'] ?? null;
        $member_id = $_SESSION['member_id'] ?? null;

        if (!$member_id) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to reply.']);
            return;
        }

        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Reply cannot be empty.']);
            return;
        }

        if ($this->forumModel->addReply($feed_uuid, $member_id, $content, $parent_uuid)) {
            echo json_encode([
                'success' => true,
                'reply' => [
                    'uuid' => Utils::generateUUID(), // Temporary for UI key
                    'author_name' => $_SESSION['member_name'],
                    'content' => htmlspecialchars($content),
                    'created_at' => date('Y-m-d H:i:s'),
                    'parent_uuid' => $parent_uuid
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to post reply.']);
        }
    }

    public function store()
    {
        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to post.']);
            return;
        }

        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
            return;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $category_uuid = $_POST['category_uuid'] ?? '';
        $member_id = $_SESSION['member_id'];

        if (empty($title) || empty($content) || empty($category_uuid)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            return;
        }

        $uuid = $this->forumModel->createTopic($member_id, $category_uuid, $title, $content);
        if ($uuid) {
            echo json_encode([
                'success' => true, 
                'message' => 'Discussion posted successfully!',
                'uuid' => $uuid,
                'view_url' => BASE_URL . '/forum/discussion?uuid=' . $uuid
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create discussion.']);
        }
    }

    public function fetch()
    {
        $category = $_GET['category'] ?? 'all';
        $sort = $_GET['sort'] ?? 'latest';
        $member_id = $_SESSION['member_id'] ?? null;

        $feeds = $this->forumModel->getFeeds(20, $member_id, $category, $sort);

        echo json_encode([
            'success' => true,
            'feeds' => $feeds
        ]);
    }

    public function uploadImage()
    {
        // 1. Check Permissions
        if (!$this->isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Please sign in to upload images.']);
            return;
        }

        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid security token.']);
            return;
        }

        // 2. Check File
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Failed to receive image.']);
            return;
        }

        $file = $_FILES['image'];
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.']);
            return;
        }

        // 3. Size Limit (2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File too large. Max size is 2MB.']);
            return;
        }

        // 4. Save File
        $uploadDir = 'uploads/forum/';
        $fileName = Utils::generateUUID() . '.' . $ext;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo json_encode([
                'success' => true,
                'url' => BASE_URL . '/' . $targetPath
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save file. Check directory permissions.']);
        }
    }
}
