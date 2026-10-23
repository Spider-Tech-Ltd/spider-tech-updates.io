<link rel="stylesheet" href="<?= BASE_URL ?>/css/services.css" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Expert <span>Services</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Services
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Services Section ====== -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Professional Solutions</span>
                <h2 class="section-title" style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 2.8rem; color: var(--dark-bg);">What We <span>Do Best</span></h2>
                <p class="section-subtitle">We provide cutting-edge IT solutions and consulting to help businesses navigate and thrive in the digital transformation era.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach($services as $service): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div>
                        <div class="icon-box">
                            <i class="<?= $service['service_icon']; ?>"></i>
                        </div>
                        <h3 class="service-title"><?= htmlspecialchars($service['service_name']); ?></h3>
                        <p class="service-desc">
                            <?= strlen($service['service_description']) > 140 ? substr(htmlspecialchars($service['service_description']), 0, 140) . '...' : htmlspecialchars($service['service_description']); ?>
                        </p>
                    </div>
                    <a href="<?= BASE_URL ?>/services/detail?id=<?= $service['id']; ?>" class="learn-more-link">
                        Explore Service 
                        <span class="material-symbols-outlined arrow-icon">trending_flat</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
