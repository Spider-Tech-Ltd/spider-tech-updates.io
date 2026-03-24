<?php
/**
 * Member Sidebar Widget — Enhanced with Logout Icon
 */
require_once __DIR__ . '/../../../config/db.php';

$memberId = $_SESSION['member_id'] ?? 0;
$memberName = $_SESSION['username'] ?? 'Member';

// Fetch stats for sidebar
try {
    $stmtPosts = $conn->prepare("SELECT COUNT(*) FROM feeds WHERE member_id = ?");
    $stmtPosts->execute([$memberId]);
    $postsCount = $stmtPosts->fetchColumn();
} catch (PDOException $e) {
    $postsCount = 0;
}
?>

<style>
  .sidebar-widget { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
  .widget-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
  .profile-snippet { text-align: center; }
  .ps-avatar { width: 64px; height: 64px; border-radius: 20px; margin-bottom: 12px; }
  .ps-name { display: block; font-weight: 700; color: #0f172a; font-size: 1.1rem; }
  .ps-stats { display: flex; justify-content: center; gap: 20px; margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; }
  .ps-stat-item { text-align: center; }
  .ps-stat-val { display: block; font-weight: 800; color: #3b82f6; }
  .ps-stat-lab { font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; }
  .btn-logout-icon { color: #94a3b8; transition: color 0.2s; text-decoration: none !important; }
  .btn-logout-icon:hover { color: #ef4444; }
</style>

<aside class="forum-member-sidebar">

  <!-- Profile Widget -->
  <section class="sidebar-widget">
    <div class="widget-title">
        <span>Your Profile</span>
        <a href="pages/forum/logout.php" class="btn-logout-icon" title="Sign Out">
            <span class="material-symbols-outlined">logout</span>
        </a>
    </div>
    <div class="profile-snippet">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($memberName); ?>&background=3b82f6&color=fff&size=64" class="ps-avatar" alt="Avatar">
        <span class="ps-name"><?php echo htmlspecialchars($memberName); ?></span>

        <div class="ps-stats">
            <div class="ps-stat-item">
                <span class="ps-stat-val"><?php echo $postsCount; ?></span>
                <span class="ps-stat-lab">Posts</span>
            </div>
            <div class="ps-stat-item">
                <span class="ps-stat-val">12</span>
                <span class="ps-stat-lab">Likes</span>
            </div>
        </div>

        <a href="pages/forum/profile.php" class="btn btn-outline-primary btn-sm btn-block mt-3 rounded-pill font-weight-bold" style="border-width:2px;">View Profile</a>
    </div>
  </section>

  <!-- Trending Discussions -->
  <section class="sidebar-widget">
    <div class="widget-title">Trending Discussions</div>
    <div class="trending-list d-flex flex-column gap-3">
        <a href="javascript:void(0)" class="text-dark font-weight-bold small text-decoration-none">AI in Heavy Industry <span class="badge badge-light float-right">🔥</span></a>
        <a href="javascript:void(0)" class="text-dark font-weight-bold small text-decoration-none">SCADA Security 2026</a>
        <a href="javascript:void(0)" class="text-dark font-weight-bold small text-decoration-none">Solar Hybrid ROI</a>
    </div>
  </section>

</aside>
