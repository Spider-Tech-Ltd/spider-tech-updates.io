<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Client Testimonials</h1>
            <p>Manage feedback from our valued clients and partners.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/testimonials/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Testimonial</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Testimonial</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($testimonials as $testimonial):
                        $imagePath = str_replace('../', BASE_URL . '/', $testimonial['image']);
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= $imagePath ?>" class="avatar-sm" alt="">
                                <div>
                                    <div class="fw-600"><?= htmlspecialchars($testimonial['name']) ?></div>
                                    <div class="text-muted fs-08"><?= htmlspecialchars($testimonial['organization']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted fs-09"><?= htmlspecialchars(substr($testimonial['testimonial'], 0, 100)) ?>...</span></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/testimonials/edit/<?= $testimonial['id'] ?>" class="btn-action edit" title="Edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" title="Delete" onclick="deleteItem(<?= $testimonial['id'] ?>, 'testimonial')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
    </div>
</div>
