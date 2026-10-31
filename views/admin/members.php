<!-- Forum Members Management — Spider Tech Admin Operations Console -->
<?php
$allList = $members ?? [];
$totalCount = $pagination['total_records'] ?? count($allList);
$hasActiveFilters = (($current_status ?? 'all') !== 'all' || !empty($search_query));
$reviewsList = $reviews ?? [];
$pendingReviewsCount = (int)($stats['pending_reviews'] ?? 0);
?>

<div x-data="{
    activeTab: '<?= !empty($_GET['tab']) ? htmlspecialchars($_GET['tab']) : 'members' ?>'
}">
    <!-- Header -->
    <div class="dashboard-header mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center mb-1">
                    <h1 class="dashboard-title mb-0">Forum Members</h1>
                    <span class="title-badge-count"><?= (int)$totalCount ?> total</span>
                </div>
                <p class="dashboard-subtitle">Manage community users, account verification states, and suspension appeal reviews.</p>
            </div>
            
            <!-- Segmented View Mode Tabs -->
            <div class="d-inline-flex p-1 bg-white border shadow-xs" style="border-radius: 50px !important; border-color: #e2e8f0 !important;">
                <button type="button" 
                        class="btn btn-sm px-3 py-1 fw-600 d-inline-flex align-items-center gap-2 border-0" 
                        :class="activeTab === 'members' ? 'btn-primary-custom' : 'bg-transparent text-muted'"
                        @click="activeTab = 'members'; const u = new URL(window.location); u.searchParams.set('tab', 'members'); window.history.replaceState({}, '', u);"
                        style="border-radius: 50px !important; font-size: 0.82rem; transition: all 0.15s ease;">
                    <span class="material-symbols-outlined fs-16">group</span>
                    <span>All Members</span>
                    <span class="badge" :class="activeTab === 'members' ? 'bg-white text-dark' : 'bg-light text-muted'" style="border-radius: 50px !important; font-size: 0.7rem; padding: 2px 8px;">
                        <?= (int)$totalCount ?>
                    </span>
                </button>
                <button type="button" 
                        class="btn btn-sm px-3 py-1 fw-600 d-inline-flex align-items-center gap-2 border-0" 
                        :class="activeTab === 'reviews' ? 'btn-primary-custom' : 'bg-transparent text-muted'"
                        @click="activeTab = 'reviews'; const u = new URL(window.location); u.searchParams.set('tab', 'reviews'); window.history.replaceState({}, '', u);"
                        style="border-radius: 50px !important; font-size: 0.82rem; transition: all 0.15s ease;">
                    <span class="material-symbols-outlined fs-16">rate_review</span>
                    <span>Review Requests</span>
                    <?php if ($pendingReviewsCount > 0): ?>
                        <span class="badge bg-danger text-white" style="border-radius: 50px !important; font-size: 0.7rem; padding: 2px 8px;">
                            <?= $pendingReviewsCount ?>
                        </span>
                    <?php else: ?>
                        <span class="badge" :class="activeTab === 'reviews' ? 'bg-white text-dark' : 'bg-light text-muted'" style="border-radius: 50px !important; font-size: 0.7rem; padding: 2px 8px;">
                            <?= count($reviewsList) ?>
                        </span>
                    <?php endif; ?>
                </button>
            </div>
        </div>
    </div>

<!-- ====================================================
         KPI SUMMARY CARDS
         ==================================================== -->
    <div class="apps-stats-grid mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Total Community</span>
                <span class="stat-icon bg-soft-blue text-blue">
                    <span class="material-symbols-outlined">group</span>
                </span>
            </div>
            <div class="stat-value"><?= number_format($stats['total_members'] ?? 0) ?></div>
            <div class="stat-desc">Registered forum member profiles</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Verified Members</span>
                <span class="stat-icon bg-soft-green text-green">
                    <span class="material-symbols-outlined">verified_user</span>
                </span>
            </div>
            <div class="stat-value"><?= number_format($stats['verified_members'] ?? 0) ?></div>
            <div class="stat-desc">Email-authenticated accounts</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Pending Verification</span>
                <span class="stat-icon bg-soft-orange text-orange">
                    <span class="material-symbols-outlined">pending</span>
                </span>
            </div>
            <div class="stat-value"><?= number_format($stats['pending_members'] ?? 0) ?></div>
            <div class="stat-desc">Awaiting activation or verification</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Suspension Reviews</span>
                <span class="stat-icon bg-soft-purple text-purple">
                    <span class="material-symbols-outlined">gavel</span>
                </span>
            </div>
            <div class="stat-value"><?= number_format($stats['suspended_members'] ?? 0) ?></div>
            <div class="stat-desc"><?= $pendingReviewsCount ?> active appeal requests</div>
        </div>
    </div>

    <!-- ====================================================
         TAB 1: FULL-WIDTH MEMBERS TABLE
         ==================================================== -->
    <div x-show="activeTab === 'members'" x-cloak>
        <div class="admin-card">
            <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <!-- Integrated Search Bar (340px) -->
                    <form method="GET" action="<?= BASE_URL ?>/admin/members" class="m-0">
                        <?php if (!empty($current_limit)): ?>
                            <input type="hidden" name="limit" value="<?= htmlspecialchars((string)$current_limit) ?>">
                        <?php endif; ?>
                        <?php if (!empty($current_sort)): ?>
                            <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                        <?php endif; ?>
                        <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                            <input type="hidden" name="status" value="<?= htmlspecialchars($current_status) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="tab" value="members">

                        <div class="search-bar-integrated">
                            <span class="material-symbols-outlined search-icon">search</span>
                            <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search member name, handle, email...">
                            <?php if (!empty($search_query)): ?>
                                <a href="<?= BASE_URL ?>/admin/members?tab=members" class="search-clear-btn" title="Clear Search">
                                    <span class="material-symbols-outlined fs-16">close</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <?php if ($hasActiveFilters): ?>
                        <a href="<?= BASE_URL ?>/admin/members?tab=members" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                            <span class="material-symbols-outlined fs-14">close</span>
                            <span>Reset</span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="table-toolbar-right">
                    <!-- Custom Brand Dropdown: Status Filter -->
                    <div class="custom-dropdown" x-data="{
                        open: false,
                        current: '<?= $current_status ?? 'all' ?>',
                        label: '<?= match($current_status ?? 'all') { 'verified' => 'Verified Only', 'pending' => 'Pending Only', 'suspended' => 'Suspended Only', default => 'All Members' } ?>'
                    }" @click.outside="open = false">
                        <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                            <span class="d-flex align-items-center">
                                <span class="custom-dropdown-label">Status:</span>
                                <strong class="custom-dropdown-val" x-text="label"></strong>
                            </span>
                            <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="custom-dropdown-menu" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyMemberParam('status', 'all'); open = false;">
                                <span>All Members</span>
                                <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'verified' }" @click="applyMemberParam('status', 'verified'); open = false;">
                                <span>Verified Only</span>
                                <svg class="check-icon" x-show="current === 'verified'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'pending' }" @click="applyMemberParam('status', 'pending'); open = false;">
                                <span>Pending Only</span>
                                <svg class="check-icon" x-show="current === 'pending'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'suspended' }" @click="applyMemberParam('status', 'suspended'); open = false;">
                                <span>Suspended Only</span>
                                <svg class="check-icon" x-show="current === 'suspended'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Custom Brand Dropdown: Sort -->
                    <div class="custom-dropdown" x-data="{
                        open: false,
                        current: '<?= $current_sort ?? 'id_desc' ?>',
                        label: '<?= match($current_sort ?? 'id_desc') { 'date_asc' => 'Joined (Oldest)', 'name_asc' => 'Name (A to Z)', 'name_desc' => 'Name (Z to A)', default => 'Joined (Recent)' } ?>'
                    }" @click.outside="open = false">
                        <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                            <span class="d-flex align-items-center">
                                <span class="custom-dropdown-label">Sort:</span>
                                <strong class="custom-dropdown-val" x-text="label"></strong>
                            </span>
                            <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="custom-dropdown-menu" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyMemberParam('sort', 'id_desc'); open = false;">
                                <span>Joined (Recent First)</span>
                                <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'date_asc' }" @click="applyMemberParam('sort', 'date_asc'); open = false;">
                                <span>Joined (Oldest First)</span>
                                <svg class="check-icon" x-show="current === 'date_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_asc' }" @click="applyMemberParam('sort', 'name_asc'); open = false;">
                                <span>Name (A &rarr; Z)</span>
                                <svg class="check-icon" x-show="current === 'name_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_desc' }" @click="applyMemberParam('sort', 'name_desc'); open = false;">
                                <span>Name (Z &rarr; A)</span>
                                <svg class="check-icon" x-show="current === 'name_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Custom Brand Dropdown: Rows Per Page -->
                    <div class="custom-dropdown" x-data="{
                        open: false,
                        current: '<?= (string)$current_limit ?>',
                        label: '<?= (string)$current_limit ?> rows'
                    }" @click.outside="open = false">
                        <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                            <span class="d-flex align-items-center">
                                <span class="custom-dropdown-label">Show:</span>
                                <strong class="custom-dropdown-val" x-text="label"></strong>
                            </span>
                            <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="custom-dropdown-menu" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '10' }" @click="applyMemberParam('limit', '10'); open = false;">
                                <span>10 rows</span>
                                <svg class="check-icon" x-show="current === '10'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '25' }" @click="applyMemberParam('limit', '25'); open = false;">
                                <span>25 rows</span>
                                <svg class="check-icon" x-show="current === '25'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '50' }" @click="applyMemberParam('limit', '50'); open = false;">
                                <span>50 rows</span>
                                <svg class="check-icon" x-show="current === '50'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full-Width Data Table -->
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th style="min-width: 250px;">Member Profile</th>
                                <th style="min-width: 220px;">Email Address</th>
                                <th style="min-width: 140px;">Account Status</th>
                                <th style="min-width: 150px;">Registration Date</th>
                                <th class="text-end" style="width: 130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($members)): ?>
                                <?php foreach ($members as $member):
                                    $avatarPath = $member['avatar'] ?? null;
                                    $defaultAvatar = BASE_URL . '/img/default-user.svg';

                                    if ($avatarPath) {
                                        $avatar = (strpos($avatarPath, 'uploads/') !== false) ? BASE_URL . '/' . ltrim($avatarPath, '/') : BASE_URL . '/uploads/forum/avatars/' . $avatarPath;
                                    } else {
                                        $avatar = $defaultAvatar;
                                    }
                                    $isVerified = (int)($member['is_verified'] ?? 0);
                                    $status = $member['status'] ?? 'Active';
                                ?>
                                <tr>
                                    <!-- Member Profile -->
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="flex-shrink-0" style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; background: #f1f5f9; border: 1.5px solid #e2e8f0;">
                                                <img src="<?= $avatar ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?= $defaultAvatar ?>'">
                                            </div>
                                            <div class="min-w-0">
                                                <div class="fw-600 text-dark" style="font-size: 0.88rem; line-height: 1.25;">
                                                    <?= htmlspecialchars($member['name']) ?>
                                                </div>
                                                <div class="text-muted" style="font-size: 0.76rem; margin-top: 2px;">
                                                    @<?= htmlspecialchars($member['username']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td>
                                        <div class="text-dark fw-500" style="font-size: 0.83rem;">
                                            <?= htmlspecialchars($member['email']) ?>
                                        </div>
                                    </td>

                                    <!-- Account Status -->
                                    <td>
                                        <?php if ($status === 'Suspended'): ?>
                                            <span class="badge" style="background: rgba(239, 68, 68, 0.09); color: #dc2626; font-size: 0.74rem; font-weight: 600; padding: 4px 9px; border-radius: 6px;">
                                                Suspended
                                            </span>
                                        <?php elseif ($isVerified): ?>
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.09); color: #059669; font-size: 0.74rem; font-weight: 600; padding: 4px 9px; border-radius: 6px;">
                                                <span class="status-pulse-dot bg-success me-1"></span> Verified
                                            </span>
                                        <?php else: ?>
                                            <span class="badge" style="background: rgba(244, 130, 33, 0.09); color: #c25e00; font-size: 0.74rem; font-weight: 600; padding: 4px 9px; border-radius: 6px;">
                                                Pending Verification
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Registration Date -->
                                    <td>
                                        <div class="text-dark fw-500" style="font-size: 0.82rem;">
                                            <span class="material-symbols-outlined fs-14 text-muted align-middle me-1">calendar_month</span>
                                            <span><?= date('M d, Y', strtotime($member['created_at'])) ?></span>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <div class="action-btns justify-content-end">
                                            <button type="button" class="btn-action edit" title="View Profile Dossier" onclick="viewMemberDetails(<?= $member['id'] ?>)">
                                                <span class="material-symbols-outlined fs-16">visibility</span>
                                            </button>
                                            <button type="button" class="btn-action <?= $status === 'Suspended' ? '' : 'delete' ?>" 
                                                    title="<?= $status === 'Suspended' ? 'Activate Member Account' : 'Suspend Member Access' ?>" 
                                                    onclick="confirmToggleStatus(<?= $member['id'] ?>, '<?= $status ?>')">
                                                <span class="material-symbols-outlined fs-16"><?= $status === 'Suspended' ? 'person' : 'person_off' ?></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 48px;">group_off</span>
                                            <p class="text-muted mt-2 mb-3">No members match your search or filter criteria.</p>
                                            <?php if ($hasActiveFilters): ?>
                                                <a href="<?= BASE_URL ?>/admin/members?tab=members" class="btn btn-sm btn-outline-custom">Reset Filters</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
            </div>
        </div>
    </div>

        <!-- ====================================================
         TAB 2: FULL-WIDTH SUSPENSION REVIEWS SECTION
         ==================================================== -->
    <div x-show="activeTab === 'reviews'" x-cloak>
        <div class="admin-card">
            <div class="card-header-custom d-flex flex-wrap justify-content-between align-items-center py-3 px-4 border-bottom gap-2" style="background: #ffffff; border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">gavel</span>
                    <h5 class="m-0 fw-700 text-dark" style="font-size: 0.98rem; font-family: 'Poppins', sans-serif;">Suspension Appeals & Reviews</h5>
                    <span class="badge bg-light text-muted border px-2 py-1 fs-07" style="border-radius: 50px !important;">
                        <?= count($reviewsList) ?> total
                    </span>
                </div>
                <span class="text-muted fs-08">
                    Review and decide on reactivation appeals submitted by suspended members
                </span>
            </div>

            <div class="card-body-custom p-3 p-md-4">
                <?php if (empty($reviewsList)): ?>
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: #f0fdf4; color: #16a34a;">
                            <span class="material-symbols-outlined" style="font-size: 26px;">verified</span>
                        </div>
                        <h6 class="fw-700 text-dark mb-1">All Caught Up</h6>
                        <p class="text-muted fs-08 mb-0" style="max-width: 420px; margin: 0 auto;">There are currently no suspended members awaiting reactivation review.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3" style="row-gap: 20px;">
                        <?php foreach ($reviewsList as $rev):
                            $isPending = ($rev['status'] === 'Pending');
                            $nameParts = explode(' ', trim($rev['name'] ?? 'User'));
                            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            if (!$initials) $initials = 'U';
                        ?>
                            <div class="col-xl-4 col-md-6 col-12" x-data="{ localStatus: '<?= htmlspecialchars($rev['status']) ?>' }">
                                <div class="review-appeal-card h-100 d-flex flex-column justify-content-between bg-white border shadow-xs" 
                                     style="padding: 14px 16px; border-color: #e2e8f0 !important; border-radius: 12px !important; transition: all 0.2s ease;">
                                    <div>
                                        <!-- Header: Avatar, Name & Status Badge -->
                                        <div class="d-flex justify-content-between align-items-start gap-2" style="margin-bottom: 10px;">
                                            <div class="d-flex align-items-center gap-2 min-w-0">
                                                <div class="avatar-initials-badge d-flex align-items-center justify-content-center flex-shrink-0"
                                                     style="width: 34px; height: 34px; border-radius: 8px; font-weight: 700; font-size: 0.78rem; <?= $isPending ? 'background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;' ?>">
                                                    <?= htmlspecialchars($initials) ?>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span class="fw-700 text-dark text-truncate" style="font-size: 0.88rem; letter-spacing: -0.2px;">
                                                            <?= htmlspecialchars($rev['name']) ?>
                                                        </span>
                                                        <button type="button" 
                                                                class="btn btn-link p-0 text-muted d-inline-flex align-items-center" 
                                                                title="View Full Profile Dossier"
                                                                onclick="openMemberModal(<?= (int)$rev['member_id'] ?>)"
                                                                style="color: #94a3b8 !important; text-decoration: none;">
                                                            <span class="material-symbols-outlined" style="font-size: 13px;">open_in_new</span>
                                                        </button>
                                                    </div>
                                                    <div class="text-muted text-truncate" style="font-size: 0.72rem;">
                                                        <span class="fw-600" style="color: #475569;">@<?= htmlspecialchars($rev['username']) ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Pill -->
                                            <div class="flex-shrink-0">
                                                <template x-if="localStatus === 'Pending'">
                                                    <span class="d-inline-flex align-items-center gap-1" 
                                                          style="padding: 2px 8px; background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; border-radius: 50px !important; font-size: 0.68rem; font-weight: 600;">
                                                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #ea580c; display: inline-block;"></span>
                                                        <span>Pending</span>
                                                    </span>
                                                </template>
                                                <template x-if="localStatus !== 'Pending'">
                                                    <span class="d-inline-flex align-items-center gap-1" 
                                                          style="padding: 2px 8px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 50px !important; font-size: 0.68rem; font-weight: 600;">
                                                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                                        <span>Resolved</span>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Statement / Appeal Callout Box -->
                                        <div style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 8px !important; padding: 10px 12px; margin-bottom: 12px; min-height: 56px;">
                                            <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.66rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 4px;">
                                                <span class="material-symbols-outlined text-orange" style="font-size: 13px;">format_quote</span>
                                                <span>Appeal Reason</span>
                                            </div>
                                            <p class="mb-0 text-dark" style="font-size: 0.81rem; line-height: 1.5; color: #334155 !important; font-weight: 400;">
                                                <?= nl2br(htmlspecialchars(trim($rev['reason']))) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Footer: Timestamp & Action Button -->
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #f1f5f9 !important;">
                                        <div class="d-inline-flex align-items-center gap-1 text-muted" style="font-size: 0.7rem;">
                                            <span class="material-symbols-outlined text-light" style="font-size: 13px;">schedule</span>
                                            <span><?= date('M d, Y · h:i A', strtotime($rev['created_at'])) ?></span>
                                        </div>
                                        <div>
                                            <template x-if="localStatus === 'Pending'">
                                                <button type="button" 
                                                        class="btn btn-sm btn-primary-custom d-inline-flex align-items-center gap-1" 
                                                        style="padding: 3px 10px; border-radius: 50px !important; font-size: 0.72rem;"
                                                        @click="reactivateMember(<?= (int)$rev['member_id'] ?>, $el); localStatus = 'Resolved';">
                                                    <span class="material-symbols-outlined" style="font-size: 13px;">lock_open</span>
                                                    <span>Reactivate</span>
                                                </button>
                                            </template>
                                            <template x-if="localStatus !== 'Pending'">
                                                <span class="d-inline-flex align-items-center gap-1 text-success fw-600" style="padding: 2px 8px; background: #f0fdf4; border-radius: 50px !important; font-size: 0.7rem;">
                                                    <span class="material-symbols-outlined" style="font-size: 13px;">check_circle</span>
                                                    <span>Restored</span>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================
     MEMBER DETAILS DOSSIER MODAL
     ==================================================== -->
<div id="memberModal" class="modal-custom">
    <div class="modal-content-custom" style="max-width: 520px;">
        <div class="modal-header-custom">
            <h5 class="m-0 fw-700" style="font-family: 'Poppins', sans-serif;">Member Profile Dossier</h5>
            <button class="btn-action" onclick="closeMemberModal()"><span class="material-symbols-outlined fs-18">close</span></button>
        </div>
        <div class="modal-body-custom" id="memberDetailsContent">
            <!-- Loaded via JS -->
        </div>
        <div class="modal-footer-custom border-top p-3 d-flex justify-content-end">
            <button class="btn btn-admin-cancel px-4" onclick="closeMemberModal()">Close</button>
        </div>
    </div>
</div>

<script>
function applyMemberParam(key, value) {
    const url = new URL(window.location.href);
    if (value === 'all' || value === '') {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    url.searchParams.set('page', '1');
    url.searchParams.set('tab', 'members');
    window.location.href = url.toString();
}

async function viewMemberDetails(id) {
    try {
        const response = await fetch(`<?= BASE_URL ?>/admin/members/details/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            const m = result.data;
            const defaultAvatar = '<?= BASE_URL ?>/img/default-user.svg';
            const avatar = m.avatar ? (m.avatar.includes('uploads/') ? `<?= BASE_URL ?>/${m.avatar.replace(/^\//, '')}` : `<?= BASE_URL ?>/uploads/forum/avatars/${m.avatar}`) : defaultAvatar;

            let html = `
                <div class="text-center mb-4">
                    <img src="${avatar}" class="rounded-circle mb-3 shadow-xs" style="width: 84px; height: 84px; object-fit: cover; border: 2px solid #e2e8f0;" onerror="this.src='${defaultAvatar}'">
                    <h4 class="mb-1 fw-700 text-dark" style="font-family: 'Poppins', sans-serif;">${escapeHtml(m.name)}</h4>
                    <p class="text-muted fs-085 mb-0">@${escapeHtml(m.username)}</p>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Email Address</label>
                        <div class="fs-085 text-dark fw-500">${escapeHtml(m.email)}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Member ID</label>
                        <div class="fs-085 text-dark fw-500">#${m.id}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Joined Date</label>
                        <div class="fs-085 text-dark fw-500">${new Date(m.created_at).toLocaleDateString()}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Status</label>
                        <div class="fs-085">
                            <span class="badge ${m.status === 'Suspended' ? 'badge-soft-muted' : (m.is_verified == 1 ? 'badge-soft-green' : 'badge-soft-orange')}">
                                ${m.status === 'Suspended' ? 'Suspended' : (m.is_verified == 1 ? 'Verified' : 'Pending')}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Account UUID</label>
                        <div class="fs-075 text-muted text-break"><code>${m.uuid || 'N/A'}</code></div>
                    </div>
                </div>
            `;
            document.getElementById('memberDetailsContent').innerHTML = html;
            document.getElementById('memberModal').classList.add('show');
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        showToast('Failed to fetch member details.', 'error');
    }
}

function closeMemberModal() {
    document.getElementById('memberModal').classList.remove('show');
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function confirmToggleStatus(id, currentStatus) {
    const isSuspended = currentStatus === 'Suspended';
    const action = isSuspended ? 'activate' : 'suspend';

    if (window.Alpine && Alpine.store('actionModal')) {
        Alpine.store('actionModal').show({
            id: id,
            title: (isSuspended ? 'Activate' : 'Suspend') + ' Member',
            message: `Are you sure you want to ${action} this member's account access?`,
            confirmText: 'Yes, ' + (isSuspended ? 'Activate' : 'Suspend'),
            variant: isSuspended ? 'warning' : 'danger',
            icon: isSuspended ? 'person' : 'person_off',
            actionUrl: '<?= BASE_URL ?>/admin/members/toggle-status'
        });
    } else {
        setTimeout(() => toggleMemberStatus(id, currentStatus), 100);
    }
}

async function reactivateMember(id, btn) {
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';

    const formData = new FormData();
    formData.append('id', id);

    try {
        const response = await fetch(`<?= BASE_URL ?>/admin/members/toggle-status`, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            showToast('Member reactivated successfully.');
        } else {
            showToast(result.message, 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

window.onclick = function(event) {
    if (event.target == document.getElementById('memberModal')) {
        closeMemberModal();
    }
}
</script>
