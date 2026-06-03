<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Spider Tech Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin-custom.css">
    <script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- CKEditor 5 for Rich Text Content -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <!-- Top Navigation Bar -->
        <header class="admin-header">
            <div class="header-left">
                <button id="sidebarToggle" class="sidebar-toggle">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="admin-breadcrumb">
                    <span class="text-muted">Admin</span>
                    <span class="separator">/</span>
                    <span class="current-page"><?= ucfirst(explode('/', $_GET['url'] ?? 'dashboard')[1] ?? 'dashboard') ?></span>
                </div>
            </div>
            <div class="header-right">
                <div class="admin-profile-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="profile-trigger">
                        <div class="profile-info">
                            <span class="profile-name"><?= $_SESSION['admin_name'] ?? 'Admin' ?></span>
                            <span class="profile-role"><?= $_SESSION['admin_privilege'] ?? 'Super Admin' ?></span>
                        </div>
                        <img src="<?= BASE_URL ?>/images/testimonials.png" alt="Profile" class="profile-avatar">
                    </button>
                    <div x-show="open" @click.away="open = false" class="dropdown-menu-custom">
                        <a href="<?= BASE_URL ?>/admin/settings"><i class="fa fa-cog"></i> Settings</a>
                        <hr>
                        <a href="<?= BASE_URL ?>/admin/logout" class="text-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>
