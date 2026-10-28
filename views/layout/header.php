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
  <title><?= isset($og_title) ? htmlspecialchars($og_title) . ' — Spider Tech' : 'Spider Tech' ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
  <?php if (isset($og_title)): ?>
  <!-- Open Graph / Social Sharing Meta Tags -->
  <meta property="og:type"        content="article">
  <meta property="og:site_name"   content="Spider Tech">
  <meta property="og:title"       content="<?= htmlspecialchars($og_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($og_description ?? '') ?>">
  <meta property="og:image"       content="<?= htmlspecialchars($og_image ?? '') ?>">
  <meta property="og:url"         content="<?= htmlspecialchars($og_url ?? '') ?>">
  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="<?= htmlspecialchars($og_title) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($og_description ?? '') ?>">
  <meta name="twitter:image"       content="<?= htmlspecialchars($og_image ?? '') ?>">
  <?php endif; ?>
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
  <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />
  <script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
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

  <link rel="stylesheet" href="<?= BASE_URL ?>/css/site-header.css?v=<?= filemtime(ROOT_PATH . '/css/site-header.css') ?>" />

  <div class="wraper">
    <?php
      if (empty($contact) || !isset($socialLinks)) {
          $headerGm = new GeneralModel($this->db);
          if (empty($contact)) {
              $contact = $headerGm->getContactDetails();
          }
          if (!isset($socialLinks)) {
              $socialLinks = $headerGm->getSocialLinks();
          }
      }
      $topEmail = $contact['contact_email'] ?? '';
      $topPhone = $contact['contact_pno'] ?? '';
      $topPhoneHref = preg_replace('/[^0-9+]/', '', $topPhone);
    ?>
    <!-- ====== Top Utility Bar (Scrolls away, not fixed) ====== -->
    <div class="site-topbar" id="siteTopbar" role="region" aria-label="Company contact and social media links">
      <div class="topbar-container">
        <div class="topbar-contact">
          <?php if (!empty($topEmail)): ?>
            <a href="mailto:<?= htmlspecialchars($topEmail) ?>" class="topbar-link" aria-label="Email us at <?= htmlspecialchars($topEmail) ?>">
              <span class="material-symbols-outlined topbar-icon" aria-hidden="true">mail</span>
              <span><?= htmlspecialchars($topEmail) ?></span>
            </a>
          <?php endif; ?>
          <?php if (!empty($topEmail) && !empty($topPhone)): ?>
            <span class="topbar-divider" aria-hidden="true"></span>
          <?php endif; ?>
          <?php if (!empty($topPhone)): ?>
            <a href="tel:<?= htmlspecialchars($topPhoneHref) ?>" class="topbar-link" aria-label="Call us at <?= htmlspecialchars($topPhone) ?>">
              <span class="material-symbols-outlined topbar-icon" aria-hidden="true">call</span>
              <span><?= htmlspecialchars($topPhone) ?></span>
            </a>
          <?php endif; ?>
        </div>

        <div class="topbar-social" aria-label="Social media links">
          <?php
            $hasSocial = false;
            if (!empty($socialLinks)):
              foreach ($socialLinks as $sl):
                if (!empty($sl['url']) && $sl['url'] !== '#'):
                  $hasSocial = true;
          ?>
            <a target="_blank" rel="noopener noreferrer" href="<?= htmlspecialchars($sl['url']) ?>" class="topbar-social-link" title="<?= htmlspecialchars($sl['platform']) ?>" aria-label="<?= htmlspecialchars($sl['platform']) ?>">
              <i class="<?= htmlspecialchars($sl['icon_class']) ?>" aria-hidden="true"></i>
            </a>
          <?php
                endif;
              endforeach;
            endif;
            if (!$hasSocial):
          ?>
            <a target="_blank" rel="noopener noreferrer" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" class="topbar-social-link" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://x.com/spidertech_hub" class="topbar-social-link" title="X (Twitter)" aria-label="X (Twitter)"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" class="topbar-social-link" title="YouTube" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://linkedin.com/company/spider-technologies-limited" class="topbar-social-link" title="LinkedIn" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" class="topbar-social-link" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <header class="site-header" id="mainHeader">
      <div class="header-container">

        <!-- Left Cluster: Brand Logo + Primary Nav Menu -->
        <div class="header-left-cluster">
          <a href="<?= BASE_URL ?>/home" class="header-logo" aria-label="Spider Tech Home">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" class="logo-img" alt="Spider Tech">
          </a>

          <!-- Primary Navigation (Left Group) -->
          <nav class="header-nav header-nav-primary" aria-label="Primary navigation">
            <a href="<?= BASE_URL ?>/home"      class="nav-link-item<?= navActive('home',      $navSegment) ?>">Home</a>
            <a href="<?= BASE_URL ?>/about"     class="nav-link-item<?= navActive('about',     $navSegment) ?>">About Us</a>
            <a href="<?= BASE_URL ?>/services"  class="nav-link-item<?= navActive('services',  $navSegment) ?>">Services</a>
            <a href="<?= BASE_URL ?>/projects"  class="nav-link-item<?= navActive('projects',  $navSegment) ?>">Projects</a>
            <a href="<?= BASE_URL ?>/events"    class="nav-link-item<?= navActive('events',    $navSegment) ?>">Events</a>
            <a href="<?= BASE_URL ?>/trainings" class="nav-link-item<?= navActive('trainings', $navSegment) ?>">Trainings</a>
            <a href="<?= BASE_URL ?>/blog"      class="nav-link-item<?= navActive('blog',      $navSegment) ?>">Blog</a>
          </nav>
        </div>

        <!-- Right Cluster: Secondary Nav Menu (Forum, FAQ & Contact in Tab Style) + Mobile Toggle -->
        <div class="header-right-cluster">
          <!-- Secondary Navigation (Right Group) -->
          <nav class="header-nav-secondary" aria-label="Secondary navigation">
            <!-- Forum Community Link -->
            <a href="<?= BASE_URL ?>/forum" class="nav-link-item nav-link-forum<?= navActive('forum', $navSegment) ?>" aria-label="Community Forum">
              <span class="material-symbols-outlined nav-forum-icon" aria-hidden="true">forum</span>
              <span>Forum</span>
            </a>

            <!-- Subtle Vertical Separator -->
            <span class="nav-secondary-divider" aria-hidden="true"></span>

            <!-- Tab-Style Capsule for FAQ & Contact -->
            <div class="nav-tab-pill-group" role="group" aria-label="Help and Contact Actions">
              <a href="<?= BASE_URL ?>/faq" class="nav-tab-pill<?= navActive('faq', $navSegment) ?>">
                <span>FAQ</span>
              </a>
              <a href="<?= BASE_URL ?>/contact" class="nav-tab-pill nav-tab-cta<?= navActive('contact', $navSegment) ?>">
                <span>Contact Us</span>
              </a>
            </div>
          </nav>

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
              <span class="drawer-group-label">Navigation</span>
              <a href="<?= BASE_URL ?>/home"      class="drawer-link<?= navActive('home',      $navSegment) ?>">Home</a>
              <a href="<?= BASE_URL ?>/about"     class="drawer-link<?= navActive('about',     $navSegment) ?>">About Us</a>
              <a href="<?= BASE_URL ?>/services"  class="drawer-link<?= navActive('services',  $navSegment) ?>">Services</a>
              <a href="<?= BASE_URL ?>/projects"  class="drawer-link<?= navActive('projects',  $navSegment) ?>">Projects</a>
              <a href="<?= BASE_URL ?>/events"    class="drawer-link<?= navActive('events',    $navSegment) ?>">Events</a>
              <a href="<?= BASE_URL ?>/trainings" class="drawer-link<?= navActive('trainings', $navSegment) ?>">Trainings</a>
              <a href="<?= BASE_URL ?>/blog"      class="drawer-link<?= navActive('blog',      $navSegment) ?>">Blog</a>

              <div class="drawer-divider"></div>

              <span class="drawer-group-label">Community & Support</span>
              <a href="<?= BASE_URL ?>/forum"     class="drawer-link<?= navActive('forum',     $navSegment) ?>">
                <span class="material-symbols-outlined drawer-link-icon" aria-hidden="true">forum</span>
                <span>Forum</span>
              </a>
              <a href="<?= BASE_URL ?>/faq"       class="drawer-link<?= navActive('faq',       $navSegment) ?>">
                <span class="material-symbols-outlined drawer-link-icon" aria-hidden="true">help</span>
                <span>FAQ</span>
              </a>
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
        const topbar       = document.getElementById('siteTopbar');
        const header       = document.getElementById('mainHeader');
        const openBtn      = document.getElementById('mobileMenuOpen');
        const drawer       = document.getElementById('mobileDrawer');
        const backdrop     = document.getElementById('mobileBackdrop');
        const hamIcon      = document.getElementById('hamburgerIcon');

        // ---- Scroll glassmorphism ----
        function handleScroll() {
          const topbarHeight = topbar ? topbar.offsetHeight : 0;
          const scrollY = window.scrollY || window.pageYOffset;
          header.style.top = Math.max(0, topbarHeight - scrollY) + 'px';
          header.classList.toggle('is-scrolled', scrollY > topbarHeight);
        }
        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleScroll, { passive: true });
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