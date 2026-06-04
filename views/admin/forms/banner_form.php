<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/banners" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Banner</h1>
            <p>Manage the homepage hero section carousel.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'banner', 'bannerRedirect')" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="banner">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['banner_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Banner Title / Caption</label>
                        <input type="text" name="banner_title" class="form-control-custom" value="<?= $item['banner_title'] ?? '' ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if ($mode == 'edit' && !empty($item['banner_image'])):
                            $path = $item['banner_image'];
                            if (preg_match('#^https?://#i', $path)) {
                                $previewPath = $path;
                            } elseif (strpos($path, '/') !== false) {
                                $previewPath = BASE_URL . '/' . ltrim($path, './');
                            } else {
                                // Fallback logic for legacy filenames in banner form
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
                            <div class="mt-3 table-img-wrapper" style="width: 300px; height: 180px;">
                                <img src="<?= $previewPath ?>" alt="Banner Preview" style="object-fit: cover; width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/banners" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Save Banner' : 'Update Banner' ?>
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
