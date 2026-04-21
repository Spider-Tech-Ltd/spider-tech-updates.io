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
                $banner['banner_title'] = "Innovating the <span>Future of Tech</span>";
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
            <img :src="'<?= BASE_URL ?>/images/banners/' + slide.banner_image" alt="Slider Image">
        </div>
    </template>

    <!-- Content Overlay -->
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content" x-show="true" x-transition:enter="animate__animated animate__fadeInUp">
                <span class="hero-eyebrow">Precision and Speed</span>

                <h1 class="hero-title" x-html="slides[activeSlide].banner_title"></h1>

                <p class="hero-desc">
                    We are team of passionate tech enthusiats committed to elavating your technological ambision to greater heights.
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
                    <img src="<?= BASE_URL ?>/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About Spider Tech" class="about-img-main">
                    <div class="about-experience-card">
                        <span class="exp-years">4+</span>
                        <span class="exp-text">Years of Tech Excellence</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pl-lg-5">
                <span class="tag-eyebrow">
                    <span class="material-symbols-outlined fs-18">auto_stories</span>
                    Our Story
                </span>
                <h2 class="section-title">Driving <span>Innovation</span> with Purpose</h2>
                <div class="section-subtitle text-left mb-4 m-0">
                    <?= stripslashes($about[0]['details'] ?? ''); ?>
                </div>
                <p class="mb-5 text-muted">
                    <?= stripslashes($about[0]['short_details'] ?? ''); ?>
                </p>
                <a href="<?= BASE_URL ?>/about" class="btn-pill btn-orange">Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- ====== Services Section ====== -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Core <span>Services</span></h2>
            <p class="section-subtitle">We provide high-impact technical solutions designed to scale your business and empower your workforce.</p>
        </div>
        <div class="row">
            <?php foreach (array_slice($services, 0, 6) as $service): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?= BASE_URL ?>/services/detail?id=<?= $service['id']; ?>" class="service-card-new">
                        <div class="service-icon-box">
                            <i class="<?= $service['service_icon']; ?>"></i>
                        </div>
                        <h3 class="service-title"><?= $service['service_name']; ?></h3>
                        <p class="service-text"><?= $service['service_description']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-footer">
            <a href="<?= BASE_URL ?>/services" class="btn-pill btn-orange">Explore All Services</a>
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
                                    <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" class="event-img-h w-100" alt="Event Image">
                                </div>
                                <div class="col-md-7">
                                    <div class="event-content-h">
                                        <span class="event-tag">Upcoming Event</span>
                                        <h3 class="service-title mb-4 fs-20">
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
                                        <div class="text-muted mb-5 line-clamp-2 fs-14">
                                            <?= substr(strip_tags(stripslashes($event['event_detail'])), 0, 150); ?>...
                                        </div>
                                        <div class="mt-auto">
                                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="btn-pill btn-orange">
                                                Register Now
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
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured <span>Projects</span></h2>
            <p class="section-subtitle">We design innovative digital solutions leveraging cutting-edge technology.</p>
        </div>
        <div class="row">
            <?php foreach ($projects as $project): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?= BASE_URL ?>/projects/detail?id=<?= $project['project_id']; ?>" class="project-card-new">
                        <div class="card-img-wrap">
                            <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="<?= stripslashes($project['project_name']); ?>">
                        </div>
                        <div class="card-content-p">
                            <span class="card-category-p"><?= $project['service_name']; ?></span>
                            <h4 class="card-title-p"><?= stripslashes($project['project_name']); ?></h4>
                            <div class="view-btn-p">
                                View Project Details
                                <span class="material-symbols-outlined fs-18">arrow_forward</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-footer">
            <a href="<?= BASE_URL ?>/projects" class="btn-pill btn-orange">View All Projects</a>
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
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="item">
                    <div class="testimonial-slide-new">
                        <div class="quote-icon">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">
                            "<?= stripslashes($testimonial['testimonial']); ?>"
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