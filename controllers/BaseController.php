<?php
class BaseController {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    protected function render($view, $data = []) {
        extract($data);
        $header = ROOT_PATH . "/views/layout/header.php";
        $viewFile = ROOT_PATH . "/views/$view.php";
        $footer = ROOT_PATH . "/views/layout/footer.php";

        if (file_exists($header)) include $header;
        if (file_exists($viewFile)) include $viewFile;
        if (file_exists($footer)) include $footer;
    }
}
?>