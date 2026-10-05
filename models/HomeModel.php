<?php
class HomeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getContactDetails() {
        $query = "SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBanners() {
        try {
            $query = "SELECT * FROM `banners_tb` ORDER BY banner_id DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($banners as &$banner) {
                if (!empty($banner['banner_image'])) {
                    $path = $banner['banner_image'];
                    // If it's not an external URL and doesn't already contain a path prefix
                    if (!preg_match('#^https?://#i', $path) && strpos($path, '/') === false) {
                        // Check multiple possible locations for legacy images
                        if (file_exists(ROOT_PATH . '/images/banners/' . $path)) {
                            $banner['banner_image'] = 'images/banners/' . $path;
                        } elseif (file_exists(ROOT_PATH . '/img/' . $path)) {
                            $banner['banner_image'] = 'img/' . $path;
                        } else {
                            $banner['banner_image'] = 'images/banners/' . $path;
                        }
                    }
                }
            }
            return $banners;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAboutInfo() {
        $query = "SELECT * FROM `about_info` WHERE id BETWEEN 1 AND 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServices() {
        // Fallback for when columns don't exist yet (prevent total page crash)
        try {
            $query = "SELECT * FROM `services_tb` WHERE `show_on_home` = 1 ORDER BY sort_order ASC, id DESC LIMIT 6";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $this->conn->query("SELECT * FROM `services_tb` ORDER BY id DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getProjects($limit = 6, $onlyFeatured = true) {
        try {
            $where = $onlyFeatured ? " WHERE p.show_on_home = 1 " : "";
            $limitSql = $limit ? " LIMIT $limit " : "";
            $query = "SELECT p.*, s.service_name
                      FROM projects_tb p
                      LEFT JOIN services_tb s ON p.service_id = s.id
                      $where
                      ORDER BY p.sort_order ASC, p.project_id DESC $limitSql";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $limitSql = $limit ? " LIMIT $limit " : "";
            return $this->conn->query("SELECT p.*, s.service_name FROM projects_tb p LEFT JOIN services_tb s ON p.service_id = s.id ORDER BY p.project_id DESC $limitSql")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getUpcomingEvents() {
        try {
            $query = "SELECT * FROM `events` WHERE LOWER(`event_status`) = 'upcoming' AND `show_on_home` = 1 ORDER BY sort_order ASC, event_date ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $this->conn->query("SELECT * FROM `events` WHERE LOWER(`event_status`) = 'upcoming' ORDER BY event_date ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getLatestEvents() {
        $query = "SELECT * FROM `events` ORDER BY `event_date` DESC LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestimonials() {
        $query = "SELECT * FROM `testimonials_tb` ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $unique = [];
        $filtered = [];
        foreach ($all as $t) {
            // Clean quote strings and fix typos in testimonial text
            $t['testimonial'] = str_replace('SpidersTech', 'SpiderTech', $t['testimonial']);
            $t['testimonial'] = trim(stripslashes($t['testimonial']), " \"'\t\n\r\0\x0B");

            $name = trim($t['name']);
            if (!isset($unique[$name])) {
                $unique[$name] = true;
                $filtered[] = $t;
            }
            if (count($filtered) >= 10) break; // Fetch up to 10 unique ones
        }
        return $filtered;
    }

    public function getStats() {
        $stats = [
            'clients' => 0,
            'hours' => 10000, // Default/Static if no table
            'projects' => 0,
            'locations' => 1
        ];

        try {
            // Get members count for "Happy Clients"
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM members");
            $stmt->execute();
            $stats['clients'] = (int)$stmt->fetchColumn();

            // Get actual projects count
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM projects_tb");
            $stmt->execute();
            $stats['projects'] = (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("HomeModel::getStats error: " . $e->getMessage());
        }

        return $stats;
    }
}
?>