<?php

class ForumController extends BaseController {

    public function index() {
        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $category_filter = $_GET['category'] ?? null;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $sort = in_array($_GET['sort'] ?? '', ['latest', 'hottest']) ? $_GET['sort'] : 'latest';
        $feeds = $forumModel->getFeeds($limit, $_SESSION['member_id'] ?? null, $category_filter, $sort, $page);
        $total_feeds = $forumModel->getTotalFeedCount($category_filter);
        $total_pages = ceil($total_feeds / $limit);

        $global_stats = $forumModel->getGlobalStats();
        $trending = $forumModel->getTrendingTopics(5);
        $top_categories = $forumModel->getTopCategories(5);
        $top_contributors = $forumModel->getTopContributors(3);
        $active_members = $forumModel->getActiveMembers(6);

        $this->render('forum/index', [
            'title' => 'Spider Tech Community Forum',
            'categories' => $categories,
            'feeds' => $feeds,
            'global_stats' => $global_stats,
            'trending' => $trending,
            'top_categories' => $top_categories,
            'top_contributors' => $top_contributors,
            'active_members' => $active_members,
            'current_page' => $page,
            'total_pages' => $total_pages
        ]);
    }

    public function feed() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if (empty($_SESSION['terms_accepted'])) {
            $this->redirect('forum/terms');
        }

        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $category_filter = $_GET['category'] ?? null;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $feeds = $forumModel->getFeeds($limit, $_SESSION['member_id'], $category_filter, 'latest', $page);
        $total_feeds = $forumModel->getTotalFeedCount($category_filter);
        $total_pages = ceil($total_feeds / $limit);

        $global_stats = $forumModel->getGlobalStats();
        $trending = $forumModel->getTrendingTopics(5);
        $member_stats = $forumModel->getMemberStats($_SESSION['member_id']);
        $active_members = $forumModel->getActiveMembers(6);
        $unread_count = $forumModel->getUnreadReplyCount($_SESSION['member_id']);

        // Get member data
        $stmt = $this->db->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['member_id']]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->render('forum/feed', [
            'title' => 'Member Feed',
            'member' => $member,
            'feeds' => $feeds,
            'categories' => $categories,
            'global_stats' => $global_stats,
            'trending' => $trending,
            'member_stats' => $member_stats,
            'active_members' => $active_members,
            'current_page' => $page,
            'total_pages' => $total_pages
        ]);
    }

    public function newTopic() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if (empty($_SESSION['terms_accepted'])) {
            $this->redirect('forum/terms');
        }

        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $member_stats = $forumModel->getMemberStats($_SESSION['member_id']);

        $stmt = $this->db->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['member_id']]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->render('forum/new-topic', [
            'title' => 'Start a New Discussion',
            'member' => $member,
            'categories' => $categories,
            'member_stats' => $member_stats
        ]);
    }

    public function discussion() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if (empty($_SESSION['terms_accepted'])) {
            $this->redirect('forum/terms');
        }

        $uuid = $_GET['uuid'] ?? '';
        if (empty($uuid)) {
            $this->redirect('forum/feed');
        }

        $forumModel = new ForumModel($this->db);
        $member_uuid = $_SESSION['member_uuid'] ?? '';
        $member_id = $_SESSION['member_id'] ?? null;

        $topic = $forumModel->getTopic($uuid, $member_id);

        if (!$topic) {
            $this->redirect('forum/feed');
        }

        // Mark as read if user is logged in
        if ($member_uuid) {
            $forumModel->markRepliesAsRead($uuid, $member_uuid);
        }

        $categories = $forumModel->getCategories();
        $member_stats = $forumModel->getMemberStats($member_id);
        $trending = $forumModel->getTrendingTopics(5);
        $active_members = $forumModel->getActiveMembers(6);
        
        $stmt = $this->db->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute([':id' => $member_id]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->render('forum/view', [
            'title' => $topic['title'],
            'topic' => $topic,
            'categories' => $categories,
            'member_stats' => $member_stats,
            'trending' => $trending,
            'active_members' => $active_members,
            'member' => $member
        ]);
    }

    public function profile() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if (empty($_SESSION['terms_accepted'])) {
            $this->redirect('forum/terms');
        }

        $forumModel = new ForumModel($this->db);
        $member_id = $_SESSION['member_id'];
        
        $stmt = $this->db->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute([':id' => $member_id]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        $member_stats = $forumModel->getMemberStats($member_id);

        $this->render('forum/profile', [
            'title'        => 'Profile Settings',
            'member'       => $member,
            'member_stats' => $member_stats,
            'categories'   => $forumModel->getCategories()
        ]);
    }

    public function updateProfile() {
        // Always respond with JSON
        ob_clean();
        header('Content-Type: application/json');

        if (!$this->isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        try {
            $name         = trim($_POST['name'] ?? '');
            $new_password = $_POST['new_password'] ?? '';
            $member_id    = $_SESSION['member_id'];

            if (empty($name)) {
                echo json_encode(['success' => false, 'message' => 'Display name is required.']);
                return;
            }

            $forumModel   = new ForumModel($this->db);
            $passwordHash = null;
            if (!empty($new_password)) {
                // Password Regex: 1 Uppercase, 1 Lowercase, 1 Special Char, 1 Number, min 8 chars
                $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/';

                if (!preg_match($regex, $new_password)) {
                    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.']);
                    return;
                }

                $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
            }

            // Handle avatar upload
            $avatarPath = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $mimeType  = null;

                // Use finfo if available, else fallback to mime_content_type
                if (function_exists('finfo_open')) {
                    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $_FILES['avatar']['tmp_name']);
                    finfo_close($finfo);
                } elseif (function_exists('mime_content_type')) {
                    $mimeType = mime_content_type($_FILES['avatar']['tmp_name']);
                }

                if ($mimeType && !in_array($mimeType, $allowed)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid image type. Use JPG, PNG, GIF or WebP.']);
                    return;
                }

                if ($_FILES['avatar']['size'] > 5 * 1024 * 1024) {
                    echo json_encode(['success' => false, 'message' => 'Image must be under 5MB.']);
                    return;
                }

                $ext       = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                $filename  = 'avatar_' . $member_id . '_' . time() . '.' . $ext;
                $uploadDir = ROOT_PATH . '/uploads/forum/avatars/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $dest = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
                    $avatarPath = '/uploads/forum/avatars/' . $filename;
                }
            }

            $success = $forumModel->updateMember($member_id, $name, $passwordHash, $avatarPath);

            if ($success) {
                $_SESSION['member_name'] = $name;
                if ($avatarPath) $_SESSION['member_avatar'] = $avatarPath;
                echo json_encode([
                    'success'    => true,
                    'message'    => 'Profile updated successfully',
                    'avatarPath' => $avatarPath
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update profile. Please try again.']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
}
