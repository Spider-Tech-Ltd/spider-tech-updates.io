<link rel="stylesheet" href="<?= BASE_URL ?>/css/about.css" />

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
                        <span class="exp-text">Years of Tech Excellence</span>
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