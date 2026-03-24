<?php
/**
 * Dynamic Forum Feed Component
 * Fetches and displays feeds from the database with category filtering.
 */
require_once __DIR__ . '/../../../config/db.php';

$categoryFilter = $_GET['category'] ?? 'all';

try {
    $sql = "
        SELECT f.*, m.name as member_name, c.name as category_name, c.slug as category_slug
        FROM feeds f
        JOIN members m ON f.member_id = m.id
        JOIN categories c ON f.category_uuid = c.uuid
        WHERE f.status = 'published'
    ";

    $params = [];
    if ($categoryFilter !== 'all') {
        $sql .= " AND c.slug = ?";
        $params[] = $categoryFilter;
    }

    $sql .= " ORDER BY f.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $feeds = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Feed Fetch Error: " . $e->getMessage());
    $feeds = [];
}

if (!function_exists('time_ago')) {
    function time_ago($timestamp) {
        $time = strtotime($timestamp);
        $diff = time() - $time;
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return round($diff / 60) . ' mins ago';
        if ($diff < 86400) return round($diff / 3600) . ' hours ago';
        if ($diff < 604800) return round($diff / 86400) . ' days ago';
        return date('M j, Y', $time);
    }
}
?>

<style>
  /* ====== Discussion Card List Styles ====== */
  .discussion-card-list { display: flex; flex-direction: column; gap: 20px; }

  .discussion-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    display: block;
    text-decoration: none !important;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
  }
  .discussion-card:hover { border-color: #f48221; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transform: translateY(-2px); }

  .category-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 16px;
    background: #f1f5f9; color: #64748b;
  }

  .card-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.35rem;
    line-height: 1.4;
    color: #1e293b;
    margin-bottom: 12px;
  }
  .card-excerpt {
    font-family: 'Open Sans', sans-serif;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .card-author-row { display: flex; align-items: center; gap: 12px; }
  .author-avatar-sm { width: 32px; height: 32px; border-radius: 50%; }
  .author-name { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem; color: #1e293b; }
  .author-time { font-family: 'Open Sans', sans-serif; font-size: 0.8rem; color: #94a3b8; margin-left: auto; }

  .card-interaction-bar {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
  }
  .btn-interact {
    background: none;
    border: none;
    display: flex;
    align-items: center;
    gap: 6px;
    color: #94a3b8;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 6px 12px;
    border-radius: 50px;
    text-decoration: none !important;
  }
  .btn-interact:hover { background-color: rgba(244, 130, 33, 0.08); color: #f48221; }
  .btn-interact .material-symbols-outlined { font-size: 18px; }
  .interact-spacer { flex: 1; }

  /* Pagination — Styled to match Guest Feed */
  .member-feed-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 40px;
  }

  .pag-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #f48221;
    background: none;
    border: 1.5px solid #f48221;
    padding: 8px 18px;
    border-radius: 50px;
    transition: all 0.2s ease;
    text-decoration: none !important;
  }

  .pag-btn:hover {
    background-color: #f48221;
    color: #ffffff;
  }

  .pag-info {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #797979;
  }

  .empty-feed {
    text-align: center;
    padding: 60px 20px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
  }
  .empty-icon { font-size: 48px; color: #94a3b8; margin-bottom: 16px; display: block; }
</style>

<div class="discussion-card-list">

  <?php if (empty($feeds)): ?>
    <div class="empty-feed">
        <span class="material-symbols-outlined empty-icon">forum</span>
        <h4>No discussions found</h4>
        <p class="text-muted">Be the first to start a conversation in this category!</p>
        <a href="pages/forum/new-topic.php" class="btn btn-outline-primary mt-3">Start Discussion</a>
    </div>
  <?php else: ?>
      <?php foreach ($feeds as $feed):
          $avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($feed['member_name']) . "&background=f48221&color=fff";
      ?>
      <a href="pages/forum/feed-detail.php?id=<?php echo $feed['uuid']; ?>" class="discussion-card">
        <div class="card-top-row">
          <span class="category-badge">
            <?php echo htmlspecialchars($feed['category_name']); ?>
          </span>
        </div>

        <h3 class="card-title"><?php echo htmlspecialchars($feed['title']); ?></h3>

        <p class="card-excerpt">
            <?php echo nl2br(htmlspecialchars($feed['content'])); ?>
        </p>

        <div class="card-author-row">
          <img src="<?php echo $avatarUrl; ?>" class="author-avatar-sm" alt="Avatar">
          <span class="author-name"><?php echo htmlspecialchars($feed['member_name']); ?></span>
          <span class="author-time"><?php echo time_ago($feed['created_at']); ?></span>
        </div>

        <div class="card-interaction-bar">
          <div class="btn-interact" title="Upvote">
            <span class="material-symbols-outlined">thumb_up</span>
            <span class="vote-count">0</span>
          </div>
          <div class="btn-interact" title="Replies">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span>0</span>
          </div>
          <div class="interact-spacer"></div>
          <div class="btn-interact" title="Bookmark">
            <span class="material-symbols-outlined">bookmark</span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
  <?php endif; ?>

</div>

<!-- Pagination -->
<div class="member-feed-pagination">
  <a href="#" class="pag-btn">
    <span class="material-symbols-outlined">chevron_left</span> Previous
  </a>
  <span class="pag-info">Page 1 of 1</span>
  <a href="#" class="pag-btn">
    Next <span class="material-symbols-outlined">chevron_right</span>
  </a>
</div>

<!-- Mobile FAB -->
<a href="pages/forum/new-topic.php" class="member-fab-mobile d-md-none position-fixed bottom-0 end-0 m-4" style="z-index:1000;">
  <div class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color:#f48221; border:none;">
    <span class="material-symbols-outlined text-white">edit</span>
  </div>
</a>
