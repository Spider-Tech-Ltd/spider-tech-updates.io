<div class="content-header">
    <h1>System Settings</h1>
    <p>Manage administrative accounts and global site configuration.</p>
</div>

<div class="row g-4" x-data="settingsPage">
    <!-- My Profile Section -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">My Profile</h5>
            </div>
            <div class="card-body-custom">
                <form @submit.prevent="updateProfile" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img :src="profilePreview || '<?= !empty($currentAdmin['profile_pic']) ? BASE_URL . '/' . ltrim($currentAdmin['profile_pic'], './') : BASE_URL . '/img/member_dp.jpg' ?>'"
                                 class="rounded-circle border"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                            <label for="profilePic" class="btn btn-sm btn-primary-custom position-absolute bottom-0 end-0 rounded-circle p-2" style="width: 35px; height: 35px;">
                                <span class="material-symbols-outlined fs-1rem">edit</span>
                            </label>
                            <input type="file" id="profilePic" name="profile_pic" class="d-none" @change="previewImage" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Display Name</label>
                        <input type="text" name="admin_name" class="form-control-custom" value="<?= htmlspecialchars($currentAdmin['admin_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">New Password (Leave blank to keep current)</label>
                        <div class="input-group-custom">
                            <input :type="showPassword ? 'text' : 'password'" name="new_password" x-model="password" class="form-control-custom" placeholder="Enter new password">
                            <span class="password-toggle" @click="showPassword = !showPassword">
                                <span class="material-symbols-outlined fs-1rem" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Confirm New Password</label>
                        <div class="input-group-custom">
                            <input :type="showConfirmPassword ? 'text' : 'password'" x-model="confirmPassword" class="form-control-custom" placeholder="Confirm new password">
                            <span class="password-toggle" @click="showConfirmPassword = !showConfirmPassword">
                                <span class="material-symbols-outlined fs-1rem" x-text="showConfirmPassword ? 'visibility_off' : 'visibility'"></span>
                            </span>
                        </div>
                        <template x-if="password && confirmPassword && password !== confirmPassword">
                            <small class="text-danger">Passwords do not match</small>
                        </template>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 mt-3" :disabled="loading || (password && password !== confirmPassword)">
                        <span x-show="!loading">Update Profile</span>
                        <span x-show="loading">Updating...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">Social Media Handles</h5>
            </div>
            <div class="card-body-custom">
                <form @submit.prevent="updateSocial">
                    <?php foreach ($socialLinks as $link): ?>
                    <div class="mb-3">
                        <label class="form-label-custom">
                            <i class="<?= $link['icon_class'] ?> me-2 text-orange"></i>
                            <?= $link['platform'] ?>
                        </label>
                        <input type="url" name="links[<?= $link['platform'] ?>]" class="form-control-custom" value="<?= htmlspecialchars($link['url']) ?>" placeholder="https://...">
                    </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary-custom w-100 mt-3" :disabled="loadingSocial">
                        <span x-show="!loadingSocial">Save Social Links</span>
                        <span x-show="loadingSocial">Saving...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin Accounts Section -->
    <div class="col-lg-12 mt-4">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">Manage Administrators</h5>
                <button class="btn btn-primary-custom btn-sm-custom">Add New Admin</button>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($admins) && is_array($admins)): ?>
                                <?php foreach ($admins as $adm): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?= !empty($adm['profile_pic']) ? BASE_URL . '/' . ltrim($adm['profile_pic'], './') : BASE_URL . '/img/member_dp.jpg' ?>"
                                                 class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                            <span class="fw-600"><?= htmlspecialchars($adm['admin_name'] ?? 'N/A') ?></span>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-soft-blue"><?= ($adm['privilege'] ?? '') ?: 'Admin' ?></span></td>
                                    <td class="text-muted fs-08"><?= $adm['lastlogin'] ?? 'Never' ?></td>
                                    <td class="text-end">
                                        <?php if ($adm['admin_id'] != $_SESSION['admin_id']): ?>
                                            <button class="btn-action delete" onclick="deleteItem(<?= $adm['admin_id'] ?>, 'admin')">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4">No admin accounts found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsPage', () => ({
        loading: false,
        loadingSocial: false,
        profilePreview: null,
        showPassword: false,
        showConfirmPassword: false,
        password: '',
        confirmPassword: '',

        previewImage(e) {
            const file = e.target.files[0];
            if (file) {
                this.profilePreview = URL.createObjectURL(file);
            }
        },

        async updateProfile(e) {
            if (this.password && this.password !== this.confirmPassword) {
                showToast('Passwords do not match', 'error');
                return;
            }
            this.loading = true;
            const formData = new FormData(e.target);

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/settings/update-profile', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                showToast('An unexpected error occurred.', 'error');
            } finally {
                this.loading = false;
            }
        },

        async updateSocial(e) {
            this.loadingSocial = true;
            const formData = new FormData(e.target);

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/settings/update-social', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message);
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                showToast('An unexpected error occurred.', 'error');
            } finally {
                this.loadingSocial = false;
            }
        }
    }));
});
</script>
