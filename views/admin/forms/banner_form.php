<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/banners" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Banner</h1>
            <p>Manage the homepage hero section carousel.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'banner', 'bannerRedirect')">
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
                        <?php if ($mode == 'edit' && $item['banner_image']): ?>
                            <div class="mt-3 table-img-wrapper" style="width: 200px; height: 120px;">
                                <img src="<?= BASE_URL ?>/images/pictures/<?= $item['banner_image'] ?>" alt="">
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
