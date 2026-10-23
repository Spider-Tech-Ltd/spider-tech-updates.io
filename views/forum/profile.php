<?php include 'includes/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-profile.css" />

<?php
$member_name  = htmlspecialchars($member['name'] ?? 'Member', ENT_QUOTES);
$member_role  = htmlspecialchars($member['role']  ?? 'Member', ENT_QUOTES);
$member_since = isset($member['created_at']) ? date('F Y', strtotime($member['created_at'])) : 'N/A';
$avatar_db    = $member['avatar'] ?? null;
$post_count   = $member_stats['post_count']     ?? 0;
$reply_count  = $member_stats['reply_count']    ?? 0;
$likes_count  = $member_stats['likes_received'] ?? 0;
?>

<div class="pd-wrapper" x-data="profileDash()">
  <div class="pd-grid">

    <!-- ══════════════════════════
         LEFT — Identity & Stats
    ══════════════════════════ -->
    <div>
      <div class="pd-card text-center">

        <!-- Avatar -->
        <div class="avatar-ring" @click="$refs.avatarInput.click()" title="Change photo">
          <img x-show="avatarPreview" :src="avatarPreview" alt="Your Avatar">
          <div class="avatar-initials" x-show="!avatarPreview" x-text="initials"></div>
          <div class="avatar-overlay">
            <span class="material-symbols-outlined">photo_camera</span>
            <span>Change</span>
          </div>
        </div>

        <h1 class="pd-name" x-text="name || '<?= $member_name ?>'"></h1>
        <p class="pd-role"><?= $member_role ?></p>

        <!-- Stats -->
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

        <!-- Member since -->
        <div class="member-since-row">
          <span class="material-symbols-outlined">calendar_today</span>
          Member since <?= $member_since ?>
        </div>

        <!-- Nav shortcuts -->
        <a href="<?= BASE_URL ?>/forum/feed" class="pd-nav-link">
          <span class="material-symbols-outlined">forum</span> Back to Feed
        </a>
        <a href="<?= BASE_URL ?>/forum/new-topic" class="pd-nav-link">
          <span class="material-symbols-outlined">edit_square</span> New Discussion
        </a>
        <a href="<?= BASE_URL ?>/forum/logout" class="pd-nav-link danger">
          <span class="material-symbols-outlined">logout</span> Sign Out
        </a>
      </div>
    </div>

    <!-- ══════════════════════════
         RIGHT — Edit Forms
    ══════════════════════════ -->
    <div style="display:flex; flex-direction:column; gap:24px;">

      <!-- Section 1: Profile Picture -->
      <div class="pd-card">
        <h2 class="pd-section-title">
          <span class="material-symbols-outlined">photo_camera</span> Profile Picture
        </h2>

        <input type="file" accept="image/*" x-ref="avatarInput" style="display:none"
          @change="previewAvatar($event)">

        <div class="avatar-drop-zone"
          @click="$refs.avatarInput.click()"
          @dragover.prevent="dragging=true"
          @dragleave="dragging=false"
          @drop.prevent="dropFile($event)"
          :class="{ dragging }">
          <template x-if="avatarPreview">
            <div>
              <img class="avatar-preview-thumb" :src="avatarPreview" alt="Preview">
              <p><strong>Change photo</strong> or drag &amp; drop another</p>
            </div>
          </template>
          <template x-if="!avatarPreview">
            <div>
              <span class="material-symbols-outlined drop-icon">cloud_upload</span>
              <p>Drag &amp; drop or <strong>click to upload</strong><br>JPG, PNG, WebP — max 5 MB</p>
            </div>
          </template>
        </div>
      </div>

      <!-- Section 2: Account Info & Password -->
      <div class="pd-card">
        <h2 class="pd-section-title">
          <span class="material-symbols-outlined">manage_accounts</span> Account Info
        </h2>

        <div class="mb-3">
          <label class="pd-label">Display Name</label>
          <input type="text" class="pd-input" x-model="name" placeholder="Your display name" required>
        </div>

        <div class="mb-3">
          <label class="pd-label">Email</label>
          <input type="email" class="pd-input"
            value="<?= htmlspecialchars($member['email'] ?? '', ENT_QUOTES) ?>"
            disabled title="Contact support to change email">
          <p class="pd-input-hint">Email cannot be changed here. Contact support.</p>
        </div>

        <hr class="pd-divider">

        <h2 class="pd-section-title">
          <span class="material-symbols-outlined">lock</span> Change Password
        </h2>

        <div class="mb-3">
          <label class="pd-label">
            New Password
            <span style="color:var(--sp-gray); font-weight:400; font-size:0.75rem;">&nbsp;— leave blank to keep current</span>
          </label>
          <div class="pd-pw-wrapper">
            <input :type="showPw1 ? 'text' : 'password'" class="pd-input" x-model="newPassword"
              placeholder="Enter new password" style="padding-right:44px;">
            <button type="button" class="pd-pw-toggle" @click="showPw1 = !showPw1" tabindex="-1">
              <span class="material-symbols-outlined" x-text="showPw1 ? 'visibility_off' : 'visibility'"></span>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label class="pd-label">Confirm New Password</label>
          <div class="pd-pw-wrapper">
            <input :type="showPw2 ? 'text' : 'password'" class="pd-input" x-model="confirmPassword"
              placeholder="Repeat new password" style="padding-right:44px;">
            <button type="button" class="pd-pw-toggle" @click="showPw2 = !showPw2" tabindex="-1">
              <span class="material-symbols-outlined" x-text="showPw2 ? 'visibility_off' : 'visibility'"></span>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button id="pdSaveBtn"
            class="btn-pd-save"
            @click="saveAll()"
            :disabled="loading">
            <span class="spinner-border spinner-border-sm" x-show="loading" style="display:none;"></span>
            <span class="material-symbols-outlined" x-show="!loading" style="font-size:17px;">save</span>
            <span x-text="loading ? 'Saving…' : 'Save Changes'"></span>
          </button>
          <p class="pd-input-hint ms-2 mt-2" x-show="newPassword && confirmPassword && newPassword !== confirmPassword"
            style="color:#ef4444; display:none; align-self:center;">
            Passwords do not match.
          </p>
        </div>
      </div>

    </div><!-- end right col -->
  </div><!-- pd-grid -->

  <!-- Toast -->
  <div class="pd-toast" :class="toastSuccess ? 'success' : 'error'"
    x-show="toastShow" x-transition.duration.300ms style="display:none;">
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
        // Block only if both password fields are filled and they mismatch
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