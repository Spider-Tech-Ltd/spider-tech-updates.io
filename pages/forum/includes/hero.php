<?php
/**
 * Forum Hero Section — Phase 1 Redesign
 * Generated via Stitch MCP (screen: 1d17ebcda4f3407c9ccdb8d27d248948)
 * Translated from Tailwind to Bootstrap 4 + Vanilla CSS
 */
?>

<style>
  /* ====== Hero Section Styles ====== */
  .forum-hero-section {
    position: relative;
    background-color: #f4f4f4;
    padding: 160px 16px 80px 16px; /* Increased top padding for fixed header */
    overflow: hidden;
    text-align: center;
  }

  /* Radial gradient glow centered behind content */
  .forum-hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(244, 130, 33, 0.08) 0%, transparent 68%);
    pointer-events: none;
    z-index: 0;
  }

  /* Decorative ambient blobs */
  .forum-hero-blob {
    position: absolute;
    border-radius: 50%;
    background-color: rgba(244, 130, 33, 0.06);
    filter: blur(60px);
    pointer-events: none;
  }
  .forum-hero-blob-left  { width: 280px; height: 280px; top: 20%; left: -80px; }
  .forum-hero-blob-right { width: 320px; height: 320px; bottom: 15%; right: -80px; }

  .forum-hero-inner { position: relative; z-index: 1; }

  /* Eyebrow pill */
  .hero-eyebrow-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 18px;
    border-radius: 50px;
    background-color: rgba(244, 130, 33, 0.12);
    border: 1px solid rgba(244, 130, 33, 0.25);
    font-family: 'Poppins', sans-serif;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #f48221;
    margin-bottom: 28px;
  }
  .hero-eyebrow-pill .material-symbols-outlined { font-size: 16px; }

  /* Main heading */
  .hero-heading {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 3.5rem;
    line-height: 1.2;
    color: #111111;
    max-width: 700px;
    margin: 0 auto 20px;
    animation: heroFadeUp 0.6s ease both;
  }

  @keyframes heroFadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 768px) {
    .hero-heading { font-size: 2.2rem; }
    .forum-hero-section { padding: 120px 16px 56px 16px; } /* Increased top padding for mobile */
  }

  /* Subheading */
  .hero-subtext {
    font-family: 'Open Sans', sans-serif;
    font-size: 1.15rem;
    color: #555555;
    max-width: 600px;
    margin: 0 auto 48px;
    line-height: 1.7;
  }

  /* Action row container */
  .hero-action-row {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 56px;
  }

  /* Buttons */
  .hero-btn-group {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
  }
  .hero-btn-primary {
    height: 48px;
    padding: 0 16px;
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    border-radius: 50px;
    white-space: nowrap;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(244, 130, 33, 0.35);
    transition: background-color 0.2s ease, transform 0.1s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 220px;
  }
  .hero-btn-primary:hover  { background-color: #e6751c; color: #fff; text-decoration: none; }
  .hero-btn-primary:active { transform: scale(0.97); }

  .hero-btn-secondary {
    height: 48px;
    padding: 0 16px;
    background-color: transparent;
    color: #f48221;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid #f48221;
    border-radius: 50px;
    white-space: nowrap;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 220px;
  }
  .hero-btn-secondary:hover { background-color: rgba(244,130,33,0.07); color: #f48221; text-decoration: none; }

  @media (max-width: 767px) {
    .hero-action-row { flex-direction: column; }
    .hero-btn-group { width: 100%; flex-direction: column; }
    .hero-btn-primary, .hero-btn-secondary { width: 100%; justify-content: center; }
  }

  /* Stats row */
  .hero-stats-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
  }
  .hero-stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 40px;
  }
  .hero-stat-item:not(:last-child) {
    border-right: 1px solid #e0e0e0;
  }
  .hero-stat-number {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.9rem;
    color: #111111;
    line-height: 1.1;
  }
  .hero-stat-label {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.82rem;
    color: #797979;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-top: 4px;
  }

  @media (max-width: 576px) {
    .hero-stats-row { flex-direction: column; }
    .hero-stat-item { padding: 16px 20px; border-right: none !important; width: 100%; }
    .hero-stat-item:not(:last-child) { border-bottom: 1px solid rgba(0,0,0,0.05); }
    .hero-heading { font-size: 1.8rem; }
    .hero-subtext { font-size: 1rem; margin-bottom: 32px; }
  }
</style>

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
      Join 12,000+ experts to share insights, solve complex engineering challenges, and accelerate your technical career.
    </p>

    <!-- Buttons Row -->
    <div class="hero-action-row">
      <div class="hero-btn-group">
        <a href="pages/forum/new-topic.php" class="hero-btn-primary">Start a Discussion</a>
        <a href="pages/forum/sign-in.php" class="hero-btn-secondary">Sign In</a>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="hero-stats-row">
      <div class="hero-stat-item">
        <span class="hero-stat-number">12k+</span>
        <span class="hero-stat-label">Members</span>
      </div>
      <div class="hero-stat-item">
        <span class="hero-stat-number">450</span>
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
