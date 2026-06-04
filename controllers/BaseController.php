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
        if ($currentUrl === 'forum/suspended' || $currentUrl === 'forum/logout' || strpos($currentUrl, 'admin/') === 0) {
            return;
        }

        // Fetch fresh status from DB to ensure immediate enforcement
        try {
            $stmt = $this->db->prepare("SELECT status FROM members WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['member_id']]);
            $member = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($member && $member['status'] === 'Suspended') {
                // Member is suspended - update session and redirect
                $_SESSION['member_status'] = 'Suspended';
                $this->redirect('forum/suspended');
            } else {
                // Ensure session reflects active status
                $_SESSION['member_status'] = 'Active';
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
