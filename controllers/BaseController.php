<?php
class BaseController {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        if ($this->db === null) {
            $this->db = new class {
                public function prepare($sql) {
                    return new class {
                        public function execute($params = []) {}
                        public function fetch($mode = null) { return []; }
                        public function fetchAll($mode = null) { return []; }
                        public function bindValue($name, $value, $type = null) {}
                        public function rowCount() { return 0; }
                    };
                }
                public function query($sql) {
                    return new class {
                        public function fetch($mode = null) { return []; }
                        public function fetchAll($mode = null) { return []; }
                        public function rowCount() { return 0; }
                    };
                }
            };
        }
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