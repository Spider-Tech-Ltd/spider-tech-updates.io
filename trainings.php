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
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    /* Global Overrides for modern feel */
    body { font-family: 'Work Sans', sans-serif; }
    h1, h2, h3, h4, h5, .font-headline { font-family: 'Plus Jakarta Sans', sans-serif; }

    .fill-1 { font-variation-settings: 'FILL' 1; }
    .text-orange { color: #f48221 !important; }

    /* Hero Section Styles */
    .training-hero {
        position: relative;
        background-color: #f4f4f4;
        padding: 100px 0 60px;
        overflow: hidden;
    }
    .training-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(244, 130, 33, 0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    .hero-eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-weight: 700;
        font-size: 0.75rem;
        color: #f48221;
        display: block;
        margin-bottom: 1rem;
    }
    .hero-title {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: #111111;
    }
    .hero-subtitle {
        font-size: 1.1rem;
        color: #555555;
        max-width: 500px;
        line-height: 1.6;
    }
    .industry-standard-badge {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        border-left: 4px solid #f48221;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
    }
    .training-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
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
        padding: 0 1.5rem 1.5rem;
    }
    .card-category {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #f48221;
        margin-bottom: 0.75rem;
        display: block;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #111111;
        transition: color 0.3s ease;
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
    }
    .register-btn {
        color: #f48221;
        font-weight: 700;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        text-decoration: none !important;
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
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        filter: blur(40px);
    }
    .featured-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: inline-block;
        margin-bottom: 2rem;
    }
    .featured-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .featured-desc {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }
    .featured-btn {
        background: #ffffff;
        color: #f48221;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-align: center;
        font-weight: 700;
        text-decoration: none !important;
        transition: transform 0.2s ease;
    }
    .featured-btn:hover {
        transform: scale(1.02);
        color: #964900;
    }

    @media (max-width: 992px) {
        .hero-title { font-size: 3rem; }
        .training-hero { padding: 60px 0; }
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
        box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
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
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-8">
          <span class="hero-eyebrow">Professional Growth</span>
          <h1 class="hero-title">Our Training <br>Programs</h1>
          <p class="hero-subtitle">Elevate your technical and interpersonal skills through curated paths designed by industry leaders at the Digital Atelier.</p>
        </div>
        <div class="col-lg-4 d-none d-lg-block">
          <div class="industry-standard-badge">
            <div class="badge-label">
              <span class="material-symbols-outlined fill-1">verified</span>
              Industry Standard
            </div>
            <p class="mb-0 text-muted small">All programs are verified and recognized by our global network of enterprise partners.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ====== Hero Section End ====== -->
  
  <!-- ====== Trainings Start ====== -->
  <section id="services" class="index-2 padding">
    <div class="container">
      <div class="row">
        <?php
              $select_trainings = $conn->prepare("SELECT * FROM `trainings_tb`");
              $select_trainings->execute();
              $counter = 0;
              if($select_trainings->rowCount() > 0){
              while($fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC)){
                $counter++;
                if($counter == 1){
                  // Featured Card
             ?>
          <div class="col-lg-4 col-md-12 mb-4">
            <div class="training-card featured-card h-100">
              <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="featured-badge">Featured Program</div>
                <span class="material-symbols-outlined fill-1">star</span>
              </div>
              <h3 class="featured-title"><?= $fetch_training['training_name']; ?></h3>
              <p class="featured-desc"><?= $fetch_training['training_description']; ?></p>
              <div class="mt-auto pt-4">
                <div class="d-flex gap-2 mb-4">
                  <span class="px-2 py-1 bg-white-20 rounded small font-weight-bold" style="background: rgba(255,255,255,0.1); font-size: 10px;">TRAINING</span>
                  <span class="px-2 py-1 bg-white-20 rounded small font-weight-bold" style="background: rgba(255,255,255,0.1); font-size: 10px;">24 WEEKS</span>
                </div>
                <a href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>#registerNow" class="featured-btn w-100 d-block text-center">Register Now</a>
              </div>
            </div>
          </div>
          <?php } else { ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="training-card">
              <div class="card-img-wrap">
                <img src="<?= $fetch_training['training_image']; ?>" alt="<?= $fetch_training['training_name']; ?>">
              </div>
              <div class="card-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="card-category">Program</span>
                  <span class="material-symbols-outlined text-muted small">more_horiz</span>
                </div>
                <h3 class="card-title"><?= $fetch_training['training_name']; ?></h3>
                <p class="card-desc"><?= $fetch_training['training_description']; ?></p>
                <div class="card-footer bg-transparent p-0">
                  <div class="text-muted small d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined text-orange" style="font-size: 16px;">bolt</span>
                    Intensive
                  </div>
                  <a href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>#registerNow" class="register-btn">
                    Register Now
                    <span class="material-symbols-outlined">arrow_forward</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <?php
              }
             }else{
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
</body>

</html>