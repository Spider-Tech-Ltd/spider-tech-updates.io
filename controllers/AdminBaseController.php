<?php
class AdminBaseController extends BaseController {
    public function __construct() {
        parent::__construct();
        // Check if we are on the login page to avoid redirect loops
        $currentUrl = $_GET['url'] ?? '';
        if ($currentUrl !== 'admin/login' && !$this->isAdminLoggedIn()) {
            $this->redirect('admin/login');
        }
    }

    protected function isAdminLoggedIn() {
        return isset($_SESSION['admin_id']);
    }

    protected function renderAdmin($view, $data = []) {
        extract($data);
        $header = ROOT_PATH . "/views/admin/layout/header.php";
        $sidebar = ROOT_PATH . "/views/admin/layout/sidebar.php";
        $viewFile = ROOT_PATH . "/views/admin/$view.php";
        $footer = ROOT_PATH . "/views/admin/layout/footer.php";

        if (file_exists($header)) include $header;
        if (file_exists($sidebar)) include $sidebar;
        if (file_exists($viewFile)) include $viewFile;
        if (file_exists($footer)) include $footer;
    }
}
