<link rel="stylesheet" href="<?= BASE_URL ?>/css/services.css?v=<?= filemtime(ROOT_PATH . '/css/services.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Expert <span>Services</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Services
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Services Section ====== -->
<section class="section-padding services-page-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Professional Solutions</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>
                <br>
                <h2 class="section-title">What We <span>Do Best</span></h2>
                <p class="section-subtitle">We provide high-impact IT engineering, software architecture, and technical consulting to help organizations scale with confidence.</p>
            </div>
        </div>

        <?php
        if (!function_exists('truncateServiceDescWordAware')) {
            function truncateServiceDescWordAware($text, $limit = 118) {
                $text = trim(preg_replace('/\s+/', ' ', strip_tags(stripslashes($text))));
                if ($text === '' || mb_strlen($text) <= $limit) {
                    return $text;
                }
                $truncated = mb_substr($text, 0, $limit);
                $lastSpace = mb_strrpos($truncated, ' ');
                if ($lastSpace !== false) {
                    $truncated = mb_substr($truncated, 0, $lastSpace);
                }
                return rtrim($truncated, ".,;:- ") . '...';
            }
        }
        ?>

        <div class="row services-grid-row">
            <?php foreach ($services as $service):
                $sName = trim(stripslashes($service['service_name'] ?? 'Service'));
                $sDesc = truncateServiceDescWordAware($service['service_description'] ?? '', 118);
            ?>
            <div class="col-lg-4 col-md-6 services-grid-col">
                <a href="<?= BASE_URL ?>/services/detail?id=<?= (int) $service['id']; ?>" class="service-card">
                    <div class="service-card-body">
                        <div class="icon-box">
                            <i class="<?= htmlspecialchars($service['service_icon'] ?? ''); ?>"></i>
                        </div>
                        <h3 class="service-title"><?= htmlspecialchars($sName); ?></h3>
                        <p class="service-desc"><?= htmlspecialchars($sDesc); ?></p>
                    </div>
                    <span class="learn-more-link">
                        <span>Explore Service</span>
                        <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                    </span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== Testimonials Section ====== -->
<?php include ROOT_PATH . '/views/layout/testimonials.php'; ?>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
