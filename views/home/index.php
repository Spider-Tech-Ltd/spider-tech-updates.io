<?php

/**
 * Home Page Redesign
 * Modern MVC structure with Alpine.js and Bootstrap 4
 */

// Improve banner titles if they are generic placeholders
foreach ($banners as &$banner) {
    if (strpos($banner['banner_title'], 'Homepage slider') !== false) {
        switch ($banner['banner_id']) {
            case 1:
                $banner['banner_title'] = "Give Wings to your <span>Business</span>";
                break;
            case 2:
                $banner['banner_title'] = "Innovating the <span>Feature of Tech</span>";
                break;
            case 3:
                $banner['banner_title'] = "Empowering <span>Digital Transformation</span>";
                break;
            default:
                $banner['banner_title'] = "Think Big, Grow your <span>Business</span>";
                break;
        }
    }
}
?>

<!-- Custom Home Styles -->
<link rel="stylesheet" href="<?= BASE_URL ?>/css/home.css" />

<!-- ====== Hero Slider Section ====== -->
<section class="home-hero" x-data="{
    activeSlide: 0,
    slides: <?= htmlspecialchars(json_encode($banners)) ?>,
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
    init() { setInterval(() => this.next(), 7000) }
}">
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div class="hero-slide" :class="{ 'active': activeSlide === index }">
            <img :src="slide.banner_image.startsWith('http') ? slide.banner_image : '<?= BASE_URL ?>/' + slide.banner_image" src="<?= !empty($banners[0]['banner_image']) ? (preg_match('#^https?://#i', $banners[0]['banner_image']) ? $banners[0]['banner_image'] : BASE_URL . '/' . ltrim($banners[0]['banner_image'], '/')) : BASE_URL . '/images/placeholder-banner.jpg' ?>" alt="Slider Image" fetchpriority="high">
        </div>
    </template>
    <?php if (!empty($banners)): 
        $firstBanner = $banners[0]['banner_image'];
        $firstSrc = (preg_match('#^https?://#i', $firstBanner)) ? $firstBanner : BASE_URL . '/' . ltrim($firstBanner, '/');
    ?>
    <noscript>
        <div class="hero-slide active">
            <img src="<?= htmlspecialchars($firstSrc) ?>" alt="Spider Tech Hero Banner">
        </div>
    </noscript>
    <?php endif; ?>

    <!-- Content Overlay -->
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content" x-show="true" x-transition:enter="animate__animated animate__fadeInUp">
                <span class="hero-eyebrow">Precision and Speed</span>

                <h1 class="hero-title" x-html="slides[activeSlide].banner_title"></h1>

                <p class="hero-desc">
                    We are a team of passionate tech enthusiasts committed to elevating your technological ambition to greater heights.
                </p>

                <div class="hero-btns">
                    <a href="<?= BASE_URL ?>/about" class="btn-pill btn-orange">
                        View More
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <a href="<?= BASE_URL ?>/contact" class="btn-pill btn-outline-white">
                        Contact Us
                        <span class="material-symbols-outlined">mail</span>
                    </a>
                </div>

                <!-- Hero Stats -->
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <span class="hero-stat-value"><?= Utils::formatNumber($stats['clients']) ?>+</span>
                        <span class="hero-stat-label">Happy Clients</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-value"><?= Utils::formatNumber($stats['projects']) ?>+</span>
                        <span class="hero-stat-label">Projects Done</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-value"><?= Utils::formatNumber($stats['hours']) ?>+</span>
                        <span class="hero-stat-label">Hours Worked</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-value"><?= $stats['locations'] ?></span>
                        <span class="hero-stat-label">Office Location</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== About Us Section ====== -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="about-img-group">
                    <img src="<?= BASE_URL ?>/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About Spider Tech" class="about-img-main" loading="lazy" decoding="async">
                    <div class="about-experience-card">
                        <span class="exp-years">4+</span>
                        <span class="exp-text">Years of Tech Excellence</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-5">
                <span class="event-tag">
                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">auto_stories</span>
                    Our Story
                </span>
                <h2 class="section-title">Driving <span>Innovation</span> with Purpose</h2>
                <div class="about-desc text-left">
                    <?= stripslashes($about[0]['details'] ?? ''); ?>
                </div>
                <?php if (!empty(trim($about[0]['short_details'] ?? ''))): ?>
                    <p class="about-desc text-muted">
                        <?= stripslashes($about[0]['short_details']); ?>
                    </p>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/about" class="btn-pill btn-orange about-cta-btn">Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- ====== Services Section ====== -->
<section class="section-padding bg-light services-section">
    <div class="container">
        <div class="section-header">
            <span class="event-tag">
                <span class="material-symbols-outlined" style="font-size: 1.05rem;">layers</span>
                What We Do
            </span>
            <br>
            <h2 class="section-title">Our Core <span>Services</span></h2>
            <p class="section-subtitle">We provide high-impact technical solutions designed to scale your business and empower your workforce.</p>
        </div>
        <div class="row services-grid-row">
            <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6 services-grid-col">
                    <a href="<?= BASE_URL ?>/services/detail?id=<?= $service['id']; ?>" class="service-card-new">
                        <div class="service-card-body">
                            <div class="service-icon-box">
                                <i class="<?= $service['service_icon']; ?>"></i>
                            </div>
                            <h3 class="service-title"><?= htmlspecialchars($service['service_name']); ?></h3>
                            <p class="service-text"><?= htmlspecialchars($service['service_description']); ?></p>
                        </div>
                        <span class="service-card-link">
                            Learn More
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-footer">
            <a href="<?= BASE_URL ?>/services" class="btn-pill btn-orange services-cta-btn">Explore All Services</a>
        </div>
    </div>
</section>
<!-- ====== Upcoming Events Section ====== -->
<?php if (!empty($upcoming_events)): ?>
    <section class="section-padding">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Join Our <span>Latest Events</span></h2>
                <p class="section-subtitle">Stay ahead in tech with curated events designed to help you learn, connect, and grow explore new trends, gain insights, and build valuable connections.
                </p>
            </div>

            <div class="owl-carousel owl-theme" id="event-carousel">
                <?php foreach ($upcoming_events as $event): ?>
                    <div class="item p-3">
                        <div class="event-card-horizontal">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="<?= resolvePath($event['event_img']) ?>" class="event-img-h w-100" alt="Event Image">
                                </div>
                                <div class="col-md-7">
                                    <div class="event-content-h">
                                        <span class="event-tag">
                                            <?php if (strtolower($event['event_status'] ?? '') === 'ongoing'): ?>
                                                <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">sensors</span> Ongoing Event
                                            <?php else: ?>
                                                Upcoming Event
                                            <?php endif; ?>
                                        </span>
                                        <h3 class="service-title mb-4" style="font-size: 1.8rem;">
                                            <?= stripslashes($event['event_title']); ?>
                                        </h3>
                                        <div class="event-meta-h">
                                            <div class="meta-item-h">
                                                <span class="material-symbols-outlined">calendar_today</span>
                                                <span><?= date_format(date_create($event['event_date']), "M j, Y"); ?></span>
                                            </div>
                                            <div class="meta-item-h">
                                                <span class="material-symbols-outlined">schedule</span>
                                                <span><?= stripslashes($event['event_time']); ?></span>
                                            </div>
                                        </div>
                                        <div class="text-muted mb-5 line-clamp-2" style="font-size: 0.95rem; line-height: 1.6;">
                                            <?= substr(strip_tags(stripslashes($event['event_detail'])), 0, 150); ?>...
                                        </div>
                                        <div class="mt-auto">
                                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="btn-pill btn-orange">
                                                <?= (strtolower($event['event_status'] ?? '') === 'ongoing') ? 'View Event Details' : 'Register Now' ?>
                                                <span class="material-symbols-outlined">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ====== Projects Showcase ====== -->
<section class="section-padding bg-light projects-showcase-section">
    <div class="container">
        <div class="section-header">
            <span class="event-tag">
                <span class="material-symbols-outlined" style="font-size: 1.05rem;">work_history</span>
                Our Portfolio
            </span>
            <br>
            <h2 class="section-title">Featured <span>Projects</span></h2>
            <p class="section-subtitle">We design innovative digital solutions leveraging cutting-edge technology.</p>
        </div>
        <div class="row">
            <?php foreach ($projects as $project):
                $rawPic = trim($project['project_pic'] ?? '');
                $hasPic = false;
                $pPic = '';
                if ($rawPic !== '') {
                    if (preg_match('#^https?://#i', $rawPic)) {
                        $pPic = $rawPic;
                        $hasPic = true;
                    } else {
                        $relPath = ltrim($rawPic, './');
                        if (file_exists(ROOT_PATH . '/' . $relPath)) {
                            $pPic = BASE_URL . '/' . $relPath;
                            $hasPic = true;
                        }
                    }
                }
                $pTitle = trim(stripslashes($project['project_name'] ?? 'Untitled Project'));
                $pCategory = trim(stripslashes($project['service_name'] ?? 'Technology Solution'));
                if (!function_exists('truncateProjectDescWordAware')) {
                    function truncateProjectDescWordAware($text, $limit = 112) {
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
                $pDesc = truncateProjectDescWordAware($project['project_description'] ?? '', 112);
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?= BASE_URL ?>/projects/detail?id=<?= (int)$project['project_id']; ?>"
                       class="project-card-new"
                       aria-label="View project details for <?= htmlspecialchars($pTitle); ?>">
                        <div class="card-img-wrap">
                            <?php if ($hasPic): ?>
                                <img src="<?= htmlspecialchars($pPic) ?>"
                                     alt="<?= htmlspecialchars($pTitle); ?>"
                                     loading="lazy"
                                     decoding="async"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <?php endif; ?>
                            <div class="project-img-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true">
                                <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                    <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="2.5"/>
                                    <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="fallback-label">Thumbnail Unavailable</span>
                            </div>
                        </div>
                        <div class="card-content-p">
                            <span class="card-category-p"><?= htmlspecialchars($pCategory); ?></span>
                            <h3 class="card-title-p" title="<?= htmlspecialchars($pTitle); ?>"><?= htmlspecialchars($pTitle); ?></h3>
                            <?php if ($pDesc !== ''): ?>
                                <p class="card-desc-p"><?= htmlspecialchars($pDesc); ?></p>
                            <?php endif; ?>
                            <div class="view-btn-p">
                                <span>View Project Details</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-footer">
            <a href="<?= BASE_URL ?>/projects" class="btn-pill btn-orange services-cta-btn">View All Projects</a>
        </div>
    </div>
</section>
<!-- ====== Testimonials Section ====== -->
<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What <span>Clients Say</span></h2>
            <p class="section-subtitle">Trusted by industry leaders to deliver excellence and technical innovation.</p>
        </div>
        <div class="owl-carousel owl-theme" id="testimonial-carousel">
            <?php 
            // Smart word-boundary truncation helper to avoid mid-word cuts or CSS line-clamp issues
            if (!function_exists('truncateTestimonialWordAware')) {
                function truncateTestimonialWordAware($text, $limit = 140) {
                    $text = trim(stripslashes($text), " \"'\t\n\r\0\x0B");
                    if (mb_strlen($text) <= $limit) {
                        return $text;
                    }
                    $truncated = mb_substr($text, 0, $limit);
                    $lastSpace = mb_strrpos($truncated, ' ');
                    if ($lastSpace !== false) {
                        $truncated = mb_substr($truncated, 0, $lastSpace);
                    }
                    $truncated = rtrim($truncated, ".,;:-");
                    return $truncated . '...';
                }
            }

            foreach ($testimonials as $testimonial): 
                $cleanQuote = truncateTestimonialWordAware($testimonial['testimonial'], 140);
            ?>
                <div class="item">
                    <div class="testimonial-slide-new">
                        <div class="quote-icon">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">
                            "<?= htmlspecialchars($cleanQuote); ?>"
                        </p>
                        <div class="client-info-v2">
                            <div class="client-avatar-v2">
                                <span class="material-symbols-outlined">account_circle</span>
                            </div>
                            <div>
                                <h5 class="client-name-v2"><?= stripslashes($testimonial['name']); ?></h5>
                                <p class="client-job-v2"><?= stripslashes($testimonial['title']); ?>, <?= stripslashes($testimonial['organization']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>

<script>
    $(document).ready(function() {
        // Initialize Event Carousel
        $("#event-carousel").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            dots: true,
            nav: false,
            margin: 30
        });

        // Initialize Testimonial Carousel - Smooth Glide
        $("#testimonial-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 6000,
            smartSpeed: 1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        });


    });
</script>