<?php
/**
 * Feed Banner — Member Welcome Banner
 * Compact slim banner visible only to logged-in members.
 * Now dynamically driven by database stats.
 */
require_once __DIR__ . '/../../../config/db.php';

try {
    // 1. Total Members Count
    $stmtMembers = $conn->query("SELECT COUNT(*) FROM members");
    $totalMembers = $stmtMembers->fetchColumn();

    // 2. Total Discussions (Feeds) Count
    $stmtFeeds = $conn->query("SELECT COUNT(*) FROM feeds WHERE status = 'published'");
    $totalDiscussions = $stmtFeeds->fetchColumn();

    // 3. Current Member Post Count
    $memberPostCount = 0;
    if (isset($_SESSION['member_id'])) {
        $stmtMyPosts = $conn->prepare("SELECT COUNT(*) FROM feeds WHERE member_id = ?");
        $stmtMyPosts->execute([$_SESSION['member_id']]);
        $memberPostCount = $stmtMyPosts->fetchColumn();
    }
} catch (PDOException $e) {
    error_log("Banner Stats Error: " . $e->getMessage());
    $totalMembers = '...';
    $totalDiscussions = '...';
    $memberPostCount = 0;
}
?>

<style>
  /* ============================
     FEED BANNER
     ============================ */
  .feed-member-banner {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 28px 0;
    position: relative;
    overflow: hidden;
  }

  /* Subtle geometric background lines */
  .feed-member-banner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image:
      linear-gradient(rgba(244, 130, 33, 0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(244, 130, 33, 0.04) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
  }

  /* Orange accent line at top */
  .feed-member-banner::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f48221, #e6751c 60%, transparent);
  }

  .banner-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    position: relative;
    z-index: 1;
  }

  .banner-greeting {
    font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 1.6rem;
    color: #111111;
    margin-bottom: 4px;
    line-height: 1.2;
    letter-spacing: -0.02em;
  }

  .banner-greeting span {
    color: #f48221;
  }

  .banner-subtitle {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.9rem;
    color: #555555;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .banner-subtitle .notif-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background-color: rgba(244, 130, 33, 0.1);
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.72rem;
    padding: 2px 10px;
    border-radius: 50px;
  }

  .banner-cta-group {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
  }

  .btn-start-discussion {
    background: linear-gradient(135deg, #f48221, #e6751c);
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 12px 28px;
    border-radius: 50px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(244, 130, 33, 0.3);
    transition: all 0.25s ease;
    text-decoration: none !important;
    white-space: nowrap;
  }

  .btn-start-discussion:hover {
    background: linear-gradient(135deg, #e6751c, #d9690e);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(244, 130, 33, 0.4);
  }

  .btn-start-discussion .material-symbols-outlined {
    font-size: 18px;
  }

  .banner-stats {
    display: flex;
    align-items: center;
    gap: 24px;
    margin-top: 14px;
  }

  .banner-stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: #797979;
  }

  .banner-stat .material-symbols-outlined {
    font-size: 16px;
    color: #f48221;
  }

  .banner-stat strong {
    color: #111111;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
  }

  .banner-stat-divider {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background-color: #d6d6d6;
  }

  @media (max-width: 768px) {
    .banner-inner {
      flex-direction: column;
      align-items: flex-start;
    }
    .banner-greeting { font-size: 1.3rem; }
    .btn-start-discussion { width: 100%; justify-content: center; }
    .banner-cta-group { width: 100%; }
    .banner-stats { flex-wrap: wrap; gap: 12px; }
  }
</style>

<section class="feed-member-banner">
  <div class="container">
    <div class="banner-inner">

      <!-- Left: Welcome Text -->
      <div class="banner-text-group">
        <h2 class="banner-greeting">
          Welcome back, <span><?php echo htmlspecialchars($_SESSION['member_name'] ?? 'Member'); ?></span>. 👋
        </h2>
        <p class="banner-subtitle">
          Stay ahead of the curve.
          <?php if (isset($member['new_replies']) && $member['new_replies'] > 0): ?>
            <span class="notif-pill">
              <span class="material-symbols-outlined" style="font-size:12px;">chat_bubble</span>
              <?php echo $member['new_replies']; ?> new replies
            </span>
          <?php endif; ?>
        </p>

        <!-- Quick stats -->
        <div class="banner-stats">
          <div class="banner-stat">
            <span class="material-symbols-outlined">article</span>
            <strong><?php echo $memberPostCount; ?></strong> Posts
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">people</span>
            <strong><?php echo number_format($totalMembers); ?></strong> Members
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">forum</span>
            <strong><?php echo number_format($totalDiscussions); ?></strong> Discussions
          </div>
        </div>
      </div>

      <!-- Right: CTA -->
      <div class="banner-cta-group">
        <a href="pages/forum/new-topic.php" class="btn-start-discussion">
          <span class="material-symbols-outlined">edit</span>
          Start a Discussion
        </a>
      </div>

    </div>
  </div>
</section>
