<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Spider Tech Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/lightbox.css">
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
    <script src="<?= BASE_URL ?>/js/lightbox.js"></script>
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
                <!-- Notifications Dropdown -->
                <div class="admin-notifications" x-data="adminNotifications()" x-init="init()">
                    <button @click="open = !open" class="notification-trigger" :class="{ 'has-unread': unreadCount > 0 }">
                        <span class="material-symbols-outlined">notifications</span>
                        <template x-if="unreadCount > 0">
                            <span class="notification-badge" x-text="unreadCount"></span>
                        </template>
                    </button>

                    <div x-show="open" @click.away="open = false" class="dropdown-menu-custom notification-dropdown" x-cloak x-transition>
                        <div class="dropdown-header-custom d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="mb-0 fw-bold poppins">Notifications</h6>
                            <div class="notification-filters d-flex gap-2">
                                <button @click="filter = 'all'; fetchNotifications()" class="btn btn-xs" :class="filter === 'all' ? 'btn-primary-custom btn-sm-custom' : 'btn-light text-muted'" style="font-size: 10px;">All</button>
                                <button @click="filter = 'unread'; fetchNotifications()" class="btn btn-xs" :class="filter === 'unread' ? 'btn-primary-custom btn-sm-custom' : 'btn-light text-muted'" style="font-size: 10px;">Unread</button>
                            </div>
                        </div>

                        <div class="notification-list" style="max-height: 350px; overflow-y: auto;">
                            <template x-for="notif in notifications" :key="notif.id">
                                <div class="notification-item p-3 border-bottom" :class="{ 'unread': !notif.is_read }">
                                    <div class="d-flex gap-3">
                                        <div class="notif-icon-circle flex-shrink-0">
                                            <span class="material-symbols-outlined text-orange" x-text="getIcon(notif.type)"></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <span class="fw-bold fs-08 text-dark" x-text="notif.type"></span>
                                                <span class="text-muted" style="font-size: 10px;" x-text="formatDate(notif.created_at)"></span>
                                            </div>
                                            <p class="mb-2 text-muted small" x-text="notif.message" style="line-height: 1.4;"></p>
                                            <div class="d-flex gap-2 align-items-center">
                                                <template x-if="notif.link">
                                                    <a :href="'<?= BASE_URL ?>/' + notif.link" class="btn btn-link p-0 text-orange small fw-600" style="font-size: 11px; text-decoration: none;">View Detail</a>
                                                </template>
                                                <template x-if="!notif.is_read">
                                                    <button @click="markRead(notif.id)" class="btn btn-link p-0 text-muted small" style="font-size: 11px; text-decoration: none;">Mark read</button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="notifications.length === 0">
                                <div class="p-5 text-center">
                                    <span class="material-symbols-outlined text-muted mb-2" style="font-size: 48px;">notifications_off</span>
                                    <p class="text-muted small">No notifications found.</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="admin-profile-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="profile-trigger">
                        <div class="profile-info">
                            <span class="profile-name"><?= $_SESSION['admin_name'] ?? 'Admin' ?></span>
                            <span class="profile-role"><?= $_SESSION['admin_privilege'] ?? 'Super Admin' ?></span>
                        </div>
                        <?php
                            $headerAvatar = !empty($_SESSION['admin_profile_pic']) ? BASE_URL . '/' . ltrim($_SESSION['admin_profile_pic'], './') : BASE_URL . '/img/member_dp.jpg';
                        ?>
                        <img src="<?= $headerAvatar ?>" alt="Profile" class="profile-avatar" onerror="this.src='<?= BASE_URL ?>/img/member_dp.jpg'">
                    </button>
                    <div x-show="open" @click.away="open = false" class="dropdown-menu-custom">
                        <a href="<?= BASE_URL ?>/admin/settings"><i class="fa fa-cog"></i> Settings</a>
                        <hr>
                        <a href="<?= BASE_URL ?>/admin/logout" class="text-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>
