<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/trainings" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Training</h1>
            <p>Manage the training programs and educational sessions.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
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

                    <div class="mb-4">
                        <label class="form-label-custom">Icon Class</label>
                        <input type="text" name="training_icon" class="form-control-custom" value="<?= $item['training_icon'] ?? 'fas fa-graduation-cap' ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary</label>
                        <textarea name="training_description" class="form-control-custom" rows="3" required><?= $item['training_description'] ?? '' ?></textarea>
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
