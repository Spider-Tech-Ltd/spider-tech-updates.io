<?php

/**
 * Member Sidebar — Premium Synchronization
 * Dashboard-style sidebar for logged-in members.
 * Refined with high-fidelity design tokens: Icon-boxes, Metric rows, and Emoji accents.
 */
?>

<style>
  :root {
    --spider-orange: #f48221;
    --spider-dark: #111111;
    --spider-gray: #797979;
  }

  /* ============================
     PREMIUM SIDEBAR FOUNDATION
     ============================ */
  .member-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
    position: sticky;
    top: 160px;
    /* Keeps the sidebar below the fixed header */
    margin-top: 6px;
  }

  @media (max-width: 768px) {
    .member-sidebar {
      top: 110px;
    }
  }

  .sidebar-widget {
    background-color: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(17, 17, 17, 0.05);
    border: 1px solid transparent;
    transition: all 0.3s ease;
  }

  /* Widget Header Sync */
  .widget-header-premium {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  .widget-icon-box {
    width: 32px;
    height: 32px;
    background-color: rgba(244, 130, 33, 0.08);
    color: var(--spider-orange);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .widget-title-premium {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--spider-dark);
    margin: 0;
  }

  /* ============================
     METRIC ROWS (PROFILE & STATS)
     ============================ */
  .metric-row-premium {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px;
    background-color: #f8f9fa;
    border-radius: 14px;
    margin-bottom: 10px;
    transition: transform 0.2s ease;
    text-decoration: none !important;
  }

  .metric-row-premium:hover {
    transform: translateX(4px);
    background-color: #fffbf7;
  }

  .metric-label-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .metric-label-group .material-symbols-outlined {
    font-size: 18px;
    color: var(--spider-gray);
  }

  .metric-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--spider-gray);
    font-family: 'Open Sans';
  }

  .metric-value-badge {
    background-color: #ffffff;
    color: var(--spider-dark);
    font-family: 'Poppins';
    font-weight: 700;
    font-size: 0.8rem;
    padding: 4px 12px;
    border-radius: 50px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  }

  /* ============================
     TRENDING LINKS
     ============================ */
  .trending-link-premium {
    text-decoration: none !important;
    display: block;
    padding: 12px;
    border-radius: 14px;
    transition: all 0.2s ease;
    margin-bottom: 8px;
    border: 1px solid transparent;
  }

  .trending-link-premium:hover {
    background-color: #fffbf7;
    border-color: rgba(244, 130, 33, 0.1);
    transform: translateX(4px);
  }

  .trending-title-premium {
    font-family: 'Poppins';
    font-weight: 700;
    font-size: 0.85rem;
    color: var(--spider-dark);
    line-height: 1.4;
    margin-bottom: 4px;
  }

  .trending-meta-premium {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.72rem;
    color: var(--spider-gray);
    font-family: 'Open Sans';
  }

  /* Profile Avatar */
  .profile-avatar-premium {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 4px 12px rgba(244, 130, 33, 0.15);
  }
</style>

<aside class="member-sidebar">

  <!-- WIDGET 1: Your Profile Snippet -->
  <section class="sidebar-widget">
    <div class="widget-header-premium">
      <div class="widget-icon-box">
        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">person</span>
      </div>
      <h3 class="widget-title-premium">Your Dashboard 🎯</h3>
    </div>

    <div class="d-flex align-items-center gap-3 mb-4 p-2">
      <div class="position-relative">
        <img src="<?= !empty($member['avatar']) ? BASE_URL . $member['avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($member['name']) . "&background=f48221&color=fff&size=56" ?>" class="profile-avatar-premium" alt="Avatar">
        <span class="position-absolute" style="width:14px; height:14px; background:#2ecc71; border:2.5px solid #fff; border-radius:50%; right:2px; bottom:2px;"></span>
      </div>
      <div class="d-flex flex-column">
        <span style="font-family:'Poppins'; font-weight:700; font-size:1rem; color:#111; line-height:1.2;"><?= htmlspecialchars($member['name']) ?></span>
        <span style="font-size:0.75rem; color:var(--spider-orange); font-weight:700; text-transform:uppercase; letter-spacing:0.5px;"><?= htmlspecialchars($member['role'] ?? 'Member') ?></span>
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
      <a href="<?= BASE_URL ?>/forum/profile" class="text-decoration-none" style="font-family:'Poppins'; font-weight:700; font-size:0.8rem; color:var(--spider-gray); display:inline-flex; align-items:center; transition: color 0.2s;" onmouseover="this.style.color='var(--spider-orange)'" onmouseout="this.style.color='var(--spider-gray)'">
        <span class="material-symbols-outlined mr-1" style="font-size:16px;">manage_accounts</span> Edit Profile
      </a>
      <a href="<?= BASE_URL ?>/forum/logout" class="text-decoration-none" style="font-family:'Poppins'; font-weight:700; font-size:0.8rem; color:#e11d48; display:inline-flex; align-items:center;">
        <span class="material-symbols-outlined mr-1" style="font-size:16px;">logout</span> Sign Out
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
              style="width:36px; height:36px; border-radius:50%; border:1.5px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.06); object-fit: cover;" alt="Member">
            <span class="position-absolute" style="width:10px; height:10px; background:#2ecc71; border:2.2px solid #fff; border-radius:50%; right:-1px; bottom:-1px;"></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <a href="#" class="text-decoration-none" style="font-family:'Poppins'; font-weight:700; font-size:0.75rem; color:var(--spider-orange); display:inline-flex; align-items:center; gap:4px;">
      See community directory <span class="material-symbols-outlined" style="font-size:14px;">arrow_forward</span>
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
        <p class="text-center text-muted py-3" style="font-size: 0.8rem;">No trending topics yet.</p>
      <?php else: ?>
        <?php foreach (array_slice($trending, 0, 5) as $topic): ?>
          <a href="<?= BASE_URL ?>/forum/discussion?uuid=<?= $topic['uuid'] ?>" class="trending-link-premium">
            <div class="trending-title-premium"><?= htmlspecialchars($topic['title']) ?></div>
            <div class="trending-meta-premium">
              <span class="material-symbols-outlined" style="font-size:14px; color:var(--spider-orange); font-variation-settings: 'FILL' 1;">trending_up</span>
              <span><?= $topic['likes'] ?> engagement score</span>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

</aside>