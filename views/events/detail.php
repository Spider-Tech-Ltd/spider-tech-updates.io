
<!-- Reading Progress Bar -->
<div id="progress-bar" class="reading-progress"></div>

<?php if($event): ?>
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Event <span>Insights</span></h1>
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
                        Detail
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
                    <span class="material-symbols-outlined fs-20">keyboard_backspace</span>
                    Back to Archives
                </a>
            </div>

            <div class="event-featured-image">
                <span class="card-status-pill status-<?= strtolower(stripslashes($event['event_status'])) ?>">
                    <span class="material-symbols-outlined fs-18">
                        <?= strtolower($event['event_status']) === 'upcoming' ? 'bolt' : 'history' ?>
                    </span>
                    <?= ucfirst(stripslashes($event['event_status'])) ?> Event
                </span>
                <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="<?= htmlspecialchars($event['event_title']) ?>">
            </div>

            <div class="mb-5">
                <h2 class="section-title mb-5" class="fs-3rem"><?= stripslashes($event['event_title']) ?></h2>
                
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

            <?php if (strtolower(trim(stripslashes($event['event_status']))) === "upcoming"): ?>
            <div class="mt-5 p-5 bg-white border rounded-4 text-center">
                <h3 class="mb-4" class="fw-extrabold ls-neg-1">Join us at this session!</h3>
                <a href="<?= BASE_URL ?>/trainings" class="cta-button">
                    Secure Your Spot
                    <span class="material-symbols-outlined">how_to_reg</span>
                </a>
                <p class="text-muted mt-4 small">
                    <span class="material-symbols-outlined fs-16" class="v-align-middle">info</span>
                    #SpiderTechEmpowers - Limited slots available for this interactive event.
                </p>
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
                    <a href="<?= BASE_URL . '/' . ltrim(substr($media['event_pics_name'], 3), '/'); ?>" class="gallery-item popup-box" data-lightbox="event-gallery">
                        <img src="<?= BASE_URL . '/' . ltrim(substr($media['event_pics_name'], 3), '/'); ?>" alt="Gallery Image">
                        <div class="gallery-overlay">
                            <span class="material-symbols-outlined fs-32">zoom_in</span>
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
        <span class="material-symbols-outlined" class="fs-5rem color-ddd mb-4">release_alert</span>
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
