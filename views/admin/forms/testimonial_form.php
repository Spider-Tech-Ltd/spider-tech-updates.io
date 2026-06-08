<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/testimonials" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Testimonial</h1>
            <p>Manage client feedback and stories.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'testimonial', 'testimonialRedirect')" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="testimonial">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Client Name</label>
                        <input type="text" name="name" class="form-control-custom" value="<?= $item['name'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Organization</label>
                            <input type="text" name="organization" class="form-control-custom" value="<?= $item['organization'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Job Title / Role</label>
                            <input type="text" name="title" class="form-control-custom" value="<?= $item['title'] ?? '' ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Client Photo</label>
                        <input type="file" name="image" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Testimonial Content</label>
                        <textarea name="testimonial" class="form-control-custom" rows="6" required><?= $item['testimonial'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/testimonials" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Save Testimonial' : 'Update Testimonial' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function testimonialRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/testimonials';
}
</script>
