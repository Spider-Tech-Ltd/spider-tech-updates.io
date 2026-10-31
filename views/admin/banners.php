<!-- Hero Banners Admin Management -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h1 class="dashboard-title">Hero Banners</h1>
            <p class="dashboard-subtitle">Manage homepage hero carousel slides, headlines, and visual assets.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/admin/banners/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Add Banner</span>
            </a>
        </div>
    </div>
</div>

<!-- Banners Grid -->
<div class="row g-3 mb-4">
    <?php if (!empty($banners)): ?>
        <?php
        $slideIndex = 1;
        foreach ($banners as $banner):
            $path = $banner['banner_image'];
            if (preg_match('#^https?://#i', $path)) {
                $imagePath = $path;
            } elseif (strpos($path, '/') !== false) {
                $imagePath = BASE_URL . '/' . ltrim($path, './');
            } else {
                if (file_exists(ROOT_PATH . '/images/banners/' . $path)) {
                    $imagePath = BASE_URL . '/images/banners/' . $path;
                } elseif (file_exists(ROOT_PATH . '/img/' . $path)) {
                    $imagePath = BASE_URL . '/img/' . $path;
                } elseif (file_exists(ROOT_PATH . '/images/pictures/' . $path)) {
                    $imagePath = BASE_URL . '/images/pictures/' . $path;
                } else {
                    $imagePath = BASE_URL . '/images/banners/' . $path;
                }
            }

            // Display title cleanly
            $displayTitle = $banner['banner_title'];
            if (strpos($displayTitle, 'Homepage slider') !== false) {
                switch ($banner['banner_id']) {
                    case 1: $displayTitle = "Give Wings to your <span>Business</span>"; break;
                    case 2: $displayTitle = "Innovating the <span>Feature of Tech</span>"; break;
                    case 3: $displayTitle = "Empowering <span>Digital Transformation</span>"; break;
                    default: $displayTitle = "Think Big, Grow your <span>Business</span>"; break;
                }
            }
        ?>
        <div class="col-md-6 col-xl-4">
            <div class="banner-card-modern">
                <!-- Preview Image with Slide Badge -->
                <div class="banner-preview-wrap">
                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars(strip_tags($displayTitle)) ?>" class="banner-preview-img" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'">
                    <div class="banner-badge-overlay">
                        <span class="banner-chip">Slide #<?= $slideIndex++ ?></span>
                        <span class="banner-status-pill">
                            <span class="service-status-dot bg-green"></span> Active
                        </span>
                    </div>
                </div>

                <!-- Banner Meta & Actions -->
                <div class="banner-body-wrap">
                    <div class="banner-title-preview">
                        <?= $displayTitle ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-muted" style="font-size: 0.72rem; font-family: 'Poppins', sans-serif;">
                            ID: #<?= $banner['banner_id'] ?>
                        </span>
                        <div class="action-btns">
                            <a href="<?= BASE_URL ?>/admin/banners/edit/<?= $banner['banner_id'] ?>" class="btn-action edit" title="Edit Banner">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <button class="btn-action delete" onclick="deleteItem(<?= $banner['banner_id'] ?>, 'banner')" title="Delete Banner">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="admin-card text-center p-5">
                <span class="material-symbols-outlined text-muted mb-2" style="font-size: 48px;">view_carousel</span>
                <h5 class="fw-bold mb-1">No Hero Banners Found</h5>
                <p class="text-muted small mb-3">Add banner slides to showcase headlines on the homepage hero carousel.</p>
                <a href="<?= BASE_URL ?>/admin/banners/add" class="btn-primary-custom d-inline-flex">
                    <span class="material-symbols-outlined fs-18">add_circle</span>
                    <span>Create First Banner</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
