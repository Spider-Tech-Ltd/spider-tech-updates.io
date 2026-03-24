<?php
/**
 * Forum Feed Component (Guest/Public View)
 * Dynamically fetches and displays latest discussions from the database.
 * Now shows Like and Reply counts (Read-only for guests).
 */
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../auth/FeedActions.php';

$feedActions = new FeedActions($conn);

try {
    $stmt = $conn->prepare("
        SELECT f.*, m.username as member_name, c.name as category_name
        FROM feeds f
        JOIN members m ON f.member_id = m.id
        JOIN categories c ON f.category_uuid = c.uuid
        WHERE f.status = 'published'
        ORDER BY f.created_at DESC
        LIMIT 5
    ");
    $stmt->execute();
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
  .forum-feed-container { display: flex; flex-direction: column; }
  .feed-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e9ecef; }
  .feed-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #111111; margin: 0; }

  .btn-new-topic { display: inline-flex; align-items: center; gap: 8px; background-color: #f48221; color: #ffffff; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem; padding: 10px 20px; border-radius: 50px; text-decoration: none !important; }
  .tab-link { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.95rem; color: #797979; padding-bottom: 12px; text-decoration: none !important; position: relative; }
  .tab-link.active { color: #111111; }
  .tab-link.active::after { content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 3px; background-color: #f48221; border-radius: 50px; }

  .discussion-card { background-color: #ffffff; border: 1px solid #e9ecef; border-radius: 16px; padding: 20px; text-decoration: none !important; transition: all 0.2s ease; display: block; margin-bottom: 16px; }
  .discussion-card:hover { border-color: #f48221; transform: translateY(-2px); }

  .category-badge { display: inline-flex; padding: 4px 12px; background-color: #f1f3f5; color: #495057; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 12px; }
  .card-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.15rem; color: #111111; margin-bottom: 12px; }
  .card-author-row { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
  .author-avatar-sm { width: 24px; height: 24px; border-radius: 50%; }
  .author-name { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.85rem; color: #495057; }
  .author-time { font-family: 'Open Sans', sans-serif; font-size: 0.8rem; color: #adb5bd; margin-left: auto; }

  .card-interaction-bar { display: flex; align-items: center; gap: 16px; padding-top: 16px; border-top: 1px solid #f1f3f5; }
  .btn-interact { display: inline-flex; align-items: center; gap: 6px; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.78rem; color: #797979; }
  .interact-spacer { flex: 1; }
</style>

<div class="forum-feed-container">
  <div class="feed-header">
    <h2 class="feed-title">Latest Discussions</h2>
    <a href="pages/forum/sign-in.php" class="btn-new-topic">
      <span class="material-symbols-outlined">add</span> New Topic
    </a>
  </div>

  <div class="discussion-card-list">
    <?php foreach ($feeds as $f):
        $likes = $feedActions->getLikesCount($f['uuid']);
        $replies = $feedActions->getRepliesCount($f['uuid']);
    ?>
    <a href="pages/forum/sign-in.php" class="discussion-card">
      <div class="card-top-row">
        <span class="category-badge"><?php echo htmlspecialchars($f['category_name']); ?></span>
      </div>
      <h3 class="card-title"><?php echo htmlspecialchars($f['title']); ?></h3>
      <div class="card-author-row">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($f['member_name']); ?>&background=f48221&color=fff" class="author-avatar-sm" alt="AV">
        <span class="author-name"><?php echo htmlspecialchars($f['member_name']); ?></span>
        <span class="author-time"><?php echo time_ago($f['created_at']); ?></span>
      </div>
      <div class="card-interaction-bar">
        <div class="btn-interact"><span class="material-symbols-outlined">thumb_up</span> <?php echo $likes; ?></div>
        <div class="btn-interact"><span class="material-symbols-outlined">chat_bubble</span> <?php echo $replies; ?></div>
        <div class="interact-spacer"></div>
        <div class="btn-interact"><span class="material-symbols-outlined">bookmark</span></div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</div>
