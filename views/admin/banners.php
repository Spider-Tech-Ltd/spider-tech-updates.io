<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Hero Banners</h1>
            <p>Manage the high-impact images and titles on the home page carousel.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/banners/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Banner</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="row gy-4 gx-4">
            <?php
            foreach ($banners as $banner):
                // Prioritize images/pictures/ based on DB dump inspection
                $imageName = $banner['banner_image'];
                $imagePath = BASE_URL . '/images/pictures/' . $imageName;

                // Fallback checks
                if (!file_exists(ROOT_PATH . '/images/pictures/' . $imageName)) {
                    if (file_exists(ROOT_PATH . '/img/' . $imageName)) {
                        $imagePath = BASE_URL . '/img/' . $imageName;
                    } elseif (file_exists(ROOT_PATH . '/images/' . $imageName)) {
                        $imagePath = BASE_URL . '/images/' . $imageName;
                    }
                }
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="banner-manage-card">
                    <div class="banner-img-preview">
                        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($banner['banner_title']) ?>" onerror="this.src='<?= BASE_URL ?>/images/placeholder-banner.jpg'">
                    </div>
                    <div class="banner-details">
                        <h6 class="poppins fw-600 mb-1"><?= htmlspecialchars($banner['banner_title']) ?></h6>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted fs-08">ID: #<?= $banner['banner_id'] ?></span>
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/banners/edit/<?= $banner['banner_id'] ?>" class="btn-action edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" onclick="deleteItem(<?= $banner['banner_id'] ?>, 'banner')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
    </div>
</div>
