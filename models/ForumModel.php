<?php

class ForumModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeeds($limit = 10, $member_id = null, $category_filter = null, $sort = 'latest') {
        $where = "WHERE f.status IN ('active', 'published')";
        $params = [':member_id' => $member_id];

        if ($category_filter && $category_filter !== 'all') {
            $where .= " AND (c.slug = :cat OR c.uuid = :cat)";
            $params[':cat'] = $category_filter;
        }

        $orderBy = 'f.created_at DESC';
        if ($sort === 'hottest') {
            $orderBy = 'upvotes DESC, f.created_at DESC';
        }

        $sql = "SELECT f.*, 
                COALESCE(m.name, 'Anonymous') as author_name, 
                COALESCE(m.username, 'anonymous') as author_username, 
                COALESCE(c.name, 'General') as category_name,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid) as upvotes,
                (SELECT COUNT(*) FROM feed_replies WHERE feed_uuid = f.uuid) as replies_count,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid AND member_id = :member_id) as is_liked
                FROM feeds f
                LEFT JOIN members m ON f.member_id = m.id
                LEFT JOIN categories c ON f.category_uuid = c.uuid
                $where
                ORDER BY $orderBy LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $feeds = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($feeds as &$feed) {
            $feed['replies'] = $this->getReplies($feed['uuid']);
        }

        return $feeds;
    }

    public function getReplies($feed_uuid) {
        $sql = "SELECT r.*, 
                COALESCE(m.name, 'Anonymous') as author_name, 
                COALESCE(m.username, 'anonymous') as author_username
                FROM feed_replies r
                LEFT JOIN members m ON r.member_id = m.id
                WHERE r.feed_uuid = :feed_uuid
                ORDER BY r.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':feed_uuid', $feed_uuid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleLike($feed_uuid, $member_id) {
        $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = :feed_uuid AND member_id = :member_id");
        $stmt->execute([':feed_uuid' => $feed_uuid, ':member_id' => $member_id]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $this->db->prepare("DELETE FROM feed_likes WHERE id = :id");
            return $stmt->execute([':id' => $like['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO feed_likes (feed_uuid, member_id) VALUES (:feed_uuid, :member_id)");
            return $stmt->execute([':feed_uuid' => $feed_uuid, ':member_id' => $member_id]);
        }
    }

    public function addReply($feed_uuid, $member_id, $content, $parent_uuid = null) {
        // Get category_uuid from feed
        $stmt = $this->db->prepare("SELECT category_uuid FROM feeds WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $feed_uuid]);
        $feed = $stmt->fetch();
        if (!$feed) return false;

        $uuid = Utils::generateUUID();
        $sql = "INSERT INTO feed_replies (uuid, feed_uuid, member_id, category_uuid, content, parent_uuid)
                VALUES (:uuid, :feed_uuid, :member_id, :category_uuid, :content, :parent_uuid)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uuid' => $uuid,
            ':feed_uuid' => $feed_uuid,
            ':member_id' => $member_id,
            ':category_uuid' => $feed['category_uuid'],
            ':content' => $content,
            ':parent_uuid' => $parent_uuid
        ]);
    }

    public function createTopic($member_id, $category_uuid, $title, $content) {
        $uuid = Utils::generateUUID();
        $sql = "INSERT INTO feeds (uuid, member_id, category_uuid, title, content, status) 
                VALUES (:uuid, :member_id, :category_uuid, :title, :content, 'active')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uuid' => $uuid,
            ':member_id' => $member_id,
            ':category_uuid' => $category_uuid,
            ':title' => $title,
            ':content' => $content
        ]);
    }
}
