<?php
/**
 * Forum Discussion Feed — Streamlined Anti-Scroll Engineering Rows
 * Features: Compact row cards (~82px), dual-pill stats, progressive "Show More / Show Less" disclosure
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-guest-feed.css?v=<?= filemtime(ROOT_PATH . '/css/forum-guest-feed.css') ?>" />

<div class="forum-feed-container" x-data="forumFeedController(<?= count($feeds ?? []) ?>)">

  <!-- Feed Header Wrap -->
  <div class="feed-header-wrap">
    <div class="feed-header-meta">
      <div class="feed-eyebrow">
        <span class="eyebrow-accent">|–</span>
        <span>ENGINEERING THREADS</span>
        <span class="eyebrow-accent">–|</span>
      </div>
      <h2 class="feed-title">Latest Discussions</h2>
      <p class="feed-subtitle">
        Showing <span class="feed-count-highlight" x-text="Math.min(visibleCount, totalCount)"><?= min(6, count($feeds ?? [])) ?></span> of <?= count($feeds ?? []) ?> active discussions
      </p>
    </div>

    <div class="feed-header-actions">
      <?php if (isset($_SESSION['member_uuid'])): ?>
        <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-new-topic">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start Topic</span>
        </a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/forum/sign-in" class="btn-new-topic">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start Topic</span>
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Discussion List -->
  <div class="discussion-feed-list" role="feed" aria-label="Community discussions">
    <?php if (!empty($feeds)): ?>
      <?php foreach ($feeds as $index => $feed): ?>
        <?php 
          $isPinned = !empty($feed['is_pinned']);
          $isHot = !empty($feed['is_hot']);
          $authorName = htmlspecialchars($feed['author_name'] ?? 'Member');
          $avatarUrl = !empty($feed['author_avatar']) ? BASE_URL . $feed['author_avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($authorName) . "&background=f48221&color=fff&size=32";
          $likesCount = $feed['likes'] ?? ($feed['upvotes'] ?? 0);
          $repliesCount = $feed['replies_count'] ?? (is_array($feed['replies'] ?? null) ? count($feed['replies']) : 0);
          $excerpt = htmlspecialchars(mb_substr(strip_tags($feed['content'] ?? ''), 0, 140));
        ?>
        <div class="discussion-item-wrap"
             x-show="<?= $index ?> < visibleCount"
             x-transition:enter="feed-item-fade-in"
             style="<?= $index >= 6 ? 'display: none;' : '' ?>">
          
          <a href="<?= BASE_URL ?>/forum/discussion?uuid=<?= urlencode($feed['uuid'] ?? ''); ?>" 
             class="discussion-row-card <?= $isPinned ? 'is-pinned' : '' ?>"
             role="article"
             aria-label="<?= htmlspecialchars($feed['title']) ?>">

            <!-- Left: Stat Counters (Upvotes & Replies in compact dual-pill) -->
            <div class="row-stats-box" aria-label="<?= $likesCount ?> upvotes, <?= $repliesCount ?> replies">
              <div class="row-stat-col" title="<?= $likesCount ?> upvotes">
                <span class="material-symbols-outlined row-stat-icon">thumb_up</span>
                <span class="row-stat-num"><?= $likesCount ?></span>
              </div>
              <div class="row-stat-divider"></div>
              <div class="row-stat-col <?= $repliesCount > 0 ? 'has-replies' : '' ?>" title="<?= $repliesCount ?> replies">
                <span class="material-symbols-outlined row-stat-icon">chat_bubble</span>
                <span class="row-stat-num"><?= $repliesCount ?></span>
              </div>
            </div>

            <!-- Center: Topic Content -->
            <div class="row-content-body">
              <!-- Top Inline Meta: Badges + Time -->
              <div class="row-meta-inline">
                <span class="row-category-chip"><?= htmlspecialchars($feed['category_name'] ?? 'General') ?></span>
                <?php if ($isPinned): ?>
                  <span class="row-badge-pinned">
                    <span class="material-symbols-outlined">push_pin</span>
                    <span>Pinned</span>
                  </span>
                <?php endif; ?>
                <?php if ($isHot): ?>
                  <span class="row-badge-hot">
                    <span class="material-symbols-outlined">local_fire_department</span>
                    <span>Trending</span>
                  </span>
                <?php endif; ?>
                <span class="row-meta-separator">•</span>
                <span class="row-time-ago">
                  <span class="material-symbols-outlined">schedule</span>
                  <?= date('M j, Y', strtotime($feed['created_at'])) ?>
                </span>
              </div>

              <!-- Title -->
              <h3 class="row-topic-title"><?= htmlspecialchars($feed['title']) ?></h3>

              <!-- Compact Excerpt Preview -->
              <?php if (!empty($excerpt)): ?>
                <p class="row-topic-excerpt"><?= $excerpt ?>...</p>
              <?php endif; ?>

              <!-- Author Meta Line -->
              <div class="row-author-meta">
                <img src="<?= $avatarUrl ?>" class="row-author-avatar" alt="<?= $authorName ?>" loading="lazy">
                <span class="row-author-name"><?= $authorName ?></span>
                <span class="row-author-role">Member</span>
              </div>
            </div>

            <!-- Right: Action Arrow -->
            <div class="row-arrow-box" aria-hidden="true">
              <span class="material-symbols-outlined row-arrow-icon">arrow_forward</span>
            </div>

          </a>
        </div>
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

  <!-- Progressive Reveal: Show More / Show Less Button (Matching Services & Projects UX) -->
  <?php if (!empty($feeds) && count($feeds) > 6): ?>
    <div class="feed-more-actions">
      <button type="button" 
              class="feed-show-more-btn"
              @click="toggleFeedRows()"
              :aria-expanded="(visibleCount >= totalCount).toString()">
        <span x-text="visibleCount >= totalCount ? 'Show Less' : 'Show More Discussions'">Show More Discussions</span>
        <span class="material-symbols-outlined toggle-chevron" :class="{ 'is-rotated': visibleCount >= totalCount }">expand_more</span>
      </button>
    </div>
  <?php endif; ?>

</div>

<script>
  function forumFeedController(total) {
    return {
      totalCount: total,
      visibleCount: 6,
      step: 6,

      toggleFeedRows() {
        if (this.visibleCount >= this.totalCount) {
          this.visibleCount = 6;
          // Smooth scroll back to feed header if user scrolled far down
          const feedEl = document.getElementById('feedSection');
          if (feedEl) {
            feedEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        } else {
          this.visibleCount = Math.min(this.visibleCount + this.step, this.totalCount);
        }
      }
    };
  }
</script>
