<?php

class ForumController extends BaseController {

    public function index() {
        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $category_filter = $_GET['category'] ?? null;
        $feeds = $forumModel->getFeeds(10, $_SESSION['member_id'] ?? null, $category_filter);

        $this->render('forum/index', [
            'title' => 'Spider Tech Community Forum',
            'categories' => $categories,
            'feeds' => $feeds
        ]);
    }

    public function feed() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $category_filter = $_GET['category'] ?? null;
        $feeds = $forumModel->getFeeds(10, $_SESSION['member_id'], $category_filter);

        // Mock member data for UI fidelity
        $member = [
            'name' => $_SESSION['member_name'] ?? 'Member',
            'role' => 'Engineer',
            'posts' => 128,
            'new_replies' => 3
        ];

        $this->render('forum/feed', [
            'title' => 'Member Feed',
            'member' => $member,
            'feeds' => $feeds,
            'categories' => $categories
        ]);
    }

    public function newTopic() {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();

        $member = [
            'name'       => $_SESSION['member_name'] ?? 'Member',
            'initials'   => strtoupper(substr($_SESSION['member_name'] ?? 'M', 0, 1)),
            'role'       => 'Verified Member',
        ];

        $this->render('forum/new-topic', [
            'title' => 'Start a New Discussion',
            'member' => $member,
            'categories' => $categories
        ]);
    }
}
