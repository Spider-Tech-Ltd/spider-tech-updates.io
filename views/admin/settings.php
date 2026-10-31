<?php
// views/admin/settings.php
$currentTab = !empty($_GET['tab']) ? htmlspecialchars($_GET['tab']) : 'profile';
if (!in_array($currentTab, ['profile', 'social', 'admins'])) {
    $currentTab = 'profile';
}

$defaultAvatar = !empty($currentAdmin['profile_pic']) && file_exists(ROOT_PATH . '/' . ltrim($currentAdmin['profile_pic'], './')) 
    ? BASE_URL . '/' . ltrim($currentAdmin['profile_pic'], './') 
    : BASE_URL . '/img/admin-avatar.svg';
?>

<style>
/* Scoped Settings Form & Icon Input Refinements */
.settings-form .input-icon-wrapper {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
}

.settings-form .input-icon-wrapper .form-control-custom {
    width: 100% !important;
    height: 42px !important;
    padding: 8px 42px 8px 14px !important;
    border-radius: 8px !important;
    border: 1.5px solid #e2e8f0 !important;
    font-size: 0.88rem !important;
    transition: all 0.18s ease !important;
}

.settings-form .input-icon-wrapper .form-control-custom:focus {
    border-color: #f48221 !important;
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.12) !important;
    outline: none !important;
}

.settings-form .input-icon-wrapper .form-control-custom.bg-light {
    background-color: #f8fafc !important;
    border-color: #e2e8f0 !important;
    color: #64748b !important;
}

.settings-form .input-icon-wrapper .input-icon-right {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    pointer-events: none;
    line-height: 1;
}

.settings-form .input-icon-wrapper .password-toggle-btn {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: transparent;
    border: none;
    padding: 0;
    color: #94a3b8;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.15s ease;
    line-height: 1;
}

.settings-form .input-icon-wrapper .password-toggle-btn:hover {
    color: #0f172a;
    background-color: #f1f5f9;
}

.settings-form .form-label-custom {
    font-weight: 600;
    font-size: 0.82rem;
    color: #1e293b;
    margin-bottom: 6px;
    display: block;
}
</style>

<script>
function settingsPage() {
    return {
        activeTab: '<?= $currentTab ?>',
        defaultPic: '<?= $defaultAvatar ?>',
        loading: false,
        loadingSocial: false,
        profilePreview: null,
        showPassword: false,
        showConfirmPassword: false,
        password: '',
        confirmPassword: '',

        // Add Admin Modal State
        openAddModal: false,
        isSubmittingAdmin: false,
        showNewAdminPassword: false,
        newAdmin: {
            name: '',
            privilege: 'Admin',
            password: '',
            confirmPassword: ''
        },

        // Social links data dictionary
        socialLinks: {
            <?php foreach ($socialLinks as $link): ?>
            '<?= addslashes($link['platform']) ?>': '<?= addslashes($link['url']) ?>',
            <?php endforeach; ?>
        },

        switchTab(tab) {
            this.activeTab = tab;
            try {
                const u = new URL(window.location);
                u.searchParams.set('tab', tab);
                window.history.replaceState({}, '', u);
            } catch (e) {}
        },

        previewImage(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    showToast('Image size exceeds 5MB limit.', 'error');
                    e.target.value = '';
                    return;
                }
                this.profilePreview = URL.createObjectURL(file);
            }
        },

        resetPhotoPreview() {
            this.profilePreview = null;
            const fileInput = document.getElementById('profilePicInput');
            if (fileInput) fileInput.value = '';
        },

        testLink(url) {
            if (!url || !url.trim()) {
                showToast('Please enter a valid URL first.', 'error');
                return;
            }
            let validUrl = url.trim();
            if (!/^https?:\/\//i.test(validUrl)) {
                validUrl = 'https://' + validUrl;
            }
            window.open(validUrl, '_blank', 'noopener,noreferrer');
        },

        generateRandomPassword() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%';
            let pwd = '';
            for (let i = 0; i < 12; i++) {
                pwd += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            this.newAdmin.password = pwd;
            this.newAdmin.confirmPassword = pwd;
            this.showNewAdminPassword = true;
            showToast('Generated secure temporary password');
        },

        async updateProfile(e) {
            if (this.password && this.password !== this.confirmPassword) {
                showToast('Passwords do not match.', 'error');
                return;
            }
            this.loading = true;
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/settings/update-profile', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message);
                    this.password = '';
                    this.confirmPassword = '';
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                showToast('An unexpected error occurred while saving profile.', 'error');
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
                showToast('An unexpected error occurred while saving social links.', 'error');
            } finally {
                this.loadingSocial = false;
            }
        },

        async createAdmin() {
            if (this.newAdmin.password !== this.newAdmin.confirmPassword) {
                showToast('Passwords do not match.', 'error');
                return;
            }
            if (this.newAdmin.password.length < 6) {
                showToast('Password must be at least 6 characters long.', 'error');
                return;
            }

            this.isSubmittingAdmin = true;
            const formData = new FormData();
            formData.append('admin_name', this.newAdmin.name);
            formData.append('privilege', this.newAdmin.privilege);
            formData.append('admin_password', this.newAdmin.password);

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/settings/create-admin', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message);
                    this.openAddModal = false;
                    this.newAdmin = { name: '', privilege: 'Admin', password: '', confirmPassword: '' };
                    setTimeout(() => {
                        const u = new URL(window.location);
                        u.searchParams.set('tab', 'admins');
                        window.location.href = u.toString();
                    }, 800);
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                showToast('Failed to create administrator account.', 'error');
            } finally {
                this.isSubmittingAdmin = false;
            }
        },

        deleteAdminAccount(id, name) {
            if (window.Alpine && Alpine.store('actionModal')) {
                Alpine.store('actionModal').show({
                    id: id,
                    type: 'admin',
                    title: 'Delete Administrator',
                    message: `Are you sure you want to remove administrator "${name}"? This account will permanently lose access to the system.`,
                    confirmText: 'Yes, Remove Admin',
                    variant: 'danger',
                    icon: 'warning',
                    actionUrl: '<?= BASE_URL ?>/admin/delete'
                });
            } else {
                deleteItem(id, 'admin');
            }
        }
    };
}
</script>

<div x-data="settingsPage()" class="settings-form">

    <!-- Dashboard Header with Segmented Tab Switcher -->
    <div class="dashboard-header mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="dashboard-title">System Settings</h1>
                <p class="dashboard-subtitle">Manage administrative privileges, profile credentials, and global brand touchpoints.</p>
            </div>

            <!-- Segmented View Mode Tabs -->
            <div class="d-inline-flex p-1 bg-white border shadow-xs" style="border-radius: 50px !important; border-color: #e2e8f0 !important;">
                <button type="button" 
                        class="btn btn-sm px-3 py-1-5 fw-600 d-inline-flex align-items-center gap-2 border-0" 
                        :class="activeTab === 'profile' ? 'btn-primary-custom' : 'bg-transparent text-muted'"
                        @click="switchTab('profile')"
                        style="border-radius: 50px !important; font-size: 0.82rem; transition: all 0.15s ease;">
                    <span class="material-symbols-outlined fs-16">person</span>
                    <span>Profile & Security</span>
                </button>
                <button type="button" 
                        class="btn btn-sm px-3 py-1-5 fw-600 d-inline-flex align-items-center gap-2 border-0" 
                        :class="activeTab === 'social' ? 'btn-primary-custom' : 'bg-transparent text-muted'"
                        @click="switchTab('social')"
                        style="border-radius: 50px !important; font-size: 0.82rem; transition: all 0.15s ease;">
                    <span class="material-symbols-outlined fs-16">share</span>
                    <span>Social Channels</span>
                    <span class="badge" :class="activeTab === 'social' ? 'bg-white text-dark' : 'bg-light text-muted'" style="border-radius: 50px !important; font-size: 0.7rem; padding: 2px 7px;">
                        <?= count($socialLinks) ?>
                    </span>
                </button>
                <button type="button" 
                        class="btn btn-sm px-3 py-1-5 fw-600 d-inline-flex align-items-center gap-2 border-0" 
                        :class="activeTab === 'admins' ? 'btn-primary-custom' : 'bg-transparent text-muted'"
                        @click="switchTab('admins')"
                        style="border-radius: 50px !important; font-size: 0.82rem; transition: all 0.15s ease;">
                    <span class="material-symbols-outlined fs-16">admin_panel_settings</span>
                    <span>Admin Team</span>
                    <span class="badge" :class="activeTab === 'admins' ? 'bg-white text-dark' : 'bg-light text-muted'" style="border-radius: 50px !important; font-size: 0.7rem; padding: 2px 7px;">
                        <?= count($admins) ?>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- ====================================================
         TAB 1: ACCOUNT PROFILE & SECURITY CREDENTIALS
         ==================================================== -->
    <div x-show="activeTab === 'profile'" x-cloak>
        <div class="row g-4">
            <!-- Left Column: Identity Dossier Card -->
            <div class="col-lg-4 col-md-5">
                <div class="admin-card h-100">
                    <div class="card-header-custom py-3 px-4 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-orange fs-20">badge</span>
                            <h5 class="m-0 fw-700 text-dark" style="font-size: 0.95rem; font-family: 'Poppins', sans-serif;">Identity Profile</h5>
                        </div>
                    </div>
                    <div class="card-body-custom p-4 text-center">
                        <!-- Modern Avatar Container with Ring -->
                        <div class="position-relative d-inline-block mb-3">
                            <div class="rounded-circle p-1" style="background: linear-gradient(135deg, rgba(244, 130, 33, 0.4) 0%, rgba(244, 130, 33, 0.08) 100%);">
                                <img :src="profilePreview || defaultPic"
                                     class="rounded-circle bg-white"
                                     alt="Admin Avatar"
                                     style="width: 90px; height: 90px; object-fit: cover; border: 2px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                            </div>
                        </div>

                        <!-- Name & Privilege Badges -->
                        <h4 class="fw-700 text-dark mb-1" style="font-size: 1.15rem; font-family: 'Poppins', sans-serif;">
                            <?= htmlspecialchars($currentAdmin['admin_name'] ?? 'Admin') ?>
                        </h4>
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                            <span class="badge badge-status-pill <?= (($currentAdmin['privilege'] ?? '') === 'Super Admin') ? 'badge-soft-orange' : 'badge-soft-blue' ?>">
                                <?= htmlspecialchars(($currentAdmin['privilege'] ?? '') ?: 'Administrator') ?>
                            </span>
                            <span class="badge badge-soft-muted text-muted" style="border-radius: 50px; font-size: 0.72rem; padding: 3px 8px;">
                                #ADM-<?= str_pad((string)($currentAdmin['admin_id'] ?? 1), 3, '0', STR_PAD_LEFT) ?>
                            </span>
                        </div>

                        <!-- Photo Trigger -->
                        <div class="mb-4">
                            <label for="profilePicInput" class="btn btn-sm btn-light border px-3 py-1-5 fw-600 d-inline-flex align-items-center gap-2" style="font-size: 0.78rem; border-radius: 50px !important; cursor: pointer;">
                                <span class="material-symbols-outlined fs-16 text-muted">photo_camera</span>
                                <span>Change Photo</span>
                            </label>
                            <template x-if="profilePreview">
                                <button type="button" @click="resetPhotoPreview" class="btn btn-sm text-danger border-0 bg-transparent p-0 ms-2" style="font-size: 0.75rem; text-decoration: underline;">
                                    Reset
                                </button>
                            </template>
                        </div>

                        <hr class="my-3" style="border-color: #f1f5f9;">

                        <!-- Metadata Dossier List -->
                        <div class="text-start" style="font-size: 0.82rem;">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: #f8fafc !important;">
                                <span class="text-muted d-inline-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-15 text-muted">schedule</span>
                                    <span>Last Active</span>
                                </span>
                                <span class="fw-600 text-dark">
                                    <?= !empty($currentAdmin['lastlogin']) && $currentAdmin['lastlogin'] !== '0000-00-00 00:00:00' 
                                        ? date('M d, Y - h:i A', strtotime($currentAdmin['lastlogin'])) 
                                        : 'Active Now' ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color: #f8fafc !important;">
                                <span class="text-muted d-inline-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-15 text-muted">verified_user</span>
                                    <span>Session State</span>
                                </span>
                                <span class="badge badge-soft-green d-inline-flex align-items-center gap-1" style="border-radius: 50px; font-size: 0.72rem; padding: 2px 8px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                    <span>Authenticated</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted d-inline-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-15 text-muted">security</span>
                                    <span>Access Control</span>
                                </span>
                                <span class="text-dark fw-600">Full Dashboard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile & Password Form Card -->
            <div class="col-lg-8 col-md-7">
                <div class="admin-card">
                    <div class="card-header-custom py-3 px-4 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-orange fs-20">manage_accounts</span>
                            <div>
                                <h5 class="m-0 fw-700 text-dark" style="font-size: 0.95rem; font-family: 'Poppins', sans-serif;">Account Credentials & Security</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-custom p-4">
                        <form @submit.prevent="updateProfile" enctype="multipart/form-data" id="profileForm">
                            <!-- Hidden File Input linked to Dossier Trigger -->
                            <input type="file" id="profilePicInput" name="profile_pic" class="d-none" @change="previewImage" accept="image/*">

                            <!-- Section 1: Basic Information -->
                            <div class="mb-3">
                                <h6 class="text-muted text-uppercase fw-700 mb-3" style="font-size: 0.72rem; letter-spacing: 0.05em;">Basic Account Details</h6>
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label-custom">Admin Display Name <span class="text-danger">*</span></label>
                                        <div class="input-icon-wrapper">
                                            <input type="text" name="admin_name" class="form-control-custom" value="<?= htmlspecialchars($currentAdmin['admin_name']) ?>" required placeholder="e.g. Alex Johnson">
                                            <span class="input-icon-right">
                                                <span class="material-symbols-outlined fs-18">person</span>
                                            </span>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.74rem;">Visible across administrative logs and published author marks.</small>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label-custom">Assigned Privilege Role</label>
                                        <div class="input-icon-wrapper">
                                            <input type="text" class="form-control-custom bg-light" value="<?= htmlspecialchars(($currentAdmin['privilege'] ?? '') ?: 'Administrator') ?>" readonly style="cursor: not-allowed; color: #475569;">
                                            <span class="input-icon-right">
                                                <span class="material-symbols-outlined fs-18">lock</span>
                                            </span>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.74rem;">Role permissions are restricted by system root.</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3" style="border-color: #f1f5f9;">

                            <!-- Section 2: Security & Password -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted text-uppercase fw-700 m-0" style="font-size: 0.72rem; letter-spacing: 0.05em;">Password Security</h6>
                                    <span class="badge badge-soft-muted text-muted" style="font-size: 0.7rem; font-weight: 500;">Optional</span>
                                </div>

                                <!-- Security Notice Callout -->
                                <div class="p-2-5 px-3 mb-3 rounded-3 border d-flex align-items-start gap-2" style="background: #f8fafc; border-color: #e2e8f0 !important; font-size: 0.8rem; color: #475569;">
                                    <span class="material-symbols-outlined text-orange fs-18 flex-shrink-0" style="margin-top: 1px;">info</span>
                                    <span>Leave the password fields blank if you do not wish to change your existing password. If updating, choose a strong passphrase of at least 6 characters.</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">New Password</label>
                                        <div class="input-icon-wrapper">
                                            <input :type="showPassword ? 'text' : 'password'" 
                                                   name="new_password" 
                                                   x-model="password" 
                                                   class="form-control-custom" 
                                                   placeholder="••••••••" 
                                                   autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" @click="showPassword = !showPassword" tabindex="-1" title="Toggle password visibility">
                                                <span class="material-symbols-outlined fs-18" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Confirm New Password</label>
                                        <div class="input-icon-wrapper">
                                            <input :type="showConfirmPassword ? 'text' : 'password'" 
                                                   x-model="confirmPassword" 
                                                   class="form-control-custom" 
                                                   placeholder="••••••••" 
                                                   autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" @click="showConfirmPassword = !showConfirmPassword" tabindex="-1" title="Toggle password visibility">
                                                <span class="material-symbols-outlined fs-18" x-text="showConfirmPassword ? 'visibility_off' : 'visibility'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Live Validation Helpers -->
                                <div class="mt-2" style="min-height: 20px;">
                                    <template x-if="password && confirmPassword && password !== confirmPassword">
                                        <div class="d-flex align-items-center gap-1 text-danger" style="font-size: 0.78rem;">
                                            <span class="material-symbols-outlined fs-16">cancel</span>
                                            <span>Passwords do not match</span>
                                        </div>
                                    </template>
                                    <template x-if="password && confirmPassword && password === confirmPassword">
                                        <div class="d-flex align-items-center gap-1 text-success" style="font-size: 0.78rem;">
                                            <span class="material-symbols-outlined fs-16">check_circle</span>
                                            <span>Passwords match</span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Form Action Footer -->
                            <div class="pt-3 border-top d-flex justify-content-end align-items-center gap-2" style="border-color: #f1f5f9 !important;">
                                <button type="submit" 
                                        class="btn btn-primary-custom px-4 py-2 d-inline-flex align-items-center gap-2" 
                                        :disabled="loading || (password && password !== confirmPassword)">
                                    <span class="material-symbols-outlined fs-18" x-show="!loading">save</span>
                                    <span class="spinner-border spinner-border-sm" x-show="loading" role="status"></span>
                                    <span x-text="loading ? 'Saving Changes...' : 'Save Profile Changes'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================================================
         TAB 2: BRAND SOCIAL CHANNELS
         ==================================================== -->
    <div x-show="activeTab === 'social'" x-cloak>
        <div class="admin-card col-xl-10 col-lg-11 mx-auto p-0">
            <div class="card-header-custom py-3 px-4 border-bottom d-flex justify-content-between align-items-center" style="background: #ffffff; border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">share</span>
                    <div>
                        <h5 class="m-0 fw-700 text-dark" style="font-size: 0.95rem; font-family: 'Poppins', sans-serif;">Public Social Touchpoints</h5>
                        <p class="text-muted m-0" style="font-size: 0.78rem;">Configure official links displayed across the website header, footer, and community channels.</p>
                    </div>
                </div>
                <span class="badge badge-soft-muted px-3 py-1-5 text-muted" style="border-radius: 50px; font-size: 0.75rem;">
                    <?= count($socialLinks) ?> Configured Channels
                </span>
            </div>

            <div class="card-body-custom p-4">
                <form @submit.prevent="updateSocial">
                    <div class="row g-3">
                        <?php 
                        $platformMeta = [
                            'Facebook' => [
                                'icon' => 'fa-brands fa-facebook-f',
                                'bg' => '#eff6ff',
                                'color' => '#1877f2',
                                'placeholder' => 'https://facebook.com/your-page-id'
                            ],
                            'Twitter' => [
                                'icon' => 'fa-brands fa-x-twitter',
                                'bg' => '#f1f5f9',
                                'color' => '#0f172a',
                                'placeholder' => 'https://x.com/your-handle'
                            ],
                            'Youtube' => [
                                'icon' => 'fa-brands fa-youtube',
                                'bg' => '#fef2f2',
                                'color' => '#dc2626',
                                'placeholder' => 'https://youtube.com/@channel'
                            ],
                            'Linkedin' => [
                                'icon' => 'fa-brands fa-linkedin-in',
                                'bg' => '#f0f9ff',
                                'color' => '#0284c7',
                                'placeholder' => 'https://linkedin.com/company/your-page'
                            ],
                            'Instagram' => [
                                'icon' => 'fa-brands fa-instagram',
                                'bg' => '#fdf2f8',
                                'color' => '#db2777',
                                'placeholder' => 'https://instagram.com/your-profile'
                            ]
                        ];
                        ?>

                        <?php foreach ($socialLinks as $link): 
                            $meta = $platformMeta[$link['platform']] ?? [
                                'icon' => $link['icon_class'] ?? 'fa-solid fa-link',
                                'bg' => '#f8fafc',
                                'color' => '#f48221',
                                'placeholder' => 'https://...'
                            ];
                        ?>
                        <div class="col-12">
                            <div class="p-3 bg-white rounded-3 border d-flex flex-wrap align-items-center justify-content-between gap-3" 
                                 style="border-color: #e2e8f0 !important; transition: border-color 0.2s ease;">
                                <!-- Platform Brand Badge & Name -->
                                <div class="d-flex align-items-center gap-3" style="min-width: 170px;">
                                    <div class="d-flex align-items-center justify-content-center rounded-3" 
                                         style="width: 42px; height: 42px; background: <?= $meta['bg'] ?>; color: <?= $meta['color'] ?>; font-size: 1.15rem; flex-shrink: 0;">
                                        <i class="<?= $meta['icon'] ?>"></i>
                                    </div>
                                    <div>
                                        <h6 class="m-0 fw-700 text-dark" style="font-size: 0.9rem; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($link['platform']) ?></h6>
                                        <span class="text-muted" style="font-size: 0.72rem;">Public Profile</span>
                                    </div>
                                </div>

                                <!-- Input Field with Test Action -->
                                <div class="d-flex align-items-center gap-2 flex-grow-1" style="min-width: 280px;">
                                    <div class="position-relative flex-grow-1">
                                        <input type="url" 
                                               name="links[<?= $link['platform'] ?>]" 
                                               x-model="socialLinks['<?= addslashes($link['platform']) ?>']"
                                               class="form-control-custom" 
                                               placeholder="<?= $meta['placeholder'] ?>"
                                               style="font-family: monospace, monospace; font-size: 0.82rem; height: 42px; border-radius: 8px;">
                                    </div>
                                    <button type="button" 
                                            class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1"
                                            :disabled="!socialLinks['<?= addslashes($link['platform']) ?>']"
                                            @click="testLink(socialLinks['<?= addslashes($link['platform']) ?>'])"
                                            title="Test this URL in a new browser tab"
                                            style="height: 42px; padding: 0 14px; font-size: 0.78rem; border-radius: 8px;">
                                        <span class="material-symbols-outlined fs-16 text-muted">open_in_new</span>
                                        <span class="d-none d-sm-inline">Test</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Action Bar -->
                    <div class="pt-4 mt-3 border-top d-flex justify-content-between align-items-center" style="border-color: #f1f5f9 !important;">
                        <span class="text-muted" style="font-size: 0.78rem;">Changes take effect immediately across all public customer views.</span>
                        <button type="submit" 
                                class="btn btn-primary-custom px-4 py-2 d-inline-flex align-items-center gap-2" 
                                :disabled="loadingSocial">
                            <span class="material-symbols-outlined fs-18" x-show="!loadingSocial">done_all</span>
                            <span class="spinner-border spinner-border-sm" x-show="loadingSocial" role="status"></span>
                            <span x-text="loadingSocial ? 'Saving Links...' : 'Save Social Links'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ====================================================
         TAB 3: ADMINISTRATOR TEAM MANAGEMENT
         ==================================================== -->
    <div x-show="activeTab === 'admins'" x-cloak>
        <div class="admin-card">
            <!-- Table Header Toolbar -->
            <div class="card-header-custom py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: #ffffff; border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">admin_panel_settings</span>
                    <div>
                        <h5 class="m-0 fw-700 text-dark" style="font-size: 0.95rem; font-family: 'Poppins', sans-serif;">Administrator Team</h5>
                        <p class="text-muted m-0" style="font-size: 0.78rem;">Administrative staff authorized to configure content and view sensitive member records.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-soft-muted px-3 py-1-5 text-muted" style="border-radius: 50px; font-size: 0.75rem;">
                        <?= count($admins) ?> Active Admins
                    </span>
                    <button type="button" 
                            class="btn btn-primary-custom btn-sm-custom d-inline-flex align-items-center gap-1"
                            @click="openAddModal = true"
                            style="border-radius: 50px !important; padding: 6px 16px;">
                        <span class="material-symbols-outlined fs-16">person_add</span>
                        <span>Add Administrator</span>
                    </button>
                </div>
            </div>

            <!-- Administrators Table -->
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th style="min-width: 240px;">Administrator</th>
                                <th style="min-width: 130px;">Admin ID</th>
                                <th style="min-width: 150px;">Privilege Role</th>
                                <th style="min-width: 180px;">Last Activity</th>
                                <th style="min-width: 130px;">Status</th>
                                <th class="text-end" style="min-width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admins) && is_array($admins)): ?>
                                <?php foreach ($admins as $adm): 
                                    $isSelf = ((int)$adm['admin_id'] === (int)$_SESSION['admin_id']);
                                    $hasPic = !empty($adm['profile_pic']) && file_exists(ROOT_PATH . '/' . ltrim($adm['profile_pic'], './'));
                                    $picSrc = $hasPic ? BASE_URL . '/' . ltrim($adm['profile_pic'], './') : BASE_URL . '/img/admin-avatar.svg';
                                    $role = trim($adm['privilege'] ?? '') ?: 'Admin';
                                    $roleBadge = match($role) {
                                        'Super Admin' => 'badge-soft-orange',
                                        'Editor' => 'badge-soft-purple',
                                        'Moderator' => 'badge-soft-yellow',
                                        default => 'badge-soft-blue'
                                    };
                                ?>
                                <tr>
                                    <!-- User Avatar & Name -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle p-0-5 flex-shrink-0" style="background: #f1f5f9;">
                                                <img src="<?= $picSrc ?>" 
                                                     class="rounded-circle" 
                                                     alt="<?= htmlspecialchars($adm['admin_name']) ?>"
                                                     style="width: 38px; height: 38px; object-fit: cover; border: 1px solid #e2e8f0;">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="fw-700 text-dark" style="font-size: 0.88rem; font-family: 'Poppins', sans-serif;">
                                                        <?= htmlspecialchars($adm['admin_name'] ?? 'N/A') ?>
                                                    </span>
                                                    <?php if ($isSelf): ?>
                                                        <span class="badge badge-soft-orange" style="font-size: 0.68rem; padding: 2px 7px; border-radius: 50px;">You (Active)</span>
                                                    <?php endif; ?>
                                                </div>
                                                <span class="text-muted" style="font-size: 0.74rem;">System Credential</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Admin ID -->
                                    <td class="align-middle">
                                        <span class="badge badge-soft-muted text-muted" style="border-radius: 50px; font-size: 0.74rem; font-family: monospace;">
                                            #ADM-<?= str_pad((string)$adm['admin_id'], 3, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <!-- Role / Privilege -->
                                    <td class="align-middle">
                                        <span class="badge badge-status-pill <?= $roleBadge ?>" style="font-size: 0.75rem;">
                                            <?= htmlspecialchars($role) ?>
                                        </span>
                                    </td>

                                    <!-- Last Login -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.8rem;">
                                            <span class="material-symbols-outlined fs-15 text-muted">schedule</span>
                                            <span>
                                                <?= (!empty($adm['lastlogin']) && $adm['lastlogin'] !== '0000-00-00 00:00:00') 
                                                    ? date('M d, Y - h:i A', strtotime($adm['lastlogin'])) 
                                                    : 'Never' ?>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="align-middle">
                                        <span class="badge badge-soft-green d-inline-flex align-items-center gap-1" style="border-radius: 50px; font-size: 0.72rem; padding: 2px 8px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                            <span>Active</span>
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle text-end">
                                        <?php if ($isSelf): ?>
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.7rem; border-radius: 50px;" title="Cannot delete your active authenticated session">
                                                Self Account
                                            </span>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn-action delete" 
                                                    @click="deleteAdminAccount(<?= (int)$adm['admin_id'] ?>, '<?= htmlspecialchars(addslashes($adm['admin_name']), ENT_QUOTES) ?>')"
                                                    title="Remove Administrator">
                                                <span class="material-symbols-outlined fs-16">delete</span>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                            <span class="material-symbols-outlined fs-36 text-muted mb-2">group_off</span>
                                            <p class="m-0 fw-600">No administrator accounts found.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================================================
         ADD NEW ADMINISTRATOR MODAL
         ==================================================== -->
    <div class="modal-custom" :class="{ 'show': openAddModal }" x-show="openAddModal" x-cloak>
        <div class="modal-content-custom" style="max-width: 520px;" @click.outside="if (!isSubmittingAdmin) openAddModal = false">
            <!-- Modal Header -->
            <div class="modal-header-custom d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">person_add</span>
                    <h5 class="modal-title m-0 fw-700 text-dark fs-095" style="font-family: 'Poppins', sans-serif;">Add New Administrator</h5>
                </div>
                <button type="button" class="btn-close-modal border-0 bg-transparent text-muted p-1" @click="if (!isSubmittingAdmin) openAddModal = false" style="cursor: pointer;">
                    <span class="material-symbols-outlined fs-18">close</span>
                </button>
            </div>

            <!-- Modal Form -->
            <form @submit.prevent="createAdmin">
                <div class="p-4" style="max-height: 520px; overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label-custom">Admin Username / Full Name <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="text" x-model="newAdmin.name" class="form-control-custom" placeholder="e.g. joshua_admin" required autocomplete="off">
                            <span class="input-icon-right">
                                <span class="material-symbols-outlined fs-18">badge</span>
                            </span>
                        </div>
                        <small class="text-muted" style="font-size: 0.74rem;">Unique login identity for dashboard authentication.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Privilege Level <span class="text-danger">*</span></label>
                        <select x-model="newAdmin.privilege" class="form-control-custom" style="height: 42px; border-radius: 8px; border: 1.5px solid #e2e8f0; font-size: 0.88rem;" required>
                            <option value="Admin">Admin (Standard Dashboard Access)</option>
                            <option value="Super Admin">Super Admin (Full Root Permissions)</option>
                            <option value="Editor">Editor (Content & Blog Management)</option>
                            <option value="Moderator">Moderator (Community Member Moderation)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label-custom m-0">Initial Password <span class="text-danger">*</span></label>
                            <button type="button" @click="generateRandomPassword" class="btn btn-sm btn-light border-0 p-0 text-orange fw-600" style="font-size: 0.72rem; text-decoration: underline;">
                                Generate Random
                            </button>
                        </div>
                        <div class="input-icon-wrapper">
                            <input :type="showNewAdminPassword ? 'text' : 'password'" 
                                   x-model="newAdmin.password" 
                                   class="form-control-custom" 
                                   placeholder="Minimum 6 characters" 
                                   required 
                                   minlength="6"
                                   autocomplete="new-password">
                            <button type="button" class="password-toggle-btn" @click="showNewAdminPassword = !showNewAdminPassword" tabindex="-1" title="Toggle password visibility">
                                <span class="material-symbols-outlined fs-18" x-text="showNewAdminPassword ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-custom">Confirm Initial Password <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <input :type="showNewAdminPassword ? 'text' : 'password'" 
                                   x-model="newAdmin.confirmPassword" 
                                   class="form-control-custom" 
                                   placeholder="Re-type initial password" 
                                   required 
                                   autocomplete="new-password">
                        </div>
                        <template x-if="newAdmin.password && newAdmin.confirmPassword && newAdmin.password !== newAdmin.confirmPassword">
                            <small class="text-danger d-block mt-1" style="font-size: 0.75rem;">Passwords do not match.</small>
                        </template>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer-custom d-flex justify-content-end align-items-center gap-2 p-3 px-4 border-top" style="border-color: #f1f5f9 !important; background: #fafafa;">
                    <button type="button" class="btn btn-sm btn-light border px-3" @click="openAddModal = false" :disabled="isSubmittingAdmin" style="font-size: 0.82rem; border-radius: 50px !important;">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="btn btn-sm btn-primary-custom px-4 py-1-5 d-inline-flex align-items-center gap-2" 
                            :disabled="isSubmittingAdmin || !newAdmin.name || !newAdmin.password || newAdmin.password !== newAdmin.confirmPassword"
                            style="font-size: 0.82rem; border-radius: 50px !important;">
                        <span class="spinner-border spinner-border-sm" x-show="isSubmittingAdmin" role="status"></span>
                        <span x-text="isSubmittingAdmin ? 'Creating...' : 'Create Administrator'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
