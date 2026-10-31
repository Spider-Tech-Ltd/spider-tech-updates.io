<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-profile.css?v=<?= filemtime(ROOT_PATH . '/css/forum-profile.css') ?>" />

<?php
$member_name  = htmlspecialchars($member['name'] ?? 'Member', ENT_QUOTES);
$member_role  = htmlspecialchars($member['role']  ?? 'Member', ENT_QUOTES);
$member_since = isset($member['created_at']) ? date('F Y', strtotime($member['created_at'])) : 'N/A';
$avatar_db    = $member['avatar'] ?? null;
$post_count   = $member_stats['post_count']     ?? 0;
$reply_count  = $member_stats['reply_count']    ?? 0;
$likes_count  = $member_stats['likes_received'] ?? 0;
?>

<div class="profile-page-wrapper" x-data="profileDash()">
    <!-- Top Hero Banner (Soft Orange-Gray Grid) -->
    <section class="profile-hero-banner">
        <div class="container">
            <!-- Back Navigation -->
            <div class="detail-nav">
                <a href="<?= BASE_URL ?>/forum/feed" class="back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Back to Feed</span>
                </a>
            </div>

            <div class="profile-header-meta">
                <div class="profile-eyebrow">
                    <span class="material-symbols-outlined" style="font-size:13px;">manage_accounts</span>
                    <span>Engineering Profile</span>
                </div>
                <h1 class="profile-title">Account Settings &amp; Profile</h1>
                <p class="profile-subtitle">Manage your public technical identity, avatar, credentials, and forum telemetry.</p>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="profile-content-section">
        <div class="container">
            <div class="row align-items-start">
                <!-- Left Column: Identity & Telemetry (col-lg-4) -->
                <div class="col-lg-4 mb-4">
                    <div class="profile-sidebar-card">
                        <!-- Avatar with Status Dot -->
                        <div class="profile-avatar-wrap">
                            <div class="avatar-ring" @click="$refs.avatarInput.click()" title="Click to change photo">
                                <img x-show="avatarPreview" :src="avatarPreview" alt="Your Avatar" style="display:none;">
                                <div class="avatar-initials" x-show="!avatarPreview" x-text="initials"></div>
                                <div class="avatar-overlay">
                                    <span class="material-symbols-outlined">photo_camera</span>
                                    <span>Change</span>
                                </div>
                            </div>
                            <span class="profile-online-dot" title="Active Account"></span>
                        </div>

                        <h2 class="pd-name" x-text="name || '<?= $member_name ?>'"><?= $member_name ?></h2>
                        <div class="pd-role-wrap">
                            <span class="pd-role-badge"><?= $member_role ?></span>
                            <span class="pd-verified-badge">
                                <span class="material-symbols-outlined" style="font-size:13px;">verified</span>
                                <span>Verified Member</span>
                            </span>
                        </div>

                        <!-- 3-Column Telemetry Stat Pills -->
                        <div class="stat-grid">
                            <div class="stat-pill">
                                <div class="stat-pill-val"><?= number_format($post_count) ?></div>
                                <div class="stat-pill-label">Posts</div>
                            </div>
                            <div class="stat-pill">
                                <div class="stat-pill-val"><?= number_format($reply_count) ?></div>
                                <div class="stat-pill-label">Replies</div>
                            </div>
                            <div class="stat-pill">
                                <div class="stat-pill-val"><?= number_format($likes_count) ?></div>
                                <div class="stat-pill-label">Likes</div>
                            </div>
                        </div>

                        <!-- Member Since Badge -->
                        <div class="member-since-row">
                            <span class="material-symbols-outlined">calendar_today</span>
                            <span>Member since <?= $member_since ?></span>
                        </div>

                        <div class="pd-nav-divider"></div>

                        <!-- Nav Quick Links -->
                        <div class="pd-nav-menu">
                            <a href="<?= BASE_URL ?>/forum/feed" class="pd-nav-btn">
                                <span class="material-symbols-outlined">forum</span>
                                <span>Back to Feed</span>
                            </a>
                            <a href="<?= BASE_URL ?>/forum/new-topic" class="pd-nav-btn">
                                <span class="material-symbols-outlined">edit_square</span>
                                <span>New Discussion</span>
                            </a>
                            <a href="<?= BASE_URL ?>/forum/logout" class="pd-nav-btn danger">
                                <span class="material-symbols-outlined">logout</span>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings & Forms (col-lg-8) -->
                <div class="col-lg-8">
                    <!-- Profile Picture Card -->
                    <div class="pd-main-card mb-4">
                        <div class="card-header-strip">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon-box">
                                    <span class="material-symbols-outlined">photo_camera</span>
                                </div>
                                <div>
                                    <h3 class="card-heading">Profile Picture</h3>
                                    <p class="card-subheading">Update your community avatar across discussions and replies.</p>
                                </div>
                            </div>
                        </div>

                        <input type="file" accept="image/*" x-ref="avatarInput" class="d-none" @change="previewAvatar($event)">

                        <div class="avatar-drop-zone"
                             @click="$refs.avatarInput.click()"
                             @dragover.prevent="dragging=true"
                             @dragleave="dragging=false"
                             @drop.prevent="dropFile($event)"
                             :class="{ dragging }">
                            <template x-if="avatarPreview">
                                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                                    <img class="avatar-preview-thumb mb-0" :src="avatarPreview" alt="Preview">
                                    <div class="text-start">
                                        <div class="drop-text-primary">Photo Selected</div>
                                        <p class="drop-text-muted mb-0"><strong>Click to replace</strong> or drag &amp; drop another image</p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!avatarPreview">
                                <div>
                                    <span class="material-symbols-outlined drop-icon">cloud_upload</span>
                                    <div class="drop-text-primary">Drag &amp; drop your photo here, or <strong>browse files</strong></div>
                                    <p class="drop-text-muted mb-0">Supports JPG, PNG, or WebP &bull; Max 5 MB recommended</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Account Info & Security Card -->
                    <div class="pd-main-card">
                        <div class="card-header-strip">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon-box">
                                    <span class="material-symbols-outlined">manage_accounts</span>
                                </div>
                                <div>
                                    <h3 class="card-heading">Account Information</h3>
                                    <p class="card-subheading">Your personal identity and security credentials.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="pd-label">
                                    <span>Display Name</span>
                                    <span class="field-required">*</span>
                                </label>
                                <input type="text" class="pd-input" x-model="name" placeholder="Your display name" required>
                                <span class="pd-input-hint">Your public username shown on all discussions.</span>
                            </div>

                            <div class="col-md-6">
                                <label class="pd-label">
                                    <span>Email Address</span>
                                    <span class="badge-locked"><span class="material-symbols-outlined" style="font-size:12px;">lock</span> Verified</span>
                                </label>
                                <input type="email" class="pd-input is-disabled"
                                       value="<?= htmlspecialchars($member['email'] ?? '', ENT_QUOTES) ?>"
                                       disabled title="Contact support to change email">
                                <span class="pd-input-hint">Email is managed by system admins.</span>
                            </div>
                        </div>

                        <div class="pd-section-divider">
                            <span class="divider-text">Security &amp; Password</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="pd-label">
                                    <span>New Password</span>
                                    <span class="pd-label-note">— Optional</span>
                                </label>
                                <div class="pd-pw-wrapper">
                                    <input :type="showPw1 ? 'text' : 'password'" class="pd-input" x-model="newPassword"
                                           placeholder="Enter new password">
                                    <button type="button" class="pd-pw-toggle" @click="showPw1 = !showPw1" tabindex="-1">
                                        <span class="material-symbols-outlined" x-text="showPw1 ? 'visibility_off' : 'visibility'"></span>
                                    </button>
                                </div>
                                <span class="pd-input-hint">Leave blank to keep your current password.</span>
                            </div>

                            <div class="col-md-6">
                                <label class="pd-label">Confirm New Password</label>
                                <div class="pd-pw-wrapper">
                                    <input :type="showPw2 ? 'text' : 'password'" class="pd-input" x-model="confirmPassword"
                                           placeholder="Repeat new password">
                                    <button type="button" class="pd-pw-toggle" @click="showPw2 = !showPw2" tabindex="-1">
                                        <span class="material-symbols-outlined" x-text="showPw2 ? 'visibility_off' : 'visibility'"></span>
                                    </button>
                                </div>
                                <span class="pd-input-hint text-danger" x-show="newPassword && confirmPassword && newPassword !== confirmPassword" style="display:none;">
                                    Passwords do not match.
                                </span>
                            </div>
                        </div>

                        <!-- Save Action Strip -->
                        <div class="pd-action-strip">
                            <div class="pd-action-meta">
                                <span class="material-symbols-outlined">info</span>
                                <span>Changes update immediately across your technical profile.</span>
                            </div>
                            <button id="pdSaveBtn"
                                    class="btn-pd-save"
                                    @click="saveAll()"
                                    :disabled="loading || (newPassword && confirmPassword && newPassword !== confirmPassword)">
                                <span class="spinner-border spinner-border-sm" x-show="loading" style="display:none;"></span>
                                <span class="material-symbols-outlined" x-show="!loading">save</span>
                                <span x-text="loading ? 'Saving Changes...' : 'Save Changes'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Toast Notification -->
    <div class="pd-toast" :class="toastSuccess ? 'success' : 'error'"
         x-show="toastShow" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         style="display:none;">
        <span class="material-symbols-outlined" x-text="toastSuccess ? 'check_circle' : 'error'"></span>
        <span x-text="toastMessage"></span>
    </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('profileDash', () => ({
      name: '<?= $member_name ?>',
      newPassword: '',
      confirmPassword: '',
      showPw1: false,
      showPw2: false,
      avatarPreview: <?= $avatar_db ? "'" . BASE_URL . $avatar_db . "'" : 'null' ?>,
      avatarFile: null,
      loading: false,
      dragging: false,
      toastShow: false,
      toastSuccess: true,
      toastMessage: '',

      get initials() {
        return this.name ? this.name.charAt(0).toUpperCase() : 'M';
      },

      previewAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;
        this.avatarFile = file;
        this.avatarPreview = URL.createObjectURL(file);
      },

      dropFile(event) {
        this.dragging = false;
        const file = event.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
          this.avatarFile = file;
          this.avatarPreview = URL.createObjectURL(file);
        }
      },

      async saveAll() {
        if (this.newPassword && this.confirmPassword && this.newPassword !== this.confirmPassword) {
          this.toastSuccess = false;
          this.toastMessage = 'Passwords do not match.';
          this.toastShow = true;
          setTimeout(() => this.toastShow = false, 3000);
          return;
        }
        this.loading = true;
        this.toastShow = false;

        try {
          const fd = new FormData();
          fd.append('name', this.name);
          fd.append('new_password', this.newPassword);
          if (this.avatarFile) fd.append('avatar', this.avatarFile);

          const res = await fetch('<?= BASE_URL ?>/forum/updateProfile', {
            method: 'POST',
            body: fd
          });
          const data = await res.json();

          this.toastSuccess = data.success;
          this.toastMessage = data.message || (data.success ? 'Saved!' : 'Something went wrong.');
          this.toastShow = true;

          if (data.success) {
            this.newPassword = '';
            this.confirmPassword = '';
            if (data.avatarPath) this.avatarPreview = '<?= BASE_URL ?>' + data.avatarPath;
          }
        } catch {
          this.toastSuccess = false;
          this.toastMessage = 'Network error. Try again.';
          this.toastShow = true;
        } finally {
          this.loading = false;
          setTimeout(() => this.toastShow = false, 3500);
        }
      }
    }));
  });
</script>

<?php include 'includes/footer.php'; ?>
