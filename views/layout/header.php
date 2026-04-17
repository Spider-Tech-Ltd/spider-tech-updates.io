<?php
  // --- Phase 6: Server-side active nav segment detection ---
  $currentUrl = rtrim($_GET['url'] ?? 'home', '/');
  // Normalize: "events/detail" → "events", "" → "home"
  $navSegment = explode('/', $currentUrl ?: 'home')[0];
  function navActive(string $segment, string $current): string {
      return ($segment === $current) ? ' active' : '';
  }
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spider Tech</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/animate.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/flaticon.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/owl.carousel.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/owl.theme.default.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/lightbox.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/skin-red.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/header.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/responsive.css" />
  <!-- Global Header Section — Phase 6 Redesign -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />
  <script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Alpine.js for Forum Interactivity (Including Collapse Plugin) -->
  <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
  <div id="preloader">
    <div id="status">
      <div class="loader">
        <div class="loader-inner"></div>
      </div>
    </div>
  </div>

  <style>
    /* ====================================================
       HEADER — Industrial-Grade Design System
       Phase 6: Mobile Accessibility & Active State
    ==================================================== */

    /* ====== Modern Header Reset & Base ====== */
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1200;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 28px 0;
    }

    /* Scrolled State: Glassmorphism */
    .site-header.is-scrolled {
      padding: 14px 0;
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

    /* ====== Logo ====== */
    .header-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none !important;
    }

    .logo-img {
      height: 45px;
      width: auto;
    }

    /* ====== Desktop Navigation Links ====== */
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

    .nav-link-item:hover::after,
    .nav-link-item.active::after {
      width: 100%;
    }

    /* Active link colour */
    .nav-link-item.active {
      color: #f48221;
      font-weight: 700;
    }

    /* ====== Header Actions ====== */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 24px;
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

    /* ====== Hamburger Button ====== */
    .mobile-toggle {
      display: none;
      background: none;
      border: 1.5px solid rgba(17, 17, 17, 0.12);
      color: #111111;
      padding: 7px 9px;
      cursor: pointer;
      border-radius: 12px;
      transition: all 0.25s ease;
      line-height: 0;
    }

    .mobile-toggle:hover {
      background: rgba(244, 130, 33, 0.07);
      border-color: rgba(244, 130, 33, 0.3);
      color: #f48221;
    }

    .mobile-toggle:focus-visible {
      outline: 2px solid #f48221;
      outline-offset: 2px;
    }

    /* ====== Mobile Breakpoint ====== */
    @media (max-width: 1024px) {
      .header-nav {
        display: none; /* Desktop nav hidden; replaced by drawer */
      }

      .mobile-toggle {
        display: flex;
        align-items: center;
      }

      /* Hide the desktop CTA button — it lives in the drawer on mobile */
      .btn-cta-desktop {
        display: none !important;
      }

      .site-header {
        padding: 20px 0;
      }
    }

    /* ====================================================
       MOBILE DRAWER SYSTEM
    ==================================================== */

    /* --- Backdrop Overlay --- */
    .mobile-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
      z-index: 1100;
      opacity: 0;
      transition: opacity 0.35s ease;
    }

    .mobile-backdrop.is-visible {
      display: block;
      opacity: 1;
    }

    /* --- Dropdown Panel (Stretch Header Style) --- */
    .mobile-dropdown-panel {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 24px 70px rgba(0, 0, 0, 0.15);
      border-top: 1px solid rgba(244, 130, 31, 0.08);
      display: grid;
      grid-template-rows: 0fr;
      transition: grid-template-rows 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0.4s;
      opacity: 0;
      visibility: hidden;
      z-index: -1;
    }

    .mobile-dropdown-panel.is-open {
      grid-template-rows: 1fr;
      opacity: 1;
      visibility: visible;
    }

    .mobile-dropdown-inner {
      overflow: hidden;
    }

    .mobile-dropdown-scrollable {
      max-height: calc(100vh - 80px); /* fit viewport below header */
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    /* Dropdown Nav Links */
    .drawer-links {
      display: flex;
      flex-direction: column;
      padding: 20px 16px 0;
      flex: 1;
      overflow-y: auto;
      gap: 2px;
    }

    .drawer-link {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 0.97rem;
      color: #374151;
      text-decoration: none !important;
      padding: 13px 16px;
      border-radius: 14px;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      position: relative;
      letter-spacing: 0.1px;
    }

    .drawer-link:hover {
      background: rgba(244, 130, 33, 0.06);
      color: #f48221;
    }

    /* Active drawer link */
    .drawer-link.active {
      background: rgba(244, 130, 33, 0.09);
      color: #f48221;
      font-weight: 700;
    }

    .drawer-link.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 22%;
      height: 56%;
      width: 3px;
      background: #f48221;
      border-radius: 0 4px 4px 0;
    }

    /* Drawer Footer — Contact CTA */
    .drawer-footer {
      padding: 20px 16px 28px;
      border-top: 1px solid #f0f0f0;
      flex-shrink: 0;
    }

    .drawer-cta {
      width: 100%;
      justify-content: center;
      min-width: unset;
      border-radius: 16px;
      font-size: 0.9rem;
      padding: 14px 20px;
    }
  </style>

  <div class="wraper">
    <header class="site-header" id="mainHeader">
      <div class="header-container">

        <!-- Logo -->
        <a href="<?= BASE_URL ?>/home" class="header-logo">
          <img src="<?= BASE_URL ?>/images/spider-tech.png" class="logo-img" alt="Spider Tech">
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav" aria-label="Main navigation">
          <a href="<?= BASE_URL ?>/home"      class="nav-link-item<?= navActive('home',      $navSegment) ?>">Home</a>
          <a href="<?= BASE_URL ?>/about"     class="nav-link-item<?= navActive('about',     $navSegment) ?>">About Us</a>
          <a href="<?= BASE_URL ?>/services"  class="nav-link-item<?= navActive('services',  $navSegment) ?>">Services</a>
          <a href="<?= BASE_URL ?>/projects"  class="nav-link-item<?= navActive('projects',  $navSegment) ?>">Projects</a>
          <a href="<?= BASE_URL ?>/events"    class="nav-link-item<?= navActive('events',    $navSegment) ?>">Events</a>
          <a href="<?= BASE_URL ?>/trainings" class="nav-link-item<?= navActive('trainings', $navSegment) ?>">Trainings</a>
          <a href="<?= BASE_URL ?>/forum"     class="nav-link-item<?= navActive('forum',     $navSegment) ?>">Forum</a>
          <a href="<?= BASE_URL ?>/blog"      class="nav-link-item<?= navActive('blog',      $navSegment) ?>">Blog</a>
        </nav>

        <!-- Actions -->
        <div class="header-actions">
          <!-- Contact Us: desktop only. Hidden on mobile via .btn-cta-desktop -->
          <a href="<?= BASE_URL ?>/contact" class="btn-header-cta btn-cta-desktop">Contact Us</a>

          <!-- Mobile Hamburger Toggle -->
          <button
            class="mobile-toggle"
            id="mobileMenuOpen"
            aria-label="Open navigation menu"
            aria-expanded="false"
            aria-controls="mobileDrawer">
            <span class="material-symbols-outlined" id="hamburgerIcon" style="font-size:24px;">menu</span>
          </button>
        </div>

      </div>

      <!-- ====== Mobile Nav Dropdown ====== -->
      <nav
        id="mobileDrawer"
        class="mobile-dropdown-panel"
        role="navigation"
        aria-label="Mobile navigation"
        aria-hidden="true">
        <div class="mobile-dropdown-inner">
          <div class="mobile-dropdown-scrollable">
            <!-- Dropdown Nav Links -->
            <div class="drawer-links">
              <a href="<?= BASE_URL ?>/home"      class="drawer-link<?= navActive('home',      $navSegment) ?>">Home</a>
              <a href="<?= BASE_URL ?>/about"     class="drawer-link<?= navActive('about',     $navSegment) ?>">About Us</a>
              <a href="<?= BASE_URL ?>/services"  class="drawer-link<?= navActive('services',  $navSegment) ?>">Services</a>
              <a href="<?= BASE_URL ?>/projects"  class="drawer-link<?= navActive('projects',  $navSegment) ?>">Projects</a>
              <a href="<?= BASE_URL ?>/events"    class="drawer-link<?= navActive('events',    $navSegment) ?>">Events</a>
              <a href="<?= BASE_URL ?>/trainings" class="drawer-link<?= navActive('trainings', $navSegment) ?>">Trainings</a>
              <a href="<?= BASE_URL ?>/forum"     class="drawer-link<?= navActive('forum',     $navSegment) ?>">Forum</a>
              <a href="<?= BASE_URL ?>/blog"      class="drawer-link<?= navActive('blog',      $navSegment) ?>">Blog</a>
            </div>

            <!-- Dropdown Footer — Contact CTA (mobile-only) -->
            <div class="drawer-footer">
              <a href="<?= BASE_URL ?>/contact" class="btn-header-cta drawer-cta">Contact Us</a>
            </div>
          </div>
        </div>
      </nav>

    </header>

    <!-- ====== Mobile Nav Backdrop ====== -->
    <div id="mobileBackdrop" class="mobile-backdrop" aria-hidden="true"></div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const header       = document.getElementById('mainHeader');
        const openBtn      = document.getElementById('mobileMenuOpen');
        const drawer       = document.getElementById('mobileDrawer');
        const backdrop     = document.getElementById('mobileBackdrop');
        const hamIcon      = document.getElementById('hamburgerIcon');

        // ---- Scroll glassmorphism ----
        function handleScroll() {
          header.classList.toggle('is-scrolled', window.scrollY > 40);
        }
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();

        // ---- Focusable elements inside drawer ----
        function getFocusable() {
          return Array.from(drawer.querySelectorAll(
            'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
          ));
        }

        // ---- Open Drawer ----
        function openDrawer() {
          drawer.classList.add('is-open');
          backdrop.classList.add('is-visible');
          document.body.style.overflow = 'hidden';
          openBtn.setAttribute('aria-expanded', 'true');
          drawer.setAttribute('aria-hidden', 'false');
          hamIcon.textContent = 'close';
          
          // Move focus to the first focusable element inside the drawer
          const focusable = getFocusable();
          if(focusable.length > 0) requestAnimationFrame(() => focusable[0].focus());
        }

        // ---- Close Drawer ----
        function closeDrawer() {
          drawer.classList.remove('is-open');
          backdrop.classList.remove('is-visible');
          document.body.style.overflow = '';
          openBtn.setAttribute('aria-expanded', 'false');
          drawer.setAttribute('aria-hidden', 'true');
          hamIcon.textContent = 'menu';
          // Return focus to the hamburger button
          openBtn.focus();
        }

        // Toggle handling
        function toggleDrawer() {
            if(drawer.classList.contains('is-open')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        }

        // ---- Focus Trap inside drawer ----
        drawer.addEventListener('keydown', function (e) {
          if (e.key !== 'Tab') return;
          const focusable = getFocusable();
          const first = focusable[0];
          const last  = focusable[focusable.length - 1];
          if (e.shiftKey) {
            if (document.activeElement === first) { e.preventDefault(); last.focus(); }
          } else {
            if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
          }
        });

        // ---- Event Bindings ----
        openBtn.addEventListener('click',  toggleDrawer);
        backdrop.addEventListener('click', closeDrawer);

        // Close on Escape
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeDrawer();
          }
        });
      });
    </script>