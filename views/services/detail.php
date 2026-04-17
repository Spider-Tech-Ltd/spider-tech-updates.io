<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-muted: #888888;
        --card-bg: #ffffff;
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

    /* Showcase Content */
    .section-padding {
        padding: 120px 0;
    }

    .showcase-icon-box {
        width: 100px;
        height: 100px;
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
    }

    .showcase-icon-box i {
        font-size: 3.5rem;
    }

    .service-main-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 2.8rem;
        color: var(--dark-bg);
        margin-bottom: 1.8rem;
        line-height: 1.2;
    }

    .service-full-desc {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #444;
        margin-bottom: 3rem;
    }

    /* Benefit Cards */
    .benefit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }

    .benefit-card {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .benefit-card:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        transform: translateY(-5px);
    }

    .benefit-icon {
        color: var(--primary-orange);
        font-size: 1.8rem;
        margin-top: 4px;
    }

    .benefit-content h5 {
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--dark-bg);
    }

    .benefit-content p {
        margin-bottom: 0;
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* CTA Section */
    .cta-box {
        background: var(--dark-bg);
        padding: 60px;
        border-radius: 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: 80px;
    }

    .cta-box h3 {
        color: #ffffff !important;
    }

    .cta-box h3 span {
        color: var(--primary-orange) !important;
    }

    .cta-box::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(244, 130, 33, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .btn-pill {
        padding: 16px 40px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-orange {
        background: var(--primary-orange);
        color: #fff;
        border: 2px solid var(--primary-orange);
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.3);
    }

    .btn-orange:hover {
        background: #e6751c;
        border-color: #e6751c;
        transform: translateY(-5px);
        color: #fff;
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.45);
    }

    @media (max-width: 991px) {
        .cta-box { padding: 40px 30px; text-align: center; }
        .service-main-title { font-size: 2.2rem; }
    }
</style>

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
