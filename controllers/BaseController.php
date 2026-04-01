<?php
class BaseController {
    protected $db;

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
