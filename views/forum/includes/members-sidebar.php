<?php

/**
 * Member Sidebar — Phase 2
 * Dashboard-style sidebar for logged-in members.
 * Widgets: Profile Snippet, Active Members Now, Trending Topics.
 * Replaces the guest "Join CTA" sidebar from the public forum.
 */
?>

<style>
  /* ============================
     MEMBER SIDEBAR
     ============================ */
  .member-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: sticky;
    top: 136px;
    margin-top: 6px;
    /* Align top edge with feed card */
  }

  .sidebar-widget {
    background-color: #ffffff;
    border-radius: 20px;
    padding: 22px;
    box-shadow: 0 2px 12px rgba(17, 17, 17, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.04);
  }

  .widget-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    color: #111111;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  /* ============================
     WIDGET 1: PROFILE SNIPPET
     ============================ */
  .profile-card-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .profile-avatar-wrapper {
    position: relative;
    margin-bottom: 14px;
  }

  .profile-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(244, 130, 33, 0.2);
  }

  .profile-online-dot {
    position: absolute;
    bottom: 3px;
    right: 3px;
    width: 13px;
    height: 13px;
    background-color: #22c55e;
    border-radius: 50%;
    border: 2px solid #ffffff;
  }

  .profile-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #111111;
    margin-bottom: 6px;
  }

  .profile-role-badge {
    display: inline-block;
    background-color: rgba(244, 130, 33, 0.1);
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 3px 12px;
    border-radius: 50px;
    margin-bottom: 16px;
  }

  .profile-stats-row {
    display: flex;
    justify-content: center;
    gap: 24px;
    width: 100%;
    padding: 14px 0;
    border-top: 1px solid #f1f3f5;
    border-bottom: 1px solid #f1f3f5;
    margin-bottom: 14px;
  }

  .profile-stat {
    text-align: center;
  }

  .profile-stat strong {
    display: block;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #111111;
  }

  .profile-stat small {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.72rem;
    color: #797979;
  }

  .profile-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    color: #f48221;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s;
  }

  .profile-link:hover {
    opacity: 0.75;
    color: #f48221;
  }

  .profile-link .material-symbols-outlined {
    font-size: 14px;
  }

  /* ============================
     WIDGET 2: ACTIVE MEMBERS
     ============================ */
  .active-members-row {
    display: flex;
    align-items: center;
    gap: 0;
    /* Removed gap for overlap */
    margin-bottom: 14px;
    flex-wrap: wrap;
  }

  .active-member-avatar {
    position: relative;
    flex-shrink: 0;
    margin-left: -12px;
    /* Overlap effect */
    transition: transform 0.2s ease, z-index 0.2s;
  }

  .active-member-avatar:first-child {
    margin-left: 0;
  }

  .active-member-avatar:hover {
    transform: translateY(-4px);
    z-index: 10;
  }

  .active-member-avatar img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    /* Cutout effect for overlap */
    object-fit: cover;
  }

  /* .active-member-avatar .online-dot {
    position: absolute;
    bottom: 1px;
    left: 1px;
    width: 9px;
    height: 9px;
    background-color: #22c55e;
    border-radius: 50%;
    border: 1.5px solid #ffffff;
  } */

  .active-count-pill {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.72rem;
    background-color: rgba(244, 130, 33, 0.1);
    color: #f48221;
    padding: 4px 10px;
    border-radius: 50px;
    white-space: nowrap;
    margin-left: 14px;
    z-index: 1;
  }



  .widget-see-all {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.78rem;
    color: #f48221;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s;
  }

  .widget-see-all:hover {
    opacity: 0.75;
    color: #f48221;
  }

  .widget-see-all .material-symbols-outlined {
    font-size: 14px;
  }

  /* ============================
     WIDGET 3: TRENDING TOPICS
     ============================ */
  .trending-topic-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .trending-topic-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    text-decoration: none !important;
  }

  .trending-rank-badge {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
  }

  .trending-rank-badge.rank-1 {
    background: linear-gradient(135deg, #f48221, #e6751c);
    box-shadow: 0 2px 6px rgba(244, 130, 33, 0.3);
  }

  .trending-rank-badge.rank-2,
  .trending-rank-badge.rank-3 {
    background-color: rgba(244, 130, 33, 0.15);
    color: #f48221;
  }

  .trending-rank-badge.rank-4,
  .trending-rank-badge.rank-5 {
    background-color: #f1f3f5;
    color: #555555;
  }

  .trending-topic-content {
    flex: 1;
  }

  .trending-topic-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.875rem;
    color: #111111;
    display: block;
    line-height: 1.35;
    margin-bottom: 3px;
    transition: color 0.2s;
  }

  .trending-topic-item:hover .trending-topic-name {
    color: #f48221;
  }

  .trending-topic-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .trending-reply-count {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.72rem;
    color: #797979;
  }

  .badge-hot-sm {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    background-color: #fff0f3;
    color: #e11d48;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.6rem;
    padding: 1px 7px;
    border-radius: 50px;
  }
</style>

<aside class="member-sidebar">

  <!-- WIDGET 1: Your Profile Snippet -->
  <section class="sidebar-widget" aria-label="Your profile">
    <div class="widget-title">
      <span class="material-symbols-outlined" style="font-size:16px; color:#f48221; font-variation-settings:'FILL' 1;">person</span>
      Your Profile
    </div>
    <div class="profile-card-inner">
      <div class="profile-avatar-wrapper">
        <img
          src="https://ui-avatars.com/api/?name=<?php echo urlencode($member['name']); ?>&background=f48221&color=fff&size=64"
          class="profile-avatar"
          alt="<?php echo htmlspecialchars($member['name']); ?>">
        <div class="profile-online-dot"></div>
      </div>
      <div class="profile-name"><?php echo htmlspecialchars($member['name']); ?></div>
      <div class="profile-role-badge"><?php echo htmlspecialchars($member['role'] ?? 'Member'); ?></div>
      <div class="profile-stats-row">
        <div class="profile-stat">
          <strong><?php echo $member['posts'] ?? 0; ?></strong>
          <small>Posts</small>
        </div>
        <div class="profile-stat">
          <strong>12</strong>
          <small>Bookmarks</small>
        </div>
        <div class="profile-stat">
          <strong>382</strong>
          <small>Upvotes</small>
        </div>
      </div>
      <a href="pages/forum/logout.php" class="profile-link">
        Sign Out <span class="material-symbols-outlined">logout</span>
      </a>
    </div>
  </section>

  <!-- WIDGET 2: Active Members Now -->
  <section class="sidebar-widget" aria-label="Active members">
    <div class="widget-title">
      Active Now
    </div>
    <div class="active-members-row">
      <div class="active-member-avatar">
        <img src="https://ui-avatars.com/api/?name=Alice+M&background=0284c7&color=fff&size=36" alt="Alice M">
        <div class="online-dot"></div>
      </div>
      <div class="active-member-avatar">
        <img src="https://ui-avatars.com/api/?name=Chris+O&background=059669&color=fff&size=36" alt="Chris O">
        <div class="online-dot"></div>
      </div>
      <div class="active-member-avatar">
        <img src="https://ui-avatars.com/api/?name=Sarah+B&background=7c3aed&color=fff&size=36" alt="Sarah B">
        <div class="online-dot"></div>
      </div>
      <div class="active-member-avatar">
        <img src="https://ui-avatars.com/api/?name=David+A&background=e11d48&color=fff&size=36" alt="David A">
        <div class="online-dot"></div>
      </div>
      <div class="active-member-avatar">
        <img src="https://ui-avatars.com/api/?name=Kofi+B&background=ca8a04&color=fff&size=36" alt="Kofi B">
        <div class="online-dot"></div>
      </div>
      <span class="active-count-pill">+47 online</span>
    </div>
    <a href="#" class="widget-see-all">
      See all members <span class="material-symbols-outlined">arrow_forward</span>
    </a>
  </section>

  <!-- WIDGET 3: Trending Topics -->
  <section class="sidebar-widget" aria-label="Trending topics">
    <div class="widget-title">
      🔥 Trending Topics
    </div>
    <div class="trending-topic-list">

      <a href="#" class="trending-topic-item">
        <div class="trending-rank-badge rank-1">1</div>
        <div class="trending-topic-content">
          <span class="trending-topic-name">AI Predictive Maintenance in Heavy Industry</span>
          <div class="trending-topic-meta">
            <span class="trending-reply-count">142 replies</span>
            <span class="badge-hot-sm">🔥 Hot</span>
          </div>
        </div>
      </a>

      <a href="#" class="trending-topic-item">
        <div class="trending-rank-badge rank-2">2</div>
        <div class="trending-topic-content">
          <span class="trending-topic-name">SCADA Systems Comparison 2026</span>
          <div class="trending-topic-meta">
            <span class="trending-reply-count">98 replies</span>
          </div>
        </div>
      </a>

      <a href="#" class="trending-topic-item">
        <div class="trending-rank-badge rank-3">3</div>
        <div class="trending-topic-content">
          <span class="trending-topic-name">Solar-Diesel Hybrid ROI Case Studies</span>
          <div class="trending-topic-meta">
            <span class="trending-reply-count">76 replies</span>
          </div>
        </div>
      </a>

      <a href="#" class="trending-topic-item">
        <div class="trending-rank-badge rank-4">4</div>
        <div class="trending-topic-content">
          <span class="trending-topic-name">Fleet Telematics ROI Breakdown</span>
          <div class="trending-topic-meta">
            <span class="trending-reply-count">54 replies</span>
          </div>
        </div>
      </a>

      <a href="#" class="trending-topic-item">
        <div class="trending-rank-badge rank-5">5</div>
        <div class="trending-topic-content">
          <span class="trending-topic-name">Open Source ERP for SME Manufacturers</span>
          <div class="trending-topic-meta">
            <span class="trending-reply-count">43 replies</span>
          </div>
        </div>
      </a>

    </div>
  </section>

</aside>
