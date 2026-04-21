


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
            <span class="material-symbols-outlined fs-16">auto_awesome</span>
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
                  
                  <div class="d-flex gap-15 mb-20 fs-13 fw-bold text-muted text-uppercase" class="ls-1">
                      <span class="d-flex align-items-center gap-5"><span class="material-symbols-outlined fs-16 text-orange">school</span> <?= isset($training['students_enrolled']) ? number_format($training['students_enrolled']) . '+' : '41K+' ?></span>
                      <span class="d-flex align-items-center gap-5"><span class="material-symbols-outlined fs-16 text-orange">star</span> <?= isset($training['rating']) ? $training['rating'] : '4.9' ?></span>
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