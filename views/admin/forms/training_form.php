<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/trainings" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Training</h1>
            <p>Manage the training programs and educational sessions.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'training', 'trainingRedirect')">
                    <input type="hidden" name="type" value="training">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Name</label>
                        <input type="text" name="training_name" class="form-control-custom" value="<?= $item['training_name'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Icon Class</label>
                            <input type="text" name="training_icon" class="form-control-custom" value="<?= $item['training_icon'] ?? 'fas fa-graduation-cap' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Show on Home</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="show_on_home" value="0">
                                <input type="checkbox" name="show_on_home" value="1" <?= (!isset($item) || $item['show_on_home']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Feature on homepage</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Display Order</label>
                        <input type="number" name="sort_order" class="form-control-custom" value="<?= $item['sort_order'] ?? 0 ?>" min="0">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary</label>
                        <textarea name="training_description" class="form-control-custom" rows="3" required><?= $item['training_description'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Cover Image</label>
                        <input type="file" name="training_image" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if ($mode == 'edit' && $item['training_image']): ?>
                            <div class="mt-3 table-img-wrapper" style="width: 150px; height: 100px;">
                                <img src="<?= str_replace('../', BASE_URL . '/', $item['training_image']) ?>" alt="">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Details (HTML)</label>
                        <textarea name="training_details" class="form-control-custom" rows="8"><?= $item['training_details'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/trainings" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Create Training' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function trainingRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/trainings';
}
</script>
