  <style>
    /* Global Overrides for modern feel */
    body {
      font-family: 'Work Sans', sans-serif;
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

    /* Page Header High-Fidelity */
    .page-header {
        background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.05);
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
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item-custom a:hover {
        color: var(--primary-orange);
    }

    .breadcrumb-item-custom.active {
        color: var(--primary-orange);
    }

    .breadcrumb-separator {
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
    }

    @media (max-width: 991px) {
        .page-header { padding: 120px 0 60px; }
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
      padding-top: 1.125rem !important;
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
      color: #f48221;
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
      padding: 1rem 2rem;
      border-radius: 9999px;
      text-align: center;
      font-weight: 700;
      text-decoration: none !important;
      transition: all 0.2s ease;
      font-size: 1.1rem;
    }

    .featured-btn:hover {
      transform: scale(1.02);
      color: #e6751c;
    }

    @media (max-width: 992px) {
      .hero-title {
        font-size: 3rem;
      }

      .training-hero {
        padding: 60px 0;
      }
    }
  </style>



  <!-- ====== Hero Section Start ====== -->
  <section class="training-hero">
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
      <div class="section-header text-center mb-4">
        <h2>Fast-track your career with practical tech training</h2>
        <p class="text-muted">Build role-ready skills with curriculum vetted by Spider Technologies and partners.</p>
      </div>
      <div class="row">
        <?php
        $counter = 0;
        if (!empty($trainings)) {
          foreach ($trainings as $training) {
            $counter++;
            if ($counter == 1) {
        ?>
              <div class="col-lg-4 col-md-12 mb-4">
                <div class="training-card featured-card h-100">
                  <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="featured-badge">Featured Program</div>
                    <span class="material-symbols-outlined fill-1">star</span>
                  </div>
                  <h3 class="featured-title"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></h3>
                  <p class="featured-desc"><?= nl2br(htmlspecialchars(strip_tags($training['training_description']))); ?></p>
                  <div class="mt-auto pt-4">
                    <div class="d-flex gap-2 mb-4">
                      <span class="px-3 py-1 bg-white-20 font-weight-bold" style="background: rgba(255,255,255,0.2); font-size: 11px; border-radius: 9999px;">TRAINING</span>
                      <span class="px-3 py-1 bg-white-20 font-weight-bold" style="background: rgba(255,255,255,0.2); font-size: 11px; border-radius: 9999px;">24 WEEKS</span>
                    </div>
                        <span class="material-symbols-outlined">school</span>
                        <span><?= isset($training['students_enrolled']) ? number_format($training['students_enrolled']) . '+' : '41K+'; ?></span>
                      </div>
                      <div class="meta-item">
                        <span class="material-symbols-outlined">star</span>
                        <span><?= isset($training['rating']) ? $training['rating'] : '4.9'; ?>/5</span>
                      </div>
                    </div>
                    <p class="card-desc"><?= nl2br(htmlspecialchars(strip_tags($training['training_description']))); ?></p>
                    <div class="card-footer bg-transparent p-0">
                      <div class="text-muted small d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined text-orange" style="font-size: 16px;">bolt</span>
                        Intensive
                      </div>
                      <a href="<?= BASE_URL ?>/trainings/detail?id=<?= stripslashes($training['id']); ?>" class="register-btn">
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

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>