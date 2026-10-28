<?php
/**
 * Forum Hero Section — Industrial Engineering Aesthetic
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-hero.css?v=<?= filemtime(ROOT_PATH . '/css/forum-hero.css') ?>" />

<!-- ====== Forum Hero Section ====== -->
<section class="forum-hero-section">
  <!-- Decorative ambient grid/glow -->
  <div class="forum-hero-grid-pattern" aria-hidden="true"></div>

  <div class="container forum-hero-inner">

    <!-- Signature Eyebrow with SVG Ornament -->
    <div class="mb-3">
      <span class="section-eyebrow">
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
          <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
        </svg>
        <span class="eyebrow-label-text">Spider Tech Community</span>
        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
          <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
        </svg>
      </span>
    </div>

    <!-- Scaled Industrial Heading -->
    <h1 class="hero-heading">Master the Industrial Tech <span>of Tomorrow</span></h1>

    <!-- Subtext -->
    <p class="hero-subtext">
      Join <?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+ engineers, practitioners, and technology leaders to share intelligence, solve complex engineering challenges, and accelerate your technical career.
    </p>

    <!-- Buttons Row -->
    <div class="hero-action-row">
      <div class="hero-btn-group">
        <?php if (isset($_SESSION['member_uuid'])): ?>
          <a href="<?= BASE_URL ?>/forum/new-topic" class="hero-btn-primary">
            <span>Start a Discussion</span>
            <span class="material-symbols-outlined">edit</span>
          </a>
          <a href="<?= BASE_URL ?>/forum/feed" class="hero-btn-secondary">
            <span>Browse Feed</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-btn-primary">
            <span>Start a Discussion</span>
            <span class="material-symbols-outlined">edit</span>
          </a>
          <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-btn-secondary">
            <span>Sign In</span>
            <span class="material-symbols-outlined">login</span>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Precision Stats Row -->
    <div class="hero-stats-row">
      <div class="hero-stat-item">
        <span class="material-symbols-outlined stat-icon">group</span>
        <div class="stat-content">
          <span class="hero-stat-number"><?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+</span>
          <span class="hero-stat-label">Active Members</span>
        </div>
      </div>
      <div class="hero-stat-item">
        <span class="material-symbols-outlined stat-icon">forum</span>
        <div class="stat-content">
          <span class="hero-stat-number"><?= Utils::formatNumber($global_stats['total_discussions'] ?? 0) ?></span>
          <span class="hero-stat-label">Active Discussions</span>
        </div>
      </div>
      <div class="hero-stat-item">
        <span class="material-symbols-outlined stat-icon">verified</span>
        <div class="stat-content">
          <span class="hero-stat-number">24/7</span>
          <span class="hero-stat-label">Peer Collaboration</span>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- ====== Forum Hero End ====== -->
