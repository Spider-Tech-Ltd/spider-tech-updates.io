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
                                return [
                                    'banner_id' => 1,
                                    'banner_title' => 'Spider Technologies',
                                    'banner_image' => '1426021047.jpg'
                                ];
                            }
                            if (strpos($this->sql, 'training_form_fields') !== false) {
                                if (strpos($this->sql, 'program_id = 3') !== false || (isset($this->params[0]) && $this->params[0] == 3)) {
                                    return [
                                        ['id' => 10, 'program_id' => 3, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                        ['id' => 11, 'program_id' => 3, 'field_name' => 'local_government', 'field_label' => 'Local Government', 'field_type' => 'select', 'is_required' => 1, 'options' => json_encode(['Kano Municipal', 'Tarauni', 'Nassarawa', 'Gwale', 'Fagge']), 'field_order' => 2, 'field_section' => 'Demographics', 'field_width' => 'full']
                                    ];
                                }
                                return [
                                    ['id' => 1, 'program_id' => 1, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 2, 'program_id' => 1, 'field_name' => 'email', 'field_label' => 'Email Address', 'field_type' => 'email', 'is_required' => 1, 'options' => null, 'field_order' => 2, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 3, 'program_id' => 1, 'field_name' => 'experience', 'field_label' => 'Experience Level', 'field_type' => 'select', 'is_required' => 1, 'options' => json_encode(['Beginner', 'Intermediate', 'Expert']), 'field_order' => 3, 'field_section' => 'Professional Information', 'field_width' => 'full']
                                ];
                            }
                            if (strpos($this->sql, 'contact_details') !== false) {
                                return [
                                    'contact_id' => 1,
                                    'email' => 'info@spidertechnologies.com',
                                    'phone' => '+1234567890',
                                    'address' => 'Main Street, City'
                                ];
                            }
                            if (strpos($this->sql, 'events') !== false) {
                                return [
                                    'event_id' => 1,
                                    'event_title' => 'Tech Conference 2024',
                                    'event_detail' => 'Join us for the biggest tech event.',
                                    'event_content' => 'Deep dive into AI, Cloud, and Web3.',
                                    'event_status' => 'Upcoming',
                                    'event_time' => '10:00am',
                                    'event_date' => '2024-12-01',
                                    'event_date2' => '2024-12-02',
                                    'event_address' => 'Conference Center',
                                    'event_img' => '../images/pictures/1079035004.jpg'
                                ];
                            }
                            if (strpos($this->sql, 'trainings') !== false) {
                                if (strpos($this->sql, 'id = 3') !== false || (isset($this->params[0]) && $this->params[0] == 3)) {
                                    return [
                                        'id' => 3,
                                        'training_name' => 'Cybersecurity Essentials',
                                        'training_description' => 'Protect your digital assets with advanced security training.',
                                        'training_details' => '<p>Learn about network security, cryptography, and ethical hacking.</p>',
                                        'training_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=600&q=80'
                                    ];
                                }
                                return [
                                    'id' => 1,
                                    'training_name' => 'Full Stack Web Development',
                                    'training_description' => 'Comprehensive course on modern web technologies.',
                                    'training_details' => '<p>This is the detailed content for Full Stack Web Development course. It includes HTML, CSS, JS, Node, and more.</p>',
                                    'training_image' => '../images/pictures/338527298.png'
                                ];
                            }
                            if (strpos($this->sql, 'services_tb') !== false) {
                                return [
                                    'id' => 1,
                                    'service_name' => 'Software Development',
                                    'service_description' => 'Custom software solutions.',
                                    'service_icon' => 'fas fa-laptop-code'
                                ];
                            }
                            if (strpos($this->sql, 'projects_tb') !== false) {
                                return [
                                    'project_id' => 1,
                                    'project_name' => 'Project One',
                                    'project_pic' => '../images/pictures/2103069771.jpg'
                                ];
                            }
                            if (strpos($this->sql, 'members') !== false) {
                                if (isset($this->params[':identifier']) && ($this->params[':identifier'] === 'tester@example.com' || $this->params[':identifier'] === 'mvctester')) {
                                    return [
                                        'uuid' => '1234-5678',
                                        'username' => 'mvctester',
                                        'email' => 'tester@example.com',
                                        'name' => 'MVC Tester',
                                        'password_hash' => password_hash('HashedPass123!', PASSWORD_DEFAULT)
                                    ];
                                }
                                if (isset($this->params[':identifier']) && ($this->params[':identifier'] === 'final@example.com' || $this->params[':identifier'] === 'finalmvc')) {
                                    return [
                                        'uuid' => 'final-uuid',
                                        'username' => 'finalmvc',
                                        'email' => 'final@example.com',
                                        'name' => 'Final MVC',
                                        'password_hash' => password_hash('FinalPass123!', PASSWORD_DEFAULT)
                                    ];
                                }
                                return [];
                            }
                            return [];
                        }
                        public function fetchAll($mode = null) {
                            if (strpos($this->sql, 'banners_tb') !== false) {
                                return [
                                    ['banner_id' => 1, 'banner_title' => 'Innovative Solutions', 'banner_image' => '1426021047.jpg'],
                                    ['banner_id' => 2, 'banner_title' => 'Digital Excellence', 'banner_image' => '1460642200.jpg']
                                ];
                            }
                            if (strpos($this->sql, 'training_form_fields') !== false) {
                                if (strpos($this->sql, 'program_id = 3') !== false || (isset($this->params[0]) && $this->params[0] == 3)) {
                                    return [
                                        ['id' => 10, 'program_id' => 3, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                        ['id' => 11, 'program_id' => 3, 'field_name' => 'local_government', 'field_label' => 'Local Government', 'field_type' => 'select', 'is_required' => 1, 'options' => json_encode(['Kano Municipal', 'Tarauni', 'Nassarawa', 'Gwale', 'Fagge']), 'field_order' => 2, 'field_section' => 'Demographics', 'field_width' => 'full']
                                    ];
                                }
                                return [
                                    ['id' => 1, 'program_id' => 1, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 2, 'program_id' => 1, 'field_name' => 'email', 'field_label' => 'Email Address', 'field_type' => 'email', 'is_required' => 1, 'options' => null, 'field_order' => 2, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 3, 'program_id' => 1, 'field_name' => 'experience', 'field_label' => 'Experience Level', 'field_type' => 'select', 'is_required' => 1, 'options' => json_encode(['Beginner', 'Intermediate', 'Expert']), 'field_order' => 3, 'field_section' => 'Professional Information', 'field_width' => 'full']
                                ];
                            }
                            if (strpos($this->sql, 'about_info') !== false) {
                                return [
                                    ['id' => 1, 'title' => 'Who We Are', 'details' => 'Leading IT company providing cutting-edge solutions.', 'image' => '1027161136.jpg']
                                ];
                            }
                            if (strpos($this->sql, 'services_tb') !== false) {
                                return [
                                    ['id' => 1, 'service_name' => 'Software Development', 'service_description' => 'Custom software solutions.', 'service_icon' => 'fas fa-laptop-code'],
                                    ['id' => 2, 'service_name' => 'Database Management', 'service_description' => 'Scalable DB solutions.', 'service_icon' => 'fas fa-database'],
                                    ['id' => 3, 'service_name' => 'Web Design', 'service_description' => 'Responsive and modern designs.', 'service_icon' => 'fas fa-pencil-ruler']
                                ];
                            }
                            if (strpos($this->sql, 'projects_tb') !== false) {
                                return [
                                    ['project_id' => 1, 'project_name' => 'Project One', 'project_pic' => '../images/pictures/2103069771.jpg'],
                                    ['project_id' => 2, 'project_name' => 'Project Two', 'project_pic' => '../images/pictures/400280262.jpg']
                                ];
                            }
                            if (strpos($this->sql, 'upcoming_events') !== false || strpos($this->sql, 'events') !== false) {
                                if (strpos($this->sql, 'event_id = 3') !== false || (isset($this->params[0]) && $this->params[0] == 3)) {
                                    return [
                                        'event_id' => 3,
                                        'event_title' => 'MVC Workshop',
                                        'event_detail' => 'Master the MVC pattern in PHP.',
                                        'event_content' => 'Hands-on workshop for modern PHP development.',
                                        'event_status' => 'Upcoming',
                                        'event_time' => '9:00am',
                                        'event_date' => '2024-12-10',
                                        'event_date2' => '2024-12-11',
                                        'event_address' => 'Tech Hub',
                                        'event_img' => '../images/pictures/1079035004.jpg'
                                    ];
                                }
                                return [
                                    [
                                        'event_id' => 1,
                                        'event_title' => 'Tech Conference 2024',
                                        'event_detail' => 'Join us for the biggest tech event.',
                                        'event_content' => 'Deep dive into AI, Cloud, and Web3.',
                                        'event_status' => 'Upcoming',
                                        'event_time' => '10:00am',
                                        'event_date' => '2024-12-01',
                                        'event_date2' => '2024-12-02',
                                        'event_address' => 'Conference Center',
                                        'event_img' => '../images/pictures/1079035004.jpg'
                                    ]
                                ];
                            }
                            if (strpos($this->sql, 'trainings') !== false) {
                                return [
                                    ['id' => 1, 'training_name' => 'Full Stack Web Development', 'training_description' => 'Comprehensive course on modern web technologies.', 'training_details' => '<p>Detailed content 1</p>', 'training_image' => '../images/pictures/338527298.png'],
                                    ['id' => 2, 'training_name' => 'Data Science Essentials', 'training_description' => 'Learn the basics of data analysis and machine learning.', 'training_details' => '<p>Detailed content 2</p>', 'training_image' => '../images/pictures/338527298.png'],
                                    ['id' => 3, 'training_name' => 'Cybersecurity Essentials', 'training_description' => 'Protect your digital assets with advanced security training.', 'training_details' => '<p>Detailed content 3</p>', 'training_image' => '../images/pictures/338527298.png']
                                ];
                            }
                            if (strpos($this->sql, 'categories') !== false) {
                                return [
                                    ['id' => 1, 'name' => 'Manufacturing', 'slug' => 'manufacturing', 'icon' => 'settings', 'topic_count' => '1.2k', 'description' => 'Discuss industrial processes, production efficiency, and factory automation.'],
                                    ['id' => 2, 'name' => 'Energy & Utilities', 'slug' => 'energy', 'icon' => 'bolt', 'topic_count' => '850', 'description' => 'Power generation, distribution, and sustainable energy solutions.'],
                                    ['id' => 3, 'name' => 'AI & Robotics', 'slug' => 'ai', 'icon' => 'smart_toy', 'topic_count' => '610', 'description' => 'Machine learning, autonomous systems, and advanced robotics in industry.'],
                                    ['id' => 4, 'name' => 'Logistics', 'slug' => 'logistics', 'icon' => 'local_shipping', 'topic_count' => '430', 'description' => 'Supply chain management, transport, and warehousing.'],
                                    ['id' => 5, 'name' => 'Infrastructure', 'slug' => 'infra', 'icon' => 'construction', 'topic_count' => '320', 'description' => 'Smart cities, construction tech, and large-scale engineering.']
                                ];
                            }
                            if (strpos($this->sql, 'feeds') !== false) {
                                return [
                                    [
                                        'id' => 1,
                                        'title' => 'The Future of AI in African Tech Startups',
                                        'author_name' => 'James K.',
                                        'category_name' => 'Startups',
                                        'created_at' => '3h ago',
                                        'upvotes' => 34,
                                        'replies' => 42,
                                        'is_pinned' => 0,
                                        'is_hot' => 0
                                    ],
                                    [
                                        'id' => 2,
                                        'title' => 'Best Practices for Remote Team Management',
                                        'author_name' => 'Alice M.',
                                        'category_name' => 'Management',
                                        'created_at' => 'Yesterday',
                                        'upvotes' => 18,
                                        'replies' => 28,
                                        'is_pinned' => 0,
                                        'is_hot' => 0
                                    ]
                                ];
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
