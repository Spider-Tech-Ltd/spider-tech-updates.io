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

    public function getFeeds($limit = 10, $member_id = null, $category_filter = null, $sort = 'latest', $page = 1) {
        $where = "WHERE f.status IN ('published')";
        $params = [':member_id' => $member_id];
        $offset = ($page - 1) * $limit;

        if ($category_filter && $category_filter !== 'all') {
            $where .= " AND (c.slug = :cat OR c.uuid = :cat)";
            $params[':cat'] = $category_filter;
        }

        $orderBy = 'f.created_at DESC';
        if ($sort === 'hottest') {
            $orderBy = 'likes DESC, f.created_at DESC';
        }

        $sql = "SELECT f.*, 
                COALESCE(m.name, 'Anonymous') as author_name, 
                COALESCE(m.username, 'anonymous') as author_username, 
                COALESCE(c.name, 'General') as category_name,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid) as likes,
                (SELECT COUNT(*) FROM feed_replies WHERE feed_uuid = f.uuid) as replies_count,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid AND member_id = (SELECT uuid FROM members WHERE id = :member_id)) as is_liked
                FROM feeds f
                LEFT JOIN members m ON f.member_id = m.uuid
                LEFT JOIN categories c ON f.category_uuid = c.uuid
                $where
                ORDER BY $orderBy LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $feeds = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($feeds as &$feed) {
            $feed['replies'] = $this->getReplies($feed['uuid'], $member_id);
        }

        return $feeds;
    }

    public function getTotalFeedCount($category_filter = null) {
        $where = "WHERE status = 'published'";
        $params = [];

        if ($category_filter && $category_filter !== 'all') {
            $where .= " AND category_uuid IN (SELECT uuid FROM categories WHERE slug = :cat OR uuid = :cat)";
            $params[':cat'] = $category_filter;
        }

        $sql = "SELECT COUNT(*) FROM feeds $where";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getReplies($feed_uuid, $member_id = null) {
        $sql = "SELECT r.*, 
                COALESCE(m.name, 'Anonymous') as author_name, 
                COALESCE(m.username, 'anonymous') as author_username,
                (SELECT COUNT(*) FROM reply_likes WHERE reply_uuid = r.uuid) as likes,
                (SELECT COUNT(*) FROM reply_likes WHERE reply_uuid = r.uuid AND member_id = (SELECT uuid FROM members WHERE id = :member_id)) as is_liked
                FROM feed_replies r
                LEFT JOIN members m ON r.member_id = m.uuid
                WHERE r.feed_uuid = :feed_uuid
                ORDER BY r.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':feed_uuid', $feed_uuid);
        $stmt->bindValue(':member_id', $member_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleLike($feed_uuid, $member_id) {
        $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = :feed_uuid AND member_id = (SELECT uuid FROM members WHERE id = :member_id)");
        $stmt->execute([':feed_uuid' => $feed_uuid, ':member_id' => $member_id]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $this->db->prepare("DELETE FROM feed_likes WHERE id = :id");
            return $stmt->execute([':id' => $like['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO feed_likes (feed_uuid, member_id) VALUES (:feed_uuid, (SELECT uuid FROM members WHERE id = :member_id))");
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
                VALUES (:uuid, :feed_uuid, (SELECT uuid FROM members WHERE id = :member_id), :category_uuid, :content, :parent_uuid)";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
            ':uuid' => $uuid,
            ':feed_uuid' => $feed_uuid,
            ':member_id' => $member_id,
            ':category_uuid' => $feed['category_uuid'],
            ':content' => $content,
            ':parent_uuid' => $parent_uuid
        ])) {
            return $uuid;
        }
        return false;
    }

    public function createTopic($member_id, $category_uuid, $title, $content) {
        $uuid = Utils::generateUUID();
        $sql = "INSERT INTO feeds (uuid, member_id, category_uuid, title, content, status) 
                VALUES (:uuid, (SELECT uuid FROM members WHERE id = :member_id), :category_uuid, :title, :content, :status)";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
            ':uuid' => $uuid,
            ':member_id' => $member_id,
            ':category_uuid' => $category_uuid,
            ':title' => $title,
            ':content' => $content,
            ':status' => 'published'
        ])) {
            return $uuid;
        }
        return false;
    }

    public function getTopic($uuid, $member_id = null) {
        $sql = "SELECT f.*, 
                COALESCE(m.name, 'Anonymous') as author_name, 
                COALESCE(m.username, 'anonymous') as author_username, 
                COALESCE(c.name, 'General') as category_name,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid) as likes,
                (SELECT COUNT(*) FROM feed_replies WHERE feed_uuid = f.uuid) as replies_count,
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid AND member_id = (SELECT uuid FROM members WHERE id = :member_id)) as is_liked
                FROM feeds f
                LEFT JOIN members m ON f.member_id = m.uuid
                LEFT JOIN categories c ON f.category_uuid = c.uuid
                WHERE f.uuid = :uuid AND f.status IN ('published')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':uuid' => $uuid, ':member_id' => $member_id]);
        $topic = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($topic) {
            $topic['replies'] = $this->getReplies($topic['uuid'], $member_id);
        }

        return $topic;
    }

    public function getGlobalStats() {
        $stats = [];
        $stmt = $this->db->query("SELECT COUNT(*) FROM members");
        $stats['total_members'] = $stmt->fetchColumn();

        $stmt = $this->db->query("SELECT COUNT(*) FROM feeds WHERE status = 'published'");
        $stats['total_discussions'] = $stmt->fetchColumn();

        $stmt = $this->db->query("SELECT COUNT(*) FROM feed_replies");
        $stats['total_replies'] = $stmt->fetchColumn();

        return $stats;
    }

    public function getTrendingTopics($limit = 5) {
        $sql = "SELECT f.*, 
                (SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = f.uuid) as likes
                FROM feeds f
                WHERE f.status = 'published'
                ORDER BY likes DESC, f.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMemberStats($member_id) {
        $stats = [];
        
        // 1. Posts made by user
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM feeds WHERE member_id = (SELECT uuid FROM members WHERE id = :mid) AND status = 'published'");
        $stmt->execute([':mid' => $member_id]);
        $stats['post_count'] = $stmt->fetchColumn();

        // 2. Upvotes received (on their posts)
        $sql = "SELECT COUNT(*) FROM feed_likes l 
                JOIN feeds f ON l.feed_uuid = f.uuid 
                WHERE f.member_id = (SELECT uuid FROM members WHERE id = :mid)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':mid' => $member_id]);
        $stats['likes_received'] = $stmt->fetchColumn();
        
        // 3. Replies made by user
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM feed_replies WHERE member_id = (SELECT uuid FROM members WHERE id = :mid)");
        $stmt->execute([':mid' => $member_id]);
        $stats['reply_count'] = $stmt->fetchColumn();

        return $stats;
    }

    public function getTopCategories($limit = 5) {
        $sql = "SELECT c.*, (SELECT COUNT(*) FROM feeds WHERE category_uuid = c.uuid AND status = 'published') as post_count
                FROM categories c
                ORDER BY post_count DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopContributors($limit = 3) {
        $sql = "SELECT m.name, COUNT(f.uuid) as post_count
                FROM members m
                JOIN feeds f ON m.id = f.member_id
                WHERE f.status = 'published'
                GROUP BY m.id
                ORDER BY post_count DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Data-Driven Expansion Methods
     */

    public function getActiveMembers($limit = 5) {
        // Defined as active in the last 5 minutes
        $sql = "SELECT name, uuid, role, last_active_at 
                FROM members 
                WHERE last_active_at > (NOW() - INTERVAL 5 MINUTE)
                ORDER BY last_active_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnreadReplyCount($member_id) {
        // Count replies on the user's topics that are unread
        $sql = "SELECT COUNT(*) 
                FROM feed_replies r
                JOIN feeds f ON r.feed_uuid = f.uuid
                WHERE f.member_id = (SELECT uuid FROM members WHERE id = :id)
                AND r.member_id != (SELECT uuid FROM members WHERE id = :id)
                AND r.is_read = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $member_id]);
        return $stmt->fetchColumn();
    }

    public function markRepliesAsRead($feed_uuid, $member_uuid) {
        // Mark as read only if the viewer is the owner of the topic
        $sql = "UPDATE feed_replies r
                JOIN feeds f ON r.feed_uuid = f.uuid
                SET r.is_read = 1
                WHERE f.uuid = :feed_uuid 
                AND f.member_id = :uuid";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':feed_uuid' => $feed_uuid,
            ':uuid' => $member_uuid
        ]);
    }

    public function toggleReplyLike($reply_uuid, $member_uuid) {
        $stmt = $this->db->prepare("SELECT id FROM reply_likes WHERE reply_uuid = :reply_uuid AND member_id = :member_uuid");
        $stmt->execute([':reply_uuid' => $reply_uuid, ':member_uuid' => $member_uuid]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $this->db->prepare("DELETE FROM reply_likes WHERE id = :id");
            return $stmt->execute([':id' => $like['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO reply_likes (reply_uuid, member_id) VALUES (:reply_uuid, :member_uuid)");
            return $stmt->execute([':reply_uuid' => $reply_uuid, ':member_uuid' => $member_uuid]);
        }
    }
}
