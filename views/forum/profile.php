<?php include 'includes/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
  :root {
    --sp-orange:  #f48221;
    --sp-dark:    #111111;
    --sp-gray:    #797979;
    --sp-surface: #f8f9fa;
    --sp-white:   #ffffff;
    --sp-border:  #e9ecef;
  }

  /* ── Layout ── */
  .pd-wrapper {
    background: var(--sp-surface);
    min-height: calc(100vh - 80px);
    padding: 48px 16px 80px;
  }
  .pd-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    max-width: 1060px;
    margin: 0 auto;
  }
  @media (max-width: 900px) {
    .pd-grid { grid-template-columns: 1fr; }
  }

  /* ── Card shell — mirrors .discussion-card ── */
  .pd-card {
    background: var(--sp-white);
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 2px 12px rgba(17,17,17,0.05);
    border: 1px solid transparent;
  }

  /* ── Avatar ── */
  .avatar-ring {
    position: relative;
    width: 110px;
    height: 110px;
    margin: 0 auto 20px;
    cursor: pointer;
  }
  .avatar-ring img,
  .avatar-ring .avatar-initials {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--sp-orange);
    box-shadow: 0 4px 16px rgba(244,130,33,0.2);
  }
  .avatar-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(244,130,33,0.08);
    color: var(--sp-orange);
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 2.8rem;
  }
  .avatar-overlay {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: rgba(0,0,0,0.45);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
    color: #fff;
    gap: 2px;
  }
  .avatar-ring:hover .avatar-overlay { opacity: 1; }
  .avatar-overlay .material-symbols-outlined { font-size: 22px; }
  .avatar-overlay span:last-child { font-family: 'Poppins'; font-size: 0.7rem; font-weight: 600; }

  .pd-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--sp-dark);
    text-align: center;
    margin: 0 0 4px;
  }
  .pd-role {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.7rem;
    color: var(--sp-orange);
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 24px;
  }

  /* ── Stat pills — pill shape, matching filter pills ── */
  .stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-bottom: 20px;
  }
  .stat-pill {
    background: var(--sp-surface);
    border-radius: 50px;
    padding: 14px 8px;
    text-align: center;
    border: 1.5px solid var(--sp-border);
    transition: border-color 0.2s, background 0.2s;
  }
  .stat-pill:hover {
    border-color: var(--sp-orange);
    background: rgba(244,130,33,0.04);
  }
  .stat-pill-val {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--sp-dark);
    line-height: 1;
    margin-bottom: 4px;
  }
  .stat-pill-label {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.67rem;
    color: var(--sp-gray);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  /* Member since */
  .member-since-row {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--sp-surface);
    border-radius: 50px;
    padding: 9px 16px;
    margin-bottom: 20px;
    font-family: 'Open Sans', sans-serif;
    font-size: 0.8rem;
    color: var(--sp-gray);
    border: 1.5px solid var(--sp-border);
  }
  .member-since-row .material-symbols-outlined { font-size: 15px; color: var(--sp-orange); }

  /* Nav links — pill shaped */
  .pd-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.82rem;
    color: var(--sp-gray);
    text-decoration: none;
    transition: all 0.18s;
    margin-bottom: 4px;
    border: 1.5px solid transparent;
  }
  .pd-nav-link:hover {
    background: rgba(244,130,33,0.06);
    border-color: rgba(244,130,33,0.15);
    color: var(--sp-orange);
    text-decoration: none;
  }
  .pd-nav-link .material-symbols-outlined { font-size: 17px; }
  .pd-nav-link.danger:hover { color: #e11d48; background: #fff0f3; border-color: rgba(225,29,72,0.15); }

  /* ── Section titles — mirrors widget-title-premium ── */
  .pd-section-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.92rem;
    color: var(--sp-dark);
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .pd-section-title .material-symbols-outlined {
    font-size: 17px;
    color: var(--sp-orange);
    background: rgba(244,130,33,0.08);
    border-radius: 8px;
    padding: 4px;
  }
  .pd-divider { border: none; border-top: 1px solid var(--sp-border); margin: 24px 0; }

  /* ── Inputs — pill shaped, matching filter-sort-select ── */
  .pd-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: #555555;
    margin-bottom: 7px;
    display: block;
  }
  .pd-input {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.88rem;
    padding: 10px 20px;
    border-radius: 50px;
    border: 1.5px solid var(--sp-border);
    width: 100%;
    color: var(--sp-dark);
    background: var(--sp-surface);
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
  }
  .pd-input:focus {
    border-color: var(--sp-orange);
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
    background: var(--sp-white);
  }
  .pd-input:disabled {
    opacity: 0.55;
    cursor: not-allowed;
  }
  .pd-input-hint {
    font-family: 'Open Sans', sans-serif;
    font-size: 0.73rem;
    color: var(--sp-gray);
    margin-top: 6px;
    padding-left: 10px;
  }

  /* Password show/hide toggle */
  .pd-pw-wrapper { position: relative; }
  .pd-pw-toggle {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--sp-gray);
    display: flex;
    align-items: center;
    padding: 0;
    transition: color 0.15s;
  }
  .pd-pw-toggle:hover { color: var(--sp-orange); }
  .pd-pw-toggle .material-symbols-outlined { font-size: 17px; }

  /* Avatar drop zone */
  .avatar-drop-zone {
    border: 2px dashed var(--sp-border);
    border-radius: 20px;
    padding: 28px 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--sp-surface);
  }
  .avatar-drop-zone:hover, .avatar-drop-zone.dragging {
    border-color: var(--sp-orange);
    background: rgba(244,130,33,0.03);
  }
  .avatar-drop-zone .drop-icon { font-size: 32px; color: var(--sp-orange); margin-bottom: 8px; display: block; }
  .avatar-drop-zone p { font-family:'Open Sans'; font-size:0.82rem; color: var(--sp-gray); margin:0; line-height: 1.6; }
  .avatar-drop-zone strong { color: var(--sp-orange); }
  .avatar-preview-thumb {
    width: 72px; height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid var(--sp-orange);
    margin: 0 auto 10px;
    display: block;
    box-shadow: 0 4px 12px rgba(244,130,33,0.15);
  }

  /* ── Save button — pill, matching all forum CTAs ── */
  .btn-pd-save {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 32px;
    background: var(--sp-orange);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    box-shadow: 0 2px 8px rgba(244, 130, 33, 0.25);
    min-width: 150px;
  }
  .btn-pd-save:hover {
    background: #e6751c;
    box-shadow: 0 4px 14px rgba(244, 130, 33, 0.35);
    transform: translateY(-1px);
  }
  .btn-pd-save:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }
  .btn-pd-save .material-symbols-outlined { font-size: 17px; }

  /* Toast — pill shape */
  .pd-toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    padding: 11px 22px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.84rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 9999;
  }
  .pd-toast.success { background: #10b981; box-shadow: 0 4px 16px rgba(16,185,129,0.3); }
  .pd-toast.error   { background: #ef4444; box-shadow: 0 4px 16px rgba(239,68,68,0.3); }
  .pd-toast .material-symbols-outlined { font-size: 17px; }
</style>

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
            <input :type="showPw ? 'text' : 'password'" class="pd-input" x-model="newPassword"
                   placeholder="Enter new password" style="padding-right:44px;">
            <button type="button" class="pd-pw-toggle" @click="showPw = !showPw" tabindex="-1">
              <span class="material-symbols-outlined" x-text="showPw ? 'visibility_off' : 'visibility'"></span>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label class="pd-label">Confirm New Password</label>
          <div class="pd-pw-wrapper">
            <input :type="showPw ? 'text' : 'password'" class="pd-input" x-model="confirmPassword"
                   placeholder="Repeat new password" style="padding-right:44px;">
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
    name:            '<?= $member_name ?>',
    newPassword:     '',
    confirmPassword: '',
    showPw:          false,
    avatarPreview:   <?= $avatar_db ? "'" . BASE_URL . $avatar_db . "'" : 'null' ?>,
    avatarFile:      null,
    loading:         false,
    dragging:        false,
    toastShow:       false,
    toastSuccess:    true,
    toastMessage:    '',

    get initials() {
      return this.name ? this.name.charAt(0).toUpperCase() : 'M';
    },

    previewAvatar(event) {
      const file = event.target.files[0];
      if (!file) return;
      this.avatarFile    = file;
      this.avatarPreview = URL.createObjectURL(file);
    },

    dropFile(event) {
      this.dragging = false;
      const file = event.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        this.avatarFile    = file;
        this.avatarPreview = URL.createObjectURL(file);
      }
    },

    async saveAll() {
      // Block only if both password fields are filled and they mismatch
      if (this.newPassword && this.confirmPassword && this.newPassword !== this.confirmPassword) {
        this.toastSuccess = false;
        this.toastMessage = 'Passwords do not match.';
        this.toastShow    = true;
        setTimeout(() => this.toastShow = false, 3000);
        return;
      }
      this.loading   = true;
      this.toastShow = false;

      try {
        const fd = new FormData();
        fd.append('name', this.name);
        fd.append('new_password', this.newPassword);
        if (this.avatarFile) fd.append('avatar', this.avatarFile);

        const res  = await fetch('<?= BASE_URL ?>/forum/updateProfile', { method: 'POST', body: fd });
        const data = await res.json();

        this.toastSuccess = data.success;
        this.toastMessage = data.message || (data.success ? 'Saved!' : 'Something went wrong.');
        this.toastShow    = true;

        if (data.success) {
          this.newPassword     = '';
          this.confirmPassword = '';
          if (data.avatarPath) this.avatarPreview = '<?= BASE_URL ?>' + data.avatarPath;
        }
      } catch {
        this.toastSuccess = false;
        this.toastMessage = 'Network error. Try again.';
        this.toastShow    = true;
      } finally {
        this.loading = false;
        setTimeout(() => this.toastShow = false, 3500);
      }
    }
  }));
});
</script>

<?php include 'includes/footer.php'; ?>
