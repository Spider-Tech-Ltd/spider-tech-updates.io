<?php

class ForumController extends BaseController {

    public function index() {
        $forumModel = new ForumModel($this->db);
        $categories = $forumModel->getCategories();
        $feeds = $forumModel->getFeeds(10, $_SESSION['member_uuid'] ?? null);

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
        $feeds = $forumModel->getFeeds(10, $_SESSION['member_uuid']);

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
            'feeds' => $feeds
        ]);
    }
}
