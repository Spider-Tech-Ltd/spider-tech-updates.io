<?php

/**
 * Member Sidebar — Premium Synchronization
 * Dashboard-style sidebar for logged-in members.
 * Refined with high-fidelity design tokens: Icon-boxes, Metric rows, and Emoji accents.
 */
?>


<aside class="member-sidebar">

  <!-- WIDGET 1: Your Profile Snippet -->
  <section class="sidebar-widget">
    <div class="widget-header-premium">
      <div class="widget-icon-box">
        <span class="material-symbols-outlined" class="fill-1">person</span>
      </div>
      <h3 class="widget-title-premium">Your Dashboard 🎯</h3>
    </div>

    <div class="d-flex align-items-center gap-3 mb-4 p-2">
      <div class="position-relative">
        <img src="<?= !empty($member['avatar']) ? BASE_URL . $member['avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($member['name']) . "&background=f48221&color=fff&size=56" ?>" class="profile-avatar-premium" alt="Avatar">
        <span class="position-absolute" class="status-dot-online pos-absolute"></span>
      </div>
      <div class="d-flex flex-column">
        <span class="fw-bold fs-16 text-dark" class="lh-12"><?= htmlspecialchars($member['name']) ?></span>
        <span class="text-orange fs-12 fw-bold text-uppercase" class="ls-05"><?= htmlspecialchars($member['role'] ?? 'Member') ?></span>
      </div>
    </div>

    <div class="profile-metrics-group">
      <div class="metric-row-premium">
        <div class="metric-label-group">
          <span class="material-symbols-outlined">edit_square</span>
          <span class="metric-label">Posts Made</span>
        </div>
        <span class="metric-value-badge"><?= Utils::formatNumber($member_stats['post_count'] ?? 0) ?></span>
      </div>
      <div class="metric-row-premium">
        <div class="metric-label-group">
          <span class="material-symbols-outlined">chat</span>
          <span class="metric-label">Replies Sent</span>
        </div>
        <span class="metric-value-badge"><?= Utils::formatNumber($member_stats['reply_count'] ?? 0) ?></span>
      </div>
      <div class="metric-row-premium">
        <div class="metric-label-group">
          <span class="material-symbols-outlined">thumb_up</span>
          <span class="metric-label">Likes Received</span>
        </div>
        <span class="metric-value-badge"><?= Utils::formatNumber($member_stats['likes_received'] ?? 0) ?></span>
      </div>
    </div>

    <div class="pt-3 mt-2 border-top d-flex justify-content-around align-items-center">
      <a href="<?= BASE_URL ?>/forum/profile" class="text-decoration-none fw-bold fs-13 text-muted d-inline-flex align-items-center transition-base" onmouseover="this.classList.replace('text-muted','text-orange')" onmouseout="this.classList.replace('text-orange','text-muted')">
        <span class="material-symbols-outlined mr-1 fs-16">manage_accounts</span> Edit Profile
      </a>
      <a href="<?= BASE_URL ?>/forum/logout" class="text-decoration-none fw-bold fs-13 text-danger d-inline-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-16">logout</span> Sign Out
      </a>
    </div>
  </section>

  <!-- WIDGET 2: Active Members Now -->
  <section class="sidebar-widget">
    <div class="widget-header-premium">
      <div class="widget-icon-box">
        <span class="material-symbols-outlined">group</span>
      </div>
      <h3 class="widget-title-premium">Active Now 🌐</h3>
    </div>

    <div class="d-flex flex-wrap gap-2 pt-1 mb-3">
      <?php if (empty($active_members)): ?>
        <p class="text-muted small">No members active.</p>
      <?php else: ?>
        <?php foreach (array_slice($active_members, 0, 8) as $con): ?>
          <div class="position-relative" title="<?= htmlspecialchars($con['name']) ?>">
            <img src="<?= !empty($con['avatar']) ? BASE_URL . $con['avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($con['name']) . "&background=f48221&color=fff&size=36" ?>"
              class="active-member-avatar" alt="Member">
            <span class="position-absolute" class="status-dot-active pos-absolute"></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <a href="#" class="text-decoration-none text-orange fw-bold fs-12 d-inline-flex align-items-center gap-5">
      See community directory <span class="material-symbols-outlined fs-14">arrow_forward</span>
    </a>
  </section>

  <!-- WIDGET 3: Trending Topics -->
  <section class="sidebar-widget">
    <div class="widget-header-premium">
      <div class="widget-icon-box">
        <span class="material-symbols-outlined">local_fire_department</span>
      </div>
      <h3 class="widget-title-premium">Trending 🔥</h3>
    </div>

    <div class="trending-topic-list">
      <?php if (empty($trending)): ?>
        <p class="text-center text-muted py-3" class="fs-08rem">No trending topics yet.</p>
      <?php else: ?>
        <?php foreach (array_slice($trending, 0, 5) as $topic): ?>
          <a href="<?= BASE_URL ?>/forum/discussion?uuid=<?= $topic['uuid'] ?>" class="trending-link-premium">
            <div class="trending-title-premium"><?= htmlspecialchars($topic['title']) ?></div>
            <div class="trending-meta-premium">
              <span class="material-symbols-outlined fs-14 text-orange" class="fill-1">trending_up</span>
              <span><?= $topic['likes'] ?> engagement score</span>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

</aside>