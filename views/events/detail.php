<style>
    :root {
        --primary-orange: #f48221;
        --primary-dark: #262626;
        --text-body: #374151;
        --text-muted: #797979;
    }

    .event-detail-main {
        padding-top: 120px;
        padding-bottom: 100px;
    }

    /* Hero Header */
    .hero-wrap {
        position: relative;
        height: 500px;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .hero-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17,24,39,0.9), transparent);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    .hero-overlay h1 {
        color: #fff;
        font-size: 48px;
        font-weight: 800;
        line-height: 1.1;
        max-width: 900px;
        margin-bottom: 0;
    }
    .hero-overlay .badge {
        background: var(--primary-orange);
        color: #fff;
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        width: fit-content;
        margin-bottom: 20px;
    }

    /* Centralized Reading Flow */
    .reading-container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* Event Info Grid */
    .event-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
        padding: 30px;
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 20px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .info-item .label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }
    .info-item .value {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-dark);
    }
    .info-item i {
        color: var(--primary-orange);
        margin-right: 5px;
    }

    /* Article Content */
    .event-content {
        font-size: 18px;
        line-height: 1.8;
        color: var(--text-body);
    }
    .event-content p {
        margin-bottom: 25px;
    }
    .event-content h2, .event-content h3, .event-content h4 {
        font-weight: 700;
        color: var(--primary-dark);
        margin-top: 40px;
        margin-bottom: 20px;
    }

    /* CTA Button */
    .btn-register-now {
        background-color: var(--primary-orange);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 16px 48px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 20px rgba(244, 130, 33, 0.2);
        text-decoration: none !important;
        margin-top: 30px;
    }

    .btn-register-now:hover {
        background-color: #e6751c;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(244, 130, 33, 0.3);
        color: #fff;
    }

    .btn-back {
        background: #f3f4f6;
        color: var(--text-body);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .btn-back:hover {
        background: #e5e7eb;
        color: var(--primary-dark);
        transform: translateX(-5px);
    }

    @media (max-width: 768px) {
        .hero-overlay h1 { font-size: 32px; }
        .hero-wrap { height: 350px; }
    }

    /* Media Gallery */
    .media-gallery-section {
        margin-top: 80px;
        padding-top: 60px;
        border-top: 1px solid #eee;
    }
    .media-gallery-section h4 {
        margin-bottom: 30px;
        font-weight: 700;
        font-size: 24px;
        color: var(--primary-dark);
    }
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    .media-item {
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
    }
    .media-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .media-item:hover img {
        transform: scale(1.1);
    }
    .media-item .overlay {
        position: absolute;
        inset: 0;
        background: rgba(244, 130, 33, 0.2);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }
    .media-item:hover .overlay {
        opacity: 1;
    }
</style>

<main class="event-detail-main">
    <div class="container">
        <?php if($event): ?>

        <!-- Hero Section -->
        <div class="hero-wrap">
            <img src="<?= BASE_URL . '/' . ltrim(substr($event['event_img'], 3), '/'); ?>" alt="<?= htmlspecialchars($event['event_title']) ?>">
            <div class="hero-overlay">
                <span class="badge"><?= stripslashes($event['event_status']) ?> Event</span>
                <h1><?= stripslashes($event['event_title']) ?></h1>
            </div>
        </div>

        <!-- Reading Container -->
        <div class="reading-container">

            <!-- Breadcrumb / Back link -->
            <div class="mb-5">
                <a href="<?= BASE_URL ?>/events" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
            </div>

            <!-- Info Grid -->
            <div class="event-info-grid">
                <div class="info-item">
                    <span class="label">Date</span>
                    <span class="value"><i class="far fa-calendar-alt"></i> <?= stripslashes($event['event_date']) ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Time</span>
                    <span class="value"><i class="far fa-clock"></i> <?= stripslashes($event['event_time']) ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Location</span>
                    <span class="value"><i class="fas fa-map-marker-alt"></i> <?= stripslashes($event['event_address']) ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value"><i class="fas fa-info-circle"></i> <?= ucfirst(stripslashes($event['event_status'])) ?></span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="event-content">
                <?= stripslashes($event['event_detail']) ?>
            </div>

            <!-- CTA -->
            <?php if (trim(strtolower(stripslashes($event['event_status']))) === "upcoming"): ?>
            <div class="mt-5">
                <a href="<?= BASE_URL ?>/trainings" class="btn-register-now">
                    Register Now <i class="fas fa-arrow-right"></i>
                </a>
                <p class="text-muted small mt-3">#SpiderTechEmpowers - Limited slots available for this session.</p>
            </div>
            <?php endif; ?>

            <!-- Media Gallery -->
            <?php if (!empty($event_media)): ?>
            <div class="media-gallery-section">
                <h4>Event Media</h4>
                <div class="media-grid">
                    <?php foreach ($event_media as $media): ?>
                    <div class="media-item">
                        <img src="<?= BASE_URL . '/' . ltrim(substr($media['event_pics_name'], 3), '/'); ?>" alt="Event Media">
                        <a href="<?= BASE_URL . '/' . ltrim(substr($media['event_pics_name'], 3), '/'); ?>" class="overlay popup-box" data-lightbox="event-gallery" data-title="<?= htmlspecialchars($event['event_title']); ?>">
                            <i class="fas fa-search-plus"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <h3>Event not found</h3>
            <p>The event you are looking for does not exist or has been removed.</p>
            <a href="<?= BASE_URL ?>/events" class="btn-register-now">Return to Events</a>
        </div>
        <?php endif; ?>
    </div>
</main>
