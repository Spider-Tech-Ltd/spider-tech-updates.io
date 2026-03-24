<?php

/**
 * Forum Feed Component (Guest/Public View)
 * Dynamically fetches and displays latest discussions from the database.
 */
require_once __DIR__ . '/../../../config/db.php';

try {
  // Fetch latest published feeds with member and category info
  $stmt = $conn->prepare("
        SELECT f.*, m.name as member_name, c.name as category_name, c.slug as category_slug
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
  function time_ago($timestamp)
  {
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
  /* ====== Discussion List Styles ====== */
  .forum-feed-container {
    display: flex;
    flex-direction: column;
  }

  .feed-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e9ecef;
  }

  .feed-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    color: #111111;
    margin: 0;
  }

  .btn-new-topic {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 10px 20px;
    border-radius: 50px;
    text-decoration: none !important;
    transition: background-color 0.2s;
  }

  .btn-new-topic:hover {
    background-color: #e6751c;
    color: #ffffff;
  }

  /* Tabs */
  .feed-tabs {
    display: flex;
    gap: 24px;
    margin-bottom: 32px;
    border-bottom: 1px solid #f1f3f5;
  }

  .tab-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    color: #797979;
    padding-bottom: 12px;
    text-decoration: none !important;
    position: relative;
    transition: color 0.2s;
  }

  .tab-link:hover {
    color: #f48221;
  }

  .tab-link.active {
    color: #111111;
  }

  .tab-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: #f48221;
    border-radius: 50px;
  }

  /* Discussion Cards */
  .discussion-card-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .discussion-card {
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 16px;
    padding: 20px;
    text-decoration: none !important;
    transition: all 0.2s ease;
    display: block;
  }

  .discussion-card:hover {
    border-color: #f48221;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
  }

  .category-badge {
    display: inline-flex;
    padding: 4px 12px;
    background-color: #f1f3f5;
    color: #495057;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-bottom: 12px;
  }

  .card-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.15rem;
    color: #111111;
    margin-bottom: 12px;
    line-height: 1.4;
  }

  .card-author-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
  }

  .author-avatar-sm {
    width: 24px;
    height: 24px;
    border-radius: 50%;
  }

  .author-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
  }

  .author-time {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: #adb5bd;
    margin-left: auto;
  }

  .card-interaction-bar {
    display: flex;
    align-items: center;
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid #f1f3f5;
  }

  .btn-interact {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    color: #797979;
    background: none;
    border: none;
    padding: 6px 12px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-interact:hover {
    background-color: rgba(244, 130, 33, 0.08);
    color: #f48221;
  }

  .interact-spacer {
    flex: 1;
  }

  /* Pagination */
  .feed-pagination {
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

  /* FAB Mobile */
  .fab-mobile {
    display: none;
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 60px;
    height: 60px;
    background-color: #f48221;
    color: #ffffff;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(244, 130, 33, 0.4);
    z-index: 1000;
  }

  @media (max-width: 768px) {
    .btn-new-topic {
      display: none;
    }

    .fab-mobile {
      display: flex;
    }

    .author-time {
      display: none;
    }
  }
</style>

<div class="forum-feed-container">

  <div class="feed-header">
    <h2 class="feed-title">Latest Discussions</h2>
    <a href="pages/forum/sign-in.php?redirect=pages/forum/feed.php" class="btn-new-topic">
      <span class="material-symbols-outlined">add</span>
      New Topic
    </a>
  </div>

  <div class="feed-tabs">
    <a href="#" class="tab-link active">Latest</a>
    <a href="#" class="tab-link">Top</a>
    <a href="#" class="tab-link">Unanswered</a>
  </div>

  <div class="discussion-card-list">
    <?php if (empty($feeds)): ?>
      <p class="text-center text-muted py-5">No discussions yet. Start one!</p>
    <?php else: ?>
      <?php foreach ($feeds as $feed):
        $avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($feed['member_name']) . "&background=f48221&color=fff";
      ?>
        <a href="pages/forum/sign-in.php?redirect=pages/forum/feed-detail.php?id=<?php echo $feed['uuid']; ?>" class="discussion-card">
          <div class="card-top-row">
            <span class="category-badge">
              <?php echo htmlspecialchars($feed['category_name']); ?>
            </span>
          </div>
          <h3 class="card-title"><?php echo htmlspecialchars($feed['title']); ?></h3>
          <div class="card-author-row">
            <img src="<?php echo $avatarUrl; ?>" class="author-avatar-sm" alt="Avatar">
            <span class="author-name"><?php echo htmlspecialchars($feed['member_name']); ?></span>
            <span class="author-time"><?php echo time_ago($feed['created_at']); ?></span>
          </div>
          <div class="card-interaction-bar">
            <div class="btn-interact">
              <span class="material-symbols-outlined">thumb_up</span>
              <span class="vote-count">0</span>
            </div>
            <div class="btn-interact">
              <span class="material-symbols-outlined">chat_bubble</span>
              <span>0</span>
            </div>
            <div class="interact-spacer"></div>
            <div class="btn-interact">
              <span class="material-symbols-outlined">bookmark</span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="feed-pagination">
    <a href="pages/forum/sign-in.php" class="pag-btn">
      <span class="material-symbols-outlined">chevron_left</span> Previous
    </a>
    <span class="pag-info">Page 1 of 1</span>
    <a href="pages/forum/sign-in.php" class="pag-btn">
      Next <span class="material-symbols-outlined">chevron_right</span>
    </a>
  </div>

  <a href="pages/forum/sign-in.php" class="fab-mobile">
    <span class="material-symbols-outlined">edit</span>
  </a>

</div>