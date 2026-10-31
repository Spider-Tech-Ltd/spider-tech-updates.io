<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/testimonials" class="btn-action btn-back-header me-3 mr-3" title="Back"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Testimonial</h1>
            <p>Manage client feedback, endorsements, and executive success stories.</p>
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
                        <input type="text" name="name" class="form-control-custom" value="<?= $item['name'] ?? '' ?>" placeholder="e.g. Dr. Nasir Wali" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Organization / Institution</label>
                            <input type="text" name="organization" class="form-control-custom" value="<?= $item['organization'] ?? '' ?>" placeholder="e.g. SRCOE" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Job Title / Role</label>
                            <input type="text" name="title" class="form-control-custom" value="<?= $item['title'] ?? '' ?>" placeholder="e.g. ICT Director, CEO" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Client Portrait Photo</label>
                        <?php if (!empty($item['image'])): 
                            $rawImg = ltrim(str_replace('../', '', $item['image']), '/');
                        ?>
                            <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded bg-light border">
                                <img src="<?= BASE_URL . '/' . $rawImg ?>" alt="" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0;">
                                <div>
                                    <span class="fs-08 fw-600 text-dark d-block">Current Portrait</span>
                                    <span class="fs-07 text-muted">Upload a new image below only if you wish to change it</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Testimonial Endorsement Statement</label>
                        <textarea name="testimonial" class="form-control-custom" rows="6" placeholder="Enter client feedback, quote, or review..." required><?= $item['testimonial'] ?? '' ?></textarea>
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
