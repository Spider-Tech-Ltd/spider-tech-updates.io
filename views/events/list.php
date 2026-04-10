<style>
    /* Global Overrides for modern feel - Matching Trainings Page */
    .text-orange { color: #f48221 !important; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }

    .events-hero {
        position: relative;
        background-color: #f4f4f4;
        padding: 140px 16px 80px;
        overflow: hidden;
        text-align: center;
    }

    .events-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(244, 130, 33, 0.08) 0%, transparent 68%);
        pointer-events: none;
        z-index: 0;
    }

    .hero-blob {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(244, 130, 33, 0.06);
        filter: blur(60px);
        pointer-events: none;
    }

    .hero-blob-left { width: 280px; height: 280px; top: 20%; left: -80px; }
    .hero-blob-right { width: 320px; height: 320px; bottom: 15%; right: -80px; }

    .hero-inner { position: relative; z-index: 1; }

    .hero-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 18px;
        border-radius: 50px;
        background-color: rgba(244, 130, 33, 0.12);
        border: 1px solid rgba(244, 130, 33, 0.25);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #f48221;
        margin-bottom: 28px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin: 0 auto 1.5rem;
        color: #111111;
        max-width: 800px;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #555555;
        max-width: 600px;
        margin: 0 auto 24px;
        line-height: 1.7;
    }

    .hero-btn-primary {
        height: 52px;
        padding: 0 32px;
        background-color: #f48221;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        border-radius: 50px;
        white-space: nowrap;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(244, 130, 33, 0.28);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .hero-btn-primary:hover {
        background-color: #e6751c;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(244, 130, 33, 0.35);
    }

    /* Section Headers */
    .event-section-header {
        margin-bottom: 40px;
        position: relative;
    }

    .event-section-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 10px;
    }

    .event-section-header .line {
        width: 60px;
        height: 4px;
        background: #f48221;
        border-radius: 2px;
    }

    /* Event Card Styles */
    .event-card {
        background-color: #ffffff;
        border-radius: 1.5rem;
        padding: 0.25rem;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
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
        transition: transform 0.5s ease;
    }

    .event-card:hover .card-img-wrap img {
        transform: scale(1.05);
    }

    .card-date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        padding: 8px 15px;
        border-radius: 12px;
        text-align: center;
        min-width: 60px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .card-date-badge .day {
        display: block;
        font-size: 1.2rem;
        font-weight: 800;
        color: #111;
        line-height: 1;
    }

    .card-date-badge .month {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #f48221;
    }

    .card-content {
        padding: 0 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 12px;
        padding: 4px 10px;
        border-radius: 50px;
    }

    .status-upcoming { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .status-past { background: rgba(108, 117, 125, 0.1); color: #6c757d; }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #111111;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-desc {
        font-size: 0.9rem;
        color: #555555;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .view-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #f48221;
        font-weight: 700;
        text-decoration: none !important;
        font-size: 0.9rem;
        transition: gap 0.3s;
    }

    .view-btn:hover { gap: 12px; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fdfdfd;
        border: 2px dashed #eee;
        border-radius: 20px;
        margin: 20px 0;
    }

    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 20px;
        display: block;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .events-hero { padding: 100px 16px 60px; }
    }
</style>

<!-- ====== Hero Section Start ====== -->
<section class="events-hero">
    <div class="hero-blob hero-blob-left"></div>
    <div class="hero-blob hero-blob-right"></div>
    <div class="container hero-inner">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <span class="hero-eyebrow-pill">
                    <i class="fas fa-calendar-alt"></i>
                    Events & Gatherings
                </span>
                <h1 class="hero-title">Experience the Hub</h1>
                <p class="hero-subtitle">Join our workshops, seminars, and networking sessions designed to empower the next generation of tech leaders.</p>

                <div class="row justify-content-center mt-4 mb-5">
                    <div class="col-md-8 col-lg-4 text-center">
                        <a href="#upcoming-events" class="hero-btn-primary w-100" style="text-decoration: none;">Explore Events</a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-5 d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-orange" aria-current="page">Events</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ====== Hero Section End ====== -->

<!-- ====== Upcoming Events Section Start ====== -->
<section id="upcoming-events" class="padding pb-0">
    <div class="container">
        <div class="event-section-header">
            <h2>Upcoming Events</h2>
            <div class="line"></div>
        </div>

        <div class="row">
            <?php if(!empty($upcoming_events)): ?>
                <?php foreach($upcoming_events as $event):
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
                                <i class="fas fa-bolt"></i>
                                Upcoming
                            </span>
                            <h3 class="card-title"><?= stripslashes($event['event_title']); ?></h3>
                            <p class="card-desc"><?= stripslashes($event['event_content']); ?></p>
                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                View Event Details
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="far fa-calendar-times"></i>
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
<section id="past-events" class="padding">
    <div class="container">
        <div class="event-section-header">
            <h2>Past Events</h2>
            <div class="line"></div>
        </div>

        <div class="row">
            <?php if(!empty($past_events)): ?>
                <?php foreach($past_events as $event):
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
                                <i class="fas fa-history"></i>
                                Completed
                            </span>
                            <h3 class="card-title"><?= stripslashes($event['event_title']); ?></h3>
                            <p class="card-desc"><?= stripslashes($event['event_content']); ?></p>
                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                View Recap
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <h4>No past events found</h4>
                        <p class="text-muted">Check back later for event archives.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- ====== Past Events Section End ====== -->
