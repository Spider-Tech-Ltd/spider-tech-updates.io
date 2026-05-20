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
            // Check if password is a hash
            if (strpos($admin['admin_password'], '$2y$') === 0) {
                if (password_verify($password, $admin['admin_password'])) {
                    return $admin;
                }
            } else {
                // Fallback for legacy plain text passwords (e.g., 'admin')
                if ($password === $admin['admin_password']) {
                    // Auto-migrate to hash for better security on next login
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $this->db->prepare("UPDATE admin_tb SET admin_password = ? WHERE admin_id = ?");
                    $updateStmt->execute([$newHash, $admin['admin_id']]);
                    return $admin;
                }
            }
        }
        return false;
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
}
