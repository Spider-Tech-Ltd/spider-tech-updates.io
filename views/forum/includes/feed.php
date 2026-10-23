<?php
/**
 * Forum Discussion Feed — Phase 4 Upgraded
 * Features: Pinned thread, Hot badges, Last-reply metadata, Tabs, Pagination
 * Translated from Stitch MCP (screen: 4400a3d263fa46b7bf31877d46d5fb8a)
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-guest-feed.css" />

<div class="forum-feed-container">

  <!-- Feed Header -->
  <div class="feed-header">
    <h2 class="feed-title">Latest Discussions</h2>
    <a href="<?= BASE_URL ?>/forum/sign-in" class="btn-new-topic">
      <span class="material-symbols-outlined">add</span>
      New Topic
    </a>
  </div>


  <!-- Discussion List -->
  <div class="discussion-card-list">
    <?php if (!empty($feeds)): ?>
      <?php foreach ($feeds as $feed): ?>
        <a href="<?= BASE_URL ?>/forum/sign-in" class="discussion-card <?= ($feed['is_pinned'] ?? false) ? 'is-pinned' : ''; ?> <?= ($feed['is_hot'] ?? false) ? 'is-hot' : ''; ?>">
          <div class="card-top-row">
            <span class="category-badge"><?= htmlspecialchars($feed['category_name'] ?? 'General'); ?></span>
            <?php if ($feed['is_pinned'] ?? false): ?>
              <span class="badge-pinned-label">
                <span class="material-symbols-outlined" style="font-size:13px; font-variation-settings:'FILL' 1;">push_pin</span>
                Pinned
              </span>
            <?php endif; ?>
            <?php if ($feed['is_hot'] ?? false): ?>
              <span class="badge-hot-label">
                <span class="material-symbols-outlined" style="font-size: 13px; font-variation-settings:'FILL' 1;">local_fire_department</span> HOT
              </span>
            <?php endif; ?>
          </div>
          <h3 class="card-title"><?= htmlspecialchars($feed['title']); ?></h3>
          <div class="card-excerpt" style="font-family: 'Open Sans', sans-serif; font-size: 0.875rem; color: #555555; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px; line-height: 1.6;">
            <?= htmlspecialchars(mb_substr(strip_tags($feed['content'] ?? ''), 0, 300)) ?>...
          </div>
          <div class="card-author-row">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($feed['author_name']); ?>&background=f48221&color=fff&size=32" class="author-avatar-sm" alt="Author">
            <span class="author-name"><?= htmlspecialchars($feed['author_name']); ?></span>
            <span class="author-time"><?= date('M j, Y', strtotime($feed['created_at'])); ?></span>
          </div>
          <div class="card-interaction-bar">
            <div class="btn-interact" title="Upvote">
              <span class="material-symbols-outlined">thumb_up</span>
              <span class="vote-count"><?= $feed['upvotes'] ?? 0; ?></span>
            </div>
            <div class="btn-interact" title="Replies">
              <span class="material-symbols-outlined">chat_bubble</span>
              <span class="reply-count"><?= count($feed['replies'] ?? []); ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- PINNED THREAD FALLBACK -->
      <a href="<?= BASE_URL ?>/forum/sign-in" class="discussion-card is-pinned">
        <div class="card-top-row">
          <span class="category-badge">⚙️ Community</span>
          <span class="badge-pinned-label">
            <span class="material-symbols-outlined" style="font-size:13px; font-variation-settings:'FILL' 1;">push_pin</span>
            Pinned
          </span>
        </div>
        <h3 class="card-title">Community Guidelines & Forum Rules — Please Read Before Posting</h3>
        <div class="card-author-row">
          <img src="https://ui-avatars.com/api/?name=Spider+Admin&background=f48221&color=fff&size=32" class="author-avatar-sm" alt="Admin">
          <span class="author-name">Spider Tech Admin</span>
          <span class="author-time">Always pinned</span>
        </div>
        <div class="card-interaction-bar">
          <div class="btn-interact" title="Upvote">
            <span class="material-symbols-outlined">thumb_up</span>
            <span class="vote-count">204</span>
          </div>
          <div class="btn-interact" title="Replies">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span>58</span>
          </div>
        </div>
      </a>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <div class="feed-pagination">
    <a href="<?= BASE_URL ?>/forum/sign-in" class="pag-btn">
      <span class="material-symbols-outlined">chevron_left</span> Previous
    </a>
    <span class="pag-info">Page 1 of 1</span>
    <a href="<?= BASE_URL ?>/forum/sign-in" class="pag-btn">
      Next <span class="material-symbols-outlined">chevron_right</span>
    </a>
  </div>

  <!-- Mobile Floating Action Button (FAB) -->
  <a href="<?= BASE_URL ?>/forum/sign-in" class="fab-mobile">
    <span class="fab-pulse-ring"></span>
    <span class="material-symbols-outlined">edit</span>
  </a>

</div>
