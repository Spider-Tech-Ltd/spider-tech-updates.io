<link rel="stylesheet" href="<?= BASE_URL ?>/css/event-detail.css?v=<?= filemtime(ROOT_PATH . '/css/event-detail.css') ?>" />

<!-- Reading Progress Bar -->
<div id="progress-bar" class="reading-progress"></div>

<?php if ($event):
    $eTitle = trim(stripslashes($event['event_title'] ?? 'Event Detail'));
    $words = explode(' ', $eTitle);
    if (count($words) > 1) {
        $lastWord = array_pop($words);
        $displayTitle = htmlspecialchars(implode(' ', $words)) . ' <span>' . htmlspecialchars($lastWord) . '</span>';
    } else {
        $displayTitle = '<span>' . htmlspecialchars($eTitle) . '</span>';
    }

    $rawImg = trim($event['event_img'] ?? '');
    $hasImg = ($rawImg !== '');
    $finalImg = $hasImg ? resolvePath($rawImg) : '';

    $st = strtolower(trim($event['event_status'] ?? ''));
    $stIcon = ($st === 'upcoming') ? 'bolt' : (($st === 'ongoing') ? 'sensors' : 'history');
?>
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title"><?= $displayTitle ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/events">Events</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            <?= htmlspecialchars(mb_strimwidth($eTitle, 0, 32, '…')) ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<main class="event-detail-main">
    <div class="container">
        <div class="reading-container">

            <div class="mb-4">
                <a href="<?= BASE_URL ?>/events" class="back-nav-link">
                    <span class="material-symbols-outlined">keyboard_backspace</span>
                    <span>Back to All Events</span>
                </a>
            </div>

            <div class="event-featured-image">
                <span class="card-status-pill status-<?= htmlspecialchars($st) ?>">
                    <?php if ($st === 'ongoing'): ?>
                        <span class="live-indicator-dot"></span>
                    <?php else: ?>
                        <span class="material-symbols-outlined status-icon"><?= $stIcon ?></span>
                    <?php endif; ?>
                    <span><?= ucfirst(htmlspecialchars($st)) ?> Event</span>
                </span>
                <?php if ($hasImg): ?>
                    <img src="<?= htmlspecialchars($finalImg); ?>"
                         alt="<?= htmlspecialchars($eTitle); ?>"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <?php endif; ?>
                <div class="event-detail-img-fallback" style="display: <?= $hasImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                    <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                        <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                    <span class="fallback-label">Spider Tech Event Showcase</span>
                </div>
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
                    <?php if (!empty($event['event_time'])): ?>
                    <div class="meta-item">
                        <div class="meta-icon-wrap">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="meta-content">
                            <span class="label">Timeframe</span>
                            <span class="value"><?= htmlspecialchars(stripslashes($event['event_time'])) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($event['event_address'])): ?>
                    <div class="meta-item">
                        <div class="meta-icon-wrap">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div class="meta-content">
                            <span class="label">Venue Location</span>
                            <span class="value"><?= htmlspecialchars(stripslashes($event['event_address'])) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <article class="event-article-body">
                <div class="article-lead-wrapper">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        </svg>
                        <span class="eyebrow-label-text">Event Overview</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <h2 class="article-heading">About this <span>Gathering</span></h2>
                </div>
                <div class="article-content rich-text-content">
                    <?= stripslashes($event['event_detail'] ?? '') ?>
                </div>
            </article>

            <?php if ($st === "upcoming"): ?>
            <div class="event-status-inquiry-box">
                <div class="inquiry-icon-wrap">
                    <span class="material-symbols-outlined">bolt</span>
                </div>
                <h3 class="inquiry-title">Ready to Join Us?</h3>
                <p class="inquiry-desc">Reserve your seat early or inquire about sponsorship, speaking opportunities, and community access.</p>
                <a href="<?= BASE_URL ?>/contact" class="cta-button">
                    <span>Inquire for Access</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
            <?php elseif ($st === "ongoing"): ?>
            <div class="event-status-inquiry-box ongoing-inquiry">
                <div class="inquiry-icon-wrap">
                    <span class="material-symbols-outlined">sensors</span>
                </div>
                <h3 class="inquiry-title">This Event is Live Right Now!</h3>
                <p class="inquiry-desc">Join the session in progress or connect directly with our coordination desk for real-time access.</p>
                <a href="<?= BASE_URL ?>/contact" class="cta-button">
                    <span>Contact Desk Now</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
            <?php endif; ?>

            <?php if (!empty($event_media)): ?>
            <div class="media-gallery-section">
                <div class="text-center mb-4">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        </svg>
                        <span class="eyebrow-label-text">Visual Highlights</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <br>
                    <h3 class="section-title">Event <span>Gallery</span></h3>
                </div>
                <div class="gallery-grid">
                    <?php foreach ($event_media as $media):
                        $mediaImg = resolvePath($media['event_pics_name'] ?? '');
                    ?>
                    <a href="<?= $mediaImg; ?>" class="gallery-item popup-box" data-lightbox="event-gallery" rel="lightbox[event-gallery]" title="<?= htmlspecialchars($eTitle) ?>">
                        <img src="<?= $mediaImg; ?>" alt="Event photo" loading="lazy" onerror="this.closest('a').style.display='none';">
                        <div class="gallery-overlay">
                            <span class="material-symbols-outlined">zoom_in</span>
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
    <div class="py-5 empty-event-box">
        <span class="material-symbols-outlined" style="font-size: 4rem; color: var(--primary-orange); margin-bottom: 1rem;">release_alert</span>
        <h3 class="section-title">Event Not Found</h3>
        <p class="section-subtitle mx-auto">The event you are searching for might have been archived or removed from our schedule.</p>
        <a href="<?= BASE_URL ?>/events" class="cta-button mt-4">
            <span>Browse All Events</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>

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
            progressBar.style.width = Math.min(100, Math.max(0, percent)) + '%';
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    })();
</script>
