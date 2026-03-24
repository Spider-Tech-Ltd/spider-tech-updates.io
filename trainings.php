<?php

require('includes/connect.php');
$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

$services_banner = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 6 ");
$services_banner->execute();
$fetch_banner = $services_banner->fetch(PDO::FETCH_ASSOC);

$select_trainings = $conn->prepare("SELECT * FROM `services_tb`");
$select_trainings->execute();
$fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC);

$misc_image1 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 4 ");
$misc_image1->execute();
$fetch_misc1 = $misc_image1->fetch(PDO::FETCH_ASSOC);

$misc_image2 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 5 ");
$misc_image2->execute();
$fetch_misc2 = $misc_image2->fetch(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">

<head>
  <?php require('head-section.html'); ?>
  <!-- Google Fonts & Material Symbols for modern UI -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    /* Global Overrides for modern feel */
    body {
      font-family: 'Work Sans', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    .font-headline {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fill-1 {
      font-variation-settings: 'FILL' 1;
    }

    .text-orange {
      color: #f48221 !important;
    }

    .gap-1 {
      gap: 0.25rem;
    }

    .gap-2 {
      gap: 0.5rem;
    }

    .gap-3 {
      gap: 1rem;
    }

    .gap-4 {
      gap: 1.5rem;
    }

    .-space-x-2>*+* {
      margin-left: -0.5rem;
    }

    /* Hero Section Styles (Aligned with Forum Hero) */
    .training-hero {
      position: relative;
      background-color: #f4f4f4;
      padding: 100px 16px 80px;
      overflow: hidden;
      text-align: center;
    }

    .training-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at center, rgba(244, 130, 33, 0.08) 0%, transparent 68%);
      pointer-events: none;
      z-index: 0;
    }

    .hero-blob {
      position: absolute;
      border-radius: 50%;
      background-color: rgba(244, 130, 33, 0.06);
      filter: blur(60px);
      pointer-events: none;
    }

    .hero-blob-left {
      width: 280px;
      height: 280px;
      top: 20%;
      left: -80px;
    }

    .hero-blob-right {
      width: 320px;
      height: 320px;
      bottom: 15%;
      right: -80px;
    }

    .hero-inner {
      position: relative;
      z-index: 1;
    }

    .hero-eyebrow-pill {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 6px 18px;
      border-radius: 50px;
      background-color: rgba(244, 130, 33, 0.12);
      border: 1px solid rgba(244, 130, 33, 0.25);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #f48221;
      margin-bottom: 28px;
    }

    .hero-title {
      font-size: 4.5rem;
      font-weight: 800;
      line-height: 1.1;
      margin: 0 auto 1.5rem;
      color: #111111;
      max-width: 800px;
    }

    .hero-subtitle {
      font-size: 1.1rem;
      color: #555555;
      max-width: 600px;
      margin: 0 auto 24px;
      line-height: 1.7;
    }

    .hero-btn-primary {
      height: 48px;
      padding: 0 32px;
      background-color: #f48221;
      color: #ffffff;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 0.95rem;
      border: none;
      border-radius: 50px;
      white-space: nowrap;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(244, 130, 33, 0.28);
      transition: background-color 0.2s ease, transform 0.1s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .hero-btn-primary:hover {
      background-color: #e6751c;
      color: #ffffff;
      text-decoration: none;
    }

    .hero-btn-primary:active {
      transform: scale(0.98);
    }

    .hero-btn-primary:hover {
      background-color: #e6751c;
      color: #ffffff;
      text-decoration: none;
    }

    .hero-btn-primary:active {
      transform: scale(0.98);
    }

    .industry-standard-badge {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      border-left: 4px solid #f48221;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .badge-label {
      color: #f48221;
      font-weight: 700;
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.5rem;
    }

    /* Training Card Styles */
    .training-card {
      background-color: #ffffff;
      border-radius: 1.5rem;
      padding: 0.25rem;
      transition: all 0.3s ease;
      height: 100%;
      border: 1px solid #e9ecef;
      margin-bottom: 30px;
      display: flex;
      flex-direction: column;
      min-height: 460px;
      overflow: hidden;
    }

    .training-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .training-categories {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
      margin-bottom: 40px;
    }

    .training-category-pill {
      background-color: #ffffff;
      border: 1px solid #ebeff2;
      border-radius: 9999px;
      padding: 10px 16px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #505050;
      text-align: center;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .training-category-pill:hover,
    .training-category-pill.active {
      color: #f48221;
      border-color: rgba(244, 130, 33, 0.3);
      background: rgba(244, 130, 33, 0.08);
    }

    .section-header {
      margin-top: 24px;
      margin-bottom: 28px;
    }

    .section-header h2 {
      font-size: 1.9rem;
      margin-bottom: 0.35rem;
      font-weight: 700;
      color: #111111;
    }

    .section-header p {
      margin-bottom: 0;
      font-size: 0.95rem;
      color: #6d6d6d;
    }

    .card-img-wrap {
      aspect-ratio: 16/9;
      border-radius: 1.25rem;
      overflow: hidden;
      margin-bottom: 1.5rem;
    }

    .card-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .training-card:hover .card-img-wrap img {
      transform: scale(1.05);
    }

    .card-content {
      padding: 0 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .card-category {
      font-size: 0.65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #f48221;
      margin-bottom: 0;
      display: block;
    }

    .card-provider {
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #aaaaaa;
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      color: #111111;
      transition: color 0.3s ease;
      line-height: 1.2;
      max-height: 3.6rem;
      overflow: hidden;
      word-break: break-word;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      line-clamp: 2;
      -webkit-box-orient: vertical;
    }

    .training-card:hover .card-title {
      color: #f48221;
    }

    .card-desc {
      font-size: 0.875rem;
      color: #555555;
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    .card-footer {
      padding-top: 1.5rem;
      border-top: 1px solid #f1f1f1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
    }

    .course-meta {
      display: flex;
      gap: 12px;
      margin-bottom: 12px;
      flex-wrap: wrap;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 0.75rem;
      color: #666;
      background: #f9f9f9;
      padding: 4px 8px;
      border-radius: 4px;
    }

    .meta-item .material-symbols-outlined {
      font-size: 14px;
      color: #f48221;
    }

    .register-btn {
      color: #964900;
      font-weight: 700;
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      gap: 0.25rem;
      text-decoration: none !important;
      transition: color 0.2s;
    }

    .register-btn:hover {
      color: #f48221;
    }

    .register-btn span {
      transition: transform 0.3s ease;
    }

    .register-btn:hover span {
      transform: translateX(4px);
    }

    /* Featured Card */
    .featured-card {
      background: linear-gradient(135deg, #f48221 0%, #964900 100%);
      border: none;
      padding: 2rem;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .featured-card::after {
      content: '';
      position: absolute;
      top: -10%;
      right: -10%;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      filter: blur(40px);
    }

    .featured-badge {
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 0.65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      display: inline-block;
      color: #ffffff;
    }

    .featured-title {
      font-size: 2.3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      line-height: 1.2;
      letter-spacing: -0.02em;
      color: #ffffff;
      word-break: break-word;
      max-height: 5.2rem;
      overflow: hidden;
    }

    .featured-desc {
      font-size: 1rem;
      color: #ffffff;
      opacity: 0.9;
      margin-bottom: 3rem;
      line-height: 1.5;
      max-width: 100%;
    }

    .featured-btn {
      background: #ffffff;
      color: #f48221;
      padding: 1.25rem 2rem;
      border-radius: 9999px;
      text-align: center;
      font-weight: 700;
      text-decoration: none !important;
      transition: all 0.2s ease;
      font-size: 1.1rem;
    }

    .featured-btn:hover {
      transform: scale(1.02);
      color: #964900;
    }

    @media (max-width: 992px) {
      .hero-title {
        font-size: 3rem;
      }

      .training-hero {
        padding: 60px 0;
      }
    }

    /* Mobile Bottom Nav Styles */
    .mobile-bottom-nav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      border-top: 1px solid #f1f1f1;
      padding: 12px 16px 24px;
      z-index: 1000;
      justify-content: space-around;
      align-items: center;
      border-top-left-radius: 24px;
      border-top-right-radius: 24px;
      box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.05);
    }

    .nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      color: #aaaaaa;
      text-decoration: none !important;
    }

    .nav-item.active {
      color: #f48221;
    }

    .nav-item .material-symbols-outlined {
      font-size: 24px;
    }

    .nav-item span {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }

    .search-pill {
      width: 48px;
      height: 48px;
      background-color: #f48221;
      color: #ffffff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: -24px;
      box-shadow: 0 8px 16px rgba(244, 130, 33, 0.3);
    }

    .filters-section {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filters-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      align-items: center;
    }

    .search-box {
      display: flex;
      align-items: center;
      background: #f9f9f9;
      border-radius: 8px;
      padding: 8px 15px;
      flex: 1;
      min-width: 200px;
    }

    .search-box .material-symbols-outlined {
      color: #999;
      margin-right: 8px;
    }

    .search-box input {
      border: none;
      background: transparent;
      width: 100%;
      font-size: 0.9rem;
      color: #333;
    }

    .search-box input:focus {
      outline: none;
    }

    .search-box input::placeholder {
      color: #999;
    }

    .filter-select {
      padding: 10px 15px;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      font-size: 0.9rem;
      color: #555;
      background: #fff;
      cursor: pointer;
      min-width: 150px;
      transition: border-color 0.2s;
    }

    .filter-select:hover,
    .filter-select:focus {
      border-color: #f48221;
      outline: none;
    }

    .no-results-message {
      text-align: center;
      padding: 60px 20px;
      color: #666;
    }

    .no-results-message .material-symbols-outlined {
      font-size: 48px;
      color: #ccc;
      margin-bottom: 15px;
    }

    .no-results-message h3 {
      margin-bottom: 10px;
      color: #333;
    }

    @media (max-width: 991px) {
      .mobile-bottom-nav {
        display: flex;
      }

      body {
        padding-bottom: 80px;
      }
    }
  </style>
</head>

<body>
  <!-- ====== Preloader ====== -->
  <?php require('includes/preloader.html'); ?>

  <div class="wraper-v2-inner">
    <!-- ====== Header Starts ====== -->
    <?php require('header-section.php'); ?>
    <!-- ====== Header End ====== -->

    <!-- ====== Hero Section Start ====== -->
    <section class="training-hero">
      <!-- Decorative blobs -->
      <div class="hero-blob hero-blob-left"></div>
      <div class="hero-blob hero-blob-right"></div>

      <div class="container hero-inner">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <span class="hero-eyebrow-pill">
              <span class="material-symbols-outlined" style="font-size: 16px;">auto_awesome</span>
              Professional Growth
            </span>
            <h1 class="hero-title">Our Training Programs</h1>
            <p class="hero-subtitle">Elevate your technical and interpersonal skills through curated, high-impact paths from Spider Technologies.</p>

            <div class="row justify-content-center mt-4">
              <div class="col-md-8 col-lg-6 text-center">
                <a href="#services" class="hero-btn-primary w-100">Browse Programs</a>
              </div>
            </div>

            <div class="row justify-content-center mt-4">
              <div class="col-lg-6">
                <div class="industry-standard-badge text-left">
                  <div class="badge-label">
                    <span class="material-symbols-outlined fill-1">verified</span>
                    Industry Standard
                  </div>
                  <p class="mb-0 text-muted small">All programs are verified and recognized by our global network of enterprise partners.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ====== Hero Section End ====== -->

    <!-- ====== Trainings Start ====== -->
    <section id="services" class="index-2 padding">
      <div class="container">

        <!-- Search and Filters -->
        <div class="filters-section">
          <div class="filters-wrapper">
            <!-- Search Box -->
            <div class="search-box">
              <span class="material-symbols-outlined">search</span>
              <input type="text" id="courseSearch" placeholder="Search courses...">
            </div>

            <!-- Category Filter -->
            <select id="categoryFilter" class="filter-select">
              <option value="">All Categories</option>
              <option value="Soft Skills">Soft Skills</option>
              <option value="Entrepreneurship">Entrepreneurship</option>
              <option value="Technical Skills">Technical Skills</option>
              <option value="Business">Business</option>
            </select>

            <!-- Difficulty Filter -->
            <select id="difficultyFilter" class="filter-select">
              <option value="">All Levels</option>
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
            </select>

            <!-- Sort -->
            <select id="sortBy" class="filter-select">
              <option value="popular">Most Popular</option>
              <option value="newest">Newest First</option>
              <option value="rating">Highest Rated</option>
              <option value="duration-asc">Shortest First</option>
            </select>
          </div>
        </div>

        <div class="section-header text-center mb-4">
          <h2>Fast-track your career with practical tech training</h2>
          <p class="text-muted">Build role-ready skills with curriculum vetted by Spider Technologies and partners.</p>
        </div>
        <div class="row">
          <?php
          $select_trainings = $conn->prepare("SELECT * FROM `trainings_tb`");
          $select_trainings->execute();
          $counter = 0;
          if ($select_trainings->rowCount() > 0) {
            while ($fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC)) {
              $counter++;
              if ($counter == 1) {
                // Featured Card
          ?>
                <div class="col-lg-4 col-md-12 mb-4">
                  <div class="training-card featured-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                      <div class="featured-badge">Featured Program</div>
                      <span class="material-symbols-outlined fill-1">star</span>
                    </div>
                    <h3 class="featured-title"><?= htmlspecialchars(strip_tags($fetch_training['training_name'])); ?></h3>
                    <p class="featured-desc"><?= nl2br(htmlspecialchars(strip_tags($fetch_training['training_description']))); ?></p>
                    <div class="mt-auto pt-4">
                      <div class="d-flex gap-2 mb-4">
                        <span class="px-3 py-1 bg-white-20 font-weight-bold" style="background: rgba(255,255,255,0.2); font-size: 11px; border-radius: 9999px;">TRAINING</span>
                        <span class="px-3 py-1 bg-white-20 font-weight-bold" style="background: rgba(255,255,255,0.2); font-size: 11px; border-radius: 9999px;">24 WEEKS</span>
                      </div>
                      <a href="program-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>" class="featured-btn w-100 d-block text-center">View Program</a>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="training-card">
                    <div class="card-img-wrap">
                      <img src="<?= htmlspecialchars($fetch_training['training_image']); ?>" alt="<?= htmlspecialchars(strip_tags($fetch_training['training_name'])); ?>">
                    </div>
                    <div class="card-content">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="card-category">Program</span>
                        <span class="card-provider">Spider Tech</span>
                      </div>
                      <h3 class="card-title"><?= htmlspecialchars(strip_tags($fetch_training['training_name'])); ?></h3>
                      <div class="course-meta">
                        <div class="meta-item">
                          <span class="material-symbols-outlined">schedule</span>
                          <span><?= isset($fetch_training['duration_minutes']) ? round($fetch_training['duration_minutes'] / 60, 1) . 'h' : '2h 14min'; ?></span>
                        </div>
                        <div class="meta-item">
                          <span class="material-symbols-outlined">school</span>
                          <span><?= isset($fetch_training['students_enrolled']) ? number_format($fetch_training['students_enrolled']) . '+' : '41K+'; ?></span>
                        </div>
                        <div class="meta-item">
                          <span class="material-symbols-outlined">star</span>
                          <span><?= isset($fetch_training['rating']) ? $fetch_training['rating'] : '4.9'; ?>/5</span>
                        </div>
                      </div>
                      <p class="card-desc"><?= nl2br(htmlspecialchars(strip_tags($fetch_training['training_description']))); ?></p>
                      <div class="card-footer bg-transparent p-0">
                        <div class="text-muted small d-flex align-items-center gap-1">
                          <span class="material-symbols-outlined text-orange" style="font-size: 16px;">bolt</span>
                          Intensive
                        </div>
                        <a href="program-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>" class="register-btn">
                          View Details
                          <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
          <?php
            }
          } else {
            echo '<div class="col-12"><p class="empty">No trainings found!</p></div>';
          }
          ?>
        </div>
      </div>
    </section>
    <!-- ====== Trainings End ====== -->

    <!-- ====== Work Status Start ====== -->
    <?php require('includes/work-status.html'); ?>
    <!-- ====== Work Status End ====== -->




  </div>
  <!-- ====== Footer Start ====== -->
  <?php require('includes/mini-footer.php'); ?>
  <!-- ====== Footer End ====== -->

  <!-- Mobile Bottom Navigation Bar -->
  <nav class="mobile-bottom-nav">
    <a href="index.php" class="nav-item">
      <span class="material-symbols-outlined">home</span>
      <span>Home</span>
    </a>
    <a href="#" class="nav-item">
      <div class="search-pill">
        <span class="material-symbols-outlined">search</span>
      </div>
    </a>
    <a href="#" class="nav-item">
      <span class="material-symbols-outlined">bookmark</span>
      <span>Saved</span>
    </a>
    <a href="#" class="nav-item">
      <span class="material-symbols-outlined">person</span>
      <span>Profile</span>
    </a>
  </nav>
  <?php require('javascript-section.html'); ?>

  <script>
    // Course Filtering Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('courseSearch');
      const categoryFilter = document.getElementById('categoryFilter');
      const difficultyFilter = document.getElementById('difficultyFilter');
      const sortBy = document.getElementById('sortBy');

      function filterCourses() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const category = categoryFilter?.value || '';
        const difficulty = difficultyFilter?.value || '';

        document.querySelectorAll('.training-card').forEach(card => {
          const col = card.closest('.col-lg-4, .col-md-6, .col-md-12');
          if (!col) return;

          const title = card.querySelector('.card-title, .featured-title')?.textContent.toLowerCase() || '';
          const desc = card.querySelector('.card-desc, .featured-desc')?.textContent.toLowerCase() || '';
          const cardCategory = col.dataset.category || '';
          const cardDifficulty = col.dataset.difficulty || '';

          const matchesSearch = title.includes(searchTerm) || desc.includes(searchTerm);
          const matchesCategory = !category || cardCategory === category;
          const matchesDifficulty = !difficulty || cardDifficulty === difficulty;

          col.style.display = (matchesSearch && matchesCategory && matchesDifficulty) ? '' : 'none';
        });
      }

      searchInput?.addEventListener('input', filterCourses);
      categoryFilter?.addEventListener('change', filterCourses);
      difficultyFilter?.addEventListener('change', filterCourses);
    });
  </script>
</body>

</html>