<style>
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-body: #374151;
        --text-muted: #888888;
    }

    /* Reading Progress Bar */
    .reading-progress {
        height: 4px;
        background: var(--primary-orange);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        width: 0%;
        transition: width 0.1s ease-out;
    }

    /* Professional Page Header High-Fidelity */
    .page-header {
        background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.05);
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
        font-size: clamp(2.5rem, 5vw, 3.5rem);
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
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255,255,255,0.5);
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
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
    }

    /* Detail Page Layout */
    .event-detail-main {
        padding: 80px 0 100px;
        background-color: #fcfcfc;
    }

    .reading-container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* Event Featured Image */
    .event-featured-image {
        position: relative;
        aspect-ratio: 16/9;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .event-featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-status-pill {
        position: absolute;
        top: 30px;
        left: 30px;
        z-index: 10;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 8px 18px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .status-upcoming { color: #28a745; }
    .status-past { color: #6c757d; }

    /* Event info High-Fidelity Grid */
    .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 60px;
        background: #fff;
        padding: 35px;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    .meta-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .meta-icon-wrap {
        width: 48px;
        height: 48px;
        background: rgba(244, 130, 33, 0.08);
        color: var(--primary-orange);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .meta-content .label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .meta-content .value {
        display: block;
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-bg);
    }

    /* Event Content Modernization */
    .event-article-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #4b5563;
        margin-bottom: 60px;
    }

    .event-article-body p { margin-bottom: 30px; }
    .event-article-body h2 { 
        font-size: 2rem; 
        font-weight: 800; 
        color: var(--dark-bg); 
        margin-top: 50px; 
        margin-bottom: 25px; 
        letter-spacing: -1px;
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

    /* Media Gallery Industrial Grid */
    .media-gallery-section {
        margin-top: 80px;
        padding-top: 60px;
        border-top: 1px solid rgba(0,0,0,0.06);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .gallery-item {
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .gallery-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.2);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .gallery-item:hover .gallery-overlay { opacity: 1; }

    /* Action Buttons */
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
        background: #e6751c;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.4);
        color: #fff;
    }

    .cta-button-secondary {
        background: #fff;
        color: var(--dark-bg);
        border: 1px solid rgba(0,0,0,0.1);
        padding: 14px 35px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.4s;
        text-decoration: none !important;
        font-size: 0.9rem;
    }

    .cta-button-secondary:hover {
        background: #f9fafb;
        transform: translateX(-5px);
    }
</style>

<!-- Reading Progress Bar -->
<div id="progress-bar" class="reading-progress"></div>

<?php if($event): ?>
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= htmlspecialchars(stripslashes($event['event_title'] ?? 'Event Detail')) ?></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/events">Events</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        <?= htmlspecialchars(mb_strimwidth(stripslashes($event['event_title'] ?? 'Detail'), 0, 40, '…')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="event-detail-main">
    <div class="container">
        <div class="reading-container">

            <div class="mb-5">
                <a href="<?= BASE_URL ?>/events" class="cta-button-secondary">
                    <span class="material-symbols-outlined" style="font-size: 20px;">keyboard_backspace</span>
                    Back to Archives
                </a>
            </div>

            <div class="event-featured-image">
                <span class="card-status-pill status-<?= strtolower(stripslashes($event['event_status'])) ?>">
                    <span class="material-symbols-outlined" style="font-size: 18px;">
                        <?= strtolower($event['event_status']) === 'upcoming' ? 'bolt' : 'history' ?>
                    </span>
                    <?= ucfirst(stripslashes($event['event_status'])) ?> Event
                </span>
                <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']) ?>" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'; this.onerror=null;">
            </div>

            <div class="mb-4">
                <div class="event-meta-grid">
                    <div class="meta-item">
                        <div class="meta-icon-wrap">
                            <span class="material-symbols-outlined">calendar_today</span>
                        </div>
                        <div class="meta-content">
                            <span class="label">Event Date</span>
                            <span class="value"><?= date('l, d F Y', strtotime($event['event_date'])) ?></span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-icon-wrap">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="meta-content">
                            <span class="label">Timeframe</span>
                            <span class="value"><?= stripslashes($event['event_time']) ?></span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-icon-wrap">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div class="meta-content">
                            <span class="label">Venue Details</span>
                            <span class="value"><?= stripslashes($event['event_address']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <article class="event-article-body">
                <?= stripslashes($event['event_detail']) ?>
            </article>

            <?php if ($event['registration_available']): ?>
            <div class="mt-5 p-5 bg-white border rounded-4 text-center">
                <h3 class="mb-4" style="font-weight: 800; letter-spacing: -1px;">Join us at this session!</h3>
                <a href="<?= BASE_URL ?>/trainings/register?id=<?= $event['event_id']; ?>&type=event" class="cta-button">
                    Enroll Now
                    <span class="material-symbols-outlined">how_to_reg</span>
                </a>
                <p class="text-muted mt-4 small">
                    <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 16px;">info</span>
                    #SpiderTechEmpowers - Limited slots available for this interactive event.
                </p>
            </div>
            <?php elseif (strtolower(trim(stripslashes($event['event_status']))) === "upcoming"): ?>
            <div class="mt-5 p-5 bg-white border rounded-4 text-center">
                <h3 class="mb-4" style="font-weight: 800; letter-spacing: -1px;">Coming Soon!</h3>
                <a href="<?= BASE_URL ?>/contact" class="cta-button cta-button-secondary">
                    Inquire for Details
                    <span class="material-symbols-outlined">mail</span>
                </a>
            </div>
            <?php endif; ?>

            <?php if (!empty($event_media)): ?>
            <div class="media-gallery-section">
                <div class="mb-5">
                    <span class="tag-eyebrow">Visual Highlights</span>
                    <h3 class="section-title">Event <span>Gallery</span></h3>
                </div>
                <div class="gallery-grid">
                    <?php foreach ($event_media as $media): ?>
                    <?php $mediaImg = resolvePath($media['event_pics_name']); ?>
                    <a href="<?= $mediaImg; ?>" class="gallery-item popup-box" data-lightbox="event-gallery" rel="lightbox[event-gallery]" title="<?= htmlspecialchars($event['event_title']) ?>">
                        <img src="<?= $mediaImg; ?>" alt="Event gallery photo" loading="lazy" onerror="this.closest('a').style.display='none';">
                        <div class="gallery-overlay">
                            <span class="material-symbols-outlined" style="font-size: 32px;">zoom_in</span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php else: ?>
<div class="container py-5 text-center">
    <div class="py-5">
        <span class="material-symbols-outlined" style="font-size: 5rem; color: #ddd; margin-bottom: 2rem;">release_alert</span>
        <h3 class="section-title">Event Not Found</h3>
        <p class="section-subtitle mx-auto">The event you are searching for might have been archived or removed from our records.</p>
        <a href="<?= BASE_URL ?>/events" class="cta-button mt-4">
            Browse All Events
            <span class="material-symbols-outlined">grid_view</span>
        </a>
    </div>
</div>
<?php endif; ?>

<script>
    // Reading Progress Tracking
    (function() {
        const progressBar = document.getElementById('progress-bar');
        if (!progressBar) return;

        const updateProgress = () => {
            const h = document.documentElement,
                  b = document.body,
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            const percent = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
            progressBar.style.width = percent + '%';
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    })();
</script>
