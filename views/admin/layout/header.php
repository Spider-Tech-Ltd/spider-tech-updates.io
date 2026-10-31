<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Spider Tech Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/lightbox.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/flaticon.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                <button id="sidebarToggle" class="sidebar-toggle" aria-label="Toggle Sidebar">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="admin-breadcrumb">
                    <span class="breadcrumb-item">Admin</span>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-item active"><?= ucfirst(explode('/', $_GET['url'] ?? 'dashboard')[1] ?? 'dashboard') ?></span>
                </div>
            </div>

            <div class="header-right">
                <!-- Notifications Dropdown -->
                <div class="admin-notifications" x-data="adminNotifications()" x-init="init()">
                    <button @click="open = !open" class="notification-trigger" :class="{ 'has-unread': unreadCount > 0 }" title="Notifications">
                        <span class="material-symbols-outlined">notifications</span>
                        <template x-if="unreadCount > 0">
                            <span class="notification-badge" x-text="unreadCount"></span>
                        </template>
                    </button>

                    <div x-show="open" @click.away="open = false" class="dropdown-menu-custom notification-dropdown" x-cloak x-transition>
                        <div class="dropdown-header-custom d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="mb-0 fw-bold poppins" style="font-size: 0.88rem;">Notifications</h6>
                            <div class="notification-filters d-flex gap-2">
                                <button @click="filter = 'all'; fetchNotifications()" class="btn btn-xs" :class="filter === 'all' ? 'btn-primary-custom btn-sm-custom' : 'btn-light text-muted'" style="font-size: 11px;">All</button>
                                <button @click="filter = 'unread'; fetchNotifications()" class="btn btn-xs" :class="filter === 'unread' ? 'btn-primary-custom btn-sm-custom' : 'btn-light text-muted'" style="font-size: 11px;">Unread</button>
                            </div>
                        </div>

                        <div class="notification-list" style="max-height: 340px; overflow-y: auto;">
                            <template x-for="notif in notifications" :key="notif.id">
                                <div class="notification-item p-3 border-bottom" :class="{ 'unread': !notif.is_read }">
                                    <div class="d-flex gap-3">
                                        <div class="notif-icon-circle flex-shrink-0">
                                            <span class="material-symbols-outlined text-orange" x-text="getIcon(notif.type)"></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <span class="fw-bold fs-08 text-dark" x-text="notif.type"></span>
                                                <span class="text-muted" style="font-size: 11px;" x-text="formatDate(notif.created_at)"></span>
                                            </div>
                                            <p class="mb-2 text-muted small" x-text="notif.message" style="line-height: 1.4;"></p>
                                            <div class="d-flex gap-2 align-items-center">
                                                <template x-if="notif.link">
                                                    <a :href="'<?= BASE_URL ?>/' + notif.link" class="btn btn-link p-0 text-orange small fw-600" style="font-size: 11px; text-decoration: none;">View Detail &rarr;</a>
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
                                <div class="p-4 text-center">
                                    <span class="material-symbols-outlined text-muted mb-2" style="font-size: 32px;">notifications_none</span>
                                    <p class="text-muted small mb-0">No notifications.</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Admin Profile Dropdown Trigger -->
                <div class="admin-profile-dropdown" x-data="{ open: false }">
                    <?php
                        $adminPicPath = !empty($_SESSION['admin_profile_pic']) ? ltrim($_SESSION['admin_profile_pic'], './') : '';
                        $hasValidAdminPic = !empty($adminPicPath) && file_exists(ROOT_PATH . '/' . $adminPicPath);
                        $headerAvatar = $hasValidAdminPic ? BASE_URL . '/' . $adminPicPath : BASE_URL . '/img/admin-avatar.svg';
                        $adminRole = !empty($_SESSION['admin_privilege']) ? $_SESSION['admin_privilege'] : 'Super Admin';
                    ?>
                    <button @click="open = !open" 
                            class="profile-trigger" 
                            :class="{ 'active': open }" 
                            title="Account Settings & Quick Actions">
                        <img src="<?= $headerAvatar ?>" alt="Profile" class="profile-avatar" onerror="this.src='<?= BASE_URL ?>/img/admin-avatar.svg'">
                        <div class="profile-info d-none d-sm-flex">
                            <span class="profile-name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
                            <span class="profile-role"><?= htmlspecialchars($adminRole) ?></span>
                        </div>
                        <span class="material-symbols-outlined profile-chevron" :style="open ? 'transform: rotate(180deg);' : ''">expand_more</span>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false" 
                         class="dropdown-menu-custom profile-menu" 
                         x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95">
                        
                        <!-- Executive Header Inside Dropdown -->
                        <div class="profile-menu-header">
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?= $headerAvatar ?>" 
                                     alt="Profile" 
                                     class="rounded-circle" 
                                     style="width: 36px; height: 36px; object-fit: cover; border: 1.5px solid #e2e8f0;">
                                <div class="overflow-hidden">
                                    <div class="fw-700 text-dark text-truncate" style="font-size: 0.86rem; font-family: 'Poppins', sans-serif;">
                                        <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>
                                    </div>
                                    <span class="badge <?= ($adminRole === 'Super Admin') ? 'badge-soft-orange' : 'badge-soft-blue' ?>" 
                                          style="font-size: 0.66rem; padding: 2px 7px; border-radius: 50px;">
                                        <?= htmlspecialchars($adminRole) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div>
                            <a href="<?= BASE_URL ?>/admin/settings?tab=profile" class="dropdown-link-item">
                                <span class="material-symbols-outlined">person</span>
                                <span>Profile & Security</span>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/settings" class="dropdown-link-item">
                                <span class="material-symbols-outlined">settings</span>
                                <span>System Settings</span>
                            </a>
                            <a href="<?= BASE_URL ?>/home" target="_blank" class="dropdown-link-item">
                                <span class="material-symbols-outlined">open_in_new</span>
                                <span>Public Website</span>
                            </a>

                            <div class="my-1 border-top" style="border-color: #f1f5f9 !important;"></div>

                            <a href="<?= BASE_URL ?>/admin/logout" class="dropdown-link-item text-danger">
                                <span class="material-symbols-outlined">logout</span>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
