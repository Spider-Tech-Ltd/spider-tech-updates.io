<?php
/**
 * Forum Discussion Feed — Phase 4 Upgraded
 * Features: Pinned thread, Hot badges, Last-reply metadata, Tabs, Pagination
 * Translated from Stitch MCP (screen: 4400a3d263fa46b7bf31877d46d5fb8a)
 */
?>

<style>
  /* ====== Discussion Feed Styles ====== */
  .feed-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
    gap: 16px;
  }

  .feed-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.85rem;
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
    margin-bottom: 32px;
  }
  .tab-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #797979;
    padding-bottom: 12px;
    text-decoration: none !important;
    position: relative;
    transition: color 0.2s;
  }
  .tab-link:hover { color: #f48221; }
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

  /* Thread Items */
  .thread-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  /* Pinned Card */
  .thread-card-pinned {
    background-color: #fffbf2;
    border: 1px solid rgba(244, 130, 33, 0.1);
    border-left: 4px solid #f48221 !important;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
  }
  .pinned-icon-box {
    width: 48px;
    height: 48px;
    background-color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f48221;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    flex-shrink: 0;
  }

  .thread-card {
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: border-color 0.2s, box-shadow 0.2s;
    text-decoration: none !important;
  }
  .thread-card:hover {
    border-color: rgba(244, 130, 33, 0.4);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
  }

  .author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }

  .thread-main { flex: 1; }
  
  .thread-meta-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }
  .category-pill {
    font-family: 'Open Sans', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #797979;
  }
  .badge-hot {
    background-color: #fff0f0;
    color: #e11d48;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    padding: 2px 8px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .badge-pinned-label {
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .thread-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    color: #111111;
    margin-bottom: 4px;
    line-height: 1.4;
  }
  .thread-card:hover .thread-title { color: #f48221; }

  .thread-last-reply {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: #555555;
  }
  .thread-last-reply strong { color: #111111; }

  /* Stats Column */
  .thread-stats {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
    min-width: 100px;
    color: #797979;
  }
  .stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
  }

  /* Pagination */
  .feed-pagination {
    margin-top: 48px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
  }
  .pag-btn {
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    text-decoration: none !important;
    transition: opacity 0.2s;
  }
  .pag-btn:hover { opacity: 0.7; }
  .pag-info {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.85rem;
    color: #797979;
  }

  @media (max-width: 768px) {
    .thread-card, .thread-card-pinned { flex-direction: column; align-items: flex-start; padding: 20px; }
    .thread-stats { align-items: flex-start; margin-top: 16px; min-width: auto; padding-top: 12px; border-top: 1px solid #f1f1f1; width: 100%; }
    .feed-header { flex-direction: column; align-items: flex-start; gap: 20px; }
    .btn-new-topic { width: 100%; justify-content: center; }
    .feed-tabs { gap: 20px; overflow-x: auto; padding-bottom: 4px; }
    .tab-link { white-space: nowrap; }
  }
</style>

<div class="forum-feed-container">
  
  <!-- Feed Header -->
  <div class="feed-header">
    <h2 class="feed-title">Latest Discussions</h2>
    <a href="#" class="btn-new-topic">
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
  <div class="thread-list">
    
    <!-- PINNED THREAD -->
    <div class="thread-card-pinned">
      <div class="pinned-icon-box">
        <span class="material-symbols-outlined fill-1">push_pin</span>
      </div>
      <div class="thread-main">
        <div class="thread-meta-top">
          <span class="badge-pinned-label">Pinned by Moderator</span>
        </div>
        <h3 class="thread-title">Community Guidelines & Forum Rules — Please Read First</h3>
        <div class="thread-last-reply">
          By <strong>Spider Tech Admin</strong> <span class="material-symbols-outlined text-primary" style="font-size: 14px; vertical-align: middle;">verified</span>
        </div>
      </div>
      <div class="thread-stats">
        <span class="badge-pinned-label">Pinned</span>
      </div>
    </div>

    <!-- Regular Thread 1 -->
    <a href="#" class="thread-card">
      <img src="https://ui-avatars.com/api/?name=James+K&background=f48221&color=fff" class="author-avatar" alt="JK">
      <div class="thread-main">
        <div class="thread-meta-top">
          <span class="category-pill">Developer Hub</span>
        </div>
        <h3 class="thread-title">The Future of AI in African Tech Startups</h3>
        <div class="thread-last-reply">
          Last by <strong>James K.</strong> • 3h ago
        </div>
      </div>
      <div class="thread-stats">
        <div class="stat-item">
          <span class="material-symbols-outlined">chat_bubble</span> 42
        </div>
      </div>
    </a>

    <!-- Regular Thread 2 -->
    <a href="#" class="thread-card">
      <img src="https://ui-avatars.com/api/?name=Alice+M&background=0284c7&color=fff" class="author-avatar" alt="AM">
      <div class="thread-main">
        <div class="thread-meta-top">
          <span class="category-pill">Startup Advice</span>
        </div>
        <h3 class="thread-title">Best Practices for Remote Team Management</h3>
        <div class="thread-last-reply">
          Last by <strong>Alice M.</strong> • Yesterday
        </div>
      </div>
      <div class="thread-stats">
        <div class="stat-item">
          <span class="material-symbols-outlined">chat_bubble</span> 28
        </div>
      </div>
    </a>

    <!-- Regular Thread 3 -->
    <a href="#" class="thread-card">
      <img src="https://ui-avatars.com/api/?name=Chris+O&background=059669&color=fff" class="author-avatar" alt="CO">
      <div class="thread-main">
        <div class="thread-meta-top">
          <span class="category-pill">Hardware Review</span>
        </div>
        <h3 class="thread-title">Reviewing the New MacBook Pro M4: Worth It?</h3>
        <div class="thread-last-reply">
          Last by <strong>Chris O.</strong> • 2 days ago
        </div>
      </div>
      <div class="thread-stats">
        <div class="stat-item">
          <span class="material-symbols-outlined">chat_bubble</span> 15
        </div>
      </div>
    </a>

    <!-- Regular Thread 4 (HOT) -->
    <a href="#" class="thread-card">
      <img src="https://ui-avatars.com/api/?name=Sarah+B&background=7c3aed&color=fff" class="author-avatar" alt="SB">
      <div class="thread-main">
        <div class="thread-meta-top">
          <span class="category-pill">Industry News</span>
          <span class="badge-hot">
            <span class="material-symbols-outlined fill-1" style="font-size: 14px;">local_fire_department</span> HOT
          </span>
        </div>
        <h3 class="thread-title">What Tech Trends Are Shaping 2026?</h3>
        <div class="thread-last-reply">
          Last by <strong>Sarah B.</strong> • 3 days ago
        </div>
      </div>
      <div class="thread-stats">
        <div class="stat-item">
          <span class="material-symbols-outlined">chat_bubble</span> 63
        </div>
      </div>
    </a>

  </div>

  <!-- Pagination -->
  <div class="feed-pagination">
    <a href="#" class="pag-btn">
      <span class="material-symbols-outlined">chevron_left</span> Previous
    </a>
    <span class="pag-info">Page 1 of 8</span>
    <a href="#" class="pag-btn">
      Next <span class="material-symbols-outlined">chevron_right</span>
    </a>
  </div>

</div>
