<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/blog" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Blog Post</h1>
            <p>Publish and manage articles and insights.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'blog', 'blogRedirect')" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="blog">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['uuid'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Article Title</label>
                        <input type="text" name="title" class="form-control-custom" value="<?= $item['title'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Category</label>
                            <select name="category_id" class="form-control-custom" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['uuid'] ?>" <?= (isset($item) && $item['category_id'] == $cat['uuid']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Status</label>
                            <select name="status" class="form-control-custom" required>
                                <option value="Published" <?= (isset($item) && $item['status'] == 'Published') ? 'selected' : '' ?>>Published</option>
                                <option value="Draft" <?= (isset($item) && $item['status'] == 'Draft') ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Summary (Meta Description)</label>
                        <textarea name="summary" class="form-control-custom" rows="3" required><?= $item['summary'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Content (HTML)</label>
                        <textarea name="content" class="form-control-custom" rows="15" required><?= $item['content'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/blog" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Publish Post' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function blogRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/blog';
}
</script>
