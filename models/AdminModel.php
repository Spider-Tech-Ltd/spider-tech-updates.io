<?php
class AdminModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin_tb WHERE admin_name = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (strpos($admin['admin_password'], '$2y$') === 0) {
                if (password_verify($password, $admin['admin_password'])) {
                    return $admin;
                }
            } else {
                if ($password === $admin['admin_password']) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $this->db->prepare("UPDATE admin_tb SET admin_password = ? WHERE admin_id = ?");
                    $updateStmt->execute([$newHash, $admin['admin_id']]);
                    return $admin;
                }
            }
        }
        return false;
    }

    public function createAdmin($username, $password, $privilege = 'Admin') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO admin_tb (admin_name, admin_password, privilege, lastlogin) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$username, $hash, $privilege]);
    }

    public function getDashboardStats() {
        $stats = [];
        $queries = [
            'total_services' => "SELECT COUNT(*) FROM services_tb",
            'total_projects' => "SELECT COUNT(*) FROM projects_tb",
            'total_events' => "SELECT COUNT(*) FROM events",
            'total_trainings' => "SELECT COUNT(*) FROM trainings_tb",
            'total_members' => "SELECT COUNT(*) FROM members",
            'total_applicants' => "SELECT COUNT(*) FROM dse_application",
            'total_faq' => "SELECT COUNT(*) FROM faq_tb",
            'total_testimonials' => "SELECT COUNT(*) FROM testimonials_tb"
        ];
        foreach ($queries as $key => $sql) {
            $stmt = $this->db->query($sql);
            $stats[$key] = $stmt->fetchColumn();
        }
        return $stats;
    }

    public function getAllServices() {
        return $this->db->query("SELECT * FROM services_tb ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProjects() {
        return $this->db->query("
            SELECT p.*, s.service_name
            FROM projects_tb p
            LEFT JOIN services_tb s ON p.service_id = s.id
            ORDER BY p.project_id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEvents() {
        return $this->db->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTrainings() {
        return $this->db->query("SELECT * FROM trainings_tb ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBlogs() {
        try {
            return $this->db->query("
                SELECT b.*, bc.name as category_name
                FROM blogs b
                LEFT JOIN blog_categories bc ON b.category_id = bc.uuid
                ORDER BY b.created_at DESC
            ")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAllMembers() {
        return $this->db->query("SELECT * FROM members ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDSEApplications() {
        return $this->db->query("SELECT * FROM dse_application ORDER BY apply_date DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBootcampApplications() {
        return $this->db->query("SELECT * FROM bootcamp_application ORDER BY apply_date DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBanners() {
        return $this->db->query("SELECT * FROM banners_tb ORDER BY banner_id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAdmins() {
        return $this->db->query("SELECT * FROM admin_tb ORDER BY admin_id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFAQs() {
        return $this->db->query("SELECT * FROM faq_tb ORDER BY faq_id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTestimonials() {
        return $this->db->query("SELECT * FROM testimonials_tb ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function storeRecord($type, $data) {
        $allowedTypes = [
            'service' => [
                'table' => 'services_tb',
                'fields' => ['service_name', 'service_icon', 'service_description', 'service_detail']
            ],
            'faq' => [
                'table' => 'faq_tb',
                'fields' => ['faq_question', 'faq_answer']
            ]
        ];

        if (!isset($allowedTypes[$type])) return false;

        $table = $allowedTypes[$type]['table'];
        $fields = $allowedTypes[$type]['fields'];

        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $fieldNames = implode(',', $fields);

        $values = [];
        foreach ($fields as $field) {
            $values[] = $data[$field] ?? '';
        }

        $stmt = $this->db->prepare("INSERT INTO $table ($fieldNames) VALUES ($placeholders)");
        return $stmt->execute($values);
    }

    public function deleteRecord($type, $id) {
        $allowedTypes = [
            'service' => ['table' => 'services_tb', 'pk' => 'id'],
            'project' => ['table' => 'projects_tb', 'pk' => 'project_id'],
            'event' => ['table' => 'events', 'pk' => 'event_id'],
            'training' => ['table' => 'trainings_tb', 'pk' => 'id'],
            'blog' => ['table' => 'blogs', 'pk' => 'uuid'],
            'banner' => ['table' => 'banners_tb', 'pk' => 'banner_id'],
            'member' => ['table' => 'members', 'pk' => 'member_id'],
            'faq' => ['table' => 'faq_tb', 'pk' => 'faq_id'],
            'testimonial' => ['table' => 'testimonials_tb', 'pk' => 'id'],
            'dse_app' => ['table' => 'dse_application', 'pk' => 'id'],
            'bootcamp_app' => ['table' => 'bootcamp_application', 'pk' => 'id']
        ];

        if (!isset($allowedTypes[$type])) return false;

        $table = $allowedTypes[$type]['table'];
        $pk = $allowedTypes[$type]['pk'];

        $stmt = $this->db->prepare("DELETE FROM $table WHERE $pk = ?");
        return $stmt->execute([$id]);
    }
}
