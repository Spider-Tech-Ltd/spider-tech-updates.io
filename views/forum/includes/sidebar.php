<?php
/**
 * Forum Sidebar Component — Phase 3 Redesign
 * Generated via Stitch MCP (screen: d3161101ada444faa0722ae269be260c)
 * Translated to Bootstrap 4 + Vanilla CSS
 */
?>

<style>
  /* ====== Sidebar Styles ====== */
  .forum-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
    position: sticky;
    top: 90px;
  }

  /* Widget Card */
  .sidebar-widget {
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  }

  .widget-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.15rem;
    color: #111111;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Ranked List */
  .ranked-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .ranked-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none !important;
  }
  .ranked-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .ranked-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background-color: rgba(245, 158, 11, 0.15); /* Warm Amber tint */
    color: #f59e0b; /* Warm Amber */
    border-radius: 50%;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
  }
  .ranked-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    color: #111111;
    transition: color 0.2s;
  }
  .ranked-item:hover .ranked-name { color: #3b82f6; } /* Electric Blue */
  .ranked-count {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #94a3b8; /* Cool Gray */
  }

  /* Top Contributors */
  .contributor-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .contributor-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .contributor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .avatar-orange { background-color: rgba(244, 130, 33, 0.12); color: #f48221; }
  .avatar-blue   { background-color: #dbeafe; color: #2563eb; }
  .avatar-green  { background-color: #d1fae5; color: #059669; }
  .avatar-purple { background-color: #ede9fe; color: #7c3aed; }
  .avatar-rose   { background-color: #ffe4e6; color: #e11d48; }

  .contributor-info { flex: 1; }
  .contributor-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    color: #111111;
    display: block;
  }
  .contributor-posts {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: #797979;
  }

  /* Join CTA Card - Guest */
  .sidebar-join-card {
    background-color: rgba(244, 130, 33, 0.06);
    border: none;
    border-left: 4px solid #f48221;
    padding: 24px;
    border-radius: 16px;
  }
  .join-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #111111;
    margin-bottom: 8px;
  }
  .join-body {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.875rem;
    color: #555555;
    line-height: 1.6;
    margin-bottom: 24px;
  }
  .join-btn-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .join-btn-primary {
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 10px;
    border-radius: 50px;
    border: none;
    text-align: center;
    transition: background-color 0.2s;
    text-decoration: none !important;
  }
  .join-btn-primary:hover { background-color: #e6751c; color: #ffffff; }

  .join-btn-secondary {
    background-color: transparent;
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 10px;
    border-radius: 50px;
    border: 1px solid #f48221;
    text-align: center;
    transition: background-color 0.2s;
    text-decoration: none !important;
  }
  .join-btn-secondary:hover { background-color: rgba(244, 130, 33, 0.1); color: #f48221; }
</style>

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
    <h3 class="widget-title">⭐ Top Contributors</h3>
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
            <div class="contributor-avatar avatar-<?= $avatar_class ?>"><?= $initial ?></div>
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
