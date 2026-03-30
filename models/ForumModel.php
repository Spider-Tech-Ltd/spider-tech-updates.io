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

    public function getFeeds($limit = 10, $member_uuid = null) {
        $sql = "SELECT f.*, m.name as author_name, m.username as author_username, c.name as category_name,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid) as upvotes,
                (SELECT COUNT(*) FROM feed_replies WHERE feed_uuid = f.uuid) as replies_count,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid AND member_id = :member_uuid) as is_liked
                FROM feeds f
                JOIN members m ON f.member_id = m.uuid
                JOIN categories c ON f.category_uuid = c.uuid
                WHERE f.status = 'active'
                ORDER BY f.created_at DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':member_uuid', $member_uuid);
        $stmt->execute();
        $feeds = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($feeds as &$feed) {
            $feed['replies'] = $this->getReplies($feed['uuid']);
        }

        return $feeds;
    }

    public function getReplies($feed_uuid) {
        $sql = "SELECT r.*, m.name as author_name, m.username as author_username
                FROM feed_replies r
                JOIN members m ON r.member_id = m.uuid
                WHERE r.feed_uuid = :feed_uuid AND r.status = 'active'
                ORDER BY r.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':feed_uuid', $feed_uuid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleLike($feed_uuid, $member_uuid) {
        $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = :feed_uuid AND member_id = :member_uuid");
        $stmt->execute([':feed_uuid' => $feed_uuid, ':member_uuid' => $member_uuid]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $this->db->prepare("DELETE FROM feed_likes WHERE id = :id");
            return $stmt->execute([':id' => $like['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO feed_likes (feed_uuid, member_id) VALUES (:feed_uuid, :member_uuid)");
            return $stmt->execute([':feed_uuid' => $feed_uuid, ':member_uuid' => $member_uuid]);
        }
    }

    public function addReply($feed_uuid, $member_uuid, $content) {
        // Get category_uuid from feed
        $stmt = $this->db->prepare("SELECT category_uuid FROM feeds WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $feed_uuid]);
        $feed = $stmt->fetch();
        if (!$feed) return false;

        $uuid = $this->generateUUID();
        $sql = "INSERT INTO feed_replies (uuid, feed_uuid, member_id, category_uuid, content)
                VALUES (:uuid, :feed_uuid, :member_uuid, :category_uuid, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uuid' => $uuid,
            ':feed_uuid' => $feed_uuid,
            ':member_uuid' => $member_uuid,
            ':category_uuid' => $feed['category_uuid'],
            ':content' => $content
        ]);
    }

    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
