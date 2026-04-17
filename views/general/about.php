<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-muted: #888888;
    }

    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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

    .breadcrumb-custom {
        background: transparent;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .breadcrumb-item-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s;
    }

    .breadcrumb-item-custom a:hover {
        color: var(--primary-orange);
    }

    .breadcrumb-item-custom.active {
        color: var(--primary-orange);
    }

    .breadcrumb-item-custom+.breadcrumb-item-custom::before {
        content: '/';
        color: rgba(255, 255, 255, 0.2);
    }

    /* Common Section Styles */
    .section-padding {
        padding: 120px 0;
    }

    .section-header {
        margin-bottom: 60px;
    }

    .section-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 2.8rem;
        color: var(--dark-bg);
        margin-bottom: 1.25rem;
        position: relative;
        display: inline-block;
        line-height: 1.2;
    }

    .section-title span {
        color: var(--primary-orange);
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    /* About Content High-Fidelity */
    .about-img-group {
        position: relative;
        padding-right: 40px;
        padding-bottom: 40px;
    }

    .about-img-main {
        width: 100%;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
    }

    .about-experience-card {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--primary-orange);
        color: #fff;
        padding: 20px;
        border-radius: 25px;
        text-align: center;
        min-width: 160px;
        box-shadow: 0 15px 30px rgba(244, 130, 33, 0.3);
    }

    .exp-years {
        font-size: 3rem;
        font-weight: 800;
        display: block;
        line-height: 1;
        font-family: 'Poppins', sans-serif;
    }

    .exp-text {
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .tag-eyebrow {
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1.5rem;
    }

    /* Mission & Vision Cards */
    .mission-vision-card {
        background: #fff;
        border-radius: 30px;
        padding: 50px;
        height: 100%;
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .mission-vision-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .card-icon-box {
        width: 60px;
        height: 60px;
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .card-icon-box .material-symbols-outlined {
        font-size: 2rem;
    }

    .mv-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--dark-bg);
        margin-bottom: 1.25rem;
    }

    .mv-text {
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 0;
    }

    /* Core Values Grid */
    .value-item {
        text-align: center;
        padding: 40px 20px;
        transition: all 0.3s ease;
    }

    .value-icon-box {
        width: 80px;
        height: 80px;
        background: #fff;
        color: var(--primary-orange);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .value-item:hover .value-icon-box {
        background: var(--primary-orange);
        color: #fff;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.25);
    }

    .value-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--dark-bg);
        margin-bottom: 0.8rem;
    }

    .value-description {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 0;
    }

    .about-feature-grid {
        margin-top: 3rem;
    }

    .about-feature-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 24px;
        padding: 30px 25px;
        height: 100%;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .about-feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .about-feature-icon {
        width: 65px;
        height: 65px;
        border-radius: 20px;
        background: rgba(244, 130, 33, 0.12);
        color: var(--primary-orange);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .about-feature-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--dark-bg);
        margin-bottom: 0.6rem;
    }

    .about-feature-desc {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 0;
        flex: 1;
    }

    .about-feature-section {
        padding: 60px 0 100px;
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-content">
                    <h1 class="page-title">About <span>Us</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/">Home</a></li>
                            <li class="breadcrumb-item-custom active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="about-img-group">
                    <img src="<?= BASE_URL ?>/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About Spider Tech" class="about-img-main">
                    <div class="about-experience-card">
                        <span class="exp-years">4+</span>
                        <span class="exp-text">Years of<br>Excellence</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-5">
                <span class="tag-eyebrow">
                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">auto_stories</span>
                    Our Story
                </span>
                <h2 class="section-title">Driving <span>Innovation</span> with Purpose</h2>
                <div class="section-subtitle">
                    <?= stripslashes($about[0]['details'] ?? 'Spider Tech Limited is a premier technology firm dedicated to bridging the digital divide through advanced engineering.'); ?>
                </div>
                <?php if (isset($about[1])): ?>
                    <p class="text-muted mb-4" style="line-height: 1.7;">
                        <?= stripslashes($about[1]['details']); ?>
                    </p>
                <?php endif; ?>
                <?php if (isset($about[2])): ?>
                    <p class="text-muted mb-0" style="line-height: 1.7;">
                        <?= stripslashes($about[2]['details']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="about-feature-section bg-white">
    <div class="container">
        <div class="row about-feature-grid">
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-icon">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <h4 class="about-feature-title">We are Professional</h4>
                    <p class="about-feature-desc">Delivering top-notch IT solutions with unmatched expertise and dedication. Trust us for innovative and reliable services.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-icon">
                        <span class="material-symbols-outlined">workspace_premium</span>
                    </div>
                    <h4 class="about-feature-title">High-Ranking Company</h4>
                    <p class="about-feature-desc">Offering IT solutions with a focus on excellence and dependability, making us your top choice for technology services.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-icon">
                        <span class="material-symbols-outlined">badge</span>
                    </div>
                    <h4 class="about-feature-title">Licensed and Certified</h4>
                    <p class="about-feature-desc">Our company is serviced by licensed professionals and experts, ensuring quality delivery of service across every engagement.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-icon">
                        <span class="material-symbols-outlined">leaderboard</span>
                    </div>
                    <h4 class="about-feature-title">Leading Provider</h4>
                    <p class="about-feature-desc">We excel as a top provider, offering outstanding IT solutions with exceptional performance and trustworthiness.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Mission & Vision Section ====== -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="mission-vision-card">
                    <div class="card-icon-box">
                        <?php if (!empty($mission[0]['icon'])): ?>
                            <?php if (strpos($mission[0]['icon'], 'material') !== false): ?>
                                <span class="material-symbols-outlined"><?= $mission[0]['icon'] ?></span>
                            <?php else: ?>
                                <i class="<?= $mission[0]['icon'] ?> icon-render" style="font-size: 2.2rem;"></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="material-symbols-outlined">rocket_launch</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="mv-title"><?= stripslashes($mission[0]['title'] ?? 'Our Mission'); ?></h3>
                    <p class="mv-text">
                        <?= stripslashes($mission[0]['details'] ?? 'Providing excellence in every project.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="mission-vision-card">
                    <div class="card-icon-box">
                        <?php if (!empty($vision[0]['icon'])): ?>
                            <?php if (strpos($vision[0]['icon'], 'material') !== false): ?>
                                <span class="material-symbols-outlined"><?= $vision[0]['icon'] ?></span>
                            <?php else: ?>
                                <i class="<?= $vision[0]['icon'] ?> icon-render" style="font-size: 2.2rem;"></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="material-symbols-outlined">visibility</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="mv-title"><?= stripslashes($vision[0]['title'] ?? 'Our Vision'); ?></h3>
                    <p class="mv-text">
                        <?= stripslashes($vision[0]['details'] ?? 'Driving digital ecosystems forward.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mission-vision-card">
                    <div class="card-icon-box">
                        <?php if (!empty($values[0]['icon'])): ?>
                            <?php if (strpos($values[0]['icon'], 'material') !== false): ?>
                                <span class="material-symbols-outlined"><?= $values[0]['icon'] ?></span>
                            <?php else: ?>
                                <i class="<?= $values[0]['icon'] ?> icon-render" style="font-size: 2.2rem;"></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="material-symbols-outlined">architecture</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="mv-title"><?= stripslashes($values[0]['title'] ?? 'Custom Solutions'); ?></h3>
                    <p class="mv-text">
                        <?= stripslashes($values[0]['details'] ?? 'Spider offers custom solutions tailored to your specific needs, unlike generic bundles from product-focused companies. As a vendor-independent provider, we choose the best options to minimize your Total Cost of Ownership and maximize Quality of Service.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>