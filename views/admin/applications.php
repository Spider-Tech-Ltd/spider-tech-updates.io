<div class="content-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Program Applications</h1>
            <p>Review and manage dynamic training registrations.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <label class="fw-600 fs-09 text-muted d-none d-md-block">Filter by Program:</label>
            <select class="form-control-custom" style="width: 250px;" onchange="location.href='<?= BASE_URL ?>/admin/applications?program=' + this.value">
                <option value="all" <?= $current_program === 'all' ? 'selected' : '' ?>>All Programs</option>
                <?php foreach ($programs as $prog): ?>
                    <option value="<?= $prog['id'] ?>" <?= (string)$current_program === (string)$prog['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prog['training_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Applicant</th>
                        <th>Program</th>
                        <th>Phone</th>
                        <th>Applied On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">No applications found for the selected criteria.</div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php
                        $i = ($pagination['current_page'] - 1) * 10 + 1;
                        foreach ($applications as $app):
                            $userData = json_decode($app['user_data'], true);
                            // Extract name - handle different possible keys
                            $firstName = $userData['firstname'] ?? $userData['first_name'] ?? '';
                            $lastName = $userData['lastname'] ?? $userData['last_name'] ?? '';
                            $fullName = $userData['full_name'] ?? $userData['name'] ?? trim($firstName . ' ' . $lastName);
                            $email = $userData['email'] ?? $userData['email_address'] ?? 'N/A';
                            $phone = $userData['phone'] ?? $userData['phone_no'] ?? $userData['phone_number'] ?? 'N/A';
                        ?>
                        <tr>
                            <td class="text-muted fs-08"><?= $i++ ?></td>
                            <td>
                                <div class="fw-600"><?= htmlspecialchars($fullName) ?></div>
                                <div class="text-muted fs-08"><?= htmlspecialchars($email) ?></div>
                            </td>
                            <td>
                                <?php
                                    $pName = strtolower($app['program_name'] ?? '');
                                    $badgeClass = 'badge-soft-muted';
                                    if (strpos($pName, 'dse') !== false) $badgeClass = 'badge-soft-orange';
                                    elseif (strpos($pName, 'jobberman') !== false) $badgeClass = 'badge-soft-blue';
                                    elseif (strpos($pName, 'we code') !== false) $badgeClass = 'badge-soft-yellow';
                                    elseif (strpos($pName, 'bootcamp') !== false) $badgeClass = 'badge-soft-green';
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= htmlspecialchars($app['program_name'] ?: 'Unknown Program') ?>
                                </span>
                            </td>
                            <td><span class="fs-09"><?= htmlspecialchars($phone) ?></span></td>
                            <td><?= date('M d, Y', strtotime($app['created_at'])) ?></td>
                            <td class="text-end">
                                <div class="action-btns">
                                    <button class="btn-action edit" title="View Full Details" onclick="showRegistrationDetails(<?= htmlspecialchars(json_encode($userData)) ?>)">
                                        <span class="material-symbols-outlined">description</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
        </div>
    </div>
</div>

<!-- Modal for Registration Details -->
<div id="detailsModal" class="modal-custom">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="m-0 poppins">Application Details</h5>
            <button class="btn-action" onclick="closeDetailsModal()"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div class="modal-body-custom" id="detailsContent">
            <!-- Content dynamicly loaded -->
        </div>
        <div class="modal-footer-custom">
            <button class="btn btn-light px-4" onclick="closeDetailsModal()">Close</button>
        </div>
    </div>
</div>

<script>
function showRegistrationDetails(data) {
    let content = '<div class="row g-3">';
    for (let key in data) {
        if (data.hasOwnProperty(key)) {
            let label = key.replace(/_/g, ' ').toUpperCase();
            let value = data[key];

            // Check if value is a path to an image/file
            if (typeof value === 'string' && (value.endsWith('.jpg') || value.endsWith('.png') || value.endsWith('.jpeg') || value.endsWith('.pdf'))) {
                let baseUrl = '<?= BASE_URL ?>/';
                let fullUrl = value.startsWith('http') ? value : baseUrl + value.replace(/^\.\.\//, '');
                value = `<a href="${fullUrl}" target="_blank" class="text-orange fw-600">View File <span class="material-symbols-outlined fs-14 v-align-middle">open_in_new</span></a>`;
            }

            content += `
                <div class="col-md-6 border-bottom pb-2">
                    <label class="text-muted fs-07 fw-700 d-block">${label}</label>
                    <div class="fs-09">${value}</div>
                </div>
            `;
        }
    }
    content += '</div>';
    document.getElementById('detailsContent').innerHTML = content;
    document.getElementById('detailsModal').classList.add('show');
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('show');
}

// Close modal when clicking outside
window.onclick = function(event) {
    let modal = document.getElementById('detailsModal');
    if (event.target == modal) {
        closeDetailsModal();
    }
}
</script>
