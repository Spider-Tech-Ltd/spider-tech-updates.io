<?php
/**
 * Forum Member Feed Page — Phase 2
 * Member-only interactive discussion feed.
 * Access: Simulated via session. Redirects to index.php if no session.
 * Architecture: Bootstrap 4 + Vanilla CSS, mirrors index.php structure.
 */
require('../../includes/connect.php');
require('../../home_functions.php');

// Simulated session check — replace with real auth when backend is ready
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit;
// }

// Simulated logged-in member data
$member = [
    'name'       => 'James Harrison',
    'initials'   => 'JH',
    'role'       => 'Verified Member',
    'posts'      => 48,
    'new_replies'=> 3,
];
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Open+Sans:wght@400;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <title>Member Feed — Spider Tech Forum</title>
    <meta name="description" content="Your personalised Spider Tech industry discussion feed. Stay ahead with the latest industrial technology updates.">

    <style>
      /* ============================
         FEED PAGE — BASE OVERRIDES
         ============================ */
      body { background-color: #f8f9fa; }

      /* Hide top header stripe */
      .header-top { display: none !important; }

      /* Offset body for fixed header */
      .feed-page-wrapper {
        padding-top: 72px; /* clear the fixed site-header */
      }

      /* ============================
         FILTER BAR STICKY OFFSET
         ============================ */
      .feed-filter-bar-sticky {
        position: sticky;
        top: 72px; /* sits right below the fixed header */
        z-index: 900;
        background: #ffffff;
        border-bottom: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      }

      /* ============================
         MAIN CONTENT LAYOUT
         ============================ */
      .feed-main-section {
        padding: 40px 0 80px;
      }

      /* ============================
         RESPONSIVE
         ============================ */
      @media (max-width: 991px) {
        .feed-sidebar-col { margin-top: 40px; }
      }
    </style>
</head>
<body>
    <!-- ====== Preloader ====== -->
    <?php require('../../includes/preloader.html'); ?>

    <div class="wraper">
        <!-- ====== Global Header ====== -->
        <?php require('../../header-section.php'); ?>

        <div class="feed-page-wrapper">

            <!-- ====== 1. Member Feed Banner ====== -->
            <?php include('includes/feed-banner.php'); ?>

            <!-- ====== 2. Live Filter Bar ====== -->
            <div class="feed-filter-bar-sticky">
                <?php include('includes/feed-filter-bar.php'); ?>
            </div>

            <!-- ====== 3. Main Two-Column Content ====== -->
            <section class="feed-main-section">
                <div class="container">
                    <div class="row">

                        <!-- Left: Member Feed -->
                        <div class="col-lg-8 col-md-12 pr-lg-5">
                            <?php include('includes/member-feed.php'); ?>
                        </div>

                        <!-- Right: Member Sidebar -->
                        <div class="col-lg-4 col-md-12 feed-sidebar-col">
                            <?php include('includes/member-sidebar.php'); ?>
                        </div>

                    </div>
                </div>
            </section>

        </div>
        <!-- ====== Feed Wrapper End ====== -->

    </div>
    <!-- ====== Wrapper End ====== -->

    <!-- ====== Footer ====== -->
    <?php require('../../footer-section.php'); ?>

    <?php require('../../javascript-section.html'); ?>

    <script>
      /**
       * Filter Bar: Active pill toggle
       */
      document.addEventListener('DOMContentLoaded', function () {
        const pills = document.querySelectorAll('.filter-pill');
        pills.forEach(function (pill) {
          pill.addEventListener('click', function (e) {
            e.preventDefault();
            pills.forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
          });
        });

        /**
         * Discussion card: bookmark toggle
         */
        document.querySelectorAll('.btn-bookmark').forEach(function (btn) {
          btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.toggle('bookmarked');
            const icon = this.querySelector('.material-symbols-outlined');
            icon && icon.style.setProperty('font-variation-settings', this.classList.contains('bookmarked') ? '"FILL" 1' : '"FILL" 0');
          });
        });

        /**
         * Upvote toggle
         */
        document.querySelectorAll('.btn-upvote').forEach(function (btn) {
          btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const isActive = this.classList.toggle('active');
            const counter = this.querySelector('.vote-count');
            if (counter) {
              counter.textContent = isActive
                ? parseInt(counter.textContent) + 1
                : parseInt(counter.textContent) - 1;
            }
          });
        });

        /**
         * Phase 6: Reply Thread Toggle
         */
        document.querySelectorAll('.btn-reply').forEach(function (btn) {
          btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const card = this.closest('.discussion-card');
            if (card) {
              card.classList.toggle('expanded');
            }
          });
        });
      });
    </script>
</body>
</html>
