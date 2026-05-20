<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/projects" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Project</h1>
            <p>Manage the project portfolio entries.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'project', 'projectRedirect')">
                    <input type="hidden" name="type" value="project">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['project_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Project Name</label>
                        <input type="text" name="project_name" class="form-control-custom" value="<?= $item['project_name'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Category / Service</label>
                            <select name="service_id" class="form-control-custom" required>
                                <option value="">Select Service</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= $service['id'] ?>" <?= (isset($item) && $item['service_id'] == $service['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($service['service_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Year</label>
                            <input type="number" name="project_year" class="form-control-custom" value="<?= $item['project_year'] ?? date('Y') ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Project Image</label>
                        <input type="file" name="project_pic" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if ($mode == 'edit' && $item['project_pic']): ?>
                            <div class="mt-2 text-muted fs-08">Current: <?= $item['project_pic'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Description (HTML Supported)</label>
                        <textarea name="project_description" class="form-control-custom" rows="8"><?= $item['project_description'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/projects" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Add Project' : 'Update Project' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function projectRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/projects';
}
</script>
