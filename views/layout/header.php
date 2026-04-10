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
    /* ====== Modern Header Reset & Base ====== */
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
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

    /* Logo */
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
      .header-nav {
        display: none;
      }

      .mobile-toggle {
        display: block;
      }

      .site-header {
        padding: 20px 0;
      }
    }
  </style>

  <div class="wraper">
    <header class="site-header" id="mainHeader">
      <div class="header-container">

        <!-- Logo -->
        <a href="<?= BASE_URL ?>/home" class="header-logo">
          <img src="<?= BASE_URL ?>/images/spider-tech.png" class="logo-img" alt="Spider Tech">
        </a>

        <!-- Main Navigation -->
        <nav class="header-nav">
          <a href="<?= BASE_URL ?>/home" class="nav-link-item active">Home</a>
          <a href="<?= BASE_URL ?>/about" class="nav-link-item">About Us</a>
          <a href="<?= BASE_URL ?>/services" class="nav-link-item">Services</a>
          <a href="<?= BASE_URL ?>/projects" class="nav-link-item">Projects</a>
          <a href="<?= BASE_URL ?>/trainings" class="nav-link-item">Trainings</a>
          <a href="<?= BASE_URL ?>/forum" class="nav-link-item">Forum</a>
          <a href="<?= BASE_URL ?>/blog" class="nav-link-item">Blog</a>
          <a href="<?= BASE_URL ?>/events" class="nav-link-item">Events</a>
        </nav>

        <!-- Actions -->
        <div class="header-actions">
          <a href="<?= BASE_URL ?>/contact" class="btn-header-cta">Contact Us</a>

          <!-- Mobile Toggle -->
          <button class="mobile-toggle" id="mobileMenuOpen">
            <span class="material-symbols-outlined">menu</span>
          </button>
        </div>

      </div>
    </header>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('mainHeader');

        function handleScroll() {
          if (window.scrollY > 40) {
            header.classList.add('is-scrolled');
          } else {
            header.classList.remove('is-scrolled');
          }
        }
        window.addEventListener('scroll', handleScroll);
        handleScroll();
      });
    </script>