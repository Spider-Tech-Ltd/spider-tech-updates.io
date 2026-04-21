
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
                <h2 class="section-title"><?= htmlspecialchars($service['service_name']); ?></h2>
                <div class="service-full-desc">
                    <?= nl2br(htmlspecialchars($service['service_description'])); ?>
                </div>
                
                <h4 class="fw-bold mb-4">Key Expertise & Benefits</h4>
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
                <div class="premium-cta">
                    <h2 class="section-title text-white">Ready to <span>Transform?</span></h2>
                    <p class="text-white-70 mb-5 fs-18">
                        Let our experts build a tailored solution that drives real business value for your specific needs.
                    </p>
                    <a href="<?= BASE_URL ?>/contact" class="cta-button">
                        Get a Quote
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <div class="mt-4 text-white-70 fs-14 d-flex align-items-center gap-10">
                        <span class="material-symbols-outlined text-orange">call</span>
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
