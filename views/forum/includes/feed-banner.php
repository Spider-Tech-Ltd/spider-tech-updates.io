<?php

/**
 * Feed Banner — Member Welcome Banner (Phase 2)
 * Compact slim banner visible only to logged-in members.
 * Replaces the large hero section from index.php.
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed-banner.css" />

<section class="feed-member-banner">
  <div class="container">
    <div class="banner-inner">

      <!-- Left: Welcome Text -->
      <div class="banner-text-group">
        <h2 class="banner-greeting">
          Welcome back, <span><?php echo htmlspecialchars($member['name']); ?></span>. 👋
        </h2>
        <p class="banner-subtitle">
          Stay ahead of the curve.
          <?php if (($member['new_replies'] ?? 0) > 0): ?>
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
            <strong><?= Utils::formatNumber($member_stats['post_count'] ?? 0) ?></strong> Posts
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">people</span>
            <strong><?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?></strong> Members
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">forum</span>
            <strong><?= Utils::formatNumber($global_stats['total_discussions'] ?? 0) ?></strong> Discussions
          </div>
        </div>
      </div>

      <!-- Right: CTA -->
      <div class="banner-cta-group">
        <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-start-discussion" id="btnStartDiscussion">
          <span class="material-symbols-outlined">edit</span>
          Start a Discussion
        </a>
      </div>

    </div>
  </div>
</section>