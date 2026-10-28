<?php
/**
 * Forum Hero Section — Industrial Engineering Hub
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-hero.css?v=<?= filemtime(ROOT_PATH . '/css/forum-hero.css') ?>" />

<!-- ====== Forum Hero Section ====== -->
<section class="forum-hero-section">
  <div class="forum-hero-grid-pattern" aria-hidden="true"></div>

  <div class="container forum-hero-inner">

    <!-- Signature Eyebrow with SVG Ornament -->
    <div class="mb-3">
      <span class="section-eyebrow">
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
          <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
        </svg>
        <span class="eyebrow-label-text">Spider Tech Community Hub</span>
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
          <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
        </svg>
      </span>
    </div>

    <!-- Scaled Industrial Heading -->
    <h1 class="hero-heading">Engineering Intelligence &amp; <span>Industrial Solutions</span></h1>

    <!-- Subtext -->
    <p class="hero-subtext">
      Connect with <?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+ industrial automation practitioners, system engineers, and technology leaders. Ask questions, troubleshoot field challenges, and share technical blueprints.
    </p>

    <!-- Instant Search & Quick Tag Discovery Bar -->
    <div class="hero-search-wrapper">
      <form action="<?= BASE_URL ?>/forum/feed" method="GET" class="hero-search-form">
        <div class="search-input-group">
          <span class="material-symbols-outlined search-prefix-icon">search</span>
          <input type="text" name="search" class="hero-search-input" placeholder="Search discussions, PLC error codes, hardware models, or technical queries..." autocomplete="off">
        </div>
        <button type="submit" class="hero-search-submit">
          <span>Find Discussions</span>
          <span class="material-symbols-outlined">arrow_forward</span>
        </button>
      </form>
      
      <!-- Trending Engineering Tags -->
      <div class="hero-trending-tags">
        <span class="trending-title">Popular:</span>
        <a href="<?= BASE_URL ?>/forum/feed?search=PLC" class="trending-chip">#PLC-Programming</a>
        <a href="<?= BASE_URL ?>/forum/feed?search=SCADA" class="trending-chip">#SCADA</a>
        <a href="<?= BASE_URL ?>/forum/feed?search=Robotics" class="trending-chip">#Robotics</a>
        <a href="<?= BASE_URL ?>/forum/feed?search=IIoT" class="trending-chip">#Industrial-IoT</a>
        <a href="<?= BASE_URL ?>/forum/feed?search=VFD" class="trending-chip">#VFD-Drives</a>
      </div>
    </div>

    <!-- Actions Row -->
    <div class="hero-actions-bar">
      <?php if (isset($_SESSION['member_uuid'])): ?>
        <a href="<?= BASE_URL ?>/forum/new-topic" class="hero-action-pill primary">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start New Discussion</span>
        </a>
        <a href="<?= BASE_URL ?>/forum/feed" class="hero-action-pill secondary">
          <span class="material-symbols-outlined">format_list_bulleted</span>
          <span>Browse All Threads</span>
        </a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-action-pill primary">
          <span class="material-symbols-outlined">add_circle</span>
          <span>Start New Discussion</span>
        </a>
        <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-action-pill secondary">
          <span class="material-symbols-outlined">login</span>
          <span>Sign In to Community</span>
        </a>
      <?php endif; ?>
    </div>

    <!-- Precision Telemetry Status Strip -->
    <div>
      <div class="hero-telemetry-strip">
        <div class="telemetry-node">
          <span class="status-indicator-dot"></span>
          <span class="telemetry-data"><?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+</span>
          <span class="telemetry-caption">Verified Engineers</span>
        </div>
        <div class="telemetry-divider" aria-hidden="true"></div>
        <div class="telemetry-node">
          <span class="material-symbols-outlined node-icon">forum</span>
          <span class="telemetry-data"><?= Utils::formatNumber($global_stats['total_discussions'] ?? 0) ?></span>
          <span class="telemetry-caption">Technical Topics</span>
        </div>
        <div class="telemetry-divider" aria-hidden="true"></div>
        <div class="telemetry-node">
          <span class="material-symbols-outlined node-icon">verified_user</span>
          <span class="telemetry-data">Peer-Reviewed</span>
          <span class="telemetry-caption">Moderated Intelligence</span>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- ====== Forum Hero End ====== -->
