<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Service Management</h1>
            <p>Manage the list of services offered by Spider Tech.</p>
        </div>
        <button class="btn btn-primary-custom" onclick="openModal('serviceModal')">
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
                                <button class="btn-action delete" title="Delete" onclick="deleteItem(<?= $service['id'] ?>, 'service')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Service Modal -->
<div class="modal-custom" id="serviceModal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="poppins m-0">Service Details</h5>
            <button class="btn-action" onclick="closeModal('serviceModal')"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="serviceForm" onsubmit="submitForm(event, 'service', 'serviceModal')">
            <input type="hidden" name="type" value="service">
            <div class="modal-body-custom">
                <div class="mb-3">
                    <label class="form-label-custom">Service Name</label>
                    <input type="text" name="service_name" class="form-control-custom" placeholder="e.g. Software Development" required>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Service Icon (FontAwesome class)</label>
                    <input type="text" name="service_icon" class="form-control-custom" placeholder="e.g. fas fa-laptop-code" required>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Short Description</label>
                    <textarea name="service_description" class="form-control-custom" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Full Details (HTML supported)</label>
                    <textarea name="service_detail" class="form-control-custom" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-light" onclick="closeModal('serviceModal')">Cancel</button>
                <button type="submit" class="btn btn-primary-custom">Save Service</button>
            </div>
        </form>
    </div>
</div>
