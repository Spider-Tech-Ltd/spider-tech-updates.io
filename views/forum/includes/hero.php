<?php

/**
 * Forum Hero Section — Phase 1 Redesign
 * Generated via Stitch MCP (screen: 1d17ebcda4f3407c9ccdb8d27d248948)
 * Translated from Tailwind to Bootstrap 4 + Vanilla CSS
 */
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-hero.css" />

<!-- ====== Forum Hero Section ====== -->
<section class="forum-hero-section">
  <!-- Decorative blobs -->
  <div class="forum-hero-blob forum-hero-blob-left"></div>
  <div class="forum-hero-blob forum-hero-blob-right"></div>

  <div class="forum-hero-inner">

    <!-- Eyebrow pill -->
    <div>
      <span class="hero-eyebrow-pill">
        <span class="material-symbols-outlined">auto_awesome</span>
        Spider Tech Community
      </span>
    </div>

    <!-- Heading -->
    <h1 class="hero-heading">Master the Industrial Tech of Tomorrow</h1>

    <!-- Subtext -->
    <p class="hero-subtext">
      Join <?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+ experts to share insights, solve complex engineering challenges, and accelerate your technical career.
    </p>

    <!-- Buttons Row -->
    <div class="hero-action-row">
      <div class="hero-btn-group">
        <?php if (isset($_SESSION['member_uuid'])): ?>
          <a href="<?= BASE_URL ?>/forum/feed" class="hero-btn-primary">Start a Discussion</a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-btn-primary">Start a Discussion</a>
          <a href="<?= BASE_URL ?>/forum/sign-in" class="hero-btn-secondary">Sign In</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="hero-stats-row">
      <div class="hero-stat-item">
        <span class="hero-stat-number"><?= Utils::formatNumber($global_stats['total_members'] ?? 0) ?>+</span>
        <span class="hero-stat-label">Members</span>
      </div>
      <div class="hero-stat-item">
        <span class="hero-stat-number"><?= Utils::formatNumber($global_stats['total_discussions'] ?? 0) ?></span>
        <span class="hero-stat-label">Active Topics</span>
      </div>
      <div class="hero-stat-item">
        <span class="hero-stat-number">24/7</span>
        <span class="hero-stat-label">Support</span>
      </div>
    </div>

  </div>
</section>
<!-- ====== Forum Hero End ====== -->