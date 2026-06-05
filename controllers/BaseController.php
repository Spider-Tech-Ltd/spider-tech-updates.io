<?php
class BaseController {
    public $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $this->db = $database->getConnection();
        if ($this->db === null) {
            die("Critical Error: Database connection failed. Please check your configuration and ensure MySQL is running.");
        }
        
        // Track member activity if logged in
        if ($this->isLoggedIn()) {
            $this->trackActivity();
            $this->checkSuspension();
        }
    }

    private function checkSuspension() {
        $currentUrl = $_GET['url'] ?? '';
        // Whitelist routes that suspended or terms-pending users MUST be able to access
        $whitelist = ['forum/suspended', 'forum/logout', 'forum/request-review', 'forum/terms', 'forum/terms/accept'];
        if (in_array($currentUrl, $whitelist) || strpos($currentUrl, 'admin/') === 0) {
            return;
        }

        // Fetch fresh status and terms acceptance from DB to ensure immediate enforcement
        try {
            $stmt = $this->db->prepare("SELECT status, terms_accepted FROM members WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['member_id']]);
            $member = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($member) {
                // 1. Suspension Check
                if ($member['status'] === 'Suspended') {
                    $_SESSION['member_status'] = 'Suspended';
                    $this->redirect('forum/suspended');
                }
                $_SESSION['member_status'] = 'Active';

                // 2. Terms Check (for Active members)
                if ((int)$member['terms_accepted'] === 0) {
                    $_SESSION['terms_accepted'] = 0;
                    $this->redirect('forum/terms');
                }
                $_SESSION['terms_accepted'] = 1;
            }
        } catch (PDOException $e) {
            // Fallback to session check if DB fails
            if (isset($_SESSION['member_status']) && $_SESSION['member_status'] === 'Suspended') {
                $this->redirect('forum/suspended');
            }
        }
    }

    private function trackActivity() {
        try {
            $stmt = $this->db->prepare("UPDATE members SET last_active_at = CURRENT_TIMESTAMP WHERE uuid = ?");
            $stmt->execute([$_SESSION['member_uuid'] ?? '']);
        } catch (PDOException $e) {
            // Silently fail to not break user experience
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['member_id']);
    }

    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    protected function redirect($path) {
        header("Location: " . BASE_URL . "/" . ltrim($path, '/'));
        exit();
    }

    protected function render($view, $data = [], $layout = true) {
        extract($data);
        $header = ROOT_PATH . "/views/layout/header.php";
        $viewFile = ROOT_PATH . "/views/$view.php";
        $footer = ROOT_PATH . "/views/layout/footer.php";

        if ($layout && file_exists($header)) include $header;
        if (file_exists($viewFile)) include $viewFile;
        if ($layout && file_exists($footer)) include $footer;
    }
}
