<?php

/**
 * Global Header Section — Phase 6 Redesign
 * Features: Transparent-to-Glass transition, Glassmorphism, Modern Nav Links, Brand Pill CTA
 * Generated via Stitch MCP & Redfined for Spider Tech
 */
?>

<!-- Material Symbols and Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />

<style>
  /* ====== Modern Header Reset & Base ====== */
  .site-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 24px 0;
  }

  /* Scrolled State: Glassmorphism */
  .site-header.is-scrolled {
    padding: 12px 0;
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid rgba(244, 130, 31, 0.1);
  }

  .header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Logo */
  .header-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none !important;
  }

  .logo-icon {
    width: 40px;
    height: 40px;
    background-color: #f48221;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 4px 10px rgba(244, 130, 33, 0.2);
  }

  .logo-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #111111;
    letter-spacing: -0.02em;
  }

  .logo-text span {
    color: #f48221;
  }

  /* Navigation Links */
  .header-nav {
    display: flex;
    align-items: center;
    gap: 32px;
  }

  .nav-link-item {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    color: #111111;
    text-decoration: none !important;
    position: relative;
    transition: color 0.3s;
  }

  .nav-link-item:hover {
    color: #f48221;
  }

  /* Sliding Underline Effect */
  .nav-link-item::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    left: 0;
    background-color: #f48221;
    transition: width 0.3s ease;
  }

  .nav-link-item:hover::after {
    width: 100%;
  }

  .nav-link-item.active::after {
    width: 100%;
  }

  /* Action Area */
  .header-actions {
    display: flex;
    align-items: center;
    gap: 24px;
  }

  .action-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    color: #111111;
    text-decoration: none !important;
    transition: color 0.3s;
  }

  .action-link:hover {
    color: #f48221;
  }

  .btn-header-cta {
    background-color: #f48221;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 10px 24px;
    border-radius: 50px;
    border: none;
    box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
    transition: all 0.3s ease;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 130px;
  }

  .btn-header-cta:hover {
    background-color: #e6751c;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(244, 130, 33, 0.35);
  }

  /* Hamburger (Mobile) */
  .mobile-toggle {
    display: none;
    background: none;
    border: none;
    color: #111111;
    padding: 8px;
    cursor: pointer;
  }

  @media (max-width: 1024px) {

    .header-nav,
    .header-actions .action-link {
      display: none;
    }

    .mobile-toggle {
      display: block;
    }

    .site-header {
      padding: 16px 0;
    }
  }
</style>

<header class="site-header" id="mainHeader">
  <div class="header-container">

    <!-- Logo -->
    <a href="index.php" class="header-logo">
      <div class="logo-icon">
        <span class="material-symbols-outlined">hub</span>
      </div>
      <h1 class="logo-text">Spider <span>Tech</span></h1>
    </a>

    <!-- Main Navigation -->
    <nav class="header-nav">
      <a href="index.php" class="nav-link-item active">Home</a>
      <a href="about-us.php" class="nav-link-item">About Us</a>
      <a href="services.php" class="nav-link-item">Services</a>
      <a href="projects.php" class="nav-link-item">Projects</a>
      <a href="trainings.php" class="nav-link-item">Trainings</a>
      <a href="pages/forum/index.php" class="nav-link-item">Forum</a>
      <a href="pages/blog/index.php" class="nav-link-item">Blog</a>
    </nav>

    <!-- Actions -->
    <div class="header-actions">
      <a href="contact-us.php" class="btn-header-cta">Contact Us</a>

      <!-- Mobile Toggle -->
      <button class="mobile-toggle" id="mobileMenuOpen">
        <span class="material-symbols-outlined">menu</span>
      </button>
    </div>

  </div>
</header>

<script>
  /**
   * Header Scroll Effect Listener
   */
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('mainHeader');

    function handleScroll() {
      if (window.scrollY > 40) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }

    // Initialize on load and on scroll
    window.addEventListener('scroll', handleScroll);
    handleScroll();
  });
</script>