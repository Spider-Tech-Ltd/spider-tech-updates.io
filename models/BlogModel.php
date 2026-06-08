<?php

class BlogModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBlogs($category_slug = null) {
        $query = "SELECT b.*, c.name as category_name, c.slug as category_slug
                  FROM blogs b
                  JOIN blog_categories c ON (b.category_id = c.id OR b.category_id = c.uuid)
                  WHERE b.status = 'published'";

        $params = [];
        if ($category_slug && $category_slug !== 'all') {
            $query .= " AND c.slug = :category_slug";
            $params[':category_slug'] = $category_slug;
        }

        $query .= " ORDER BY b.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBlogBySlug($slug) {
        $stmt = $this->db->prepare("SELECT b.*, c.name as category_name, c.slug as category_slug
                                    FROM blogs b
                                    JOIN blog_categories c ON (b.category_id = c.id OR b.category_id = c.uuid)
                                    WHERE b.slug = :slug AND b.status = 'published'
                                    LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedBlogs($category_id, $exclude_id, $limit = 2) {
        $stmt = $this->db->prepare("SELECT b.*, c.name as category_name, c.slug as category_slug
                                    FROM blogs b
                                    JOIN blog_categories c ON (b.category_id = c.id OR b.category_id = c.uuid)
                                    WHERE b.category_id = :category_id
                                    AND b.id != :exclude_id
                                    AND b.status = 'published'
                                    ORDER BY RAND()
                                    LIMIT :limit");
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $exclude_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
