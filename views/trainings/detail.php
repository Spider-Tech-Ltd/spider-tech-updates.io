<?php
/**
 * Training Detail View
 */
?>

<style>
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
        font-size: clamp(2.2rem, 5vw, 3.2rem);
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -1.2px;
        line-height: 1.2;
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

    .detail-section {
      padding: 80px 0;
      background-color: #fff;
    }

    .project_screen {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      margin-bottom: 40px;
    }

    .project_screen img {
      width: 100%;
      height: auto;
      display: block;
    }

    .project_description h3 {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 2rem;
      color: #111;
      margin-bottom: 20px;
    }

    .project_description {
      font-family: 'Open Sans', sans-serif;
      line-height: 1.8;
      color: #555;
      font-size: 1.05rem;
    }

    .sidebar-card {
      background: #ffffff;
      border: 1px solid #e9ecef;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.03);
      position: sticky;
      top: 120px;
    }

    .sidebar-title {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 1.2rem;
      color: #111;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid #fef4ea;
    }

    .info-list {
      list-style: none;
      padding: 0;
      margin: 0 0 30px 0;
    }

    .info-item {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 18px;
      font-size: 0.95rem;
    }

    .info-item .material-symbols-outlined {
      color: #f48221;
      font-size: 22px;
    }

    .info-item strong {
      color: #111;
      font-weight: 600;
    }

    .register-btn-large {
      background-color: #f48221;
      color: #ffffff;
      height: 56px;
      border-radius: 50px;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 1rem;
      width: 100%;
      border: none;
      transition: all 0.3s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      text-decoration: none !important;
      box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
    }

    .register-btn-large:hover {
      background-color: #e6751c;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(244, 130, 33, 0.35);
    }

    .text-orange {
        color: #f48221 !important;
    }

    @media (max-width: 991px) {
        .sidebar-card {
            margin-top: 40px;
            position: static;
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
            <span class="material-symbols-outlined" style="font-size: 16px;">school</span>
            Training Course
          </span>
          <h1 class="hero-title"><?= $training ? htmlspecialchars($training['training_name']) : 'Training Detail'; ?></h1>

          <div class="breadcrumb-custom">
             <a href="<?= BASE_URL ?>/" title="Home">Home</a>
             <span>/</span>
             <a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a>
             <span>/</span>
             <span style="color: #999;">Detail</span>
          </div>
        </div>
      </div>
    </div>
</section>
<!-- ====== Hero Section End ====== -->

<section class="detail-section">
    <?php if($training): ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="project_screen">
                    <img src="<?= (strpos($training['training_image'], 'http') === 0) ? htmlspecialchars($training['training_image']) : BASE_URL . '/' . ltrim(substr($training['training_image'], 3), '/'); ?>" alt="Training" />
                </div>
                <div class="project_description">
                    <h3 class="mb-4">About this Program</h3>
                    <div class="mb-4"><?= nl2br(htmlspecialchars($training['training_description'])); ?></div>
                    <div class="training-rich-content">
                        <?= $training['training_details']; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-card">
                    <h5 class="sidebar-title">Course Information</h5>
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="material-symbols-outlined">schedule</span>
                            <div><strong>Duration:</strong> 24 Weeks</div>
                        </li>
                        <li class="info-item">
                            <span class="material-symbols-outlined">group</span>
                            <div><strong>Enrolled:</strong> 41,000+ Students</div>
                        </li>
                        <li class="info-item">
                            <span class="material-symbols-outlined">star</span>
                            <div><strong>Rating:</strong> 4.9/5.0</div>
                        </li>
                        <li class="info-item">
                            <span class="material-symbols-outlined">verified</span>
                            <div><strong>Certified:</strong> Yes, upon completion</div>
                        </li>
                        <li class="info-item">
                            <span class="material-symbols-outlined">language</span>
                            <div><strong>Language:</strong> English</div>
                        </li>
                    </ul>
                    <a href="<?= BASE_URL ?>/trainings/register?id=<?= $training['id']; ?>" class="register-btn-large">
                        <span class="material-symbols-outlined">how_to_reg</span>
                        Enroll Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container text-center">
        <h3 class="mb-4">Training program not found.</h3>
        <a href="<?= BASE_URL ?>/trainings" class="btn-header-cta d-inline-flex">Back to Trainings</a>
    </div>
    <?php endif; ?>
</section>
