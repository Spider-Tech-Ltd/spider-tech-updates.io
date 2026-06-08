<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Service Management</h1>
            <p>Manage the list of services offered by Spider Tech.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/services/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Service</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><i class="<?= $service['service_icon'] ?> fa-2x text-orange"></i></td>
                        <td><span class="fw-600"><?= htmlspecialchars($service['service_name']) ?></span></td>
                        <td><span class="text-muted fs-09"><?= htmlspecialchars(substr(strip_tags($service['service_description']), 0, 100)) ?>...</span></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/services/edit/<?= $service['id'] ?>" class="btn-action edit" title="Edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" title="Delete" onclick="deleteItem(<?= $service['id'] ?>, 'service')"><span class="material-symbols-outlined">delete</span></button>
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
