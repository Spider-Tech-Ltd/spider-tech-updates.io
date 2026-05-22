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

<!-- Custom Home Styles -->
<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-muted: #666666;
    }

    /* Hero Slider */
    .home-hero {
        position: relative;
        height: 100vh;
        min-height: 800px;
        background: var(--dark-bg);
        overflow: hidden;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        z-index: 1;
        opacity: 0;
        transform: scale(1.05);
        transition: opacity 1.5s ease-in-out, transform 1.5s ease-in-out;
    }

    .hero-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.65);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 10;
        display: flex;
        align-items: center;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 60%, transparent 100%);
        padding-top: 80px;
        /* Reduced to bring stats more into view */
    }

    .hero-content {
        max-width: 850px;
        color: #fff;
        padding: 0 15px;
    }

    .hero-eyebrow {
        color: var(--primary-orange);
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hero-eyebrow::after {
        content: '';
        height: 2px;
        width: 40px;
        background: var(--primary-orange);
    }

    .hero-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: rgba(255, 255, 255, 0.85);
        /* Match description color for readability */
    }

    .hero-title span {
        color: var(--primary-orange);
    }

    .hero-desc {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 1.5rem;
        /* Reduced for tighter layout */
        max-width: 650px;
        line-height: 1.7;
    }

    .hero-btns {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 3rem;
        /* Reduced to pull stats up */
    }

    .btn-pill {
        padding: 16px 38px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-orange {
        background: var(--primary-orange);
        color: #fff;
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.35);
        border: 2px solid var(--primary-orange);
    }

    .btn-orange:hover {
        background: #e6751c;
        border-color: #e6751c;
        transform: translateY(-5px);
        color: #fff;
    }

    .btn-outline-white {
        border: 2px solid #fff;
        color: #fff;
        background: transparent;
    }

    .btn-outline-white:hover {
        background: #fff;
        color: var(--dark-bg);
        transform: translateY(-5px);
    }

    /* Hero Stats */
    .hero-stats {
        display: flex;
        gap: 4.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 1.5rem;
    }

    .hero-stat-item {
        display: flex;
        flex-direction: column;
    }

    .hero-stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        color: #fff;
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.6);
        letter-spacing: 1.5px;
        margin-top: 8px;
    }

    .section-padding {
        padding: 120px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 70px;
    }

    .section-footer {
        margin-top: 60px;
        text-align: center;
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
        max-width: 700px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.7;
    }

    /* About Us */
    .about-img-group {
        position: relative;
        padding-right: 40px;
        padding-bottom: 40px;
    }

    .about-img-main {
        width: 100%;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
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

    /* Services Grid */
    .service-card-new {
        background: #fff;
        border: 1px solid #f0f0f0;
        padding: 50px 40px;
        border-radius: 24px;
        transition: all 0.4s ease;
        height: 100%;
        text-decoration: none !important;
        display: block;
    }

    .service-card-new:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .service-icon-box {
        width: 70px;
        height: 70px;
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        transition: all 0.4s ease;
    }

    .service-card-new:hover .service-icon-box {
        background: var(--primary-orange);
        color: #fff;
        transform: rotateY(180deg);
    }

    .service-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        color: var(--dark-bg);
        margin-bottom: 1rem;
    }

    .service-text {
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Events Horizontal Card */
    .event-card-horizontal {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
    }

    .event-card-horizontal:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .event-img-h {
        height: 100%;
        min-height: 350px;
        object-fit: cover;
    }

    .event-content-h {
        padding: 50px;
    }

    .event-tag {
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

    .event-meta-h {
        display: flex;
        gap: 25px;
        margin-bottom: 2rem;
    }

    .meta-item-h {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .meta-item-h i {
        color: var(--primary-orange);
    }

    /* Projects Grid - Ported from Projects Page */
    .project-card-new {
        background-color: #ffffff;
        border-radius: 1.5rem;
        padding: 0.25rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        text-decoration: none !important;
    }

    .project-card-new:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .card-img-wrap {
        aspect-ratio: 16/9;
        border-radius: 1.25rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card-new:hover .card-img-wrap img {
        transform: scale(1.08);
    }

    .card-content-p {
        padding: 0 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-category-p {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--primary-orange);
        margin-bottom: 8px;
    }

    .card-title-p {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--dark-bg);
        line-height: 1.3;
        transition: color 0.3s;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-card-new:hover .card-title-p {
        color: var(--primary-orange);
    }

    .view-btn-p {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-orange);
        font-weight: 700;
        font-size: 0.85rem;
        transition: gap 0.3s;
    }

    .view-btn-p:hover {
        gap: 12px;
    }

    /* Testimonials Slider - High Fidelity Refinement */
    .testimonial-slide-new {
        background: #fff;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        margin: 10px;
        border: 1px solid #f2f2f2;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .testimonial-slide-new:hover {
        border-color: rgba(244, 130, 33, 0.3);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        transform: translateY(-5px);
    }

    .quote-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        color: rgba(244, 130, 33, 0.1);
    }

    .testimonial-text {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 2rem;
        font-style: italic;
        position: relative;
        z-index: 1;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .client-info-v2 {
        display: flex;
        align-items: center;
        gap: 12px;
        border-top: 1px solid #f8f8f8;
        padding-top: 15px;
        margin-top: auto;
    }

    .client-avatar-v2 {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .client-avatar-v2 .material-symbols-outlined {
        font-size: 1.5rem;
    }

    .client-name-v2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--dark-bg);
        margin: 0;
        line-height: 1.2;
    }

    .client-job-v2 {
        font-size: 0.75rem;
        color: var(--primary-orange);
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }



    @media (max-width: 991px) {
        .hero-stats {
            gap: 2.5rem;
        }

        .hero-title {
            font-size: 3.2rem;
        }

        .event-img-h {
            height: 250px;
            min-height: auto;
        }

        .newsletter-section {
            padding: 60px 30px;
        }

        .hero-btns {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .hero-stats {
            display: none;
        }

        .hero-btns .btn-pill {
            width: 100%;
        }

        .hero-content {
            text-align: center;
        }

        .hero-eyebrow {
            justify-content: center;
        }

        .hero-eyebrow::after {
            display: none;
        }

        .hero-desc {
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>

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
                <span class="event-tag">
                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">auto_stories</span>
                    Our Story
                </span>
                <h2 class="section-title">Driving <span>Innovation</span> with Purpose</h2>
                <div class="section-subtitle text-left mb-4" style="margin: 0;">
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
                                    <img src="<?= BASE_URL . '/' . ltrim($event['event_img'], './'); ?>" class="event-img-h w-100" alt="Event Image">
                                </div>
                                <div class="col-md-7">
                                    <div class="event-content-h">
                                        <span class="event-tag">Upcoming Event</span>
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
                            <img src="<?= BASE_URL . '/' . ltrim($project['project_pic'], './'); ?>" alt="<?= stripslashes($project['project_name']); ?>">
                        </div>
                        <div class="card-content-p">
                            <span class="card-category-p"><?= $project['service_name']; ?></span>
                            <h4 class="card-title-p"><?= stripslashes($project['project_name']); ?></h4>
                            <div class="view-btn-p">
                                View Project Details
                                <span class="material-symbols-outlined" style="font-size: 1.1rem;">arrow_forward</span>
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