<?php
$currentUrl = $_GET['url'] ?? 'admin/dashboard';
function isAdminActive($path, $current) {
    return (strpos($current, $path) !== false) ? 'active' : '';
}
?>
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Brand Header with Official Logo -->
    <div class="sidebar-logo">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="sidebar-brand-link" title="Spider Tech Admin">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" class="sidebar-logo-img">
        </a>
    </div>

    <!-- Navigation List -->
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-item <?= isAdminActive('admin/dashboard', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">dashboard</span>
            </span>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="nav-label">Content</div>
        <a href="<?= BASE_URL ?>/admin/banners" class="nav-item <?= isAdminActive('admin/banners', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">view_carousel</span>
            </span>
            <span class="nav-text">Hero Banners</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/services" class="nav-item <?= isAdminActive('admin/services', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">design_services</span>
            </span>
            <span class="nav-text">Services</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/projects" class="nav-item <?= isAdminActive('admin/projects', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">folder_special</span>
            </span>
            <span class="nav-text">Projects</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/blog" class="nav-item <?= isAdminActive('admin/blog', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">article</span>
            </span>
            <span class="nav-text">Blog Posts</span>
        </a>

        <div class="nav-label">Programs</div>
        <a href="<?= BASE_URL ?>/admin/events" class="nav-item <?= isAdminActive('admin/events', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">calendar_today</span>
            </span>
            <span class="nav-text">Events</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/trainings" class="nav-item <?= isAdminActive('admin/trainings', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">school</span>
            </span>
            <span class="nav-text">Trainings</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/cohorts" class="nav-item <?= isAdminActive('admin/cohorts', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">groups_2</span>
            </span>
            <span class="nav-text">Cohorts</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/applications" class="nav-item <?= isAdminActive('admin/applications', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">assignment_ind</span>
            </span>
            <span class="nav-text">Applications</span>
        </a>

        <div class="nav-label">Community</div>
        <a href="<?= BASE_URL ?>/admin/members" class="nav-item <?= isAdminActive('admin/members', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">group</span>
            </span>
            <span class="nav-text">Forum Members</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/faq" class="nav-item <?= isAdminActive('admin/faq', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">quiz</span>
            </span>
            <span class="nav-text">FAQs</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/testimonials" class="nav-item <?= isAdminActive('admin/testimonials', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">format_quote</span>
            </span>
            <span class="nav-text">Testimonials</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/partners" class="nav-item <?= isAdminActive('admin/partners', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">handshake</span>
            </span>
            <span class="nav-text">Partners</span>
        </a>

        <div class="nav-label">System</div>
        <a href="<?= BASE_URL ?>/admin/settings" class="nav-item <?= isAdminActive('admin/settings', $currentUrl) ?>">
            <span class="nav-icon-wrap">
                <span class="material-symbols-outlined">tune</span>
            </span>
            <span class="nav-text">Settings</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>/home" target="_blank" class="sidebar-site-link">
            <span class="material-symbols-outlined">open_in_new</span>
            <span>View Website</span>
        </a>
    </div>
</aside>

<main class="admin-main-content">
