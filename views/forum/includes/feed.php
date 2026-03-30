<?php
/**
 * Forum Discussion Feed — Phase 4 Upgraded
 * Features: Pinned thread, Hot badges, Last-reply metadata, Tabs, Pagination
 * Translated from Stitch MCP (screen: 4400a3d263fa46b7bf31877d46d5fb8a)
 */
?>

<style>
  /* ============================
     GUEST FEED (SYNCED WITH MEMBER FEED)
     ============================ */
  .feed-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
  }

  .feed-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.4rem;
    color: #111111;
    margin-bottom: 0;
  }

  .btn-new-topic {
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 50px;
    border: none;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
    transition: transform 0.2s, background-color 0.2s;
    text-decoration: none !important;
  }

  .btn-new-topic:hover {
    background-color: #e6751c;
    color: #ffffff;
    transform: translateY(-2px);
  }

  /* Filter Tabs */
  .feed-tabs {
    display: flex;
    gap: 32px;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 24px;
  }

  .tab-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
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
    color: #f48221;
  }

  .tab-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #f48221;
  }

  /* Discussion Cards */
  .discussion-card-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .discussion-card {
    background-color: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(17, 17, 17, 0.05);
    border: 1px solid transparent;
    transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
    text-decoration: none !important;
    color: inherit;
    display: block;
  }

  .discussion-card:hover {
    border-color: rgba(244, 130, 33, 0.25);
    box-shadow: 0 8px 24px rgba(244, 130, 33, 0.08);
    transform: translateY(-3px);
    color: inherit;
    text-decoration: none !important;
  }

  .discussion-card.is-pinned {
    border-left: 3px solid #f48221;
    background-color: #fffbf7;
  }

  .card-top-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    flex-wrap: wrap;
  }

  .category-badge {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background-color: #f48221;
    color: #ffffff;
    padding: 3px 12px;
    border-radius: 50px;
    white-space: nowrap;
  }

  .badge-hot-label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background-color: #fff0f3;
    color: #e11d48;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    padding: 3px 10px;
    border-radius: 50px;
  }

  .badge-pinned-label {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .card-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.05rem;
    color: #111111;
    line-height: 1.45;
    margin-bottom: 8px;
    transition: color 0.2s;
  }

  .discussion-card:hover .card-title {
    color: #f48221;
  }

  .card-author-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
  }

  .author-avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
  }

  .author-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #111111;
  }

  .author-time {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.78rem;
    color: #797979;
    margin-left: auto;
  }

  .card-interaction-bar {
    display: flex;
    align-items: center;
    gap: 4px;
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
    text-decoration: none !important;
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

  /* FAB Floating Button */
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

  .fab-pulse-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid #f48221;
    animation: fabPulse 5s infinite cubic-bezier(0.25, 0.8, 0.25, 1);
  }

  @keyframes fabPulse {
    0% {
      transform: scale(1);
      opacity: 0.8;
    }

    20%,
    100% {
      transform: scale(1.6);
      opacity: 0;
    }
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

    .card-interaction-bar {
      gap: 16px;
    }
  }
</style>

<div class="forum-feed-container">

  <!-- Feed Header -->
  <div class="feed-header">
    <h2 class="feed-title">Latest Discussions</h2>
    <a href="<?= BASE_URL ?>/forum/sign-in" class="btn-new-topic">
      <span class="material-symbols-outlined">add</span>
      New Topic
    </a>
  </div>

  <!-- Tabs -->
  <div class="feed-tabs">
    <a href="#" class="tab-link active">Latest</a>
    <a href="#" class="tab-link">Top</a>
    <a href="#" class="tab-link">Unanswered</a>
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
            <div class="interact-spacer"></div>
            <div class="btn-interact" title="Bookmark">
              <span class="material-symbols-outlined">bookmark</span>
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
          <div class="interact-spacer"></div>
          <div class="btn-interact" title="Bookmark">
            <span class="material-symbols-outlined">bookmark</span>
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
