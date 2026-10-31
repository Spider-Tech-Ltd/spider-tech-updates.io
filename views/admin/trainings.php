<!-- Trainings & Bootcamps Management — Spider Tech Admin Operations Console -->
<?php
$allList = $trainings ?? [];
$totalCount = $pagination['total_records'] ?? count($allList);
$hasActiveFilters = (($current_status ?? 'all') !== 'all' || !empty($search_query));
?>

<!-- Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="dashboard-title mb-0">Trainings & Bootcamps</h1>
                <span class="title-badge-count"><?= (int)$totalCount ?> total</span>
            </div>
            <p class="dashboard-subtitle">Manage skill tracks, cohort curriculums, candidate enrollments, and home showcase.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/trainings" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/admin/trainings/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Add Training</span>
            </a>
        </div>
    </div>
</div>

<!-- ====================================================
     KPI SUMMARY CARDS
     ==================================================== -->
<div class="apps-stats-grid mb-4">
    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Total Programs</span>
            <span class="stat-icon bg-soft-blue text-blue">
                <span class="material-symbols-outlined">model_training</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_trainings'] ?? 0) ?></div>
        <div class="stat-desc">Curriculums and tracks offered</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Active Enrollment</span>
            <span class="stat-icon bg-soft-orange text-orange">
                <span class="material-symbols-outlined">lock_open</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['active_programs'] ?? 0) ?></div>
        <div class="stat-desc">Programs accepting registrations</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Total Cohorts</span>
            <span class="stat-icon bg-soft-green text-green">
                <span class="material-symbols-outlined">groups_2</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_cohorts'] ?? 0) ?></div>
        <div class="stat-desc">Intake cycles scheduled</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Total Applications</span>
            <span class="stat-icon bg-soft-purple text-purple">
                <span class="material-symbols-outlined">how_to_reg</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_applications'] ?? 0) ?></div>
        <div class="stat-desc">Lifetime registrations received</div>
    </div>
</div>

<!-- ====================================================
     MAIN TABLE CARD WITH TOOLBAR
     ==================================================== -->
<div class="admin-card">
    <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
    <div class="table-toolbar">
        <div class="table-toolbar-left">
            <!-- Integrated Search Bar -->
            <form method="GET" action="<?= BASE_URL ?>/admin/trainings" class="m-0">
                <?php if (!empty($current_limit)): ?>
                    <input type="hidden" name="limit" value="<?= htmlspecialchars((string)$current_limit) ?>">
                <?php endif; ?>
                <?php if (!empty($current_sort)): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                <?php endif; ?>
                <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($current_status) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search training tracks...">
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= BASE_URL ?>/admin/trainings" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined fs-16">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/trainings" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined fs-14">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Status -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_status ?? 'all' ?>',
                label: '<?= match($current_status ?? 'all') { 'open' => 'Registration Open', 'closed' => 'Registration Closed', 'featured' => 'Featured on Home', default => 'All Status' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyTrainingParam('status', 'all'); open = false;">
                        <span>All Status</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'open' }" @click="applyTrainingParam('status', 'open'); open = false;">
                        <span>Registration Open</span>
                        <svg class="check-icon" x-show="current === 'open'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'closed' }" @click="applyTrainingParam('status', 'closed'); open = false;">
                        <span>Registration Closed</span>
                        <svg class="check-icon" x-show="current === 'closed'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'featured' }" @click="applyTrainingParam('status', 'featured'); open = false;">
                        <span>Featured on Home</span>
                        <svg class="check-icon" x-show="current === 'featured'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Sort -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_sort ?? 'order_asc' ?>',
                label: '<?= match($current_sort ?? 'order_asc') { 'name_asc' => 'Name (A to Z)', 'name_desc' => 'Name (Z to A)', 'apps_desc' => 'Most Applications', 'id_desc' => 'Newest First', default => 'Display Priority' } ?>'
            }" @click.outside="open = false">
                <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                    <span class="d-flex align-items-center">
                        <span class="custom-dropdown-label">Sort by:</span>
                        <strong class="custom-dropdown-val" x-text="label"></strong>
                    </span>
                    <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="custom-dropdown-menu" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'order_asc' }" @click="applyTrainingParam('sort', 'order_asc'); open = false;">
                        <span>Display Priority</span>
                        <svg class="check-icon" x-show="current === 'order_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_asc' }" @click="applyTrainingParam('sort', 'name_asc'); open = false;">
                        <span>Name (A &rarr; Z)</span>
                        <svg class="check-icon" x-show="current === 'name_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_desc' }" @click="applyTrainingParam('sort', 'name_desc'); open = false;">
                        <span>Name (Z &rarr; A)</span>
                        <svg class="check-icon" x-show="current === 'name_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'apps_desc' }" @click="applyTrainingParam('sort', 'apps_desc'); open = false;">
                        <span>Most Applications</span>
                        <svg class="check-icon" x-show="current === 'apps_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyTrainingParam('sort', 'id_desc'); open = false;">
                        <span>Newest First</span>
                        <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '6' }" @click="applyTrainingParam('limit', '6'); open = false;">
                        <span>6 rows</span>
                        <svg class="check-icon" x-show="current === '6'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '12' }" @click="applyTrainingParam('limit', '12'); open = false;">
                        <span>12 rows</span>
                        <svg class="check-icon" x-show="current === '12'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '24' }" @click="applyTrainingParam('limit', '24'); open = false;">
                        <span>24 rows</span>
                        <svg class="check-icon" x-show="current === '24'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th style="width: 320px;">Training Program</th>
                        <th style="width: 140px;">Cohorts</th>
                        <th style="width: 130px;">Applications</th>
                        <th style="width: 160px;">Registration</th>
                        <th style="width: 130px;">Visibility</th>
                        <th class="text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($trainings)): ?>
                        <?php foreach ($trainings as $training): 
                            $isRegOpen = !empty($training['registration_available']);
                            $totalCohorts = (int)($training['total_cohorts'] ?? 0);
                            $openCohorts = (int)($training['open_cohorts'] ?? 0);
                            $totalApps = (int)($training['total_applications'] ?? 0);
                            $showOnHome = !empty($training['show_on_home']);
                        ?>
                        <tr>
                            <!-- Training Program Identity -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="table-img-wrapper flex-shrink-0" style="width: 58px; height: 44px; border-radius: 8px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <img src="<?= resolvePath($training['training_image']) ?>" alt="<?= htmlspecialchars($training['training_name']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?= BASE_URL ?>/images/placeholder.jpg'">
                                    </div>
                                    <div class="min-w-0">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="fw-600 text-dark" style="font-size: 0.88rem; line-height: 1.25;"><?= htmlspecialchars($training['training_name']) ?></span>
                                            <?php if (!empty($training['training_icon'])): ?>
                                                <i class="<?= htmlspecialchars($training['training_icon']) ?> text-orange" style="font-size: 0.82rem;" title="Track Icon"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted text-truncate" style="font-size: 0.77rem; max-width: 240px;">
                                            <?= htmlspecialchars(strip_tags($training['training_description'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Cohort Intake Counts -->
                            <td>
                                <a href="<?= BASE_URL ?>/admin/cohorts?training_id=<?= $training['id'] ?>" class="text-decoration-none" title="View cohorts for this program">
                                    <span class="badge" style="background: rgba(15, 23, 42, 0.05); color: #0f172a; font-size: 0.78rem; font-weight: 600; padding: 4px 9px; border-radius: 6px;">
                                        <?= $totalCohorts ?> <?= $totalCohorts === 1 ? 'Cohort' : 'Cohorts' ?>
                                    </span>
                                </a>
                                <?php if ($openCohorts > 0): ?>
                                    <div class="text-orange fw-600 mt-1 d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                        <span class="status-pulse-dot"></span>
                                        <span><?= $openCohorts ?> Open</span>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted mt-1" style="font-size: 0.72rem;">No open intake</div>
                                <?php endif; ?>
                            </td>

                            <!-- Total Applications -->
                            <td>
                                <a href="<?= BASE_URL ?>/admin/applications?program=<?= $training['id'] ?>" class="text-decoration-none" title="Filter applications by this program">
                                    <div class="fw-700 text-dark" style="font-size: 0.92rem;">
                                        <?= number_format($totalApps) ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.72rem;">enrolled candidates</div>
                                </a>
                            </td>

                            <!-- Registration Toggle Pill -->
                            <td>
                                <button type="button" 
                                        class="badge-status-pill <?= $isRegOpen ? 'badge-soft-orange' : 'badge-soft-muted' ?>" 
                                        onclick="toggleTrainingRegistration(<?= $training['id'] ?>)" 
                                        title="Click to toggle registration on/off">
                                    <?php if ($isRegOpen): ?>
                                        <span class="status-pulse-dot"></span>
                                        <span>Open</span>
                                    <?php else: ?>
                                        <span>Closed</span>
                                    <?php endif; ?>
                                </button>
                            </td>

                            <!-- Visibility / Home Feature -->
                            <td>
                                <?php if ($showOnHome): ?>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.09); color: #059669; font-size: 0.75rem; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fas fa-home me-1"></i> Featured
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.75rem;">Standard</span>
                                <?php endif; ?>
                            </td>

                            <!-- Action Buttons -->
                            <td class="text-end">
                                <div class="action-btns justify-content-end">
                                    <a href="<?= BASE_URL ?>/admin/cohorts?training_id=<?= $training['id'] ?>" class="btn-action" title="Manage Cohorts">
                                        <span class="material-symbols-outlined fs-16">groups_2</span>
                                    </a>
                                    <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $training['id'] ?>" target="_blank" class="btn-action" title="Preview Public Page">
                                        <span class="material-symbols-outlined fs-16">open_in_new</span>
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/trainings/edit/<?= $training['id'] ?>" class="btn-action edit" title="Edit Training">
                                        <span class="material-symbols-outlined fs-16">edit</span>
                                    </a>
                                    <button type="button" class="btn-action delete" onclick="deleteItem(<?= $training['id'] ?>, 'training')" title="Delete Training">
                                        <span class="material-symbols-outlined fs-16">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <span class="material-symbols-outlined text-muted" style="font-size: 48px;">school</span>
                                    <p class="text-muted mt-2 mb-3">No training programs match your criteria.</p>
                                    <?php if ($hasActiveFilters): ?>
                                        <a href="<?= BASE_URL ?>/admin/trainings" class="btn btn-sm btn-outline-custom">Reset Filters</a>
                                    <?php else: ?>
                                        <a href="<?= BASE_URL ?>/admin/trainings/add" class="btn btn-sm btn-primary-custom">Add First Training</a>
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

<script>
function applyTrainingParam(key, value) {
    const url = new URL(window.location.href);
    if (value === 'all' || value === '') {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
}

async function toggleTrainingRegistration(id) {
    const formData = new FormData();
    formData.append('id', id);

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/trainings/toggle', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json.status === 'success') {
            location.reload();
        } else {
            alert(json.message || 'Failed to toggle status.');
        }
    } catch (err) {
        alert('Network communication error.');
    }
}
</script>
