<?php
/**
 * Forum Sidebar Component — Phase 3 Redesign
 * Generated via Stitch MCP (screen: d3161101ada444faa0722ae269be260c)
 * Translated to Bootstrap 4 + Vanilla CSS
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sidebar.css?v=<?= filemtime(ROOT_PATH . '/css/forum-sidebar.css') ?>" />

<aside class="forum-sidebar">

  <!-- WIDGET 1: Top Categories -->
  <section class="sidebar-widget">
    <h3 class="widget-title">Top Categories</h3>
    <div class="ranked-list">
      <?php if (empty($top_categories)): ?>
        <p class="text-muted small">No categories found.</p>
      <?php else: ?>
        <?php foreach ($top_categories as $index => $cat): ?>
          <a href="<?= BASE_URL ?>/forum?category=<?= $cat['slug'] ?>" class="ranked-item">
            <div class="ranked-item-left">
              <span class="ranked-badge"><?= ($index + 1) ?></span>
              <span class="ranked-name"><?= htmlspecialchars($cat['name']) ?></span>
            </div>
            <span class="ranked-count"><?= Utils::formatNumber($cat['post_count']) ?></span>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- WIDGET 2: Top Contributors -->
  <section class="sidebar-widget">
    <h3 class="widget-title">Top Technical Contributors</h3>
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
              <span class="contributor-posts"><?= $con['post_count'] ?> posts total</span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- WIDGET 3: Join CTA -->
  <?php if (!isset($_SESSION['member_uuid'])): ?>
  <section class="sidebar-join-card">
    <h3 class="join-title">New Here?</h3>
    <p class="join-body">
      Join the Spider Tech Community to start posting, ask questions, and connect with thousands of tech professionals.
    </p>
    <div class="join-btn-group">
      <a href="<?= BASE_URL ?>/forum/sign-up" class="join-btn-primary">Register Free</a>
      <a href="<?= BASE_URL ?>/forum/sign-in" class="join-btn-secondary">Sign In</a>
    </div>
  </section>
  <?php endif; ?>

</aside>
