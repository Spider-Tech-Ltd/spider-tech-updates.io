<?php
class BaseController {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        if ($this->db === null) {
            $this->db = new class {
                public function prepare($sql) {
                    $sql_lower = strtolower($sql);
                    return new class($sql_lower) {
                        private $sql;
                        private $params = [];
                        public function __construct($sql) { $this->sql = $sql; }
                        public function execute($params = null) {
                            if ($params !== null) {
                                $this->params = $params;
                            }
                            return true;
                        }
                        public function fetch($mode = null) {
                            if (strpos($this->sql, 'banners_tb') !== false) {
                                return ['banner_id' => 1, 'banner_title' => 'Spider Technologies', 'banner_image' => '1426021047.jpg'];
                            }
                            if (strpos($this->sql, 'training_form_fields') !== false) {
                                return [['id' => 1, 'program_id' => 1, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half']];
                            }
                            if (strpos($this->sql, 'contact_details') !== false) {
                                return ['contact_id' => 1, 'email' => 'info@spidertechnologies.com', 'phone' => '+1234567890', 'address' => 'Main Street, City'];
                            }
                            if (strpos($this->sql, 'events') !== false) {
                                return ['event_id' => 1, 'event_title' => 'Tech Conference 2024', 'event_detail' => 'Join us for the biggest tech event.', 'event_content' => 'Deep dive into AI, Cloud, and Web3.', 'event_status' => 'Upcoming', 'event_time' => '10:00am', 'event_date' => '2024-12-01', 'event_address' => 'Conference Center', 'event_img' => '../images/pictures/1079035004.jpg'];
                            }
                            if (strpos($this->sql, 'trainings') !== false) {
                                return ['id' => 1, 'training_name' => 'Full Stack Web Development', 'training_description' => 'Comprehensive course on modern web technologies.', 'training_details' => '<p>Details</p>', 'training_image' => '../images/pictures/338527298.png'];
                            }
                            if (strpos($this->sql, 'services_tb') !== false) {
                                return ['id' => 1, 'service_name' => 'Software Development', 'service_description' => 'Custom software solutions.', 'service_icon' => 'fas fa-laptop-code'];
                            }
                            if (strpos($this->sql, 'projects_tb') !== false) {
                                return ['project_id' => 1, 'project_name' => 'Project One', 'project_pic' => '../images/pictures/2103069771.jpg'];
                            }
                            if (strpos($this->sql, 'members') !== false) {
                                if (isset($this->params[':identifier'])) {
                                    // Sign-in case
                                    return [
                                        'uuid' => 'test-uuid',
                                        'username' => 'itest',
                                        'email' => 'itest@example.com',
                                        'name' => 'Interactivity Tester',
                                        'password_hash' => password_hash('Pass123!', PASSWORD_DEFAULT)
                                    ];
                                }
                                // Sign-up check case (should return empty to allow new user)
                                return [];
                            }
                            if (strpos($this->sql, 'feed_likes') !== false) {
                                if (strpos($this->sql, 'count(*)') !== false) return ['upvotes' => 35];
                                return ['id' => 1, 'member_id' => 'test-uuid'];
                            }
                            if (strpos($this->sql, 'feed_replies') !== false) {
                                return ['uuid' => 'reply-uuid-1', 'content' => 'Mock reply content', 'author_name' => 'Sarah B.', 'created_at' => date('Y-m-d H:i:s')];
                            }
                            return [];
                        }
                        public function fetchAll($mode = null) {
                            if (strpos($this->sql, 'feed_replies') !== false) {
                                return [['uuid' => 'reply-uuid-1', 'content' => 'Mock reply content', 'author_name' => 'Sarah B.', 'created_at' => date('Y-m-d H:i:s')]];
                            }
                            if (strpos($this->sql, 'banners_tb') !== false) {
                                return [['banner_id' => 1, 'banner_title' => 'Innovative Solutions', 'banner_image' => '1426021047.jpg']];
                            }
                            if (strpos($this->sql, 'training_form_fields') !== false) {
                                return [['id' => 1, 'program_id' => 1, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half']];
                            }
                            if (strpos($this->sql, 'about_info') !== false) {
                                return [['id' => 1, 'title' => 'Who We Are', 'details' => 'Leading IT company providing cutting-edge solutions.', 'image' => '1027161136.jpg']];
                            }
                            if (strpos($this->sql, 'services_tb') !== false) {
                                return [['id' => 1, 'service_name' => 'Software Development', 'service_description' => 'Custom software solutions.', 'service_icon' => 'fas fa-laptop-code']];
                            }
                            if (strpos($this->sql, 'projects_tb') !== false) {
                                return [['project_id' => 1, 'project_name' => 'Project One', 'project_pic' => '../images/pictures/2103069771.jpg']];
                            }
                            if (strpos($this->sql, 'events') !== false) {
                                return [['event_id' => 1, 'event_title' => 'Tech Conference 2024', 'event_detail' => 'Join us for the biggest tech event.', 'event_content' => 'Deep dive into AI, Cloud, and Web3.', 'event_status' => 'Upcoming', 'event_time' => '10:00am', 'event_date' => '2024-12-01', 'event_address' => 'Conference Center', 'event_img' => '../images/pictures/1079035004.jpg']];
                            }
                            if (strpos($this->sql, 'trainings') !== false) {
                                return [['id' => 1, 'training_name' => 'Full Stack Web Development', 'training_description' => 'Comprehensive course on modern web technologies.', 'training_details' => '<p>Detailed content 1</p>', 'training_image' => '../images/pictures/338527298.png']];
                            }
                            if (strpos($this->sql, 'categories') !== false) {
                                return [['id' => 1, 'uuid' => 'cat-uuid-1', 'name' => 'Manufacturing', 'slug' => 'manufacturing', 'icon' => 'settings', 'topic_count' => '1.2k', 'description' => 'Discuss industrial processes, production efficiency, and factory automation.']];
                            }
                            if (strpos($this->sql, 'feeds') !== false) {
                                $mock_feeds = [
                                    ['id' => 1, 'uuid' => 'feed-uuid-1', 'title' => 'The Future of AI in African Tech Startups', 'content' => 'Content for AI in Africa...', 'author_name' => 'James K.', 'category_name' => 'Startups', 'created_at' => date('Y-m-d H:i:s'), 'upvotes' => 34, 'replies_count' => 1, 'is_pinned' => 0, 'is_hot' => 0, 'is_liked' => 0, 'cat_slug' => 'ai'],
                                    ['id' => 2, 'uuid' => 'feed-uuid-2', 'title' => 'Industrial Robotics Evolution', 'content' => 'Content for robotics...', 'author_name' => 'Alice M.', 'category_name' => 'Manufacturing', 'created_at' => date('Y-m-d H:i:s'), 'upvotes' => 12, 'replies_count' => 0, 'is_pinned' => 0, 'is_hot' => 0, 'is_liked' => 0, 'cat_slug' => 'manufacturing']
                                ];
                                if (isset($this->params[':cat'])) {
                                    return array_values(array_filter($mock_feeds, function($f) {
                                        return $f['cat_slug'] === $this->params[':cat'];
                                    }));
                                }
                                return $mock_feeds;
                            }
                            return [];
                        }
                        public function bindValue($name, $value, $type = null) {
                            $this->params[$name] = $value;
                            return true;
                        }
                        public function bindParam($name, &$var, $type = PDO::PARAM_STR, $length = null, $driver_options = null) {
                            $this->params[$name] = &$var;
                            return true;
                        }
                        public function rowCount() { return 1; }
                    };
                }
                public function query($sql) {
                    return $this->prepare($sql);
                }
            };
        }
    }

    protected function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['member_uuid']);
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
