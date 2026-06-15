<?php
/**
 * Enhanced Events Page
 * Layout: Global Highlight (YouTube), Featured Gallery, Upcoming/Past Events
 */
?>

<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #031427;
        --panel-bg: #102034;
        --border-color: #26364a;
    }

    .events-page-wrapper {
        background-color: var(--dark-bg);
        color: #d3e4fe;
        font-family: 'Inter', sans-serif;
    }

    .section-title-industrial {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: #fff;
    }

    .tag-mono {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary-orange);
    }

    /* Hero Section */
    .hero-highlight {
        padding: 100px 0;
        border-bottom: 1px solid var(--border-color);
        background: radial-gradient(circle at top right, rgba(244, 130, 33, 0.05), transparent);
    }

    .video-container {
        position: relative;
        aspect-ratio: 16/9;
        background: #000;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .video-container iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary-orange);
        color: #000;
        padding: 4px 12px;
        font-weight: 800;
        font-size: 0.75rem;
        border-radius: 2px;
        margin-bottom: 1rem;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background: #000;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }

    /* Featured Gallery */
    .featured-gallery {
        padding: 80px 0;
        background: var(--panel-bg);
    }

    .featured-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }

    .featured-item {
        position: relative;
        aspect-ratio: 4/5;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: all 0.4s;
    }

    .featured-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .featured-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(3, 20, 39, 0.9), transparent);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
        opacity: 0.9;
    }

    .featured-item:hover img {
        transform: scale(1.05);
    }

    .featured-item:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 0 20px rgba(244, 130, 33, 0.1);
    }

    /* Event Cards */
    .event-card-industrial {
        background: var(--panel-bg);
        border: 1px solid var(--border-color);
        padding: 24px;
        height: 100%;
        transition: all 0.3s;
    }

    .event-card-industrial:hover {
        border-color: var(--primary-orange);
        transform: translateY(-5px);
    }

    .event-card-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
    }

    .btn-industrial {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary-orange);
        color: #000 !important;
        padding: 10px 24px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-industrial:hover {
        background: #fff;
    }

    .btn-outline-industrial {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--primary-orange);
        color: var(--primary-orange) !important;
        padding: 10px 24px;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-outline-industrial:hover {
        background: rgba(244, 130, 33, 0.1);
    }
</style>

<div class="events-page-wrapper">
    <!-- ====== Hero Section (Global Highlights) ====== -->
    <section class="hero-highlight">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="video-container">
                        <?php
                        // Find the first featured event with a video URL or use a default
                        $hero_video = 'https://www.youtube.com/embed/LXb3EKWsInQ'; // Default placeholder
                        foreach($featured_events as $fe) {
                            if(!empty($fe['video_url'])) {
                                $hero_video = str_replace('watch?v=', 'embed/', $fe['video_url']);
                                break;
                            }
                        }
                        ?>
                        <iframe src="<?= $hero_video ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="live-badge">
                        <div class="live-dot"></div>
                        HIGHLIGHTS
                    </div>
                    <span class="tag-mono">Global Tech Summits</span>
                    <h1 class="section-title-industrial mt-3" style="font-size: 3.5rem;">The Future <br><span>Is Now</span></h1>
                    <p class="lead opacity-75 mt-4">Join Spider Tech Hub as we explore the cutting edge of industrial automation, robotics, and digital infrastructure. Experience our global highlights and upcoming keynotes.</p>
                    <div class="mt-5 d-flex gap-3">
                        <a href="#featured" class="btn-industrial">Explore Highlights</a>
                        <a href="#upcoming" class="btn-outline-industrial">Upcoming Schedule</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== Featured Events Gallery ====== -->
    <?php if(!empty($featured_events)): ?>
    <section id="featured" class="featured-gallery">
        <div class="container">
            <div class="mb-5">
                <span class="tag-mono">// Premier Selection</span>
                <h2 class="section-title-industrial">Featured <span>Events</span></h2>
            </div>
            <div class="featured-grid">
                <?php foreach($featured_events as $event): ?>
                <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="featured-item">
                    <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>">
                    <div class="featured-overlay">
                        <span class="tag-mono text-white mb-2" style="font-size: 0.6rem;"><?= date('M Y', strtotime($event['event_date'])) ?></span>
                        <h4 class="section-title-industrial" style="font-size: 1.25rem;"><?= stripslashes($event['event_title']); ?></h4>
                        <div class="mt-2" style="color: var(--primary-orange); font-weight: 700; font-size: 0.8rem;">VIEW DETAILS →</div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ====== Upcoming Events ====== -->
    <section id="upcoming" class="section-padding" style="border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="row justify-content-between align-items-end mb-5">
                <div class="col-lg-6">
                    <span class="tag-mono">// Get Involved</span>
                    <h2 class="section-title-industrial">Upcoming <span>Schedule</span></h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <p class="small opacity-50">Stay ahead with our curated workshops and meetups.</p>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($upcoming_events)): ?>
                    <?php foreach ($upcoming_events as $event): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="event-card-industrial">
                                <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" class="event-card-img" alt="">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="tag-mono" style="font-size: 0.7rem;"><?= date('l, d M', strtotime($event['event_date'])) ?></span>
                                    <span class="badge" style="background: rgba(244, 130, 33, 0.1); color: var(--primary-orange); border-radius: 0; font-family: 'Space Grotesk';">UPCOMING</span>
                                </div>
                                <h3 class="section-title-industrial" style="font-size: 1.5rem;"><?= stripslashes($event['event_title']); ?></h3>
                                <p class="opacity-75 mt-3 mb-4" style="font-size: 0.9rem;"><?= mb_strimwidth(strip_tags(stripslashes($event['event_content'])), 0, 100, "..."); ?></p>
                                <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="btn-outline-industrial w-100 justify-content-center">Secure Your Spot</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="opacity-50">No upcoming events scheduled at this moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ====== Past Events ====== -->
    <section id="past" class="section-padding bg-light text-dark">
        <div class="container">
            <div class="mb-5 text-center">
                <span class="tag-mono" style="color: #666;">// Archives</span>
                <h2 class="section-title-industrial" style="color: #111;">Past <span>Events</span></h2>
            </div>

            <div class="row g-4">
                <?php if (!empty($past_events)): ?>
                    <?php foreach ($past_events as $event): ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 rounded-0 shadow-sm">
                                <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" class="card-img-top rounded-0" style="aspect-ratio: 1; object-fit: cover;" alt="">
                                <div class="card-body p-4">
                                    <span class="text-muted small fw-bold"><?= date('d M Y', strtotime($event['event_date'])) ?></span>
                                    <h5 class="fw-bold mt-2 mb-3"><?= stripslashes($event['event_title']); ?></h5>
                                    <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="text-decoration-none fw-bold" style="color: var(--primary-orange); font-size: 0.8rem;">VIEW RECAP →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center opacity-50">No archived events found.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
