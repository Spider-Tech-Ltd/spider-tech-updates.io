<?php
/**
 * Forum Discussion Feed — Modern Industrial Engineering Feed
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-guest-feed.css?v=<?= filemtime(ROOT_PATH . '/css/forum-guest-feed.css') ?>" />

<div class="forum-feed-container">

  <!-- Feed Header Wrap -->
  <div class="feed-header-wrap">
    <div class="feed-header-meta">
      <div class="feed-eyebrow">
        <span class="eyebrow-accent">|–</span>
        <span>ACTIVE ENGINEERING THREADS</span>
        <span class="eyebrow-accent">–|</span>
      </div>
      <h2 class="feed-title">Latest Discussions</h2>
      <p class="feed-subtitle">Technical troubleshooting, automation integration, and peer insights</p>
    </div>

    <?php if (isset($_SESSION['member_uuid'])): ?>
      <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-new-topic">
        <span class="material-symbols-outlined">add_circle</span>
        <span>Start Discussion</span>
      </a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/forum/sign-in" class="btn-new-topic">
        <span class="material-symbols-outlined">add_circle</span>
        <span>Start Discussion</span>
      </a>
    <?php endif; ?>
  </div>

  <!-- Discussion List -->
  <div class="discussion-card-list">
    <?php if (!empty($feeds)): ?>
      <?php foreach ($feeds as $feed): ?>
        <a href="<?= BASE_URL ?>/forum/discussion?uuid=<?= urlencode($feed['uuid'] ?? ''); ?>" class="discussion-card <?= ($feed['is_pinned'] ?? false) ? 'is-pinned' : ''; ?>">
          
          <!-- Card Top Row: Category + Badges + Date -->
          <div class="card-meta-top">
            <div class="card-badges-group">
              <span class="card-category-pill"><?= htmlspecialchars($feed['category_name'] ?? 'General'); ?></span>
              <?php if ($feed['is_pinned'] ?? false): ?>
                <span class="badge-pinned-tag">
                  <span class="material-symbols-outlined">push_pin</span>
                  <span>Pinned</span>
                </span>
              <?php endif; ?>
              <?php if ($feed['is_hot'] ?? false): ?>
                <span class="badge-hot-tag">
                  <span class="material-symbols-outlined">local_fire_department</span>
                  <span>Trending</span>
                </span>
              <?php endif; ?>
            </div>
            
            <div class="card-timestamp">
              <span class="material-symbols-outlined">schedule</span>
              <span><?= date('M j, Y', strtotime($feed['created_at'])); ?></span>
            </div>
          </div>

          <!-- Title -->
          <h3 class="card-title"><?= htmlspecialchars($feed['title']); ?></h3>

          <!-- Excerpt -->
          <p class="card-excerpt">
            <?= htmlspecialchars(mb_substr(strip_tags($feed['content'] ?? ''), 0, 240)) ?>...
          </p>

          <!-- Card Bottom Row: Author + Interaction Stats + View Action -->
          <div class="card-bottom-bar">
            <!-- Author Identity -->
            <div class="card-author-identity">
              <?php 
                $authorName = htmlspecialchars($feed['author_name'] ?? 'Member');
                $avatarUrl = !empty($feed['author_avatar']) ? BASE_URL . $feed['author_avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($authorName) . "&background=f48221&color=fff&size=34";
              ?>
              <img src="<?= $avatarUrl ?>" class="author-avatar-img" alt="<?= $authorName ?>">
              <div class="author-details">
                <span class="author-name-text"><?= $authorName ?></span>
                <span class="author-role-label">Verified Member</span>
              </div>
            </div>

            <!-- Interactions & Link -->
            <div class="card-action-cluster">
              <div class="stat-counter-chip" title="Upvotes">
                <span class="material-symbols-outlined stat-icon">thumb_up</span>
                <span class="stat-number"><?= $feed['likes'] ?? ($feed['upvotes'] ?? 0); ?></span>
              </div>
              <div class="stat-counter-chip" title="Replies">
                <span class="material-symbols-outlined stat-icon">chat_bubble</span>
                <span class="stat-number"><?= $feed['replies_count'] ?? (is_array($feed['replies'] ?? null) ? count($feed['replies']) : 0); ?></span>
              </div>
              <div class="view-thread-cta">
                <span>View Thread</span>
                <span class="material-symbols-outlined">arrow_forward</span>
              </div>
            </div>
          </div>

        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Empty State -->
      <div class="discussion-empty-card">
        <span class="material-symbols-outlined empty-icon">forum</span>
        <h4 class="empty-title">No Discussions in This Category Yet</h4>
        <p class="empty-subtext">Be the first engineer to start a conversation in this topic hub.</p>
        <a href="<?= isset($_SESSION['member_uuid']) ? BASE_URL . '/forum/new-topic' : BASE_URL . '/forum/sign-in' ?>" class="btn-empty-create">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start First Discussion</span>
        </a>
      </div>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <?php if (($total_pages ?? 1) > 1): ?>
  <div class="feed-pagination">
    <?php if (($current_page ?? 1) > 1): ?>
      <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($_GET['category'] ?? 'all') ?>&sort=<?= urlencode($_GET['sort'] ?? 'latest') ?>&page=<?= ($current_page - 1) ?>#feedSection" class="pag-btn">
        <span class="material-symbols-outlined">chevron_left</span> Previous
      </a>
    <?php endif; ?>
    <span class="pag-info">Page <?= $current_page ?? 1 ?> of <?= $total_pages ?? 1 ?></span>
    <?php if (($current_page ?? 1) < ($total_pages ?? 1)): ?>
      <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($_GET['category'] ?? 'all') ?>&sort=<?= urlencode($_GET['sort'] ?? 'latest') ?>&page=<?= ($current_page + 1) ?>#feedSection" class="pag-btn">
        Next <span class="material-symbols-outlined">chevron_right</span>
      </a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</div>
