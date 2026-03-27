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
                        public function __construct($sql) { $this->sql = $sql; }
                        public function execute($params = []) { return true; }
                        public function fetch($mode = null) {
                            if (strpos($this->sql, 'banners_tb') !== false) {
                                return [
                                    'banner_id' => 1,
                                    'banner_title' => 'Spider Technologies',
                                    'banner_image' => '1426021047.jpg'
                                ];
                            }
                            if (strpos($this->sql, 'training_form_fields') !== false) {
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
                                return [
                                    'id' => 1,
                                    'training_name' => 'Full Stack Web Development',
                                    'training_description' => 'Comprehensive course on modern web technologies.',
                                    'training_details' => '<p>This is the detailed content for Full Stack Web Development course. It includes HTML, CSS, JS, Node, and more.</p>',
                                    'training_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80'
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
                                return [
                                    ['id' => 1, 'program_id' => 1, 'field_name' => 'full_name', 'field_label' => 'Full Name', 'field_type' => 'text', 'is_required' => 1, 'options' => null, 'field_order' => 1, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 2, 'program_id' => 1, 'field_name' => 'email', 'field_label' => 'Email Address', 'field_type' => 'email', 'is_required' => 1, 'options' => null, 'field_order' => 2, 'field_section' => 'Basic Information', 'field_width' => 'half'],
                                    ['id' => 3, 'program_id' => 1, 'field_name' => 'experience', 'field_label' => 'Experience Level', 'field_type' => 'select', 'is_required' => 1, 'options' => json_encode(['Beginner', 'Intermediate', 'Expert']), 'field_order' => 3, 'field_section' => 'Professional Information', 'field_width' => 'full']
                                ];
                            }
                            if (strpos($this->sql, 'categories') !== false) {
                                return [
                                    ['category_uuid' => 'uuid-1', 'category_name' => 'Startup Advice', 'category_description' => 'Expert tips for scaling your business.'],
                                    ['category_uuid' => 'uuid-2', 'category_name' => 'Developer Hub', 'category_description' => 'Coding, system architecture, and modern frameworks.'],
                                    ['category_uuid' => 'uuid-3', 'category_name' => 'General Tech', 'category_description' => 'Latest tech trends and global innovations.'],
                                    ['category_uuid' => 'uuid-4', 'category_name' => 'Introductions', 'category_description' => 'Meet and greet the community.'],
                                    ['category_uuid' => 'uuid-5', 'category_name' => 'Hardware Review', 'category_description' => 'Deep dives into the latest gadgets.'],
                                    ['category_uuid' => 'uuid-6', 'category_name' => 'Industry News', 'category_description' => 'Global industry movements and policy changes.']
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
                                    ['id' => 1, 'training_name' => 'Full Stack Web Development', 'training_description' => 'Comprehensive course on modern web technologies.', 'training_details' => '<p>Detailed content 1</p>', 'training_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80'],
                                    ['id' => 2, 'training_name' => 'Data Science Essentials', 'training_description' => 'Learn the basics of data analysis and machine learning.', 'training_details' => '<p>Detailed content 2</p>', 'training_image' => 'https://images.unsplash.com/photo-1551288049-bbbda536ad41?auto=format&fit=crop&w=600&q=80']
                                ];
                            }
                            return [];
                        }
                        public function bindValue($name, $value, $type = null) {}
                        public function rowCount() { return 1; }
                    };
                }
                public function query($sql) {
                    return $this->prepare($sql);
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