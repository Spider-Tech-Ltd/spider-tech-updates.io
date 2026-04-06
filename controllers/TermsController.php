<?php

class TermsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        // If already accepted, redirect to feed
        if (isset($_SESSION['terms_accepted']) && $_SESSION['terms_accepted'] == 1) {
            $this->redirect('forum/feed');
        }

        $this->render('forum/terms', [
            'title' => 'Terms of Service - Spider Tech Community',
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function accept()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $_SESSION['error_message'] = "Invalid CSRF token.";
                $this->redirect('forum/terms');
            }

            if (!isset($_POST['agree'])) {
                $_SESSION['error_message'] = "You must agree to the terms and conditions to proceed.";
                $this->redirect('forum/terms');
            }

            $member_id = $_SESSION['member_id'];
            $stmt = $this->db->prepare("UPDATE members SET terms_accepted = 1 WHERE id = ?");
            if ($stmt->execute([$member_id])) {
                $_SESSION['terms_accepted'] = 1;
                $this->redirect('forum/feed');
            } else {
                $_SESSION['error_message'] = "An error occurred while updating your status. Please try again.";
                $this->redirect('forum/terms');
            }
        } else {
            $this->redirect('forum/terms');
        }
    }
}
