<?php
/**
 * Professional Minimalistic Members Profile Page
 */
require_once '../../config/db.php';
require_once '../../auth/middleware.php';

requireAuth();

$memberUuid = $_SESSION['member_uuid'];

try {
    $stmt = $conn->prepare("SELECT * FROM members WHERE uuid = ?");
    $stmt->execute([$memberUuid]);
    $memberData = $stmt->fetch();

    if (!$memberData) {
        die("Member not found.");
    }

    // Fetch stats
    $stmtStats = $conn->prepare("SELECT COUNT(*) FROM feeds WHERE member_id = ?");
    $stmtStats->execute([$memberData['id']]);
    $postCount = $stmtStats->fetchColumn();

} catch (PDOException $e) {
    error_log("Profile Fetch Error: " . $e->getMessage());
    die("A database error occurred.");
}
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <?php require('../../head-section.html'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <title><?php echo htmlspecialchars($memberData['username']); ?> — Profile</title>
    <style>
      :root { --electric-blue: #3b82f6; --brand-orange: #f48221; --bg-light: #f8fafc; --text-main: #1e293b; }
      body { background-color: var(--bg-light); font-family: 'Poppins', sans-serif; color: var(--text-main); }
      .profile-header-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 40px; margin-top: 60px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
      .profile-avatar-lg { width: 100px; height: 100px; border-radius: 30px; object-fit: cover; border: 4px solid #f1f5f9; }
      .profile-info-group { margin-left: 24px; }
      .profile-name-h { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em; }
      .profile-email-sub { color: #64748b; font-size: 0.95rem; }
      .stat-pill { background: #f1f5f9; padding: 8px 20px; border-radius: 50px; font-weight: 700; color: var(--electric-blue); font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; }
      .profile-tabs { display: flex; gap: 32px; border-bottom: 1px solid #e2e8f0; margin-top: 40px; margin-bottom: 32px; }
      .p-tab-link { padding-bottom: 16px; font-weight: 600; color: #64748b; text-decoration: none !important; position: relative; transition: color 0.2s; }
      .p-tab-link.active { color: var(--electric-blue); }
      .p-tab-link.active::after { content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 3px; background: var(--electric-blue); border-radius: 50px; }
      .content-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; }
      .logout-link-red { color: #ef4444; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none !important; margin-top: 20px; }
      .logout-link-red:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <?php require('../../includes/preloader.html'); ?>
    <div class="wraper">
        <?php require('../../header-section.php'); ?>

        <div class="container py-5" style="padding-top: 100px !important;">
            <div class="profile-header-card d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($memberData['username']); ?>&background=3b82f6&color=fff&size=128" class="profile-avatar-lg" alt="Avatar">
                <div class="profile-info-group flex-grow-1">
                    <h1 class="profile-name-h"><?php echo htmlspecialchars($memberData['username']); ?></h1>
                    <p class="profile-email-sub"><?php echo htmlspecialchars($memberData['email']); ?></p>
                    <div class="stat-pill">
                        <span class="material-symbols-outlined" style="font-size:18px">forum</span>
                        <?php echo $postCount; ?> Total Posts
                    </div>
                </div>
                <div>
                    <a href="pages/forum/logout.php" class="logout-link-red">
                        <span class="material-symbols-outlined">logout</span>
                        Sign Out
                    </a>
                </div>
            </div>

            <div class="profile-tabs">
                <a href="javascript:void(0)" class="p-tab-link active">Overview</a>
                <a href="javascript:void(0)" class="p-tab-link">My Discussions</a>
                <a href="javascript:void(0)" class="p-tab-link">Account Settings</a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card mb-4">
                        <h3 class="h5 font-weight-bold mb-4">Personal Information</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase">Username</label>
                                <p class="font-weight-bold"><?php echo htmlspecialchars($memberData['username']); ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold text-uppercase">Member Since</label>
                                <p class="font-weight-bold"><?php echo date('F j, Y', strtotime($memberData['created_at'])); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="content-card">
                        <h3 class="h5 font-weight-bold mb-3">Account Status</h3>
                        <p class="text-muted small">Your account is active and verified for the Spider Tech Community.</p>
                        <hr>
                        <a href="pages/forum/new-topic.php" class="btn btn-primary btn-block py-2 font-weight-bold rounded-pill" style="background:var(--electric-blue); border:none;">New Topic</a>
                    </div>
                </div>
            </div>
        </div>

        <?php require('../../footer-section.php'); ?>
    </div>
    <?php require('../../javascript-section.html'); ?>
</body>
</html>
