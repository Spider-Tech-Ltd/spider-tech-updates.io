<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Program Applications</h1>
            <p>Review and manage submissions for bootcamps and trainings.</p>
        </div>
    </div>
</div>

<div class="admin-card mb-5">
    <div class="card-header-custom">
        <h5 class="m-0 poppins">DSE Applications</h5>
    </div>
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Business Name</th>
                        <th>Sector</th>
                        <th>Applied On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dse_apps as $app): ?>
                    <tr>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($app['firstname'] . ' ' . $app['lastname']) ?></div>
                            <div class="text-muted fs-08"><?= htmlspecialchars($app['email']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($app['business_name']) ?></td>
                        <td><span class="badge badge-soft-blue"><?= htmlspecialchars($app['business_sector']) ?></span></td>
                        <td><?= date('M d, Y', strtotime($app['apply_date'])) ?></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit" title="View Full Details"><span class="material-symbols-outlined">description</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-header-custom">
        <h5 class="m-0 poppins">Bootcamp Applications</h5>
    </div>
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Reason</th>
                        <th>Applied On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bootcamp_apps as $app): ?>
                    <tr>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($app['firstname'] . ' ' . $app['lastname']) ?></div>
                            <div class="text-muted fs-08"><?= htmlspecialchars($app['email']) ?></div>
                        </td>
                        <td><span class="text-muted fs-08"><?= htmlspecialchars(substr($app['reason'], 0, 60)) ?>...</span></td>
                        <td><?= date('M d, Y', strtotime($app['apply_date'])) ?></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit" title="View Full Details"><span class="material-symbols-outlined">description</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
