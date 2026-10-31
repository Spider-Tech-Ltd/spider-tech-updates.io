<?php
/**
 * Forum Sidebar Component — Tailored Compact Engineering Modules
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sidebar.css?v=<?= filemtime(ROOT_PATH . '/css/forum-sidebar.css') ?>" />

<aside class="forum-sidebar">

  <!-- WIDGET 1: Top Categories -->
  <section class="sidebar-widget">
    <div class="sidebar-widget-header">
      <div class="d-flex align-items-center gap-2">
        <span class="material-symbols-outlined widget-icon">hub</span>
        <h3 class="widget-title">Top Categories</h3>
      </div>
      <a href="<?= BASE_URL ?>/forum#feedSection" class="widget-view-all">View All</a>
    </div>
    <div class="ranked-list">
      <?php if (empty($top_categories)): ?>
        <p class="text-muted small">No categories found.</p>
      <?php else: ?>
        <?php foreach ($top_categories as $index => $cat): ?>
          <a href="<?= BASE_URL ?>/forum?category=<?= urlencode($cat['slug']) ?>#feedSection" class="ranked-item">
            <div class="ranked-item-left">
              <span class="ranked-badge"><?= sprintf('%02d', $index + 1) ?></span>
              <span class="ranked-name"><?= htmlspecialchars($cat['name']) ?></span>
            </div>
            <span class="ranked-count"><?= Utils::formatNumber($cat['post_count']) ?> topics</span>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- WIDGET 2: Top Discussions / Trending -->
  <?php if (!empty($trending)): ?>
  <section class="sidebar-widget">
    <div class="sidebar-widget-header">
      <div class="d-flex align-items-center gap-2">
        <span class="material-symbols-outlined widget-icon text-orange">trending_up</span>
        <h3 class="widget-title">Top Discussions</h3>
      </div>
    </div>
    <div class="trending-discussions-list">
      <?php foreach ($trending as $tIndex => $trend): ?>
        <a href="<?= BASE_URL ?>/forum/discussion?uuid=<?= urlencode($trend['uuid']) ?>" class="trending-discussion-item">
          <span class="trending-rank"><?= ($tIndex + 1) ?></span>
          <div class="trending-content">
            <h4 class="trending-title"><?= htmlspecialchars($trend['title']) ?></h4>
            <div class="trending-meta">
              <span class="trending-likes">
                <span class="material-symbols-outlined">thumb_up</span>
                <?= $trend['likes'] ?? 0 ?> upvotes
              </span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- WIDGET 3: Top Contributors -->
  <section class="sidebar-widget">
    <div class="sidebar-widget-header">
      <div class="d-flex align-items-center gap-2">
        <span class="material-symbols-outlined widget-icon">military_tech</span>
        <h3 class="widget-title">Top Contributors</h3>
      </div>
    </div>
    <div class="contributor-list">
      <?php if (empty($top_contributors)): ?>
        <p class="text-muted small">No contributors yet.</p>
      <?php else: ?>
        <?php 
          $avatars = ['orange', 'blue', 'green', 'purple', 'rose'];
          foreach ($top_contributors as $index => $con): 
            $avatar_class = $avatars[$index % count($avatars)];
            $initial = strtoupper(substr($con['name'] ?? 'M', 0, 1));
        ?>
          <div class="contributor-item">
            <?php if (!empty($con['avatar'])): ?>
                <img src="<?= BASE_URL . $con['avatar'] ?>" class="contributor-avatar" style="object-fit: cover;" alt="Avatar">
            <?php else: ?>
                <div class="contributor-avatar avatar-<?= $avatar_class ?>"><?= $initial ?></div>
            <?php endif; ?>
            <div class="contributor-info">
              <span class="contributor-name"><?= htmlspecialchars($con['name']) ?></span>
              <span class="contributor-posts"><?= $con['post_count'] ?> contributions</span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- WIDGET 4: Tailored Sign Access Card -->
  <?php if (!isset($_SESSION['member_uuid'])): ?>
  <section class="sidebar-join-card">
    <div class="join-card-accent"></div>
    <div class="join-eyebrow">
      <span class="eyebrow-accent">|–</span>
      <span>MEMBER ACCESS</span>
      <span class="eyebrow-accent">–|</span>
    </div>
    <h3 class="join-title">Join the Engineering Network</h3>
    <p class="join-body">
      Ask questions, share blueprints, and troubleshoot industrial systems with verified peers.
    </p>
    <div class="join-btn-group">
      <a href="<?= BASE_URL ?>/forum/sign-up" class="join-btn-primary">Register Free</a>
      <a href="<?= BASE_URL ?>/forum/sign-in" class="join-btn-secondary">Sign In</a>
    </div>
  </section>
  <?php endif; ?>

</aside>
