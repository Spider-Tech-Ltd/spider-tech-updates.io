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

    /* Section Styles */
    .section-padding {
        padding: 120px 0;
    }

    .tag-eyebrow {
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    /* Industrial Service Cards */
    .service-card {
        background: var(--card-bg);
        padding: 50px 40px;
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .service-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .service-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle at top right, rgba(244, 130, 33, 0.03), transparent);
        pointer-events: none;
    }

    .icon-box {
        width: 85px;
        height: 85px;
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    }

    .service-card:hover .icon-box {
        background: var(--primary-orange);
        border-color: var(--primary-orange);
        transform: rotate(-5deg) scale(1.05);
        color: #fff !important;
    }

    .icon-box i {
        font-size: 2.2rem;
        color: var(--primary-orange);
        transition: color 0.4s;
    }

    .service-card:hover .icon-box i {
        color: #fff;
    }

    .service-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--dark-bg);
        margin-bottom: 1.2rem;
        line-height: 1.3;
    }

    .service-desc {
        color: var(--text-muted);
        line-height: 1.7;
        font-size: 1rem;
        margin-bottom: 2.5rem;
    }

    .learn-more-link {
        color: var(--dark-bg);
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: auto;
    }

    .learn-more-link .arrow-icon {
        font-size: 1.2rem;
        transition: transform 0.3s;
    }

    .service-card:hover .learn-more-link {
        color: var(--primary-orange);
    }

    .service-card:hover .learn-more-link .arrow-icon {
        transform: translateX(5px);
    }

    @media (max-width: 991px) {
        .section-padding { padding: 80px 0; }
        .page-header { padding: 120px 0 60px; }
    }
</style>

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
