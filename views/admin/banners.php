<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Hero Banners</h1>
            <p>Manage the high-impact images and titles on the home page carousel.</p>
        </div>
        <button class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Banner</span>
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="row g-4">
            <?php
            foreach ($banners as $banner):
                $imagePath = BASE_URL . '/images/pictures/' . $banner['banner_image'];
                if (!file_exists(ROOT_PATH . '/images/pictures/' . $banner['banner_image'])) {
                    $imagePath = BASE_URL . '/img/' . $banner['banner_image'];
                }
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="banner-manage-card">
                    <div class="banner-img-preview">
                        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($banner['banner_title']) ?>">
                    </div>
                    <div class="banner-details">
                        <h6 class="poppins fw-600 mb-1"><?= htmlspecialchars($banner['banner_title']) ?></h6>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted fs-08">ID: #<?= $banner['banner_id'] ?></span>
                            <div class="action-btns">
                                <button class="btn-action edit"><span class="material-symbols-outlined">edit</span></button>
                                <button class="btn-action delete"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
