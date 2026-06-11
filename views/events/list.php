<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-body: #374151;
        --text-muted: #888888;
        --card-bg: #ffffff;
    }

    /* Global Overrides for modern feel - Matching Trainings Page */
    .text-orange {
        color: var(--primary-orange) !important;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .gap-3 {
        gap: 1rem;
    }

    /* Page Header High-Fidelity */
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
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255, 255, 255, 0.5);
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
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }

    @media (max-width: 991px) {
        .page-header {
            padding: 120px 0 60px;
        }

        .section-padding {
            padding: 80px 0;
        }
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

    .section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--dark-bg);
        margin-bottom: 25px;
        letter-spacing: -1.5px;
        line-height: 1.2;
    }

    .section-title span {
        color: var(--primary-orange);
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 700px;
        line-height: 1.7;
    }

    /* Industrial Event Card - Synchronized with Projects */
    .event-card {
        background-color: var(--card-bg);
        border-radius: 30px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
    }

    .event-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .card-img-wrap {
        margin: 10px;
        aspect-ratio: 16/10;
        border-radius: 24px;
        overflow: hidden;
        position: relative;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .event-card:hover .card-img-wrap img {
        transform: scale(1.1);
    }

    .card-date-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 12px 16px;
        border-radius: 16px;
        text-align: center;
        min-width: 65px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .card-date-badge .day {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-bg);
        line-height: 1;
    }

    .card-date-badge .month {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--primary-orange);
        letter-spacing: 1px;
    }

    .card-content {
        padding: 30px 35px 35px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 18px;
        padding: 6px 14px;
        border-radius: 50px;
        width: fit-content;
    }

    .status-upcoming {
        background: rgba(40, 167, 69, 0.08);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.1);
    }

    .status-past {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.1);
    }

    .card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--dark-bg);
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s;
    }

    .event-card:hover .card-title {
        color: var(--primary-orange);
    }

    .card-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 2.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .view-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--dark-bg);
        font-weight: 700;
        text-decoration: none !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .view-btn .material-symbols-outlined {
        font-size: 20px;
        transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .event-card:hover .view-btn {
        color: var(--primary-orange);
    }

    .event-card:hover .view-btn .material-symbols-outlined {
        transform: translateX(6px);
    }

    /* Premium CTA Bridge */
    .premium-cta {
        background: var(--dark-bg);
        border-radius: 40px;
        padding: 60px 40px;
        position: relative;
        overflow: hidden;
        text-align: center;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1);
    }

    .premium-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 10% 20%, rgba(244, 130, 33, 0.1) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(244, 130, 33, 0.1) 0%, transparent 40%);
        pointer-events: none;
    }

    .premium-cta h2 {
        color: #fff;
    }

    .cta-button {
        background: var(--primary-orange);
        color: #fff;
        padding: 16px 40px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s;
        text-decoration: none !important;
        font-size: 1rem;
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.3);
    }

    .cta-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.4);
        background: #e6751c;
        color: #fff;
    }

    .cta-button-outline {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .cta-button-outline:hover {
        background: rgba(255, 255, 255, 0.08);
        box-shadow: none;
        transform: translateY(-5px);
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 100px 40px;
        background: #ffffff;
        border: 2px dashed rgba(0, 0, 0, 0.06);
        border-radius: 30px;
        margin: 20px 0;
    }

    .empty-state .material-symbols-outlined {
        font-size: 4.5rem;
        color: #e0e0e0;
        margin-bottom: 25px;
        display: block;
    }

    /* CTA eyebrow variant for dark backgrounds */
    .tag-eyebrow-light {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.85);
    }
</style>

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
                                <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>">
                                <div class="card-date-badge">
                                    <span class="day"><?= $day ?></span>
                                    <span class="month"><?= $month ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <span class="card-status-pill status-upcoming">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">bolt</span>
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
                                <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>">
                                <div class="card-date-badge">
                                    <span class="day"><?= $day ?></span>
                                    <span class="month"><?= $month ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <span class="card-status-pill status-past">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">history</span>
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
                    <p class="section-subtitle mx-auto text-white opacity-75 mb-5">
                        Beyond our community events, we offer specialized, high-impact training programs designed to fast-track your professional growth in the digital landscape.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-4">
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
                        <span style="color: var(--primary-orange); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px;">
                            <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px; margin-right: 4px;">verified</span> Industry Recognized Professional Standards
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