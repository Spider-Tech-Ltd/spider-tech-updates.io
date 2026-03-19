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

  /* Trending Topics */
  .trending-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .trending-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    text-decoration: none !important;
  }
  .trending-rank {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    color: #f48221;
    width: 20px;
    flex-shrink: 0;
    line-height: 1.2;
  }
  .trending-content { flex: 1; }
  .trending-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    color: #111111;
    display: block;
    line-height: 1.3;
    transition: color 0.2s;
  }
  .trending-item:hover .trending-link { color: #f48221; }
  .trending-replies {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: #797979;
    margin-top: 2px;
    display: block;
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

  /* Join CTA Card */
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

  <!-- WIDGET 1: Trending Topics -->
  <section class="sidebar-widget">
    <h3 class="widget-title">🔥 Trending Topics</h3>
    <div class="trending-list">
      <a href="#" class="trending-item">
        <span class="trending-rank">1</span>
        <div class="trending-content">
          <span class="trending-link">AI Tools Roundup 2026</span>
          <span class="trending-replies">142 replies</span>
        </div>
      </a>
      <a href="#" class="trending-item">
        <span class="trending-rank">2</span>
        <div class="trending-content">
          <span class="trending-link">Web3 in Africa</span>
          <span class="trending-replies">98 replies</span>
        </div>
      </a>
      <a href="#" class="trending-item">
        <span class="trending-rank">3</span>
        <div class="trending-content">
          <span class="trending-link">Python vs Go: The 2026 Verdict</span>
          <span class="trending-replies">76 replies</span>
        </div>
      </a>
      <a href="#" class="trending-item">
        <span class="trending-rank">4</span>
        <div class="trending-content">
          <span class="trending-link">Best Laptops for Devs</span>
          <span class="trending-replies">54 replies</span>
        </div>
      </a>
      <a href="#" class="trending-item">
        <span class="trending-rank">5</span>
        <div class="trending-content">
          <span class="trending-link">Open Source Alternatives</span>
          <span class="trending-replies">43 replies</span>
        </div>
      </a>
    </div>
  </section>

  <!-- WIDGET 2: Top Contributors -->
  <section class="sidebar-widget">
    <h3 class="widget-title">⭐ Top Contributors</h3>
    <div class="contributor-list">
      <div class="contributor-item">
        <div class="contributor-avatar avatar-orange">J</div>
        <div class="contributor-info">
          <span class="contributor-name">James K.</span>
          <span class="contributor-posts">24 posts this week</span>
        </div>
      </div>
      <div class="contributor-item">
        <div class="contributor-avatar avatar-blue">A</div>
        <div class="contributor-info">
          <span class="contributor-name">Alice M.</span>
          <span class="contributor-posts">18 posts this week</span>
        </div>
      </div>
      <div class="contributor-item">
        <div class="contributor-avatar avatar-green">C</div>
        <div class="contributor-info">
          <span class="contributor-name">Chris O.</span>
          <span class="contributor-posts">15 posts this week</span>
        </div>
      </div>
      <div class="contributor-item">
        <div class="contributor-avatar avatar-purple">S</div>
        <div class="contributor-info">
          <span class="contributor-name">Sarah B.</span>
          <span class="contributor-posts">12 posts this week</span>
        </div>
      </div>
      <div class="contributor-item">
        <div class="contributor-avatar avatar-rose">D</div>
        <div class="contributor-info">
          <span class="contributor-name">David A.</span>
          <span class="contributor-posts">9 posts this week</span>
        </div>
      </div>
    </div>
  </section>

  <!-- WIDGET 3: Join CTA -->
  <section class="sidebar-join-card">
    <h3 class="join-title">New Here?</h3>
    <p class="join-body">
      Join the Spider Tech Community to start posting, ask questions, and connect with thousands of tech professionals.
    </p>
    <div class="join-btn-group">
      <a href="#" class="join-btn-primary">Register Free</a>
      <a href="#" class="join-btn-secondary">Sign In</a>
    </div>
  </section>

</aside>
