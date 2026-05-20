<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/services" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Service</h1>
            <p><?= ($mode == 'add') ? 'Create a new service offering for the website.' : 'Update existing service details.' ?></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'service', 'serviceRedirect')">
                    <input type="hidden" name="type" value="service">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Service Name</label>
                        <input type="text" name="service_name" class="form-control-custom" value="<?= $item['service_name'] ?? '' ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Icon Class (FontAwesome)</label>
                        <input type="text" name="service_icon" class="form-control-custom" value="<?= $item['service_icon'] ?? '' ?>" placeholder="fas fa-laptop-code" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Summary (Short Description)</label>
                        <textarea name="service_description" class="form-control-custom" rows="3" required><?= $item['service_description'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Full Details (HTML)</label>
                        <textarea name="service_detail" class="form-control-custom" rows="8"><?= $item['service_detail'] ?? '' ?></textarea>
                    </div>

                    <hr class="my-4 opacity-05">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= BASE_URL ?>/admin/services" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Create Service' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function serviceRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/services';
}
</script>
