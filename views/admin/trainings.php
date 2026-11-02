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
            <p class="dashboard-subtitle">Manage skill tracks, cohort curriculums, candidate enrollments, fees, and home showcase.</p>
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
                </div>
            </div>

            <!-- Custom Brand Dropdown: Pagination Limit -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= (string)($current_limit ?? 10) ?>',
                label: '<?= (int)($current_limit ?? 10) ?> rows'
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
                        <th style="width: 280px;">Training Program</th>
                        <th style="width: 120px;">Cohorts</th>
                        <th style="width: 110px;">Applications</th>
                        <th style="width: 120px;">Registration</th>
                        <th style="width: 180px;">Payment Gating</th>
                        <th style="width: 100px;">Visibility</th>
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
                            $paymentsEnabled = !empty($training['payments_enabled']);
                            $feeKobo = (int)($training['payment_amount'] ?? 0);
                            $feeFormatted = PaystackService::formatKobo($feeKobo);
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
                                        <div class="text-muted text-truncate" style="font-size: 0.77rem; max-width: 220px;">
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

                            <!-- Payment Gating & Training Fee -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" 
                                            class="badge-status-pill <?= $paymentsEnabled ? 'badge-soft-green' : 'badge-soft-muted' ?>" 
                                            onclick="toggleTrainingPayments(<?= $training['id'] ?>, <?= $paymentsEnabled ? 0 : 1 ?>, <?= $feeKobo / 100 ?>)" 
                                            title="Click to toggle payments on/off">
                                        <?php if ($paymentsEnabled): ?>
                                            <span class="status-pulse-dot" style="background-color: #10b981;"></span>
                                            <span>Paid</span>
                                        <?php else: ?>
                                            <span>Free</span>
                                        <?php endif; ?>
                                    </button>
                                    
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <span class="fw-700 text-dark" style="font-size: 0.82rem;" id="feeDisplay_<?= $training['id'] ?>">
                                            <?= $paymentsEnabled ? $feeFormatted : '₦0' ?>
                                        </span>
                                        <button type="button" 
                                                class="btn btn-sm text-muted p-0 border-0" 
                                                onclick="openFeeModal(<?= $training['id'] ?>, <?= $feeKobo / 100 ?>, '<?= htmlspecialchars(addslashes($training['training_name'])) ?>')" 
                                                title="Set or update training fee">
                                            <span class="material-symbols-outlined" style="font-size: 16px; vertical-align: middle;">tune</span>
                                        </button>
                                    </div>
                                </div>
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
                            <td colspan="7" class="text-center py-5">
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

<!-- ====================================================
     SET TRAINING FEE MODAL
     ==================================================== -->
<div class="modal fade" id="feeConfigModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header border-bottom p-3 px-4 bg-light">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-warning fs-20">payments</span>
                    <h5 class="modal-title fw-bold fs-6 mb-0">Set Training Fee</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="feeConfigForm" onsubmit="submitTrainingFee(event)">
                <input type="hidden" name="id" id="feeModalTrainingId" value="">
                <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3" id="feeModalProgramName">Configure default candidate admission fee.</p>
                    
                    <label class="form-label-custom small fw-semibold mb-1">Fee Amount (NGN)</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light border-end-0 fw-bold">₦</span>
                        <input type="number" step="100" min="0" class="form-control form-control-custom border-start-0" id="feeModalAmountInput" placeholder="e.g. 35000" required>
                    </div>
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1"></i> Individual cohorts can still override this fee in the Cohorts Console.
                    </div>
                </div>
                <div class="modal-footer border-top p-3 px-4 bg-light">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary-custom px-4" id="saveFeeBtn">Save Fee</button>
                </div>
            </form>
        </div>
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

async function toggleTrainingPayments(id, enabled, currentFeeNaira) {
    if (enabled && (!currentFeeNaira || currentFeeNaira <= 0)) {
        openFeeModal(id, 0, 'This Program');
        return;
    }

    const formData = new FormData();
    formData.append('id', id);
    formData.append('enabled', enabled);
    formData.append('csrf_token', '<?= CSRF::generateToken() ?>');

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/trainings/toggle-payments', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json.status === 'success') {
            location.reload();
        } else {
            alert(json.message || 'Failed to update payment status.');
        }
    } catch (err) {
        alert('Network communication error.');
    }
}

let feeModalInstance = null;

function openFeeModal(id, feeNaira, name) {
    document.getElementById('feeModalTrainingId').value = id;
    document.getElementById('feeModalAmountInput').value = feeNaira > 0 ? feeNaira : '';
    document.getElementById('feeModalProgramName').innerText = 'Setting admission fee for: ' + name;
    
    const modalEl = document.getElementById('feeConfigModal');
    if (window.bootstrap && bootstrap.Modal) {
        feeModalInstance = new bootstrap.Modal(modalEl);
        feeModalInstance.show();
    } else {
        $(modalEl).modal('show');
    }
}

async function submitTrainingFee(e) {
    e.preventDefault();
    const id = document.getElementById('feeModalTrainingId').value;
    const amount = document.getElementById('feeModalAmountInput').value;
    const saveBtn = document.getElementById('saveFeeBtn');

    if (!id || amount === '' || parseFloat(amount) < 0) {
        alert('Please enter a valid fee amount.');
        return;
    }

    saveBtn.disabled = true;
    saveBtn.innerText = 'Saving...';

    const formData = new FormData();
    formData.append('id', id);
    formData.append('amount', amount);
    formData.append('csrf_token', '<?= CSRF::generateToken() ?>');

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/trainings/set-payment-amount', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json.status === 'success') {
            location.reload();
        } else {
            alert(json.message || 'Failed to save fee.');
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save Fee';
        }
    } catch (err) {
        alert('Network communication error.');
        saveBtn.disabled = false;
        saveBtn.innerText = 'Save Fee';
    }
}
</script>
