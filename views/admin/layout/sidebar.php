<?php
$currentUrl = $_GET['url'] ?? 'admin/dashboard';
function isAdminActive($path, $current) {
    return (strpos($current, $path) !== false) ? 'active' : '';
}
?>
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-logo">
        <a href="<?= BASE_URL ?>/admin/dashboard">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech">
            <span>Control Panel</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-item <?= isAdminActive('admin/dashboard', $currentUrl) ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>

        <div class="nav-label">Content</div>
        <a href="<?= BASE_URL ?>/admin/banners" class="nav-item <?= isAdminActive('admin/banners', $currentUrl) ?>">
            <span class="material-symbols-outlined">imagesmode</span>
            <span>Banners</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/services" class="nav-item <?= isAdminActive('admin/services', $currentUrl) ?>">
            <span class="material-symbols-outlined">settings_suggest</span>
            <span>Services</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/projects" class="nav-item <?= isAdminActive('admin/projects', $currentUrl) ?>">
            <span class="material-symbols-outlined">work</span>
            <span>Projects</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/blog" class="nav-item <?= isAdminActive('admin/blog', $currentUrl) ?>">
            <span class="material-symbols-outlined">article</span>
            <span>Blog Posts</span>
        </a>

        <div class="nav-label">Programs</div>
        <a href="<?= BASE_URL ?>/admin/events" class="nav-item <?= isAdminActive('admin/events', $currentUrl) ?>">
            <span class="material-symbols-outlined">calendar_month</span>
            <span>Events</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/trainings" class="nav-item <?= isAdminActive('admin/trainings', $currentUrl) ?>">
            <span class="material-symbols-outlined">school</span>
            <span>Trainings</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/applications" class="nav-item <?= isAdminActive('admin/applications', $currentUrl) ?>">
            <span class="material-symbols-outlined">assignment_ind</span>
            <span>Applications</span>
        </a>

        <div class="nav-label">Management</div>
        <a href="<?= BASE_URL ?>/admin/members" class="nav-item <?= isAdminActive('admin/members', $currentUrl) ?>">
            <span class="material-symbols-outlined">group</span>
            <span>Forum Members</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/faq" class="nav-item <?= isAdminActive('admin/faq', $currentUrl) ?>">
            <span class="material-symbols-outlined">help_center</span>
            <span>FAQs</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/testimonials" class="nav-item <?= isAdminActive('admin/testimonials', $currentUrl) ?>">
            <span class="material-symbols-outlined">reviews</span>
            <span>Testimonials</span>
        </a>

        <div class="nav-label">System</div>
        <a href="<?= BASE_URL ?>/admin/settings" class="nav-item <?= isAdminActive('admin/settings', $currentUrl) ?>">
            <span class="material-symbols-outlined">settings</span>
            <span>System Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>/home" target="_blank" class="view-site-btn">
            <span class="material-symbols-outlined">open_in_new</span>
            <span>View Website</span>
        </a>
    </div>
</aside>

<main class="admin-main-content">
