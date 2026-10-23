<link rel="stylesheet" href="<?= BASE_URL ?>/css/service-detail.css" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= htmlspecialchars($service['service_name']); ?> <span>Detail</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/services">Services</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Details
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Service Detail Showcase ====== -->
<section class="section-padding">
    <div class="container">
        <?php if($service): ?>
        <div class="row justify-content-between">
            <div class="col-lg-7">
                <div class="showcase-icon-box">
                    <i class="<?= $service['service_icon']; ?>"></i>
                </div>
                <h2 class="service-main-title"><?= htmlspecialchars($service['service_name']); ?></h2>
                <div class="service-full-desc">
                    <?= nl2br(htmlspecialchars($service['service_description'])); ?>
                </div>
                
                <h4 style="font-weight: 700; margin-bottom: 25px;">Key Expertise & Benefits</h4>
                <div class="benefit-grid">
                    <div class="benefit-card">
                        <span class="material-symbols-outlined benefit-icon">verified</span>
                        <div class="benefit-content">
                            <h5>Professional Support</h5>
                            <p>Industry-leading experts dedicated to your success.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <span class="material-symbols-outlined benefit-icon">security</span>
                        <div class="benefit-content">
                            <h5>Quality Assurance</h5>
                            <p>Rigorous testing and uncompromised technical standards.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <span class="material-symbols-outlined benefit-icon">trending_up</span>
                        <div class="benefit-content">
                            <h5>Scalable Solutions</h5>
                            <p>Systems built to grow alongside your business ecosystem.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <span class="material-symbols-outlined benefit-icon">schedule</span>
                        <div class="benefit-content">
                            <h5>24/7 Availability</h5>
                            <p>Round-the-clock technical monitoring and assistance.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="cta-box">
                    <h3 style="font-weight: 800; margin-bottom: 1.5rem;">Ready to <span>Transform?</span></h3>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 2.5rem;">
                        Let our experts build a tailored solution that drives real business value for your specific needs.
                    </p>
                    <a href="<?= BASE_URL ?>/contact" class="btn-pill btn-orange">
                        Get a Quote
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <div style="margin-top: 30px; display: flex; align-items: center; gap: 15px; color: rgba(255,255,255,0.5); font-size: 0.9rem;">
                        <span class="material-symbols-outlined" style="color: var(--primary-orange);">call</span>
                        Expert Consultation Available
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <h2 class="text-muted">Service not found.</h2>
            <a href="<?= BASE_URL ?>/services" class="btn-pill btn-orange mt-4">Back to Services</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
