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

$allServices = is_array($services) ? array_values($services) : [];
$initialServices = array_slice($allServices, 0, 6);
$extraServices = array_slice($allServices, 6);
?>
<section class="section-padding services-page-section" x-data="{ showAllServices: false }">
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

        <!-- Default 6 Services Grid -->
        <div class="row services-grid-row">
            <?php foreach ($initialServices as $service):
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

        <?php if (!empty($extraServices)): ?>
        <!-- Animated Reveal Container for Remaining Services -->
        <div class="services-extra-collapse" x-show="showAllServices" x-collapse.duration.500ms x-cloak>
            <div class="row services-grid-row services-extra-row" :class="{ 'is-revealed': showAllServices }">
                <?php foreach ($extraServices as $extraIdx => $service):
                    $sName = trim(stripslashes($service['service_name'] ?? 'Service'));
                    $sDesc = truncateServiceDescWordAware($service['service_description'] ?? '', 118);
                    $delayMs = ($extraIdx + 1) * 70;
                ?>
                <div class="col-lg-4 col-md-6 services-grid-col service-extra-col" style="--stagger-delay: <?= (int) $delayMs ?>ms;">
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

        <!-- Show More / Show Less Action -->
        <div class="services-more-actions">
            <button
                type="button"
                class="services-show-more-btn services-view-more-btn"
                @click="showAllServices = !showAllServices"
                :aria-expanded="showAllServices.toString()">
                <span x-text="showAllServices ? 'Show Less' : 'Show More'">Show More</span>
                <span class="material-symbols-outlined toggle-chevron" :class="{ 'is-rotated': showAllServices }">expand_more</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ====== Testimonials Section ====== -->
<?php include ROOT_PATH . '/views/layout/testimonials.php'; ?>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
