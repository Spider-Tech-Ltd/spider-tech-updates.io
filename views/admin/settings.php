<div class="content-header">
    <h1>System Settings</h1>
    <p>Manage administrative accounts and global site configuration.</p>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">Admin Accounts</h5>
                <button class="btn btn-primary-custom btn-sm-custom">Add Admin</button>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $adm): ?>
                            <tr>
                                <td><span class="fw-600"><?= htmlspecialchars($adm['admin_name']) ?></span></td>
                                <td><span class="badge badge-soft-blue"><?= $adm['privilege'] ?: 'Admin' ?></span></td>
                                <td class="text-muted fs-08"><?= $adm['lastlogin'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">Site Configuration</h5>
            </div>
            <div class="card-body-custom">
                <form>
                    <div class="mb-3">
                        <label class="form-label fw-600 fs-09">Site Title</label>
                        <input type="text" class="form-control" value="Spider Technologies">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600 fs-09">Contact Email</label>
                        <input type="email" class="form-control" value="info@spidertech.com.ng">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600 fs-09">Maintenance Mode</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="maintenanceSwitch">
                            <label class="form-check-label text-muted fs-08" for="maintenanceSwitch">Disable public access to the website</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary-custom w-100 mt-3" onclick="showToast('Settings saved successfully!')">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
