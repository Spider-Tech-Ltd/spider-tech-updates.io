<link rel="stylesheet" href="<?= BASE_URL ?>/css/about.css" />

<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-content">
                    <span class="page-header-eyebrow">
                        <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                            <rect x="4" y="5.25" width="32" height="1.5" rx="0.75" fill="rgba(244, 130, 33, 0.55)"/>
                        </svg>
                        <span>Company Profile</span>
                        <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="32" height="1.5" rx="0.75" fill="rgba(244, 130, 33, 0.55)"/>
                            <rect x="33.5" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                        </svg>
                    </span>
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

<!-- ====== Our Story Section ====== -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-img-group">
                    <img src="<?= BASE_URL ?>/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About Spider Tech" class="about-img-main">
                    <div class="about-experience-card">
                        <span class="exp-years">4+</span>
                        <span class="exp-text">Years of Tech Excellence</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-5">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                        <rect x="4" y="5.25" width="32" height="1.5" rx="0.75" fill="#cbd5e1"/>
                    </svg>
                    <span>Our Story</span>
                    <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="32" height="1.5" rx="0.75" fill="#cbd5e1"/>
                        <rect x="33.5" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                    </svg>
                </span>
                <h2 class="section-title">Driving <span>Innovation</span> with Purpose</h2>
                <div class="section-subtitle">
                    <?= stripslashes($about[0]['details'] ?? 'Spider Tech Limited is a premier technology firm dedicated to bridging the digital divide through advanced engineering.'); ?>
                </div>
                <?php if (isset($about[1])): ?>
                    <p class="about-body-copy mb-3">
                        <?= stripslashes($about[1]['details']); ?>
                    </p>
                <?php endif; ?>
                <?php if (isset($about[2])): ?>
                    <p class="about-body-copy mb-0">
                        <?= stripslashes($about[2]['details']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ====== Core Engineering Pillars ====== -->
<section class="about-feature-section">
    <div class="container">
        <div class="row about-feature-grid">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-top">
                        <div class="about-feature-icon">
                            <span class="material-symbols-outlined">verified</span>
                        </div>
                        <span class="about-feature-num">01</span>
                    </div>
                    <h4 class="about-feature-title">Professional Execution</h4>
                    <p class="about-feature-desc">Delivering dependable IT solutions with disciplined engineering practices and clear accountability.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-top">
                        <div class="about-feature-icon">
                            <span class="material-symbols-outlined">workspace_premium</span>
                        </div>
                        <span class="about-feature-num">02</span>
                    </div>
                    <h4 class="about-feature-title">Proven Track Record</h4>
                    <p class="about-feature-desc">Trusted by enterprises and institutions for resilient architectures and measurable business impact.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-top">
                        <div class="about-feature-icon">
                            <span class="material-symbols-outlined">badge</span>
                        </div>
                        <span class="about-feature-num">03</span>
                    </div>
                    <h4 class="about-feature-title">Licensed &amp; Certified</h4>
                    <p class="about-feature-desc">Staffed by certified engineers and specialists ensuring compliance and quality across every engagement.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="about-feature-card">
                    <div class="about-feature-top">
                        <div class="about-feature-icon">
                            <span class="material-symbols-outlined">leaderboard</span>
                        </div>
                        <span class="about-feature-num">04</span>
                    </div>
                    <h4 class="about-feature-title">Industry Leadership</h4>
                    <p class="about-feature-desc">Combining regional domain insight with global technology standards to build lasting digital infrastructure.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Mission, Vision & Principles Section ====== -->
<section class="about-mv-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                        <rect x="4" y="5.25" width="32" height="1.5" rx="0.75" fill="#cbd5e1"/>
                    </svg>
                    <span>Strategic Foundation</span>
                    <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="32" height="1.5" rx="0.75" fill="#cbd5e1"/>
                        <rect x="33.5" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                    </svg>
                </span>
                <h2 class="section-title">Guided by Purpose &amp; <span>Engineering Rigor</span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="mission-vision-card">
                    <div class="mv-card-header">
                        <div class="card-icon-box">
                            <?php if (!empty($mission[0]['icon'])): ?>
                                <?php if (strpos($mission[0]['icon'], 'material') !== false): ?>
                                    <span class="material-symbols-outlined"><?= $mission[0]['icon'] ?></span>
                                <?php else: ?>
                                    <i class="<?= $mission[0]['icon'] ?> icon-render"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="material-symbols-outlined">rocket_launch</span>
                            <?php endif; ?>
                        </div>
                        <span class="mv-card-tag">Mission</span>
                    </div>
                    <h3 class="mv-title"><?= stripslashes($mission[0]['title'] ?? 'Our Mission'); ?></h3>
                    <p class="mv-text">
                        <?= stripslashes($mission[0]['details'] ?? 'Providing excellence in every project.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="mission-vision-card">
                    <div class="mv-card-header">
                        <div class="card-icon-box">
                            <?php if (!empty($vision[0]['icon'])): ?>
                                <?php if (strpos($vision[0]['icon'], 'material') !== false): ?>
                                    <span class="material-symbols-outlined"><?= $vision[0]['icon'] ?></span>
                                <?php else: ?>
                                    <i class="<?= $vision[0]['icon'] ?> icon-render"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="material-symbols-outlined">visibility</span>
                            <?php endif; ?>
                        </div>
                        <span class="mv-card-tag">Vision</span>
                    </div>
                    <h3 class="mv-title"><?= stripslashes($vision[0]['title'] ?? 'Our Vision'); ?></h3>
                    <p class="mv-text">
                        <?= stripslashes($vision[0]['details'] ?? 'Driving digital ecosystems forward.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mission-vision-card">
                    <div class="mv-card-header">
                        <div class="card-icon-box">
                            <?php if (!empty($values[0]['icon'])): ?>
                                <?php if (strpos($values[0]['icon'], 'material') !== false): ?>
                                    <span class="material-symbols-outlined"><?= $values[0]['icon'] ?></span>
                                <?php else: ?>
                                    <i class="<?= $values[0]['icon'] ?> icon-render"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="material-symbols-outlined">architecture</span>
                            <?php endif; ?>
                        </div>
                        <span class="mv-card-tag">Approach</span>
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
