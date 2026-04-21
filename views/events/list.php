
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Experience <span>the Hub</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Events
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<!-- ====== Upcoming Events Section Start ====== -->
<section id="upcoming-events" class="section-padding pb-0 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Connect & Learn</span>
                <h2 class="section-title">Upcoming <span>Events</span></h2>
                <p class="section-subtitle">Join our vibrant community of tech enthusiasts, developers, and innovators. Stay ahead with our curated workshops and meetups.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($upcoming_events)): ?>
                <?php foreach ($upcoming_events as $event):
                    $date = strtotime($event['event_date']);
                    $day = date('d', $date);
                    $month = date('M', $date);
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="event-card">
                            <div class="card-img-wrap">
                                <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>">
                                <div class="card-date-badge">
                                    <span class="day"><?= $day ?></span>
                                    <span class="month"><?= $month ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <span class="card-status-pill status-upcoming">
                                    <span class="material-symbols-outlined fs-14">bolt</span>
                                    Upcoming
                                </span>
                                <h3 class="card-title"><?= stripslashes($event['event_title']); ?></h3>
                                <div class="card-desc"><?= strip_tags(stripslashes($event['event_content'])); ?></div>
                                <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                    View Event Details
                                    <span class="material-symbols-outlined">trending_flat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <h4>No upcoming events right now</h4>
                        <p class="text-muted">Stay tuned! We are planning something amazing for you.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- ====== Upcoming Events Section End ====== -->

<!-- ====== Past Events Section Start ====== -->
<section id="past-events" class="section-padding">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Event Archives</span>
                <h2 class="section-title">Past <span>Events</span></h2>
                <p class="section-subtitle">Relive the moments. Explore the insights, galleries, and recaps from our previous successful tech gatherings.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($past_events)): ?>
                <?php foreach ($past_events as $event):
                    $date = strtotime($event['event_date']);
                    $day = date('d', $date);
                    $month = date('M', $date);
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="event-card">
                            <div class="card-img-wrap">
                                <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>">
                                <div class="card-date-badge">
                                    <span class="day"><?= $day ?></span>
                                    <span class="month"><?= $month ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <span class="card-status-pill status-past">
                                    <span class="material-symbols-outlined fs-14">history</span>
                                    Completed
                                </span>
                                <h3 class="card-title"><?= stripslashes($event['event_title']); ?></h3>
                                <div class="card-desc"><?= strip_tags(stripslashes($event['event_content'])); ?></div>
                                <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                    View Recap
                                    <span class="material-symbols-outlined">trending_flat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <span class="material-symbols-outlined">history</span>
                        <h4>No past events found</h4>
                        <p class="text-muted">Check back later for event archives.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ====== Premium CTA Block (within Past Events section) ====== -->
    <div class="container mt-5">
        <div class="premium-cta">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="tag-eyebrow tag-eyebrow-light">Ready to Accelerate?</span>
                    <h2 class="section-title">Unlock Your <span>Tech Potential</span></h2>
                    <p class="section-subtitle mx-auto text-white opacity-75 mb-5 fs-18">
                        Beyond our community events, we offer specialized, high-impact training programs designed to fast-track your professional growth in the digital landscape.
                    </p>
                    <div class="d-flex-center flex-wrap gap-4">
                        <a href="<?= BASE_URL ?>/trainings" class="cta-button">
                            Explore Certifications
                            <span class="material-symbols-outlined">school</span>
                        </a>
                        <a href="<?= BASE_URL ?>/contact" class="cta-button cta-button-outline">
                            Get in Touch
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </a>
                    </div>
                    <div class="mt-5">
                        <span class="text-orange fs-14 fw-bold text-uppercase" class="ls-15">
                            <span class="material-symbols-outlined fs-18" class="v-align-middle mr-4">verified</span> Industry Recognized Professional Standards
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== Past Events Section End ====== -->

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>