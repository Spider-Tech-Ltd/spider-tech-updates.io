<link rel="stylesheet" href="<?= BASE_URL ?>/css/service-detail.css?v=<?= filemtime(ROOT_PATH . '/css/service-detail.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= htmlspecialchars(stripslashes($service['service_name'] ?? 'Service')); ?> <span>Overview</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/services">Services</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            <?= htmlspecialchars(stripslashes($service['service_name'] ?? 'Details')); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Service Detail Showcase ====== -->
<section class="section-padding service-detail-section">
    <div class="container">
        <?php if ($service): ?>
        <div class="row justify-content-between">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Core Capability</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>

                <div class="service-title-row">
                    <div class="showcase-icon-box">
                        <i class="<?= htmlspecialchars($service['service_icon'] ?? ''); ?>"></i>
                    </div>
                    <h2 class="service-main-title"><?= htmlspecialchars(stripslashes($service['service_name'])); ?></h2>
                </div>

                <div class="service-full-desc">
                    <?= nl2br(htmlspecialchars(stripslashes($service['service_description']))); ?>
                </div>

                <h3 class="benefits-heading">Key Expertise &amp; <span>Delivery Standards</span></h3>
                <div class="benefit-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrap">
                            <span class="material-symbols-outlined benefit-icon">verified</span>
                        </div>
                        <div class="benefit-content">
                            <h5>Dedicated Engineering</h5>
                            <p>Experienced specialists focused on reliable architecture and measurable outcomes.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon-wrap">
                            <span class="material-symbols-outlined benefit-icon">security</span>
                        </div>
                        <div class="benefit-content">
                            <h5>Quality Assurance</h5>
                            <p>Rigorous code review, testing, and security practices across every milestone.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon-wrap">
                            <span class="material-symbols-outlined benefit-icon">trending_up</span>
                        </div>
                        <div class="benefit-content">
                            <h5>Scalable Architecture</h5>
                            <p>Modular systems engineered to grow alongside your user base and operations.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon-wrap">
                            <span class="material-symbols-outlined benefit-icon">schedule</span>
                        </div>
                        <div class="benefit-content">
                            <h5>Continuous Support</h5>
                            <p>Proactive monitoring, maintenance, and responsive technical assistance.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="service-sidebar-sticky">
                    <div class="cta-box">
                        <span class="cta-box-badge">Consultation</span>
                        <h3 class="cta-box-title">Ready to <span>Build Together?</span></h3>
                        <p class="cta-box-desc">
                            Let our engineering team design and deliver a tailored solution aligned with your operational goals.
                        </p>
                        <div class="cta-box-actions">
                            <a href="<?= BASE_URL ?>/contact" class="btn-pill btn-orange">
                                <span>Request a Consultation</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                            <a href="<?= BASE_URL ?>/services" class="btn-pill btn-outline-light-subtle">
                                <span class="material-symbols-outlined">grid_view</span>
                                <span>All Services</span>
                            </a>
                        </div>
                        <div class="cta-box-meta">
                            <span class="material-symbols-outlined">verified_user</span>
                            <span>Vendor-independent technical advisory</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <h2 class="text-muted">Service not found.</h2>
            <a href="<?= BASE_URL ?>/services" class="btn-pill btn-orange mt-3">Back to Services</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
