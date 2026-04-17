  <style>
    :root {
      --primary-orange: #f48221;
      --dark-bg: #111111;
      --text-body: #374151;
      --text-muted: #888888;
      --card-bg: #ffffff;
    }

    .fill-1 {
      font-variation-settings: 'FILL' 1;
    }

    .text-orange {
      color: var(--primary-orange) !important;
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

    /* Page Header High-Fidelity */
    .page-header {
      background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
      background-color: var(--dark-bg);
      padding: 140px 0 80px;
      position: relative;
      overflow: hidden;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .page-header::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 70% 30%, rgba(244, 130, 33, 0.05) 0%, transparent 60%);
      pointer-events: none;
    }

    .page-title {
      font-family: 'Poppins', sans-serif;
      font-weight: 800;
      font-size: clamp(2.5rem, 5vw, 3.8rem);
      color: #ffffff;
      margin-bottom: 1rem;
      letter-spacing: -1.5px;
      line-height: 1.1;
    }

    .page-title span {
      color: var(--primary-orange);
    }

    /* Professional Breadcrumbs */
    .breadcrumb-custom {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 15px;
    }

    .breadcrumb-item-custom {
      display: flex;
      align-items: center;
      gap: 12px;
      color: rgba(255, 255, 255, 0.5);
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
      color: rgba(255, 255, 255, 0.75);
      text-decoration: none;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .breadcrumb-item-custom a:hover {
      color: #f48221;
      transform: translateX(2px);
    }

    .breadcrumb-item-custom.active {
      color: #f48221;
      font-weight: 700;
    }

    .breadcrumb-item-custom.active span {
      color: #f48221;
    }

    .breadcrumb-separator {
      width: 4px;
      height: 4px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
    }

    @media (max-width: 991px) {
      .page-header {
        padding: 120px 0 60px;
      }
    }

    .training-hero {
      background: #ffffff;
      padding: 90px 0 70px;
    }

    .hero-eyebrow-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(244, 130, 33, 0.1);
      color: #f48221;
      padding: 0.75rem 1rem;
      border-radius: 9999px;
      font-size: 0.85rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 1.5rem;
    }

    .hero-title {
      font-family: 'Poppins', sans-serif;
      font-size: clamp(2.7rem, 4vw, 4rem);
      font-weight: 800;
      line-height: 1.05;
      margin-bottom: 1.2rem;
      color: #111111;
    }

    .hero-title span {
      color: var(--primary-orange);
    }

    .hero-subtitle {
      font-family: 'Open Sans', sans-serif;
      color: #555555;
      font-size: 1.15rem;
      line-height: 1.75;
      max-width: 760px;
      margin: 0 auto;
    }

    .hero-btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.95rem 2.25rem;
      border-radius: 9999px;
      background: #f48221;
      color: #ffffff;
      font-weight: 700;
      text-decoration: none !important;
      transition: transform 0.2s ease, background 0.2s ease;
      box-shadow: 0 14px 30px rgba(244, 130, 33, 0.18);
    }

    .hero-btn-primary:hover {
      background: #e6751c;
      transform: translateY(-2px);
    }

    .training-card {
      background-color: #ffffff;
      border-radius: 1.5rem;
      padding: 1.75rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex;
      flex-direction: column;
      min-height: 420px;
      border: 1px solid #e9ecef;
      overflow: hidden;
      height: 100%;
    }

    .card-img-wrap {
      position: relative;
      overflow: hidden;
      border-radius: 1.5rem;
      margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    }

    .card-img-wrap img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      display: block;
    }

    .training-card.featured-card {
      background: linear-gradient(135deg, rgba(244, 130, 33, 0.32) 0%, rgba(244, 130, 33, 0.92) 100%);
      border: none;
      color: #ffffff;
      box-shadow: 0 24px 40px rgba(244, 130, 33, 0.18);
    }

    .training-card.featured-card .card-img-wrap::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(244, 130, 33, 0.35), rgba(244, 130, 33, 0.05));
      pointer-events: none;
    }

    .row.g-4 {
      align-items: stretch;
    }

    .training-card.featured-card .card-title,
    .training-card.featured-card .card-desc,
    .training-card.featured-card .meta-item,
    .training-card.featured-card .card-footer .text-muted {
      color: #ffffff;
    }

    .training-card.featured-card .card-badge,
    .training-card.featured-card .training-icon {
      color: #ffffff;
    }

    .training-card.featured-card .card-badge {
      background: rgba(255, 255, 255, 0.16);
      border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .training-card.featured-card .card-head {
      border-bottom: 1px solid rgba(255, 255, 255, 0.18);
      padding-bottom: 1rem;
      margin-bottom: 1.4rem;
    }

    .training-card.featured-card .course-meta {
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }

    .training-card.featured-card .meta-item {
      background: rgba(255, 255, 255, 0.14);
      color: rgba(255, 255, 255, 0.95);
    }

    .training-card.featured-card .meta-item .material-symbols-outlined {
      color: #ffffff;
    }

    .training-card.featured-card .card-footer {
      border-top-color: rgba(255, 255, 255, 0.2);
    }

    .card-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.4rem;
    }

    .card-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      padding: 0.7rem 1rem;
      border-radius: 9999px;
      background: rgba(244, 130, 33, 0.1);
      color: #f48221;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .training-card.featured-card .card-badge {
      background: rgba(255, 255, 255, 0.18);
      color: #ffffff;
    }

    .training-icon {
      width: 52px;
      height: 52px;
      flex-shrink: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 18px;
      background: rgba(244, 130, 33, 0.12);
      color: #f48221;
      font-size: 1.45rem;
    }

    .training-icon.material-symbols-outlined {
      font-variation-settings: 'FILL' 1;
      line-height: 1;
    }

    .training-card.featured-card .training-icon {
      background: #ffffff;
      color: #f48221;
      box-shadow: inset 0 0 0 1px rgba(244, 130, 33, 0.12);
    }

    .card-title {
      font-size: 1.35rem;
      font-weight: 700;
      line-height: 1.25;
      margin-bottom: 1rem;
      color: #111111;
      transition: color 0.3s ease;
    }

    .training-card:hover .card-title {
      color: #f48221;
    }

    .training-card.featured-card:hover .card-title {
      color: #ffffff;
    }

    .card-desc {
      font-size: 0.95rem;
      color: #58606c;
      line-height: 1.75;
      margin-bottom: 1.75rem;
      flex: 1;
    }

    .training-card.featured-card .card-desc {
      color: rgba(255, 255, 255, 0.92);
    }

    .course-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }

    .meta-item {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.8rem;
      color: #6b7280;
      background: #f4f5f7;
      padding: 0.65rem 0.95rem;
      border-radius: 9999px;
    }

    .training-card.featured-card .meta-item {
      color: rgba(255, 255, 255, 0.95);
      background: rgba(255, 255, 255, 0.12);
    }

    .meta-item .material-symbols-outlined {
      font-size: 14px;
      color: #f48221;
    }

    .training-card.featured-card .meta-item .material-symbols-outlined {
      color: #ffffff;
    }

    .card-footer {
      padding-top: 1rem !important;
      border-top: 1px solid #eef2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
      gap: 1rem;
    }

    .register-btn {
      color: #f48221;
      font-weight: 700;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      text-decoration: none !important;
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .register-btn:hover {
      transform: translateX(3px);
    }

    .training-card.featured-card .register-btn {
      color: #ffffff;
    }

    .register-btn span {
      transition: transform 0.3s ease;
    }

    .register-btn:hover span {
      transform: translateX(4px);
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

    @media (max-width: 992px) {
      .hero-title {
        font-size: 2.7rem;
      }

      .training-hero {
        padding: 60px 0 50px;
      }
    }
  </style>



  <!-- ====== Page Header ====== -->
  <section class="page-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-title">Training <span>Programs</span></h1>
          <div class="breadcrumb-custom">
            <div class="breadcrumb-item-custom">
              <a href="<?= BASE_URL ?>/">Home</a>
            </div>
            <div class="breadcrumb-separator"></div>
            <div class="breadcrumb-item-custom active">
              Training
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ====== Hero Section Start ====== -->
  <section class="training-hero">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <span class="hero-eyebrow-pill">
            <span class="material-symbols-outlined" style="font-size: 16px;">auto_awesome</span>
            Professional Growth
          </span>
          <h1 class="hero-title">Our Training <span>Programs</span></h1>
          <p class="hero-subtitle">Elevate your technical and interpersonal skills through curated, high-impact paths from Spider Technologies.</p>
          <div class="mt-5">
            <a href="#services" class="hero-btn-primary">Browse Programs</a>
          </div>
          <div class="row justify-content-center mt-5">
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
  <section id="services" class="section-padding bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
          <span class="tag-eyebrow">Upskill with confidence</span>
          <h2 class="section-title">Fast-track your career with practical tech training</h2>
          <p class="section-subtitle">Build role-ready skills with curriculum vetted by Spider Technologies and partners.</p>
        </div>
      </div>

      <div class="row g-4">
        <?php if (!empty($trainings)): ?>
          <?php foreach ($trainings as $index => $training): ?>
            <?php
            $is_featured = $index === 0;
            $iconName = 'school';
            if (!empty($training['training_icon']) && preg_match('/^[a-z0-9_]+$/i', $training['training_icon'])) {
              $iconName = $training['training_icon'];
            }
            $imageSrc = '';
            if (!empty($training['image_url'])) {
              $imageSrc = $training['image_url'];
            } elseif (!empty($training['training_image'])) {
              $imageSrc = $training['training_image'];
            }
            if (!empty($imageSrc)) {
              $imageSrc = str_replace('\\', '/', $imageSrc);
              if (preg_match('#^https?://#i', $imageSrc)) {
                $imageSrc = htmlspecialchars($imageSrc);
              } else {
                $imageSrc = BASE_URL . '/' . ltrim($imageSrc, '/.');
              }
            }
            ?>
            <div class="col-lg-4 col-md-6 d-flex">
              <article class="training-card<?= $is_featured ? ' featured-card' : '' ?> h-100">
                <?php if (!empty($imageSrc)): ?>
                  <div class="card-img-wrap">
                    <img src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars(strip_tags($training['training_name'])) ?>">
                  </div>
                <?php endif; ?>
                <div class="card-head">
                  <span class="card-badge"><?= $is_featured ? 'Featured Program' : 'Training Track' ?></span>
                  <span class="training-icon material-symbols-outlined"><?= htmlspecialchars($iconName) ?></span>
                </div>
                <h3 class="card-title"><?= htmlspecialchars(strip_tags($training['training_name'])) ?></h3>
                <p class="card-desc"><?= nl2br(htmlspecialchars(strip_tags($training['training_description']))) ?></p>
                <div class="course-meta">
                  <span class="meta-item"><span class="material-symbols-outlined">school</span><?= isset($training['students_enrolled']) ? number_format($training['students_enrolled']) . '+' : '41K+' ?></span>
                  <span class="meta-item"><span class="material-symbols-outlined">star</span><?= isset($training['rating']) ? $training['rating'] : '4.9' ?>/5</span>
                </div>
                <div class="card-footer">
                  <div class="text-muted small d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined text-orange" style="font-size: 16px;">bolt</span>
                    Intensive
                  </div>
                  <a href="<?= BASE_URL ?>/trainings/detail?id=<?= stripslashes($training['id']); ?>" class="register-btn">
                    View Details
                    <span class="material-symbols-outlined">arrow_forward</span>
                  </a>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="empty-state">
              <span class="material-symbols-outlined">folder_open</span>
              <p>No trainings found!</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- ====== Trainings End ====== -->


  <!-- Include Modular Newsletter -->
  <?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>