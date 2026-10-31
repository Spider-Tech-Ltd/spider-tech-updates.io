<link rel="stylesheet" href="<?= BASE_URL ?>/css/events.css?v=<?= filemtime(ROOT_PATH . '/css/events.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Experience <span>the Hub</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Events
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php
$highlights = array_filter(array_merge($ongoing_events ?? [], $upcoming_events ?? [], $past_events ?? []), function($e) {
    return !empty($e['video_url']);
});
$highlights = array_values($highlights);

if (!function_exists('truncateEventDescWordAware')) {
    function truncateEventDescWordAware($text, $limit = 118) {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags(stripslashes($text))));
        if ($text === '' || mb_strlen($text) <= $limit) {
            return $text;
        }
        $truncated = mb_substr($text, 0, $limit);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }
        return rtrim($truncated, ".,;:- ") . '...';
    }
}
?>

<!-- ====== Events Highlights Section (Recap Videos) ====== -->
<?php if (!empty($highlights)): ?>
<section id="recap" class="highlights-section overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left: Video Player with Thumbnail & Play / Tooltip -->
            <div class="col-lg-7">
                <div class="recap-carousel-wrap">
                    <div id="recapCarousel" class="owl-carousel owl-theme">
                        <?php foreach ($highlights as $idx => $h):
                            $hType = strtolower($h['video_type'] ?? 'youtube');
                            $hUrl  = $h['video_url'];
                            if ($hType === 'instagram') {
                                $hEmbed = getInstagramEmbedUrl($hUrl);
                            } elseif ($hType === 'facebook') {
                                $hEmbed = getFacebookEmbedUrl($hUrl);
                            } else {
                                $hEmbed = getYouTubeEmbedUrl($hUrl);
                            }
                            $rawImg = trim($h['event_img'] ?? '');
                            $hasImg = ($rawImg !== '');
                            $finalImg = $hasImg ? resolvePath($rawImg) : '';
                        ?>
                        <div class="recap-slide">
                            <div class="video-container" data-embed-url="<?= htmlspecialchars($hEmbed) ?>" data-video-type="<?= $hType ?>">
                                <!-- External full video redirect button with hover tooltip -->
                                <a href="<?= htmlspecialchars($hUrl) ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="video-redirect-badge"
                                   aria-label="View full video on <?= ucfirst($hType) ?>"
                                   onclick="event.stopPropagation();">
                                    <span class="material-symbols-outlined redirect-icon">open_in_new</span>
                                    <span class="video-tooltip">
                                        <span>View full video</span>
                                        <span class="material-symbols-outlined tooltip-icon">open_in_new</span>
                                    </span>
                                </a>

                                <!-- Accessible video poster overlay that triggers inline playback -->
                                <div class="video-thumbnail-overlay"
                                     onclick="playRecapVideo(this)"
                                     role="button"
                                     tabindex="0"
                                     aria-label="Play video recap for <?= htmlspecialchars(stripslashes($h['event_title'])) ?>"
                                     onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();playRecapVideo(this);}">
                                    <?php if ($hasImg): ?>
                                        <img src="<?= htmlspecialchars($finalImg) ?>" alt="<?= htmlspecialchars(stripslashes($h['event_title'])) ?>" class="video-poster-img" loading="lazy">
                                    <?php else: ?>
                                        <div class="video-poster-fallback">
                                            <span class="material-symbols-outlined fallback-icon">smart_display</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="video-scrim"></div>
                                    <div class="play-btn-wrapper">
                                        <div class="video-play-pulse-btn" aria-hidden="true">
                                            <span class="material-symbols-outlined play-icon">play_arrow</span>
                                        </div>
                                        <span class="play-label">Click to Play Video</span>
                                    </div>
                                </div>

                                <!-- Dynamic iframe player slot -->
                                <div class="video-player-slot"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($highlights) > 1): ?>
                    <button class="recap-nav-btn recap-nav-prev" id="recapPrev" aria-label="Previous recap">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="recap-nav-btn recap-nav-next" id="recapNext" aria-label="Next recap">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php if (count($highlights) > 1): ?>
                <div class="recap-dots" id="recapDots"></div>
                <?php endif; ?>
            </div>

            <!-- Right: Event recap information (Only View Details button, no view on facebook) -->
            <div class="col-lg-5">
                <div class="highlight-content animate__animated animate__fadeInRight" id="recapInfo">
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
                    <h2 class="section-title mb-3">Event <span>Recap</span></h2>
                    <?php foreach ($highlights as $idx => $h): ?>
                    <div class="recap-info-slide" data-index="<?= $idx ?>" <?= $idx > 0 ? 'style="display:none;"' : '' ?>>
                        <h4 class="recap-title"><?= htmlspecialchars(stripslashes($h['event_title'])) ?></h4>
                        <p class="recap-desc"><?= htmlspecialchars(mb_strimwidth(strip_tags(stripslashes($h['event_content'])), 0, 200, '…')) ?></p>
                        <div class="recap-actions">
                            <a href="<?= BASE_URL ?>/events/detail?id=<?= $h['event_id'] ?>" class="btn-recap-primary">
                                <span>View Event Details</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ====== Events Directory Section (Unified Tabs UI) ====== -->
<section class="section-padding events-directory-section" x-data="eventsDirectory()" @hashchange.window="syncHashTab()">
    <div class="container">

        <!-- Section Header -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Event Directory</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>
                <br>
                <h2 class="section-title">Explore <span>Our Gatherings</span></h2>
                <p class="section-subtitle">Switch categories below to browse live cohorts, upcoming tech sessions, or archived presentations.</p>
            </div>
        </div>

        <!-- Category Tab Switcher -->
        <div class="events-tab-switcher-wrap">
            <div class="events-tab-switcher" role="tablist" aria-label="Event Categories">
                <?php if (!empty($ongoing_events)): ?>
                <button
                    type="button"
                    role="tab"
                    class="event-tab-btn"
                    :class="{ 'active': activeTab === 'ongoing' }"
                    @click="switchTab('ongoing')"
                    :aria-selected="(activeTab === 'ongoing').toString()"
                    aria-controls="panel-ongoing">
                    <span class="live-indicator-dot"></span>
                    <span>Ongoing Events</span>
                    <span class="tab-badge"><?= count($ongoing_events) ?></span>
                </button>
                <?php endif; ?>

                <button
                    type="button"
                    role="tab"
                    class="event-tab-btn"
                    :class="{ 'active': activeTab === 'upcoming' }"
                    @click="switchTab('upcoming')"
                    :aria-selected="(activeTab === 'upcoming').toString()"
                    aria-controls="panel-upcoming">
                    <span class="material-symbols-outlined tab-icon">bolt</span>
                    <span>Upcoming Events</span>
                    <span class="tab-badge"><?= count($upcoming_events) ?></span>
                </button>

                <button
                    type="button"
                    role="tab"
                    class="event-tab-btn"
                    :class="{ 'active': activeTab === 'past' }"
                    @click="switchTab('past')"
                    :aria-selected="(activeTab === 'past').toString()"
                    aria-controls="panel-past">
                    <span class="material-symbols-outlined tab-icon">history</span>
                    <span>Past Events</span>
                    <span class="tab-badge"><?= count($past_events) ?></span>
                </button>
            </div>
        </div>

        <!-- Tab Panels Container -->
        <div class="tab-content">

            <!-- Ongoing Tab Panel -->
            <?php if (!empty($ongoing_events)): ?>
            <div id="panel-ongoing" role="tabpanel" x-show="activeTab === 'ongoing'" x-cloak class="tab-panel-fade">
                <div class="row g-4">
                    <?php foreach ($ongoing_events as $event):
                        $date = strtotime($event['event_date']);
                        $day = date('d', $date);
                        $month = date('M', $date);
                        $rawImg = trim($event['event_img'] ?? '');
                        $hasImg = ($rawImg !== '');
                        $finalImg = $hasImg ? resolvePath($rawImg) : '';
                        $eTitle = trim(stripslashes($event['event_title'] ?? 'Event'));
                        $eDesc = truncateEventDescWordAware($event['event_content'] ?? '', 118);
                        $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 32, '…');
                    ?>
                        <div class="col-lg-4 col-md-6 mb-4 d-flex">
                            <div class="event-card">
                                <div class="card-img-wrap">
                                    <span class="card-status-pill status-ongoing">
                                        <span class="live-indicator-dot"></span>
                                        <span>Ongoing</span>
                                    </span>
                                    <div class="card-date-badge">
                                        <span class="day"><?= $day ?></span>
                                        <span class="month"><?= $month ?></span>
                                    </div>
                                    <?php if ($hasImg): ?>
                                        <img src="<?= htmlspecialchars($finalImg); ?>"
                                             alt="<?= htmlspecialchars($eTitle); ?>"
                                             loading="lazy"
                                             decoding="async"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <?php endif; ?>
                                    <div class="event-img-fallback" style="display: <?= $hasImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                                        <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                            <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="fallback-label">Spider Tech Event</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title" title="<?= htmlspecialchars($eTitle); ?>"><?= htmlspecialchars($eTitle); ?></h3>
                                    <div class="card-desc"><?= htmlspecialchars($eDesc); ?></div>
                                    <div class="card-meta-row">
                                        <?php if (!empty($event['event_time'])): ?>
                                        <div class="card-meta-item">
                                            <span class="material-symbols-outlined">schedule</span>
                                            <span><?= htmlspecialchars(stripslashes($event['event_time'])) ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <?php if (!empty($event['event_address'])): ?>
                                        <div class="card-meta-item">
                                            <span class="material-symbols-outlined">location_on</span>
                                            <span><?= htmlspecialchars($truncatedAddr) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?= BASE_URL ?>/events/detail?id=<?= (int) $event['event_id']; ?>" class="view-btn">
                                        <span>View Details</span>
                                        <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Upcoming Tab Panel -->
            <div id="panel-upcoming" role="tabpanel" x-show="activeTab === 'upcoming'" x-cloak class="tab-panel-fade">
                <div class="row g-4">
                    <?php if (!empty($upcoming_events)): ?>
                        <?php foreach ($upcoming_events as $event):
                            $date = strtotime($event['event_date']);
                            $day = date('d', $date);
                            $month = date('M', $date);
                            $rawImg = trim($event['event_img'] ?? '');
                            $hasImg = ($rawImg !== '');
                            $finalImg = $hasImg ? resolvePath($rawImg) : '';
                            $eTitle = trim(stripslashes($event['event_title'] ?? 'Event'));
                            $eDesc = truncateEventDescWordAware($event['event_content'] ?? '', 118);
                            $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 32, '…');
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                                <div class="event-card">
                                    <div class="card-img-wrap">
                                        <span class="card-status-pill status-upcoming">
                                            <span class="material-symbols-outlined status-icon">bolt</span>
                                            <span>Upcoming</span>
                                        </span>
                                        <div class="card-date-badge">
                                            <span class="day"><?= $day ?></span>
                                            <span class="month"><?= $month ?></span>
                                        </div>
                                        <?php if ($hasImg): ?>
                                            <img src="<?= htmlspecialchars($finalImg); ?>"
                                                 alt="<?= htmlspecialchars($eTitle); ?>"
                                                 loading="lazy"
                                                 decoding="async"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <?php endif; ?>
                                        <div class="event-img-fallback" style="display: <?= $hasImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                                            <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                                <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                                            </svg>
                                            <span class="fallback-label">Spider Tech Event</span>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-title" title="<?= htmlspecialchars($eTitle); ?>"><?= htmlspecialchars($eTitle); ?></h3>
                                        <div class="card-desc"><?= htmlspecialchars($eDesc); ?></div>
                                        <div class="card-meta-row">
                                            <?php if (!empty($event['event_time'])): ?>
                                            <div class="card-meta-item">
                                                <span class="material-symbols-outlined">schedule</span>
                                                <span><?= htmlspecialchars(stripslashes($event['event_time'])) ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($event['event_address'])): ?>
                                            <div class="card-meta-item">
                                                <span class="material-symbols-outlined">location_on</span>
                                                <span><?= htmlspecialchars($truncatedAddr) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?= BASE_URL ?>/events/detail?id=<?= (int) $event['event_id']; ?>" class="view-btn">
                                            <span>View Details</span>
                                            <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="empty-state">
                                <span class="material-symbols-outlined">calendar_today</span>
                                <h4>No Upcoming Events Scheduled Right Now</h4>
                                <p>We are finalizing dates for our next engineering hackathon and tech summit. Check back shortly!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Past Tab Panel -->
            <div id="panel-past" role="tabpanel" x-show="activeTab === 'past'" x-cloak class="tab-panel-fade">
                <div class="row g-4">
                    <?php if (!empty($past_events)): ?>
                        <?php foreach ($past_events as $event):
                            $date = strtotime($event['event_date']);
                            $day = date('d', $date);
                            $month = date('M', $date);
                            $rawImg = trim($event['event_img'] ?? '');
                            $hasImg = ($rawImg !== '');
                            $finalImg = $hasImg ? resolvePath($rawImg) : '';
                            $eTitle = trim(stripslashes($event['event_title'] ?? 'Event'));
                            $eDesc = truncateEventDescWordAware($event['event_content'] ?? '', 118);
                            $truncatedAddr = mb_strimwidth(strip_tags(stripslashes($event['event_address'] ?? '')), 0, 32, '…');
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                                <div class="event-card">
                                    <div class="card-img-wrap">
                                        <span class="card-status-pill status-past">
                                            <span class="material-symbols-outlined status-icon">history</span>
                                            <span>Completed</span>
                                        </span>
                                        <div class="card-date-badge">
                                            <span class="day"><?= $day ?></span>
                                            <span class="month"><?= $month ?></span>
                                        </div>
                                        <?php if ($hasImg): ?>
                                            <img src="<?= htmlspecialchars($finalImg); ?>"
                                                 alt="<?= htmlspecialchars($eTitle); ?>"
                                                 loading="lazy"
                                                 decoding="async"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <?php endif; ?>
                                        <div class="event-img-fallback" style="display: <?= $hasImg ? 'none' : 'flex' ?>;" aria-hidden="true">
                                            <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                                <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                                            </svg>
                                            <span class="fallback-label">Spider Tech Event</span>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-title" title="<?= htmlspecialchars($eTitle); ?>"><?= htmlspecialchars($eTitle); ?></h3>
                                        <div class="card-desc"><?= htmlspecialchars($eDesc); ?></div>
                                        <div class="card-meta-row">
                                            <?php if (!empty($event['event_time'])): ?>
                                            <div class="card-meta-item">
                                                <span class="material-symbols-outlined">schedule</span>
                                                <span><?= htmlspecialchars(stripslashes($event['event_time'])) ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($event['event_address'])): ?>
                                            <div class="card-meta-item">
                                                <span class="material-symbols-outlined">location_on</span>
                                                <span><?= htmlspecialchars($truncatedAddr) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?= BASE_URL ?>/events/detail?id=<?= (int) $event['event_id']; ?>" class="view-btn">
                                            <span>View Recap</span>
                                            <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="empty-state">
                                <span class="material-symbols-outlined">history</span>
                                <h4>No Past Event Archives Yet</h4>
                                <p>Past event recaps and galleries will appear here once upcoming events conclude.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Premium CTA Block (Synced with Homepage/Trainings) -->
        <div class="premium-cta mt-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 mb-3 mb-lg-0 text-lg-left text-center">
                    <span class="section-eyebrow cta-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="rgba(255,255,255,0.4)"/>
                        </svg>
                        <span class="eyebrow-label-text">Ready to Accelerate?</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="rgba(255,255,255,0.4)"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <h2 class="premium-cta-title">Unlock Your <span>Tech Potential</span></h2>
                    <p class="premium-cta-desc">
                        Beyond community meetups, we offer industry-recognized certifications and intensive software bootcamps to advance your career.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-right text-center d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    <a href="<?= BASE_URL ?>/trainings" class="cta-button">
                        <span>Explore Certifications</span>
                        <span class="material-symbols-outlined">school</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>

<!-- ====== Scripts ====== -->
<script>
// Inline Recap Video Playback Function
function playRecapVideo(overlayEl) {
    var container = overlayEl.closest('.video-container');
    if (!container) return;

    var embedUrl = container.getAttribute('data-embed-url');
    var videoType = container.getAttribute('data-video-type') || 'youtube';
    var slot = container.querySelector('.video-player-slot');

    if (!slot || slot.querySelector('iframe')) return;

    var finalSrc = embedUrl;
    if (videoType === 'youtube') {
        if (finalSrc.indexOf('autoplay=') === -1) {
            finalSrc += (finalSrc.indexOf('?') !== -1 ? '&' : '?') + 'autoplay=1&mute=0';
        }
    } else if (videoType === 'facebook') {
        if (finalSrc.indexOf('autoplay=') === -1) {
            finalSrc += '&autoplay=1&mute=0';
        }
    }

    var iframe = document.createElement('iframe');
    iframe.src = finalSrc;
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
    iframe.setAttribute('allowfullscreen', 'true');
    iframe.setAttribute('loading', 'eager');
    iframe.setAttribute('title', 'Event Video Player');
    iframe.style.position = 'absolute';
    iframe.style.top = '0';
    iframe.style.left = '0';
    iframe.style.width = '100%';
    iframe.style.height = '100%';
    iframe.style.border = '0';

    slot.innerHTML = '';
    slot.appendChild(iframe);

    $(overlayEl).fadeOut(250);
}

// Alpine Events Directory Controller
function eventsDirectory() {
    var defaultTab = '<?= !empty($ongoing_events) ? 'ongoing' : (!empty($upcoming_events) ? 'upcoming' : 'past') ?>';
    return {
        activeTab: defaultTab,
        init() {
            this.syncHashTab();
        },
        syncHashTab() {
            var hash = window.location.hash.replace('#', '').toLowerCase();
            if (hash === 'ongoing' || hash === 'ongoing-events') {
                this.activeTab = 'ongoing';
            } else if (hash === 'past' || hash === 'past-events') {
                this.activeTab = 'past';
            } else if (hash === 'upcoming' || hash === 'upcoming-events') {
                this.activeTab = 'upcoming';
            }
        },
        switchTab(tab) {
            this.activeTab = tab;
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, '#' + tab);
            }
        }
    };
}

// Recap Carousel Initialization & Synchronization
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

            // Pause/clean up any running iframes on slide change to avoid background audio
            $('.video-player-slot').empty();
            $('.video-thumbnail-overlay').fadeIn(150);
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
