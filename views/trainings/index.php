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
    .gap-1 { gap: 0.25rem; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
    .gap-4 { gap: 1.5rem; }
    .-space-x-2>*+* { margin-left: -0.5rem; }
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
    .hero-blob-left { width: 280px; height: 280px; top: 20%; left: -80px; }
    .hero-blob-right { width: 320px; height: 320px; bottom: 15%; right: -80px; }
    .hero-inner { position: relative; z-index: 1; }
    .hero-eyebrow-pill {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 6px 18px;
      border-radius: 50px;
      background-color: rgba(244, 130, 33, 0.12);
      border: 1px solid rgba(244, 130, 33, 0.25);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #f48221;
      margin-bottom: 28px;
    }
    .hero-title {
      font-size: 3.5rem;
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
    .hero-btn-primary:hover { background-color: #e6751c; color: #ffffff; text-decoration: none; }
    .hero-btn-primary:active { transform: scale(0.98); }
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
    .training-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); }
    .section-header { margin-top: 24px; margin-bottom: 28px; }
    .section-header h2 { font-size: 1.9rem; margin-bottom: 0.35rem; font-weight: 700; color: #111111; }
    .section-header p { margin-bottom: 0; font-size: 0.95rem; color: #6d6d6d; }
    .card-img-wrap { aspect-ratio: 16/9; border-radius: 1.25rem; overflow: hidden; margin-bottom: 1.5rem; }
    .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .training-card:hover .card-img-wrap img { transform: scale(1.05); }
    .card-content { padding: 0 1.5rem 1rem; display: flex; flex-direction: column; flex: 1; }
    .card-category { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #f48221; margin-bottom: 0; display: block; }
    .card-provider { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #aaaaaa; }
    .card-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: #111111; transition: color 0.3s ease; line-height: 1.2; max-height: 3.6rem; overflow: hidden; word-break: break-word; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; }
    .training-card:hover .card-title { color: #f48221; }
    .card-desc { font-size: 0.875rem; color: #555555; line-height: 1.6; margin-bottom: 1.5rem; }
    .card-footer { padding-top: 1.125rem !important; border-top: 1px solid #f1f1f1; display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
    .course-meta { display: flex; gap: 12px; margin-bottom: 12px; flex-wrap: wrap; }
    .meta-item { display: flex; align-items: center; gap: 4px; font-size: 0.75rem; color: #666; background: #f9f9f9; padding: 4px 8px; border-radius: 4px; }
    .meta-item .material-symbols-outlined { font-size: 14px; color: #f48221; }
    .register-btn { color: #f48221; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.25rem; text-decoration: none !important; transition: color 0.2s; }
    .register-btn:hover { color: #f48221; }
    .register-btn span { transition: transform 0.3s ease; }
    .register-btn:hover span { transform: translateX(4px); }
    .featured-card { background: linear-gradient(135deg, #f48221 0%, #964900 100%); border: none; padding: 2rem; color: #ffffff; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
    .featured-badge { background: rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 9999px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; display: inline-block; color: #ffffff; }
    .featured-title { font-size: 2.3rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; letter-spacing: -0.02em; color: #ffffff; word-break: break-word; max-height: 5.2rem; overflow: hidden; }
    .featured-desc { font-size: 1rem; color: #ffffff; opacity: 0.9; margin-bottom: 3rem; line-height: 1.5; max-width: 100%; }
    .featured-btn { background: #ffffff; color: #f48221; padding: 1rem 2rem; border-radius: 9999px; text-align: center; font-weight: 700; text-decoration: none !important; transition: all 0.2s ease; font-size: 1.1rem; }
    .featured-btn:hover { transform: scale(1.02); color: #e6751c; }
    @media (max-width: 992px) { .hero-title { font-size: 3rem; } .training-hero { padding: 60px 0; } }
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
                      <a href="<?= BASE_URL ?>/trainings/detail?id=<?= stripslashes($training['id']); ?>" class="featured-btn w-100 d-block text-center">View Program</a>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="training-card">
                    <div class="card-img-wrap">
                      <img src="<?= htmlspecialchars($training['training_image']); ?>" alt="<?= htmlspecialchars(strip_tags($training['training_name'])); ?>">
                    </div>
                    <div class="card-content">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="card-category">Program</span>
                        <span class="card-provider">Spider Tech</span>
                      </div>
                      <h3 class="card-title"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></h3>
                      <div class="course-meta">
                        <div class="meta-item">
                          <span class="material-symbols-outlined">schedule</span>
                          <span><?= isset($training['duration_minutes']) ? round($training['duration_minutes'] / 60, 1) . 'h' : '2h 14min'; ?></span>
                        </div>
                        <div class="meta-item">
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
