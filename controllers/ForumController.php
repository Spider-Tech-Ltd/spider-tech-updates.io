<?php

class ForumController extends BaseController {

    public function index() {
        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $category_filter = $_GET['category'] ?? null;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $feeds = $forumModel->getFeeds($limit, $_SESSION['member_id'] ?? null, $category_filter, 'latest', $page);
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

        // Mock member data for UI fidelity
        $member = [
            'name' => $_SESSION['member_name'] ?? 'Member',
            'role' => 'Engineer',
            'posts' => 128,
            'new_replies' => $unread_count
        ];

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

        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $member_stats = $forumModel->getMemberStats($_SESSION['member_id']);

        $member = [
            'name'       => $_SESSION['member_name'] ?? 'Member',
            'initials'   => strtoupper(substr($_SESSION['member_name'] ?? 'M', 0, 1)),
            'role'       => 'Verified Member',
        ];

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
}
