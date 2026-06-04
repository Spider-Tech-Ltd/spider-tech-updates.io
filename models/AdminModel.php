<?php
class AdminModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate($username, $password)
    {
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

    public function getDashboardData()
    {
        $data = ['stats' => $this->getDashboardStats()];

        // Latest 5 members - Using 'name' as 'full_name' for backward compatibility in views
        $data['recent_members'] = $this->db->query("SELECT name as full_name, email, avatar, created_at FROM members ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

        // Latest 5 applications from training_registrations
        $data['recent_applications'] = $this->db->query("
            SELECT tr.*, t.training_name as type
            FROM training_registrations tr
            LEFT JOIN trainings_tb t ON tr.program_id = t.id
            ORDER BY tr.created_at DESC LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getUnifiedApplications($programId = 'all', $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $where = "";
        $params = [];
        if ($programId !== 'all') {
            $where = " WHERE tr.program_id = :program_id";
            $params[':program_id'] = $programId;
        }

        $countSql = "SELECT COUNT(*) FROM training_registrations tr" . $where;
        $stmt = $this->db->prepare($countSql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $total = $stmt->fetchColumn();
        $totalPages = ceil($total / $limit);

        $sql = "SELECT tr.*, t.training_name as program_name
                FROM training_registrations tr
                LEFT JOIN trainings_tb t ON tr.program_id = t.id
                $where
                ORDER BY tr.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total_pages' => $totalPages,
            'current_page' => $page,
            'total_records' => $total
        ];
    }

    public function getAllPrograms()
    {
        return $this->db->query("SELECT id, training_name FROM trainings_tb ORDER BY training_name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDashboardStats()
    {
        $stats = [];
        $queries = [
            'total_services' => "SELECT COUNT(*) FROM services_tb",
            'total_projects' => "SELECT COUNT(*) FROM projects_tb",
            'total_events' => "SELECT COUNT(*) FROM events",
            'total_trainings' => "SELECT COUNT(*) FROM trainings_tb",
            'total_members' => "SELECT COUNT(*) FROM members",
            'total_applicants' => "SELECT COUNT(*) FROM training_registrations",
            'total_faq' => "SELECT COUNT(*) FROM faq_tb",
            'total_testimonials' => "SELECT COUNT(*) FROM testimonials_tb"
        ];
        foreach ($queries as $key => $sql) {
            $stmt = $this->db->query($sql);
            $stats[$key] = $stmt->fetchColumn();
        }
        return $stats;
    }

    public function getPaginated($table, $page = 1, $limit = 6, $orderBy = 'id DESC', $filters = [])
    {
        $offset = ($page - 1) * $limit;
        $allowedTables = ['services_tb', 'projects_tb', 'events', 'trainings_tb', 'blogs', 'members', 'faq_tb', 'testimonials_tb', 'banners_tb'];
        if (!in_array($table, $allowedTables)) return ['data' => [], 'total_pages' => 0];

        $where = "";
        $params = [];
        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $column => $value) {
                if ($value !== 'all') {
                    $conditions[] = "$column = :$column";
                    $params[":$column"] = $value;
                }
            }
            if (!empty($conditions)) $where = " WHERE " . implode(' AND ', $conditions);
        }

        $totalSql = "SELECT COUNT(*) FROM $table" . $where;
        $stmt = $this->db->prepare($totalSql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        $totalPages = ceil($total / $limit);

        if ($table === 'blogs') {
            $sql = "SELECT b.*, bc.name
                    FROM blogs b
                    LEFT JOIN blog_categories bc ON b.category_id = bc.id
                    $where
                    ORDER BY b.created_at DESC LIMIT :limit OFFSET :offset";
        } else {
            $sql = "SELECT * FROM $table $where ORDER BY $orderBy LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }

    public function getById($table, $pk, $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $pk = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPaginatedProjects($page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;
        $total = $this->db->query("SELECT COUNT(*) FROM projects_tb")->fetchColumn();
        $totalPages = ceil($total / $limit);

        $sql = "SELECT p.*, s.service_name
                FROM projects_tb p
                LEFT JOIN services_tb s ON p.service_id = s.id
                ORDER BY p.project_id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }

    public function storeRecord($type, $data)
    {
        $allowedTypes = [
            'service' => ['table' => 'services_tb', 'pk' => 'id', 'fields' => ['service_name', 'service_icon', 'service_description', 'service_detail', 'show_on_home', 'sort_order'], 'upload' => null],
            'project' => ['table' => 'projects_tb', 'pk' => 'project_id', 'fields' => ['project_name', 'service_id', 'project_year', 'project_description', 'show_on_home', 'sort_order'], 'upload' => 'project_pic', 'path' => 'images/pictures/'],
            'banner' => ['table' => 'banners_tb', 'pk' => 'banner_id', 'fields' => ['banner_title'], 'upload' => 'banner_image', 'path' => 'images/banners/'],
            'faq' => ['table' => 'faq_tb', 'pk' => 'faq_id', 'fields' => ['faq_question', 'faq_answer'], 'upload' => null],
            'testimonial' => ['table' => 'testimonials_tb', 'pk' => 'id', 'fields' => ['name', 'organization', 'title', 'testimonial'], 'upload' => 'image', 'path' => 'images/pictures/'],
            'event' => ['table' => 'events', 'pk' => 'event_id', 'fields' => ['event_title', 'event_content', 'event_detail', 'event_date', 'event_time', 'event_address', 'event_status', 'show_on_home', 'sort_order'], 'upload' => 'event_img', 'path' => 'images/pictures/'],
            'training' => ['table' => 'trainings_tb', 'pk' => 'id', 'fields' => ['training_name', 'training_description', 'training_details', 'training_icon', 'show_on_home', 'sort_order'], 'upload' => 'training_image', 'path' => 'images/pictures/'],
            'blog' => ['table' => 'blogs', 'pk' => 'uuid', 'fields' => ['category_id', 'title', 'slug', 'summary', 'content', 'status'], 'upload' => 'image_path', 'path' => 'images/blog/']
        ];
        if (!isset($allowedTypes[$type])) return false;

        $table = $allowedTypes[$type]['table'];
        $pk = $allowedTypes[$type]['pk'];
        $fields = $allowedTypes[$type]['fields'];
        $uploadField = $allowedTypes[$type]['upload'] ?? null;
        $uploadPath = $allowedTypes[$type]['path'] ?? '';
        $actionMode = $data['action_mode'] ?? 'store';

        // Handle File Upload
        if ($uploadField && isset($_FILES[$uploadField]) && $_FILES[$uploadField]['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES[$uploadField]['tmp_name'];
            $name = time() . '_' . basename($_FILES[$uploadField]['name']);
            if (!is_dir(ROOT_PATH . '/' . $uploadPath)) {
                mkdir(ROOT_PATH . '/' . $uploadPath, 0777, true);
            }
            if (move_uploaded_file($tmp_name, ROOT_PATH . '/' . $uploadPath . $name)) {
                // FIXED: Store a clean absolute root-relative path (without "../")
                $filePath = $uploadPath . $name;
                $data[$uploadField] = $filePath;
                if (!in_array($uploadField, $fields)) {
                    $fields[] = $uploadField;
                }
            }
        }

        try {
            if ($actionMode === 'update') {
                $id = $data['id'] ?? null;
                if (!$id) return false;
                $sets = [];
                $values = [];
                foreach ($fields as $field) {
                    if ($field === 'show_on_home') {
                        $sets[] = "show_on_home = ?";
                        // Safeguard checkbox state checking
                        $values[] = (isset($data['show_on_home']) && $data['show_on_home']) ? 1 : 0;
                    } elseif ($field === 'sort_order') {
                        $sets[] = "sort_order = ?";
                        $values[] = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;
                    } elseif (isset($data[$field])) {
                        $sets[] = "$field = ?";
                        $values[] = $data[$field];
                    }
                }
                $values[] = $id;
                $setSql = implode(',', $sets);
                $stmt = $this->db->prepare("UPDATE $table SET $setSql WHERE $pk = ?");
                return $stmt->execute($values);
            } else {
                // Generate UUID and slug for blog if new
                if ($type === 'blog') {
                    $fields[] = 'uuid';
                    $data['uuid'] = Utils::generateUUID();
                    if (!isset($data['slug']) || empty($data['slug'])) {
                        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));
                    }
                }
                $placeholders = implode(',', array_fill(0, count($fields), '?'));
                $fieldNames = implode(',', $fields);
                $values = [];
                foreach ($fields as $field) {
                    if ($field === 'show_on_home') {
                        $values[] = (isset($data['show_on_home']) && $data['show_on_home']) ? 1 : 0;
                    } elseif ($field === 'sort_order') {
                        $values[] = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;
                    } else {
                        $values[] = $data[$field] ?? '';
                    }
                }
                $stmt = $this->db->prepare("INSERT INTO $table ($fieldNames) VALUES ($placeholders)");
                return $stmt->execute($values);
            }
        } catch (PDOException $e) {
            error_log("AdminModel::storeRecord error for $type: " . $e->getMessage());
            throw $e;
        }
    }

    public function getAllAdmins()
    {
        return $this->db->query("SELECT * FROM admin_tb ORDER BY admin_name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAdminProfile($adminId, $data, $files)
    {
        $sets = ["admin_name = ?"];
        $params = [$data['admin_name']];

        // Handle Password Update
        if (!empty($data['new_password'])) {
            $sets[] = "admin_password = ?";
            $params[] = password_hash($data['new_password'], PASSWORD_DEFAULT);
        }

        // Handle Profile Picture
        if (isset($files['profile_pic']) && $files['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadPath = 'images/admin/';
            if (!is_dir(ROOT_PATH . '/' . $uploadPath)) mkdir(ROOT_PATH . '/' . $uploadPath, 0777, true);

            $name = time() . '_' . basename($files['profile_pic']['name']);
            if (move_uploaded_file($files['profile_pic']['tmp_name'], ROOT_PATH . '/' . $uploadPath . $name)) {
                $sets[] = "profile_pic = ?";
                $params[] = $uploadPath . $name;
                // Update session
                $_SESSION['admin_profile_pic'] = $uploadPath . $name;
            }
        }

        $params[] = $adminId;
        $sql = "UPDATE admin_tb SET " . implode(', ', $sets) . " WHERE admin_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function getSocialLinks()
    {
        return $this->db->query("SELECT * FROM social_links ORDER BY platform ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSocialLinks($links)
    {
        $stmt = $this->db->prepare("UPDATE social_links SET url = ? WHERE platform = ?");
        foreach ($links as $platform => $url) {
            $stmt->execute([$url, $platform]);
        }
        return true;
    }

    public function toggleMemberStatus($id)
    {
        $member = $this->getById('members', 'id', $id);
        if (!$member) return false;

        $newStatus = ($member['status'] === 'Suspended') ? 'Active' : 'Suspended';
        $stmt = $this->db->prepare("UPDATE members SET status = ? WHERE id = ?");
        $result = $stmt->execute([$newStatus, $id]);

        if ($result && $newStatus === 'Active') {
            // Automatically resolve any pending suspension reviews
            $stmt = $this->db->prepare("UPDATE suspension_reviews SET status = 'Resolved' WHERE member_id = ? AND status = 'Pending'");
            $stmt->execute([$id]);
        }

        return $result;
    }

    public function getSuspensionReviews()
    {
        return $this->db->query("
            SELECT sr.*, m.name, m.username, m.email
            FROM suspension_reviews sr
            JOIN members m ON sr.member_id = m.id
            ORDER BY sr.created_at DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteRecord($type, $id)
    {
        $allowedTypes = [
            'service' => ['table' => 'services_tb', 'pk' => 'id'],
            'project' => ['table' => 'projects_tb', 'pk' => 'project_id'],
            'event' => ['table' => 'events', 'pk' => 'event_id'],
            'training' => ['table' => 'trainings_tb', 'pk' => 'id'],
            'blog' => ['table' => 'blogs', 'pk' => 'uuid'],
            'banner' => ['table' => 'banners_tb', 'pk' => 'banner_id'],
            'member' => ['table' => 'members', 'pk' => 'id'],
            'faq' => ['table' => 'faq_tb', 'pk' => 'faq_id'],
            'testimonial' => ['table' => 'testimonials_tb', 'pk' => 'id']
        ];
        if (!isset($allowedTypes[$type])) return false;
        $table = $allowedTypes[$type]['table'];
        $pk = $allowedTypes[$type]['pk'];
        $stmt = $this->db->prepare("DELETE FROM $table WHERE $pk = ?");
        return $stmt->execute([$id]);
    }
}
