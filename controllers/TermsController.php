<?php

class TermsController extends BaseController
{
    /**
     * Constructor for TermsController
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Displays the Terms of Service page.
     * Checks if the user has already accepted via session or database.
     */
    public function index()
    {
        // 1. Ensure user is authenticated
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        // 2. Check Session First (Fastest check)
        if (isset($_SESSION['terms_accepted']) && $_SESSION['terms_accepted'] == 1) {
            $this->redirect('forum/feed');
        }

        // 3. Fallback: Check the Database (Handles users signing back in)
        // This solves the bug where users see terms every time they login
        $member_id = $_SESSION['member_id'];
        $stmt = $this->db->prepare("SELECT terms_accepted FROM members WHERE id = ? LIMIT 1");
        $stmt->execute([$member_id]);
        $member = $stmt->fetch();

        if ($member && (int)$member['terms_accepted'] === 1) {
            // Re-hydrate the session so we don't query the DB again during this session
            $_SESSION['terms_accepted'] = 1;
            $this->redirect('forum/feed');
        }

        // 4. If neither check passes, render the Terms page
        $this->render('forum/terms', [
            'title' => 'Terms of Service - Spider Tech Community',
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    /**
     * Handles the POST request when a user accepts the terms.
     */
    public function accept()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('forum/sign-in');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Security Check
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $_SESSION['error_message'] = "Invalid CSRF token. Please refresh and try again.";
                $this->redirect('forum/terms');
            }

            // Checkbox validation
            if (!isset($_POST['agree'])) {
                $_SESSION['error_message'] = "You must agree to the terms and community guidelines to proceed.";
                $this->redirect('forum/terms');
            }

            $member_id = $_SESSION['member_id'];

            // Update Database
            $stmt = $this->db->prepare("UPDATE members SET terms_accepted = 1 WHERE id = ?");
            if ($stmt->execute([$member_id])) {
                // Update Session state immediately
                $_SESSION['terms_accepted'] = 1;
                $this->redirect('forum/feed');
            } else {
                $_SESSION['error_message'] = "An error occurred while updating your account. Please try again.";
                $this->redirect('forum/terms');
            }
        } else {
            // If accessed via GET, just show the terms
            $this->redirect('forum/terms');
        }
    }
}
