<?php
/**
 * Member Profile Dashboard — Phase 9
 * A personal hub for members to track contributions and manage identity.
 * Architecture: Bootstrap 4 + Vanilla CSS.
 */
require('../../includes/connect.php');
require('../../home_functions.php');

// Simulated logged-in member data
$member = [
    'name'       => 'James Harrison',
    'initials'   => 'JH',
    'title'      => 'Senior Systems Architect',
    'bio'        => 'Focusing on the intersection of industrial IoT and structural engineering. 10+ years of experience in automation.',
    'company'    => 'https://spidertech.ltd',
    'posts'      => 48,
    'upvotes'    => '1.2k',
    'replies'    => 156,
    'joined'     => 'Mar 2024',
    'avatar'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAs6gBoA2k4pMTC-fJpoWQJSJQjJCUNCnjk_yAx4XrscmdIy_sYdSzHaaa0UH1G3Lte596AjGEaZRvKOmEVsCgdmbFNMgKgdf2hES_4N-OhUHREpqDOY0Aw1pJrzDQ_d6DU2WTGJUoT8_v71GJlYtbQbWpPnkr4sZyRcvrlWO8Mm6wQgXCNts-LK3NeKBLozAcewb1egWNJTfoQiLFVJD1c4KCIVAJ3DCItshMujVz7Kzvhcud0NkR60M4EoYp3dA_b5KAvW_X7A4MD'
];
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <title>Dashboard — <?php echo $member['name']; ?></title>

    <style>
      /* ======================================
         CORE DESIGN SYSTEM (DARK)
         ====================================== */
      :root {
        --deep-charcoal: #111319;
        --surface-low: #191b22;
        --surface-high: #282a30;
        --electric-blue: #3b82f6;
        --text-on-surface: #e2e2eb;
        --text-muted: #94a3b8;
      }

      body {
        background-color: var(--deep-charcoal);
        color: var(--text-on-surface);
        font-family: 'Inter', sans-serif;
      }

      /* Global Header Overrides for Dark Profile */
      .site-header { background: rgba(17, 19, 25, 0.9) !important; border-bottom: 1px solid rgba(59, 130, 246, 0.1); }
      .logo-text, .nav-link-item, .action-link { color: #fff !important; }
      .site-header.is-scrolled { background: rgba(17, 19, 25, 0.95) !important; }

      .profile-wrapper { padding-top: 80px; }

      /* ======================================
         1. PROFILE HEADER
         ====================================== */
      .profile-header-area {
        position: relative;
        background: linear-gradient(to bottom, rgba(17, 19, 25, 0.5), var(--deep-charcoal)),
                    url('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=2070');
        background-size: cover;
        background-position: center;
        padding: 80px 0 40px;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
      }

      .profile-header-area::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 2px 2px, rgba(59, 130, 246, 0.05) 1px, transparent 0);
        background-size: 24px 24px;
        pointer-events: none;
      }

      .profile-identity {
        display: flex;
        align-items: flex-end;
        gap: 32px;
        position: relative;
        z-index: 10;
      }

      .avatar-container {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        border: 4px solid var(--surface-high);
        overflow: hidden;
        box-shadow: 0 12px 24px rgba(0,0,0,0.4);
        flex-shrink: 0;
      }

      .avatar-container img { width: 100%; height: 100%; object-fit: cover; }

      .identity-text h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 2.25rem;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
        color: #fff;
      }

      .identity-text p {
        font-size: 1.1rem;
        color: var(--electric-blue);
        font-weight: 600;
        margin-bottom: 0;
      }

      .profile-header-actions { margin-left: auto; margin-bottom: 10px; }
      .btn-edit-profile {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(59, 130, 246, 0.4);
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .btn-edit-profile:hover { background: rgba(59, 130, 246, 0.1); border-color: var(--electric-blue); color: #fff; text-decoration: none; }

      @media (max-width: 768px) {
        .profile-identity { flex-direction: column; align-items: center; text-align: center; gap: 20px; }
        .profile-header-actions { margin: 20px 0 0 0; }
      }

      /* ======================================
         2. STATS BAR
         ====================================== */
      .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: -30px;
        position: relative;
        z-index: 20;
      }

      .stat-box {
        background: var(--surface-low);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        transition: transform 0.3s;
      }

      .stat-box:hover { transform: translateY(-5px); border-color: var(--electric-blue); }

      .stat-value {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
      }

      .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-muted);
        font-weight: 700;
      }

      @media (max-width: 991px) { .stats-bar { grid-template-columns: repeat(2, 1fr); } }

      /* ======================================
         3. ACTIVITY TABS & CONTENT
         ====================================== */
      .profile-content-section { padding: 60px 0 100px; }

      .activity-tabs {
        display: flex;
        gap: 40px;
        border-bottom: 1px solid var(--surface-high);
        margin-bottom: 32px;
        overflow-x: auto;
      }

      .tab-item {
        padding-bottom: 16px;
        color: var(--text-muted);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none !important;
        position: relative;
        transition: color 0.3s;
        cursor: pointer;
        white-space: nowrap;
      }

      .tab-item:hover { color: #fff; }
      .tab-item.active { color: var(--electric-blue); }
      .tab-item.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0; right: 0;
        height: 3px;
        background: var(--electric-blue);
        border-radius: 3px 3px 0 0;
      }

      .tab-pane { display: none; }
      .tab-pane.active { display: block; }

      /* ======================================
         4. ACTIVITY LIST
         ====================================== */
      .activity-list { display: flex; flex-direction: column; gap: 16px; }

      .activity-card {
        background: var(--surface-low);
        border: 1px solid rgba(255,255,255,0.03);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
      }
      .activity-card:hover { background: var(--surface-high); }

      .activity-info h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 6px; color: #fff; }
      .activity-meta { font-size: 0.85rem; color: var(--text-muted); display: flex; gap: 16px; }

      .status-pill {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
      }
      .status-trending { background: rgba(59, 130, 246, 0.1); color: var(--electric-blue); }
      .status-resolved { background: rgba(34, 197, 94, 0.1); color: #22c55e; }

      /* ======================================
         5. SETTINGS PANEL (EMBEDDED)
         ====================================== */
      .settings-panel {
        background: var(--surface-low);
        border-radius: 20px;
        padding: 32px;
      }

      .settings-group { margin-bottom: 32px; }
      .settings-group h3 { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 20px; }

      .form-label-custom {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-muted);
        margin-bottom: 8px;
      }

      .input-custom {
        width: 100%;
        background: var(--surface-high);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 12px 16px;
        color: #fff;
        outline: none;
        transition: border-color 0.3s;
      }
      .input-custom:focus { border-color: var(--electric-blue); }

      .pref-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
      .pref-row:last-child { border-bottom: none; }

      /* ======================================
         6. SIDEBAR
         ====================================== */
      .profile-sidebar { display: flex; flex-direction: column; gap: 32px; }

      .sidebar-widget h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .followed-members { display: flex; flex-direction: column; gap: 16px; }
      .member-row { display: flex; align-items: center; gap: 12px; text-decoration: none !important; }
      .member-avatar { width: 40px; height: 40px; border-radius: 10px; background: var(--surface-high); overflow: hidden; }
      .member-avatar img { width: 100%; height: 100%; object-fit: cover; }
      .member-name { font-weight: 600; color: var(--text-on-surface); font-size: 0.9rem; }
      .member-role { font-size: 0.75rem; color: var(--text-muted); display: block; }

      .badge-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
      .badge-item {
        background: var(--surface-low);
        aspect-ratio: 1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--electric-blue);
        border: 1px solid rgba(59, 130, 246, 0.1);
        transition: all 0.3s;
      }
      .badge-item:hover { background: var(--electric-blue); color: #fff; transform: scale(1.05); }

      /* ======================================
         FOOTER OVERRIDES
         ====================================== */
      .site-footer { background-color: var(--surface-low) !important; color: var(--text-muted) !important; border-top: 1px solid rgba(59, 130, 246, 0.05) !important; }
      .footer-col h4, .footer-logo-text { color: #fff !important; }
      .footer-links a { color: var(--text-muted) !important; }
      .footer-links a:hover { color: var(--electric-blue) !important; }
    </style>
</head>
<body>
    <!-- ====== Preloader ====== -->
    <?php require('../../includes/preloader.html'); ?>

    <div class="wraper">
        <!-- ====== Global Header ====== -->
        <?php require('../../header-section.php'); ?>

        <div class="profile-wrapper">

            <!-- 1. Profile Header Area -->
            <section class="profile-header-area">
                <div class="container">
                    <div class="profile-identity">
                        <div class="avatar-container">
                            <img src="<?php echo $member['avatar']; ?>" alt="<?php echo $member['name']; ?>">
                        </div>
                        <div class="identity-text">
                            <h1><?php echo $member['name']; ?></h1>
                            <p><?php echo $member['title']; ?></p>
                        </div>
                        <div class="profile-header-actions">
                            <button class="btn-edit-profile" onclick="switchTab('settings')">
                                <span class="material-symbols-outlined">edit</span>
                                Edit Profile
                            </button>
                        </div>
                    </div>

                    <!-- 2. Stats Bar -->
                    <div class="stats-bar">
                        <div class="stat-box">
                            <span class="stat-value"><?php echo $member['posts']; ?></span>
                            <span class="stat-label">Total Posts</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-value"><?php echo $member['upvotes']; ?></span>
                            <span class="stat-label">Total Upvotes</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-value"><?php echo $member['replies']; ?></span>
                            <span class="stat-label">Replies Given</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-value"><?php echo $member['joined']; ?></span>
                            <span class="stat-label">Member Since</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Main Content Section -->
            <section class="profile-content-section">
                <div class="container">
                    <div class="row">

                        <!-- Left Column: Activity -->
                        <div class="col-lg-8">

                            <!-- Tabs Navigation -->
                            <nav class="activity-tabs">
                                <a class="tab-item active" onclick="switchTab('topics', this)">My Topics</a>
                                <a class="tab-item" onclick="switchTab('bookmarks', this)">Bookmarked</a>
                                <a class="tab-item" onclick="switchTab('replies', this)">Recent Replies</a>
                                <a class="tab-item" onclick="switchTab('settings', this)">Settings</a>
                            </nav>

                            <!-- Tab: Topics -->
                            <div id="tab-topics" class="tab-pane active">
                                <div class="activity-list">
                                    <div class="activity-card">
                                        <div class="activity-info">
                                            <h4>Optimization strategies for industrial IoT sensors</h4>
                                            <div class="activity-meta">
                                                <span>Posted 2 days ago</span>
                                                <span>24 Replies</span>
                                            </div>
                                        </div>
                                        <span class="status-pill status-trending">Trending</span>
                                    </div>
                                    <div class="activity-card">
                                        <div class="activity-info">
                                            <h4>Solved: Firmware mismatch in spider-node v2.4</h4>
                                            <div class="activity-meta">
                                                <span>Posted 1 week ago</span>
                                                <span>12 Replies</span>
                                            </div>
                                        </div>
                                        <span class="status-pill status-resolved">Resolved</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Bookmarks (Empty Placeholder) -->
                            <div id="tab-bookmarks" class="tab-pane">
                                <p class="text-muted">No bookmarked posts yet.</p>
                            </div>

                            <!-- Tab: Replies (Empty Placeholder) -->
                            <div id="tab-replies" class="tab-pane">
                                <p class="text-muted">No recent replies found.</p>
                            </div>

                            <!-- Tab: Settings -->
                            <div id="tab-settings" class="tab-pane">
                                <div class="settings-panel">
                                    <div class="settings-group">
                                        <h3>Identity & Bio</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label-custom">Full Name</label>
                                                <input type="text" class="input-custom" value="<?php echo $member['name']; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label-custom">Professional Title</label>
                                                <input type="text" class="input-custom" value="<?php echo $member['title']; ?>">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label-custom">Bio</label>
                                                <textarea class="input-custom" rows="3"><?php echo $member['bio']; ?></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label-custom">Company / Personal Link</label>
                                                <input type="url" class="input-custom" value="<?php echo $member['company']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h3>Notification Preferences</h3>
                                        <div class="pref-row">
                                            <div>
                                                <span class="d-block font-weight-bold">Email Notifications</span>
                                                <span class="text-muted small">Receive updates on topics you follow</span>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="emailNotif" checked>
                                                <label class="custom-control-label" for="emailNotif"></label>
                                            </div>
                                        </div>
                                        <div class="pref-row">
                                            <div>
                                                <span class="d-block font-weight-bold">Push Notifications</span>
                                                <span class="text-muted small">Get real-time alerts in browser</span>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="pushNotif">
                                                <label class="custom-control-label" for="pushNotif"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-block py-3 font-weight-bold" style="background: var(--electric-blue); border: none; border-radius: 12px;">Save Changes</button>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Sidebar -->
                        <div class="col-lg-4">
                            <div class="profile-sidebar">

                                <!-- Members You Follow -->
                                <div class="sidebar-widget">
                                    <h3>
                                        <span class="material-symbols-outlined">group</span>
                                        Following
                                    </h3>
                                    <div class="followed-members">
                                        <a href="javascript:void(0)" class="member-row">
                                            <div class="member-avatar">
                                                <img src="https://i.pravatar.cc/100?u=1" alt="Member">
                                            </div>
                                            <div>
                                                <span class="member-name">Dr. Sarah Chen</span>
                                                <span class="member-role">Hardware Lead</span>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" class="member-row">
                                            <div class="member-avatar">
                                                <img src="https://i.pravatar.cc/100?u=2" alt="Member">
                                            </div>
                                            <div>
                                                <span class="member-name">Marcus Vane</span>
                                                <span class="member-role">Security Researcher</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!-- Latest Badges -->
                                <div class="sidebar-widget">
                                    <h3>
                                        <span class="material-symbols-outlined">verified</span>
                                        Badges
                                    </h3>
                                    <div class="badge-grid">
                                        <div class="badge-item" title="Early Adopter">
                                            <span class="material-symbols-outlined">rocket_launch</span>
                                        </div>
                                        <div class="badge-item" title="Problem Solver">
                                            <span class="material-symbols-outlined">psychology</span>
                                        </div>
                                        <div class="badge-item" title="Contributed 10+ Posts">
                                            <span class="material-symbols-outlined">forum</span>
                                        </div>
                                        <div class="badge-item" title="Hardware Expert">
                                            <span class="material-symbols-outlined">memory</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div> <!-- /profile-wrapper -->

        <!-- ====== Global Footer ====== -->
        <?php require('../../footer-section.php'); ?>
    </div> <!-- /wraper -->

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchTab(tabId, el) {
            // Update Tab Links
            if(el) {
                document.querySelectorAll('.tab-item').forEach(link => link.classList.remove('active'));
                el.classList.add('active');
            } else {
                // Handle manual switch (e.g. from Edit Profile button)
                document.querySelectorAll('.tab-item').forEach(link => {
                    link.classList.remove('active');
                    if(link.innerText.toLowerCase().includes(tabId)) link.classList.add('active');
                });
            }

            // Update Tab Panes
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');
        }
    </script>
    <?php require("../../javascript-section.html"); ?>
</body>
</html>
