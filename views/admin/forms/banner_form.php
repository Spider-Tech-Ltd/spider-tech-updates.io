<!-- Banner Form -->
<div class="dashboard-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/banners" class="btn-action btn-back-header me-3 mr-3" title="Back to Banners">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="dashboard-title"><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Banner</h1>
            <p class="dashboard-subtitle">Configure homepage hero slider headline and visual asset.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title"><?= ($mode == 'add') ? 'Create Banner Slide' : 'Update Banner Slide #' . $item['banner_id'] ?></h2>
            </div>
            <div class="admin-card-body p-4">
                <form onsubmit="submitForm(event, 'banner', 'bannerRedirect')" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="banner">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['banner_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label-custom">Banner Headline / Caption <span class="text-danger">*</span></label>
                        <input type="text" name="banner_title" class="form-control-custom" value="<?= htmlspecialchars($item['banner_title'] ?? '') ?>" placeholder="e.g. Innovating the &lt;span&gt;Feature of Tech&lt;/span&gt;" required>
                        <div class="text-muted mt-1" style="font-size: 0.72rem;">
                            Tip: Wrap words in <code>&lt;span&gt;highlight&lt;/span&gt;</code> to render them in brand orange.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Banner Image Asset <?= ($mode == 'add') ? '<span class="text-danger">*</span>' : '' ?></label>
                        <input type="file" name="banner_image" class="form-control-custom" accept="image/*" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <div class="text-muted mt-1" style="font-size: 0.72rem;">
                            Recommended format: 1920x1080 (16:9 ratio) JPEG or PNG for optimal sharpness.
                        </div>

                        <?php if ($mode == 'edit' && !empty($item['banner_image'])):
                            $path = $item['banner_image'];
                            if (preg_match('#^https?://#i', $path)) {
                                $previewPath = $path;
                            } elseif (strpos($path, '/') !== false) {
                                $previewPath = BASE_URL . '/' . ltrim($path, './');
                            } else {
                                if (file_exists(ROOT_PATH . '/images/banners/' . $path)) {
                                    $previewPath = BASE_URL . '/images/banners/' . $path;
                                } elseif (file_exists(ROOT_PATH . '/img/' . $path)) {
                                    $previewPath = BASE_URL . '/img/' . $path;
                                } elseif (file_exists(ROOT_PATH . '/images/pictures/' . $path)) {
                                    $previewPath = BASE_URL . '/images/pictures/' . $path;
                                } else {
                                    $previewPath = BASE_URL . '/images/banners/' . $path;
                                }
                            }
                        ?>
                            <div class="mt-3">
                                <span class="text-muted d-block mb-1" style="font-size: 0.74rem; font-weight: 600;">Current Slide Preview:</span>
                                <div class="table-img-wrapper" style="width: 100%; max-width: 380px; height: 190px; border-radius: 8px;">
                                    <img src="<?= $previewPath ?>" alt="Banner Preview" style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="<?= BASE_URL ?>/admin/banners" class="btn-admin-cancel px-4">Cancel</a>
                        <button type="submit" class="btn-primary-custom px-4">
                            <span class="material-symbols-outlined" style="font-size: 18px;">check</span>
                            <span><?= ($mode == 'add') ? 'Save Banner' : 'Update Banner' ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function bannerRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/banners';
}
</script>
