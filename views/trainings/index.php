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

    /* Synchronized Training Card - Industrial Grade */
    .research-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 8px;
        cursor: pointer;
        text-decoration: none !important;
    }

    .research-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .card-img-wrap {
        position: relative;
        aspect-ratio: 16/10;
        border-radius: 20px;
        overflow: hidden;
        background: var(--dark-bg);
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .research-card:hover .card-img-wrap img {
        transform: scale(1.1);
    }

    .card-img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17, 24, 39, 0.6), transparent);
        z-index: 1;
    }

    .card-category {
        position: absolute;
        bottom: 20px;
        left: 20px;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        z-index: 2;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 4px 12px;
        border-radius: 50px;
    }

    .card-body-content {
        padding: 30px 25px 35px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-body-content h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        line-height: 1.3;
        color: var(--dark-bg);
        margin-bottom: 1rem;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .research-card:hover .card-body-content h3 {
        color: var(--primary-orange);
    }

    .card-body-content p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #555;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .read-link {
        margin-top: auto;
        font-weight: 700;
        font-size: 13px;
        color: var(--primary-orange);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .read-link i {
        font-size: 18px;
        transition: transform 0.3s;
    }

    .research-card:hover .read-link i {
        transform: translateX(5px);
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
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
              <a href="<?= BASE_URL ?>/trainings/detail?id=<?= stripslashes($training['id']); ?>" class="research-card">
                <?php if (!empty($imageSrc)): ?>
                  <div class="card-img-wrap">
                    <img src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars(strip_tags($training['training_name'])) ?>">
                    <div class="card-category">[ <?= $is_featured ? 'Featured' : 'Program' ?> ]</div>
                  </div>
                <?php endif; ?>
                <div class="card-body-content">
                  <h3><?= htmlspecialchars(strip_tags($training['training_name'])) ?></h3>
                  <p><?= strip_tags($training['training_description']) ?></p>
                  
                  <div style="display: flex; gap: 15px; margin-bottom: 20px; font-size: 12px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px;">
                      <span style="display: flex; align-items: center; gap: 5px;"><span class="material-symbols-outlined" style="font-size: 16px; color: #f48221;">school</span> <?= isset($training['students_enrolled']) ? number_format($training['students_enrolled']) . '+' : '41K+' ?></span>
                      <span style="display: flex; align-items: center; gap: 5px;"><span class="material-symbols-outlined" style="font-size: 16px; color: #f48221;">star</span> <?= isset($training['rating']) ? $training['rating'] : '4.9' ?></span>
                  </div>

                  <span class="read-link">
                    View Details <i class="material-symbols-outlined">trending_flat</i>
                  </span>
                </div>
              </a>
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