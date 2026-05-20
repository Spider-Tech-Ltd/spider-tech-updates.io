<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Service Management</h1>
            <p>Manage the list of services offered by Spider Tech.</p>
        </div>
        <button class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Service</span>
        </button>
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
                                <button class="btn-action edit" title="Edit"><span class="material-symbols-outlined">edit</span></button>
                                <button class="btn-action delete" title="Delete"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
