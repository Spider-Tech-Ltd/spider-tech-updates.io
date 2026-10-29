<?php
/**
 * Feed Banner — Member Welcome Banner
 * Compact technical banner for logged-in members with telemetry chips and modern CTA.
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-feed-banner.css?v=<?= filemtime(ROOT_PATH . '/css/forum-feed-banner.css') ?>" />

<section class="feed-member-banner">
  <div class="container">
    <div class="banner-inner">

      <!-- Left: Welcome Text -->
      <div class="banner-text-group">
        <div class="banner-eyebrow">
          <span class="material-symbols-outlined eyebrow-icon">verified_user</span>
          <span>Verified Engineering Member</span>
        </div>
        <h2 class="banner-greeting">
          Welcome back, <span><?php echo htmlspecialchars($member['name']); ?></span> 👋
        </h2>
        <p class="banner-subtitle">
          Collaborate, innovate, and architect high-impact solutions with engineers across Africa.
          <?php if (($member['new_replies'] ?? 0) > 0): ?>
            <span class="notif-pill">
              <span class="material-symbols-outlined" style="font-size:12px;">chat_bubble</span>
              <?php echo $member['new_replies']; ?> new replies
            </span>
          <?php endif; ?>
        </p>

        <!-- Quick stats telemetry chips -->
        <div class="banner-stats">
          <div class="banner-stat">
            <span class="material-symbols-outlined">article</span>
            <span class="stat-meta"><strong><?= Utils::formatNumber($member_stats['post_count'] ?? 0) ?></strong> Your Posts</span>
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">people</span>
            <span class="stat-meta"><strong><?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?></strong> Members</span>
          </div>
          <div class="banner-stat-divider"></div>
          <div class="banner-stat">
            <span class="material-symbols-outlined">forum</span>
            <span class="stat-meta"><strong><?= Utils::formatNumber($global_stats['total_discussions'] ?? 0) ?></strong> Discussions</span>
          </div>
        </div>
      </div>

      <!-- Right: CTA -->
      <div class="banner-cta-group">
        <a href="<?= BASE_URL ?>/forum/new-topic" class="btn-start-discussion" id="btnStartDiscussion">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start Topic</span>
        </a>
      </div>

    </div>
  </div>
</section>
