<div class="content-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Program Applications</h1>
            <p>Review and manage submissions for bootcamps and trainings.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <label class="fw-600 fs-09 text-muted d-none d-md-block">Filter by Program:</label>
            <select class="form-control-custom" style="width: 200px;" onchange="location.href='<?= BASE_URL ?>/admin/applications?program=' + this.value">
                <option value="all" <?= $current_program === 'all' ? 'selected' : '' ?>>All Programs</option>
                <option value="DSE" <?= $current_program === 'DSE' ? 'selected' : '' ?>>DSE Program</option>
                <option value="Bootcamp" <?= $current_program === 'Bootcamp' ? 'selected' : '' ?>>Bootcamp</option>
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
                        <th>Applicant</th>
                        <th>Program</th>
                        <th>Business Name</th>
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
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td>
                                <div class="fw-600"><?= htmlspecialchars($app['firstname'] . ' ' . $app['lastname']) ?></div>
                                <div class="text-muted fs-08"><?= htmlspecialchars($app['email']) ?></div>
                            </td>
                            <td>
                                <span class="badge <?= $app['program'] === 'DSE' ? 'badge-soft-blue' : 'badge-soft-purple' ?>">
                                    <?= htmlspecialchars($app['program']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($app['business_name'] ?: 'N/A') ?></td>
                            <td><?= date('M d, Y', strtotime($app['apply_date'])) ?></td>
                            <td class="text-end">
                                <div class="action-btns">
                                    <button class="btn-action edit" title="View Full Details" onclick="showToast('Feature coming soon!')">
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
