<?php
/**
 * Feed Actions Helper Class
 * Handles Likes and Replies for forum feeds.
 */
require_once 'Utils.php';

class FeedActions {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Toggles a like for a feed by a member
     */
    public function toggleLike($feedUuid, $memberId) {
        try {
            // Check if already liked
            $stmt = $this->db->prepare("SELECT id FROM feed_likes WHERE feed_uuid = ? AND member_id = ?");
            $stmt->execute([$feedUuid, $memberId]);
            $like = $stmt->fetch();

            if ($like) {
                // Unlike
                $del = $this->db->prepare("DELETE FROM feed_likes WHERE id = ?");
                $del->execute([$like['id']]);
                return ["status" => "success", "action" => "unliked", "count" => $this->getLikesCount($feedUuid)];
            } else {
                // Like
                $ins = $this->db->prepare("INSERT INTO feed_likes (feed_uuid, member_id) VALUES (?, ?)");
                $ins->execute([$feedUuid, $memberId]);
                return ["status" => "success", "action" => "liked", "count" => $this->getLikesCount($feedUuid)];
            }
        } catch (PDOException $e) {
            error_log("Like Toggle Error: " . $e->getMessage());
            return ["status" => "error", "message" => "Could not process like."];
        }
    }

    /**
     * Adds a reply to a feed
     */
    public function addReply($feedUuid, $memberId, $content) {
        if (empty(trim($content))) {
            return ["status" => "error", "message" => "Reply content cannot be empty."];
        }

        try {
            $uuid = Utils::generateUUID();
            $stmt = $this->db->prepare("INSERT INTO feed_replies (uuid, feed_uuid, member_id, content) VALUES (?, ?, ?, ?)");
            $stmt->execute([$uuid, $feedUuid, $memberId, $content]);

            return [
                "status" => "success",
                "message" => "Reply posted.",
                "reply" => [
                    "uuid" => $uuid,
                    "content" => htmlspecialchars($content),
                    "created_at" => "Just now"
                ],
                "count" => $this->getRepliesCount($feedUuid)
            ];
        } catch (PDOException $e) {
            error_log("Add Reply Error: " . $e->getMessage());
            return ["status" => "error", "message" => "Could not post reply."];
        }
    }

    /**
     * Get total likes for a feed
     */
    public function getLikesCount($feedUuid) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = ?");
        $stmt->execute([$feedUuid]);
        return $stmt->fetchColumn();
    }

    /**
     * Get total replies for a feed
     */
    public function getRepliesCount($feedUuid) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM feed_replies WHERE feed_uuid = ?");
        $stmt->execute([$feedUuid]);
        return $stmt->fetchColumn();
    }

    /**
     * Get all replies for a feed with member info
     */
    public function getReplies($feedUuid) {
        $stmt = $this->db->prepare("
            SELECT r.*, m.username, m.uuid as member_uuid
            FROM feed_replies r
            JOIN members m ON r.member_id = m.id
            WHERE r.feed_uuid = ?
            ORDER BY r.created_at ASC
        ");
        $stmt->execute([$feedUuid]);
        return $stmt->fetchAll();
    }

    /**
     * Check if a member has liked a specific feed
     */
    public function hasMemberLiked($feedUuid, $memberId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM feed_likes WHERE feed_uuid = ? AND member_id = ?");
        $stmt->execute([$feedUuid, $memberId]);
        return $stmt->fetchColumn() > 0;
    }
}
