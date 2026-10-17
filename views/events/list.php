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
            padding: 60px 0;
        }
    }

    @media (max-width: 768px) {
        .section-padding {
            padding: 40px 0;
        }
    }

    .section-padding {
        padding: 80px 0;
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
        margin-bottom: 16px;
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
        padding: 22px 28px 28px;
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

    .status-ongoing {
        background: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }

    .live-indicator-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #0d6efd;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
        animation: ongoingPulse 1.8s infinite;
        flex-shrink: 0;
    }

    @keyframes ongoingPulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 5px rgba(13, 110, 253, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
        }
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
        margin-bottom: 1rem;
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
        padding: 60px 40px;
        background: #ffffff;
        border: 2px dashed rgba(0, 0, 0, 0.06);
        border-radius: 24px;
        margin: 0;
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

    /* Highlights Section */
    .highlights-section {
        background: #ffffff;
        padding: 72px 0;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
    }

    /* Recap Carousel Controls */
    .recap-carousel-wrap {
        position: relative;
    }

    .recap-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.25s;
        color: var(--dark-bg);
    }

    .recap-nav-btn:hover {
        background: var(--primary-orange);
        color: #fff;
        box-shadow: 0 6px 20px rgba(244,130,33,0.3);
    }

    .recap-nav-prev { left: -22px; }
    .recap-nav-next { right: -22px; }

    .recap-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 20px;
    }

    .recap-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ddd;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }

    .recap-dot.active {
        background: var(--primary-orange);
        width: 24px;
        border-radius: 4px;
    }

    /* Highlight content truncation */
    .highlight-content p.recap-desc {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Section Jump Navigation */
    .events-tab-nav {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        position: sticky;
        top: 70px;
        z-index: 100;
        padding: 0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .events-tab-nav-inner {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 12px 16px;
        max-width: 1140px;
        margin: 0 auto;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .events-tab-nav-inner::-webkit-scrollbar { display: none; }

    .events-tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none !important;
        color: var(--text-muted);
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.25s;
        white-space: nowrap;
    }

    .events-tab-pill:hover,
    .events-tab-pill.active {
        background: rgba(244, 130, 33, 0.08);
        color: var(--primary-orange);
        border-color: rgba(244, 130, 33, 0.2);
    }

    /* Card meta row (time + location) */
    .card-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 1rem;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .card-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .card-meta-item .material-symbols-outlined {
        font-size: 15px;
        color: var(--primary-orange);
        flex-shrink: 0;
    }

    /* Recap fallback block */
    .recap-fallback {
        background: #ffffff;
        padding: 56px 0;
        border-bottom: 1px solid #f0f0f0;
        text-align: center;
    }

    .recap-fallback-inner {
        max-width: 480px;
        margin: 0 auto;
    }

    .video-container {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        border-radius: 30px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
        background: #000;
        transition: transform 0.4s ease;
        overflow: hidden;
    }

    .video-container::before {
        content: 'PREVIEW';
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        z-index: 10;
        pointer-events: none;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .video-container:hover {
        transform: scale(1.02);
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
        object-fit: contain;
    }

    .highlight-content {
        padding: 20px 40px;
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

<!-- ====== Section Jump Navigation ====== -->
<?php
$highlights = array_filter(array_merge($ongoing_events ?? [], $upcoming_events ?? [], $past_events ?? []), function($e) {
    return !empty($e['video_url']);
});
$highlights = array_values($highlights); // re-index
?>
<nav class="events-tab-nav" aria-label="Events sections">
    <div class="events-tab-nav-inner">
        <?php if (!empty($ongoing_events)): ?>
        <a href="#ongoing-events" class="events-tab-pill">
            <span class="live-indicator-dot" style="margin-right:2px;"></span>
            Ongoing Events
        </a>
        <?php endif; ?>
        <a href="#upcoming-events" class="events-tab-pill">
            <span class="material-symbols-outlined" style="font-size:15px;">bolt</span>
            Upcoming Events
        </a>
        <a href="#past-events" class="events-tab-pill">
            <span class="material-symbols-outlined" style="font-size:15px;">history</span>
            Past Events
        </a>
        <?php if (!empty($highlights)): ?>
        <a href="#recap" class="events-tab-pill">
            <span class="material-symbols-outlined" style="font-size:15px;">play_circle</span>
            Recap Videos
        </a>
        <?php endif; ?>
    </div>
</nav>
<!-- ====== Section Jump Navigation End ====== -->

<!-- ====== Events Highlights Section Start ====== -->
<?php if (!empty($highlights)): ?>
<section id="recap" class="highlights-section overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left: Video Carousel -->
            <div class="col-lg-7">
                <div class="recap-carousel-wrap">
                    <div id="recapCarousel" class="owl-carousel owl-theme">
                        <?php foreach ($highlights as $h):
                            $hType = strtolower($h['video_type'] ?? 'youtube');
                            $hUrl  = $h['video_url'];
                            if ($hType === 'instagram') {
                                $hEmbed = getInstagramEmbedUrl($hUrl);
                            } elseif ($hType === 'facebook') {
                                $hEmbed = getFacebookEmbedUrl($hUrl);
                            } else {
                                $hEmbed = getYouTubeEmbedUrl($hUrl);
                            }
                        ?>
                        <div class="recap-slide">
                            <div class="video-container shadow-lg">
                                <?php if ($hType === 'youtube'): ?>
                                    <iframe src="<?= $hEmbed ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                                <?php elseif ($hType === 'instagram'): ?>
                                    <iframe src="<?= $hEmbed ?>" class="instagram-media" allowtransparency="true" frameborder="0" scrolling="no" allow="autoplay" loading="lazy"></iframe>
                                <?php elseif ($hType === 'facebook'): ?>
                                    <iframe src="<?= $hEmbed ?>" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" loading="lazy"></iframe>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($highlights) > 1): ?>
                    <button class="recap-nav-btn recap-nav-prev" id="recapPrev" aria-label="Previous recap">
                        <span class="material-symbols-outlined" style="font-size:20px;">chevron_left</span>
                    </button>
                    <button class="recap-nav-btn recap-nav-next" id="recapNext" aria-label="Next recap">
                        <span class="material-symbols-outlined" style="font-size:20px;">chevron_right</span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php if (count($highlights) > 1): ?>
                <div class="recap-dots" id="recapDots"></div>
                <?php endif; ?>
            </div>
            <!-- Right: Animated info panel (updates on slide change) -->
            <div class="col-lg-5">
                <div class="highlight-content animate__animated animate__fadeInRight" id="recapInfo">
                    <span class="tag-eyebrow">Visual Highlights</span>
                    <h2 class="section-title mb-4">Event <span>Recap</span></h2>
                    <?php foreach ($highlights as $idx => $h): ?>
                    <div class="recap-info-slide" data-index="<?= $idx ?>" <?= $idx > 0 ? 'style="display:none;"' : '' ?>>
                        <h4 class="fw-700 mb-3"><?= htmlspecialchars(stripslashes($h['event_title'])) ?></h4>
                        <p class="text-muted mb-4 recap-desc"><?= htmlspecialchars(mb_strimwidth(strip_tags(stripslashes($h['event_content'])), 0, 220, '…')) ?></p>
                        <div class="d-flex flex-column align-items-start gap-3 mt-4">
                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $h['event_id'] ?>" class="cta-button w-100 justify-content-center">
                                VIEW DETAILS
                                <span class="material-symbols-outlined">photo_library</span>
                            </a>
                            <a href="<?= htmlspecialchars($h['video_url']) ?>" target="_blank" rel="noopener noreferrer" class="cta-button cta-button-outline text-dark border-dark w-100 justify-content-center">
                                VIEW ON <?= strtoupper(strtolower($h['video_type'] ?? 'youtube')) ?>
                                <span class="material-symbols-outlined">open_in_new</span>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<!-- ====== Recap Fallback — shown when no event has a video URL ====== -->
<section id="recap" class="recap-fallback">
    <div class="recap-fallback-inner">
        <span class="material-symbols-outlined" style="font-size:3rem; color:#e0e0e0; display:block; margin-bottom:16px;">play_circle</span>
        <h4 style="font-weight:800; color: var(--dark-bg); margin-bottom:10px;">Video Recaps Coming Soon</h4>
        <p class="text-muted" style="font-size:0.9rem; line-height:1.6; margin-bottom:0;">After each event we publish a video highlight reel here. Check back once our next event wraps up!</p>
    </div>
</section>
<?php endif; ?>
<!-- ====== Events Highlights Section End ====== -->

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var $carousel = $('#recapCarousel');
        if (!$carousel.length) return;

        var totalSlides = <?= count($highlights) ?>;
        if (totalSlides <= 1) {
            $carousel.owlCarousel({ items: 1, loop: false, dots: false, nav: false });
            return;
        }

        $carousel.owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            nav: false,
            autoplay: false,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            smartSpeed: 600
        });

        // Build dots
        var $dotsContainer = $('#recapDots');
        for (var i = 0; i < totalSlides; i++) {
            $dotsContainer.append('<button class="recap-dot' + (i === 0 ? ' active' : '') + '" data-index="' + i + '" aria-label="Recap ' + (i+1) + '"></button>');
        }

        function updateRecapInfo(index) {
            var realIdx = index % totalSlides;
            $('.recap-info-slide').hide();
            $('.recap-info-slide[data-index="' + realIdx + '"]').fadeIn(300);
            $('.recap-dot').removeClass('active');
            $('.recap-dot[data-index="' + realIdx + '"]').addClass('active');
        }

        $carousel.on('changed.owl.carousel', function(e) {
            updateRecapInfo(e.item.index);
        });

        $('#recapPrev').on('click', function() { $carousel.trigger('prev.owl.carousel'); });
        $('#recapNext').on('click', function() { $carousel.trigger('next.owl.carousel'); });

        $dotsContainer.on('click', '.recap-dot', function() {
            $carousel.trigger('to.owl.carousel', [$(this).data('index'), 300]);
        });
    });
})();
</script>

<!-- ====== Ongoing Events Section Start ====== -->
<?php if (!empty($ongoing_events)): ?>
<section id="ongoing-events" class="section-padding pb-0">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Happening Now</span>
                <h2 class="section-title">Ongoing <span>Events</span></h2>
                <p class="section-subtitle">Catch the action live! Explore our currently running workshops, conferences, and programs.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($ongoing_events as $event):
                $date = strtotime($event['event_date']);
                $day = date('d', $date);
                $month = date('M', $date);
                $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 35, '…');
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="event-card">
                        <div class="card-img-wrap">
                            <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'; this.onerror=null;">
                            <div class="card-date-badge">
                                <span class="day"><?= $day ?></span>
                                <span class="month"><?= $month ?></span>
                            </div>
                        </div>
                        <div class="card-content">
                            <span class="card-status-pill status-ongoing">
                                <span class="live-indicator-dot"></span>
                                <span class="material-symbols-outlined" style="font-size: 14px;">sensors</span>
                                Ongoing
                            </span>
                            <h3 class="card-title"><?= stripslashes($event['event_title']); ?></h3>
                            <div class="card-desc"><?= strip_tags(stripslashes($event['event_content'])); ?></div>
                            <div class="card-meta-row">
                                <?php if (!empty($event['event_time'])): ?>
                                <div class="card-meta-item">
                                    <span class="material-symbols-outlined">schedule</span>
                                    <?= htmlspecialchars($event['event_time']) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($event['event_address'])): ?>
                                <div class="card-meta-item">
                                    <span class="material-symbols-outlined">location_on</span>
                                    <?= htmlspecialchars($truncatedAddr) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                    View Details
                                    <span class="material-symbols-outlined">trending_flat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- ====== Ongoing Events Section End ====== -->

<!-- ====== Upcoming Events Section Start ====== -->
<section id="upcoming-events" class="section-padding pb-0">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="tag-eyebrow">Connect &amp; Learn</span>
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
                    $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 35, '…');
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="event-card">
                            <div class="card-img-wrap">
                                <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'; this.onerror=null;">
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
                                <div class="card-meta-row">
                                    <?php if (!empty($event['event_time'])): ?>
                                    <div class="card-meta-item">
                                        <span class="material-symbols-outlined">schedule</span>
                                        <?= htmlspecialchars($event['event_time']) ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($event['event_address'])): ?>
                                    <div class="card-meta-item">
                                        <span class="material-symbols-outlined">location_on</span>
                                        <?= htmlspecialchars($truncatedAddr) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                        View Details
                                        <span class="material-symbols-outlined">trending_flat</span>
                                    </a>
                                </div>
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
        <div class="row justify-content-center mb-4">
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
                    $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 35, '…');
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="event-card">
                            <div class="card-img-wrap">
                                <img src="<?= resolvePath($event['event_img']); ?>" alt="<?= htmlspecialchars($event['event_title']); ?>" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'; this.onerror=null;">
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
                                <div class="card-meta-row">
                                    <?php if (!empty($event['event_time'])): ?>
                                    <div class="card-meta-item">
                                        <span class="material-symbols-outlined">schedule</span>
                                        <?= htmlspecialchars($event['event_time']) ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($event['event_address'])): ?>
                                    <div class="card-meta-item">
                                        <span class="material-symbols-outlined">location_on</span>
                                        <?= htmlspecialchars($truncatedAddr) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="<?= BASE_URL ?>/events/detail?id=<?= $event['event_id']; ?>" class="view-btn">
                                        View Recap
                                        <span class="material-symbols-outlined">trending_flat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <span class="material-symbols-outlined">history</span>
                        <h4>No past events yet</h4>
                        <p class="text-muted">No archives yet — check back after our next event.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ====== Premium CTA Block (within Past Events section) ====== -->
    <div class="container mt-4">
        <div class="premium-cta">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="tag-eyebrow tag-eyebrow-light">Ready to Accelerate?</span>
                    <h2 class="section-title">Unlock Your <span>Tech Potential</span></h2>
                    <p class="section-subtitle mx-auto text-white opacity-75 mb-4">
                        Beyond our community events, we offer specialized, high-impact training programs designed to fast-track your professional growth in the digital landscape.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="<?= BASE_URL ?>/trainings" class="cta-button">
                            Explore Certifications
                            <span class="material-symbols-outlined">school</span>
                        </a>
                        <a href="<?= BASE_URL ?>/contact" class="cta-button cta-button-outline">
                            Get in Touch
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </a>
                    </div>
                    <div class="mt-4">
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