<?php
/**
 * Cohorts Management — Spider Tech Admin Operations Console
 * Program Intake Scheduling, Capacity Regulation & Admission Cycles
 */

$hasActiveFilters = (($current_training ?? 'all') !== 'all' || ($current_status ?? 'all') !== 'all' || !empty($current_search));

function calculateCohortDuration($start, $end) {
    if (empty($start) || empty($end)) return 'Flexible';
    try {
        $d1 = new DateTime($start);
        $d2 = new DateTime($end);
        $interval = $d1->diff($d2);
        $days = (int)$interval->days + 1;
        $weeks = intdiv($days, 7);
        $rem = $days % 7;
        $parts = [];
        if ($weeks > 0) $parts[] = $weeks . ' ' . ($weeks === 1 ? 'Week' : 'Weeks');
        if ($rem > 0) $parts[] = $rem . ' ' . ($rem === 1 ? 'Day' : 'Days');
        return !empty($parts) ? implode(', ', $parts) : '1 Day';
    } catch (Exception $e) {
        return 'TBD';
    }
}
?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Cohorts Management</h1>
            <p>Configure program intakes, regulate enrollment switches, schedule dates, and monitor candidate capacity.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/cohorts" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                    <span>Reset Filters</span>
                </a>
            <?php endif; ?>
            <button class="btn btn-primary-custom d-inline-flex align-items-center gap-2" onclick="openCohortModal()">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Create Cohort</span>
            </button>
        </div>
    </div>
</div>

<!-- ====================================================
     KPI SUMMARY CARDS
     ==================================================== -->
<div class="apps-stats-grid">
    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Total Cohorts</span>
            <span class="stat-icon bg-soft-blue text-blue">
                <span class="material-symbols-outlined">groups_2</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div>
        <div class="stat-desc">Program intake batches configured</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Open Enrollment</span>
            <span class="stat-icon bg-soft-orange text-orange">
                <span class="material-symbols-outlined">lock_open</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['open'] ?? 0) ?></div>
        <div class="stat-desc">Cohorts actively admitting candidates</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Completed Intakes</span>
            <span class="stat-icon bg-soft-green text-green">
                <span class="material-symbols-outlined">verified</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['completed'] ?? 0) ?></div>
        <div class="stat-desc">Past cohorts successfully finished</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Enrolled Candidates</span>
            <span class="stat-icon bg-soft-purple text-purple">
                <span class="material-symbols-outlined">school</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['enrolled'] ?? 0) ?></div>
        <div class="stat-desc">Applications matched to cohorts</div>
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
            <form method="GET" action="<?= BASE_URL ?>/admin/cohorts" class="m-0">
                <?php if (!empty($current_training) && $current_training !== 'all'): ?>
                    <input type="hidden" name="training_id" value="<?= htmlspecialchars((string)$current_training) ?>">
                <?php endif; ?>
                <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars((string)$current_status) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="search" value="<?= htmlspecialchars($current_search ?? '') ?>" class="search-input-clean" placeholder="Search cohort name, slug, or program...">
                    <?php if (!empty($current_search)): ?>
                        <a href="<?= BASE_URL ?>/admin/cohorts" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined fs-16">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/cohorts" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined fs-14">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Program -->
            <?php
                $activeProgramLabel = 'All Programs';
                if (!empty($current_training) && $current_training !== 'all') {
                    foreach ($programs as $prog) {
                        if ((string)$prog['id'] === (string)$current_training) {
                            $activeProgramLabel = $prog['training_name'];
                            break;
                        }
                    }
                }
            ?>
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_training ?? 'all' ?>',
                label: '<?= htmlspecialchars($activeProgramLabel) ?>'
            }" @click.outside="open = false">
                <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                    <span class="d-flex align-items-center">
                        <span class="custom-dropdown-label">Program:</span>
                        <strong class="custom-dropdown-val" x-text="label"></strong>
                    </span>
                    <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="custom-dropdown-menu" style="min-width: 220px; max-height: 280px; overflow-y: auto;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyCohortParam('training_id', 'all'); open = false;">
                        <span>All Programs</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <?php foreach ($programs as $prog): ?>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current == '<?= $prog['id'] ?>' }" @click="applyCohortParam('training_id', '<?= $prog['id'] ?>'); open = false;">
                            <span class="text-truncate" style="max-width: 175px;"><?= htmlspecialchars($prog['training_name']) ?></span>
                            <svg class="check-icon" x-show="current == '<?= $prog['id'] ?>'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Status -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_status ?? 'all' ?>',
                label: '<?= match($current_status ?? 'all') { 'open' => 'Open / Enrolling', 'upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed', default => 'All Statuses' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyCohortParam('status', 'all'); open = false;">
                        <span>All Statuses</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'open' }" @click="applyCohortParam('status', 'open'); open = false;">
                        <span>Open / Enrolling</span>
                        <svg class="check-icon" x-show="current === 'open'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'upcoming' }" @click="applyCohortParam('status', 'upcoming'); open = false;">
                        <span>Upcoming</span>
                        <svg class="check-icon" x-show="current === 'upcoming'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'ongoing' }" @click="applyCohortParam('status', 'ongoing'); open = false;">
                        <span>Ongoing</span>
                        <svg class="check-icon" x-show="current === 'ongoing'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'completed' }" @click="applyCohortParam('status', 'completed'); open = false;">
                        <span>Completed</span>
                        <svg class="check-icon" x-show="current === 'completed'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th style="min-width: 220px;">Cohort</th>
                        <th style="min-width: 170px;">Program</th>
                        <th style="min-width: 210px;">Schedule</th>
                        <th style="min-width: 100px;">Status</th>
                        <th style="min-width: 140px;">Capacity</th>
                        <th style="min-width: 130px;">Fee</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cohorts)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state-wrap py-4">
                                <span class="material-symbols-outlined fs-3rem text-muted mb-2">groups</span>
                                <h5 class="fw-700 text-dark">No Cohorts Found</h5>
                                <p class="text-muted fs-085 mb-3">No cohorts match your selected filter criteria. Click "Create Cohort" to configure a new intake.</p>
                                <?php if ($hasActiveFilters): ?>
                                    <a href="<?= BASE_URL ?>/admin/cohorts" class="btn btn-sm btn-outline-custom">Clear All Filters</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($cohorts as $c):
                            $capacity = (int)($c['capacity'] ?? 0);
                            $applicants = (int)($c['applicant_count'] ?? 0);
                            $pct = ($capacity > 0) ? min(100, round(($applicants / $capacity) * 100)) : 0;
                            $isOpen = !empty($c['registration_open']);
                            $status = strtolower($c['status'] ?? 'upcoming');
                            $duration = calculateCohortDuration($c['start_date'], $c['end_date']);

                            $statusClass = 'badge-soft-muted';
                            if ($isOpen || $status === 'open') $statusClass = 'badge-soft-orange';
                            elseif ($status === 'ongoing') $statusClass = 'badge-soft-blue';
                            elseif ($status === 'completed') $statusClass = 'badge-soft-muted';
                            elseif ($status === 'upcoming') $statusClass = 'badge-soft-yellow';
                        ?>
                        <tr>
                            <!-- Cohort Identifier -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="cohort-num-badge <?= $isOpen ? 'active' : '' ?>">
                                        #<?= (int)$c['cohort_number'] ?>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-600 text-dark" style="font-size: 0.88rem; line-height: 1.25;"><?= htmlspecialchars($c['cohort_name']) ?></div>
                                        <div class="text-muted text-truncate" style="font-size: 0.74rem; margin-top: 2px;">
                                            <?= htmlspecialchars($c['slug']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Program -->
                            <td>
                                <span class="text-dark fw-500" style="font-size: 0.83rem;">
                                    <?= htmlspecialchars($c['training_name']) ?>
                                </span>
                            </td>

                            <!-- Schedule & Duration -->
                            <td>
                                <div class="text-dark fw-600 text-nowrap" style="font-size: 0.83rem;">
                                    <?= date('M d, Y', strtotime($c['start_date'])) ?> &ndash; <?= date('M d, Y', strtotime($c['end_date'])) ?>
                                </div>
                                <div class="text-muted text-nowrap" style="font-size: 0.74rem; margin-top: 2px;">
                                    <span><?= htmlspecialchars($duration) ?></span>
                                    <?php if (!empty($c['registration_deadline'])): ?>
                                        <span class="ms-1 text-secondary" title="Registration Deadline">&bull; Closes <?= date('M d, H:i', strtotime($c['registration_deadline'])) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Status & Topbar Banner Indicator -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <button type="button"
                                            class="badge-status-pill <?= $statusClass ?>"
                                            title="Click to toggle enrollment status"
                                            onclick="toggleCohortRegistration(<?= $c['id'] ?>)">
                                        <?php if ($isOpen): ?>
                                            <span class="status-pulse-dot"></span>
                                            <span>Open</span>
                                        <?php else: ?>
                                            <span><?= htmlspecialchars(ucfirst($status)) ?></span>
                                        <?php endif; ?>
                                    </button>
                                    <?php if (!empty($c['show_topbar_banner'])): ?>
                                        <button type="button" class="btn border-0 p-0 text-start d-inline-flex align-items-center gap-1"
                                                style="font-size: 0.70rem; color: #f48221; background: transparent; cursor: pointer;"
                                                title="Topbar announcement banner is ACTIVE. Click to toggle."
                                                onclick="toggleCohortBanner(<?= $c['id'] ?>)">
                                            <span class="material-symbols-outlined" style="font-size: 13px;">campaign</span>
                                            <span class="fw-600">Topbar: On</span>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn border-0 p-0 text-start d-inline-flex align-items-center gap-1"
                                                style="font-size: 0.70rem; color: #94a3b8; background: transparent; cursor: pointer;"
                                                title="Topbar announcement banner is OFF. Click to toggle."
                                                onclick="toggleCohortBanner(<?= $c['id'] ?>)">
                                            <span class="material-symbols-outlined" style="font-size: 13px;">campaign</span>
                                            <span>Topbar: Off</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Enrollment & Capacity -->
                            <td>
                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.78rem;">
                                    <span class="fw-600 text-dark"><?= $applicants ?><?= $capacity > 0 ? " / {$capacity}" : " candidates" ?></span>
                                    <?php if ($capacity > 0): ?>
                                        <span class="text-muted fw-600" style="font-size: 0.72rem;"><?= $pct ?>%</span>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.72rem;">Unlimited</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($capacity > 0): ?>
                                    <div class="progress" style="height: 4px; border-radius: 4px; background: #e2e8f0;">
                                        <div class="progress-bar <?= $pct >= 90 ? 'bg-danger' : ($pct >= 75 ? 'bg-warning' : ($isOpen ? 'bg-orange' : 'bg-success')) ?>"
                                             style="width: <?= $pct ?>%;"></div>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.7rem;">
                                        <?= max(0, $capacity - $applicants) ?> slots remaining
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Cohort Fee -->
                            <td>
                                <?php if (!empty($c['payment_amount']) && (int)$c['payment_amount'] > 0): ?>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #059669; font-weight: 700; font-size: 0.8rem; padding: 4px 8px; border-radius: 6px;">
                                        <?= PaystackService::formatKobo((int)$c['payment_amount']) ?>
                                    </span>
                                    <div class="text-muted mt-1" style="font-size: 0.68rem;">Override</div>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.78rem;">Inherit Default</span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <div class="action-btns justify-content-end">
                                    <a href="<?= BASE_URL ?>/admin/applications?cohort=<?= $c['id'] ?>" class="btn-action" title="View Enrolled Applicants">
                                        <span class="material-symbols-outlined fs-16">assignment_ind</span>
                                    </a>
                                    <button class="btn-action edit" title="Edit Cohort Configuration" onclick='editCohort(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, "UTF-8") ?>)'>
                                        <span class="material-symbols-outlined fs-16">edit</span>
                                    </button>
                                    <button class="btn-action delete" title="Delete Cohort" onclick="deleteCohort(<?= $c['id'] ?>)">
                                        <span class="material-symbols-outlined fs-16">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================
     ADVANCED & FLEXIBLE COHORT MODAL FORM
     ==================================================== -->
<style>
/* Modern Cohort Modal Form Styles */
.modal-cohort-dialog {
    max-width: 720px;
    width: 100%;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.22);
    background: #ffffff;
}

.cohort-modal-form .cohort-field-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

.cohort-modal-form .cohort-field-wrapper .input-leading-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 18px;
    pointer-events: none;
    line-height: 1;
    transition: color 0.15s ease;
}

.cohort-modal-form .cohort-field-wrapper:focus-within .input-leading-icon {
    color: #f48221;
}

.cohort-modal-form .form-control-custom {
    width: 100% !important;
    height: 40px !important;
    padding: 8px 12px 8px 38px !important;
    border-radius: 8px !important;
    border: 1.5px solid #e2e8f0 !important;
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #0f172a !important;
    background-color: #ffffff !important;
    transition: all 0.18s ease !important;
}

.cohort-modal-form .form-control-custom:hover {
    border-color: #cbd5e1 !important;
}

.cohort-modal-form .form-control-custom:focus {
    border-color: #f48221 !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.12) !important;
    outline: none !important;
}

.cohort-modal-form select.form-control-custom {
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 16px !important;
    padding-right: 36px !important;
    cursor: pointer !important;
}

.cohort-modal-form .form-label-custom {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 5px;
    display: block;
    letter-spacing: -0.01em;
}

.cohort-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 12px;
}

.cohort-section-badge .section-icon-box {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: rgba(244, 130, 33, 0.1);
    color: #f48221;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.cohort-section-badge .section-icon-box .material-symbols-outlined {
    font-size: 16px;
}

.cohort-section-badge .section-title {
    font-size: 0.86rem;
    font-weight: 700;
    color: #0f172a;
    font-family: 'Poppins', sans-serif;
}

/* Custom Toggle Switch */
.switch-toggle-custom {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    cursor: pointer;
    flex-shrink: 0;
}

.switch-toggle-custom input[type="checkbox"] {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #cbd5e1;
    transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 50px;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.switch-toggle-custom input:checked + .switch-slider {
    background-color: #f48221;
}

.switch-toggle-custom input:checked + .switch-slider:before {
    transform: translateX(20px);
}

/* Capacity Preset Buttons */
.btn-preset-pill {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    padding: 2px 9px;
    font-size: 0.72rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
    line-height: 1.4;
}

.btn-preset-pill:hover {
    background: #fff8f1;
    border-color: #f48221;
    color: #f48221;
}

/* Custom Scrollbar for Modal Body */
.cohort-modal-body::-webkit-scrollbar {
    width: 6px;
}
.cohort-modal-body::-webkit-scrollbar-track {
    background: transparent;
}
.cohort-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.cohort-modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<div id="cohortModal" class="modal-custom" style="display: none;">
    <div class="modal-content-custom modal-cohort-dialog">
        
        <!-- Modal Header -->
        <div class="modal-header-custom d-flex justify-content-between align-items-center py-3 px-4 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(244, 130, 33, 0.1); color: #f48221; flex-shrink: 0;">
                    <span class="material-symbols-outlined fs-22">event_repeat</span>
                </div>
                <div>
                    <h5 class="m-0 fw-700 text-dark" style="font-family: 'Poppins', sans-serif; font-size: 1.02rem;" id="modalTitle">Create New Cohort</h5>
                    <p class="text-muted m-0 mt-0-5" style="font-size: 0.78rem;">Configure timeline, enrollment boundaries, and admission switches.</p>
                </div>
            </div>
            <button type="button" class="btn-action border-0 bg-transparent text-muted p-1" onclick="closeCohortModal()" style="cursor: pointer;" title="Close modal">
                <span class="material-symbols-outlined fs-20">close</span>
            </button>
        </div>

        <form id="cohortForm" onsubmit="submitCohortForm(event)" class="cohort-modal-form">
            <input type="hidden" name="id" id="cohortId" value="">

            <div class="modal-body-custom cohort-modal-body px-4 py-3" style="max-height: calc(85vh - 130px); overflow-y: auto;">
                
                <!-- Section 1: Program & Cohort Identity -->
                <div class="mb-3">
                    <div class="cohort-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined">school</span>
                        </div>
                        <span class="section-title">Program & Identification</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Target Training Program <span class="text-danger">*</span></label>
                        <div class="cohort-field-wrapper">
                            <span class="material-symbols-outlined input-leading-icon">menu_book</span>
                            <select name="training_id" id="cohortTrainingId" class="form-control-custom" required onchange="handleTrainingChange(this)">
                                <option value="">Select Training...</option>
                                <?php foreach ($programs as $prog): ?>
                                    <option value="<?= $prog['id'] ?>" data-name="<?= htmlspecialchars($prog['training_name']) ?>">
                                        <?= htmlspecialchars($prog['training_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-4">
                            <label class="form-label-custom">Cohort Number <span class="text-danger">*</span></label>
                            <div class="cohort-field-wrapper">
                                <span class="material-symbols-outlined input-leading-icon">tag</span>
                                <input type="number" name="cohort_number" id="cohortNumber" class="form-control-custom" min="1" value="4" required oninput="handleCohortNumberChange()">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-label-custom">Cohort Display Name <span class="text-danger">*</span></label>
                            <div class="cohort-field-wrapper">
                                <span class="material-symbols-outlined input-leading-icon">edit_note</span>
                                <input type="text" name="cohort_name" id="cohortName" class="form-control-custom" placeholder="e.g. Digital Skills for Entrepreneurs - Cohort 4" required oninput="handleNameManualInput()">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label-custom m-0">URL Identifier (Slug) <span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-link p-0 text-orange fw-600 text-decoration-none d-inline-flex align-items-center gap-1" onclick="regenerateSlug()" style="font-size: 0.74rem;">
                                <span class="material-symbols-outlined fs-14">autorenew</span>
                                <span>Auto-generate from Name</span>
                            </button>
                        </div>
                        <div class="cohort-field-wrapper">
                            <span class="material-symbols-outlined input-leading-icon">link</span>
                            <input type="text" name="slug" id="cohortSlug" class="form-control-custom font-monospace" placeholder="e.g. dse-cohort-4" required style="font-size: 0.84rem;">
                        </div>
                    </div>
                </div>

                <hr class="my-3" style="border-color: #f1f5f9;">

                <!-- Section 2: Timeline & Intake Schedule -->
                <div class="mb-3">
                    <div class="cohort-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined">calendar_month</span>
                        </div>
                        <span class="section-title">Timeline & Schedule</span>
                    </div>

                    <div class="row g-3 mb-2">
                        <div class="col-sm-6">
                            <label class="form-label-custom">Start Date <span class="text-danger">*</span></label>
                            <div class="cohort-field-wrapper">
                                <span class="material-symbols-outlined input-leading-icon">event</span>
                                <input type="date" name="start_date" id="cohortStartDate" class="form-control-custom" required onchange="calculateLiveDuration()">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-custom">End Date <span class="text-danger">*</span></label>
                            <div class="cohort-field-wrapper">
                                <span class="material-symbols-outlined input-leading-icon">event_available</span>
                                <input type="date" name="end_date" id="cohortEndDate" class="form-control-custom" required onchange="calculateLiveDuration()">
                            </div>
                        </div>
                    </div>

                    <!-- Live Duration Feedback Banner -->
                    <div id="liveDurationBanner" class="p-2 px-3 rounded-3 mb-3 d-flex align-items-center gap-2" style="background: #fff8f1; border: 1px solid rgba(244, 130, 33, 0.22); font-size: 0.81rem; color: #475569;">
                        <span class="material-symbols-outlined fs-17 text-orange flex-shrink-0">timelapse</span>
                        <span id="liveDurationText">Select start and end dates to preview computed duration</span>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label-custom m-0">Registration Deadline</label>
                            <span class="badge badge-soft-muted text-muted" style="font-size: 0.68rem; border-radius: 50px;">Optional</span>
                        </div>
                        <div class="cohort-field-wrapper">
                            <span class="material-symbols-outlined input-leading-icon">schedule</span>
                            <input type="datetime-local" name="registration_deadline" id="cohortDeadline" class="form-control-custom">
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Applicants cannot register after this timestamp even if registration switch is open.</small>
                    </div>
                </div>

                <hr class="my-3" style="border-color: #f1f5f9;">

                <!-- Section 3: Admission & Capacity Boundaries -->
                <div>
                    <div class="cohort-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined">tune</span>
                        </div>
                        <span class="section-title">Capacity & Lifecycle Controls</span>
                    </div>

                    <div class="row g-3">
                        <!-- Left: Capacity Limit & Presets -->
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label-custom m-0">Intake Capacity Limit</label>
                                <span class="badge badge-soft-muted text-muted" style="font-size: 0.68rem; border-radius: 50px;">0 = Unlimited</span>
                            </div>
                            <div class="cohort-field-wrapper mb-2">
                                <span class="material-symbols-outlined input-leading-icon">groups</span>
                                <input type="number" name="capacity" id="cohortCapacity" class="form-control-custom" min="0" value="100">
                            </div>

                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <span class="text-muted me-1" style="font-size: 0.71rem;">Presets:</span>
                                <button type="button" class="btn-preset-pill" onclick="setCapacityPreset(50)">50</button>
                                <button type="button" class="btn-preset-pill" onclick="setCapacityPreset(75)">75</button>
                                <button type="button" class="btn-preset-pill" onclick="setCapacityPreset(100)">100</button>
                                <button type="button" class="btn-preset-pill" onclick="setCapacityPreset(150)">150</button>
                                <button type="button" class="btn-preset-pill" onclick="setCapacityPreset(0)">Unlimited</button>
                            </div>
                        </div>

                        <!-- Fee Override (Optional) -->
                        <div class="col-sm-6">
                            <label class="form-label-custom mb-1">Cohort Fee Override (₦)</label>
                            <div class="cohort-field-wrapper mb-1">
                                <span class="material-symbols-outlined input-leading-icon">payments</span>
                                <input type="number" name="payment_amount" id="cohortPaymentAmount" class="form-control-custom" min="0" step="100" placeholder="Inherit program default">
                            </div>
                            <span class="text-muted" style="font-size: 0.68rem;">Leave blank to inherit the program-level training fee.</span>
                        </div>

                        <!-- Right: Lifecycle Status & Public Switch -->
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <label class="form-label-custom mb-1">Cohort Lifecycle Status</label>
                                <div class="cohort-field-wrapper">
                                    <span class="material-symbols-outlined input-leading-icon">flag</span>
                                    <select name="status" id="cohortStatus" class="form-control-custom">
                                        <option value="upcoming">Upcoming (Announced)</option>
                                        <option value="open">Open (Actively Enrolling)</option>
                                        <option value="ongoing">Ongoing (Classes Active)</option>
                                        <option value="completed">Completed (Archived)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Modern Public Switch Card with Animated Toggle -->
                            <div class="p-2-5 px-3 rounded-3 border d-flex align-items-center justify-content-between mb-2" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                <div>
                                    <div class="fw-700 text-dark" style="font-size: 0.81rem; font-family: 'Poppins', sans-serif;">Public Enrollment</div>
                                    <small class="text-muted" style="font-size: 0.71rem;">Accept new student registrations</small>
                                </div>
                                <label class="switch-toggle-custom m-0" title="Toggle public enrollment status">
                                    <input type="hidden" name="registration_open" value="0">
                                    <input type="checkbox" name="registration_open" id="cohortRegOpen" value="1" checked>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>

                            <!-- Topbar Announcement Banner Switch Card -->
                            <div class="p-2-5 px-3 rounded-3 border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                <div>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="material-symbols-outlined text-orange" style="font-size: 16px;">campaign</span>
                                        <div class="fw-700 text-dark" style="font-size: 0.81rem; font-family: 'Poppins', sans-serif;">Display Topbar Banner</div>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.71rem;">Show animated announcement on site top bar</small>
                                </div>
                                <label class="switch-toggle-custom m-0" title="Toggle topbar announcement banner">
                                    <input type="hidden" name="show_topbar_banner" value="0">
                                    <input type="checkbox" name="show_topbar_banner" id="cohortShowTopbarBanner" value="1" checked onchange="toggleCustomAnnouncementField(this.checked)">
                                    <span class="switch-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Topbar Custom Announcement Input -->
                    <div class="mt-3 p-3 rounded-3 border" id="customAnnouncementWrapper" style="background: #ffffff; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label-custom m-0" style="font-size: 0.78rem;">
                                Topbar Announcement Text <span class="text-muted fw-400">(Optional)</span>
                            </label>
                            <span class="badge badge-soft-muted text-muted" style="font-size: 0.68rem; border-radius: 50px;">Auto-generated if empty</span>
                        </div>
                        <div class="cohort-field-wrapper mb-2">
                            <span class="material-symbols-outlined input-leading-icon">edit_note</span>
                            <input type="text" name="custom_announcement" id="cohortCustomAnnouncement" class="form-control-custom"
                                   placeholder="e.g., Registration for Digital Skills for Entrepreneurs (DSE) – Cohort 4 is now open"
                                   oninput="updateAnnouncementPreview()">
                        </div>
                        <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background: #f8fafc; border: 1px dashed #cbd5e1; font-size: 0.73rem;">
                            <span class="material-symbols-outlined text-orange fs-14">visibility</span>
                            <span class="text-muted">Live Preview:</span>
                            <span class="fw-600 text-dark text-truncate" id="announcementAutoPreview">Registration for Selected Training – Cohort 4 is now open</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-custom py-3 px-4 border-top d-flex justify-content-between align-items-center" style="background: #fafafa; border-color: #f1f5f9 !important;">
                <button type="button" class="btn btn-sm btn-light border px-3" onclick="closeCohortModal()" style="border-radius: 50px !important; font-size: 0.82rem; font-weight: 500;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-sm btn-primary-custom px-4 py-2 d-inline-flex align-items-center gap-2" id="cohortSubmitBtn" style="border-radius: 50px !important; font-size: 0.82rem; font-weight: 600;">
                    <span class="material-symbols-outlined fs-16">save</span>
                    <span>Save Cohort</span>
                </button>
            </div>
        </form>
    </div>
</div>


<script>
function clearCohortSearch() {
    const url = new URL(window.location.href);
    url.searchParams.delete('search');
    window.location.href = url.toString();
}

function toggleCustomAnnouncementField(show) {
    const wrap = document.getElementById('customAnnouncementWrapper');
    if (wrap) {
        wrap.style.display = show ? 'block' : 'none';
    }
}

function updateAnnouncementPreview() {
    const custom = (document.getElementById('cohortCustomAnnouncement')?.value || '').trim();
    const sel = document.getElementById('cohortTrainingId');
    const opt = sel ? sel.options[sel.selectedIndex] : null;
    const tName = opt ? (opt.getAttribute('data-name') || 'Training') : 'Training';
    const num = document.getElementById('cohortNumber')?.value || 1;

    let text = custom;
    if (!text) {
        let formattedName = tName.toLowerCase()
            .replace(/\b\w/g, c => c.toUpperCase())
            .replace(/\b(For|And|Of|In|To|The|With)\b/g, m => m.toLowerCase());
        let acronym = '';
        if (tName.toLowerCase().includes('digital skills') && tName.toLowerCase().includes('entrepreneurs')) {
            acronym = ' (DSE)';
        } else if (tName.toLowerCase().includes('jobberman')) {
            acronym = ' (JSS)';
        }
        text = 'Registration for ' + formattedName + acronym + ' – Cohort ' + num + ' is now open';
    }
    const previewElem = document.getElementById('announcementAutoPreview');
    if (previewElem) {
        previewElem.textContent = text;
    }
}

async function toggleCohortBanner(id) {
    const formData = new FormData();
    formData.append('id', id);

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/cohorts/toggle-banner', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json.status === 'success') {
            location.reload();
        } else {
            alert(json.message || 'Failed to toggle banner status.');
        }
    } catch (err) {
        alert('Network communication error.');
    }
}

function openCohortModal() {
    document.getElementById('modalTitle').innerText = 'Create New Cohort';
    document.getElementById('cohortForm').reset();
    document.getElementById('cohortId').value = '';
    document.getElementById('cohortRegOpen').checked = true;
    document.getElementById('cohortNumber').value = '4';
    document.getElementById('cohortCapacity').value = '100';
    document.getElementById('cohortPaymentAmount').value = '';
    document.getElementById('cohortStatus').value = 'open';
    document.getElementById('cohortShowTopbarBanner').checked = true;
    document.getElementById('cohortCustomAnnouncement').value = '';
    toggleCustomAnnouncementField(true);
    updateAnnouncementPreview();
    document.getElementById('liveDurationText').textContent = 'Select start and end dates to preview computed duration';
    document.getElementById('cohortModal').style.display = 'flex';
}

function closeCohortModal() {
    document.getElementById('cohortModal').style.display = 'none';
}

function handleTrainingChange(sel) {
    const opt = sel.options[sel.selectedIndex];
    const tName = opt ? opt.getAttribute('data-name') : '';
    const num = document.getElementById('cohortNumber').value || 1;
    if (tName && !document.getElementById('cohortId').value) {
        document.getElementById('cohortName').value = tName + ' - Cohort ' + num;
        regenerateSlug();
        updateAnnouncementPreview();
    }
}

function handleCohortNumberChange() {
    const sel = document.getElementById('cohortTrainingId');
    handleTrainingChange(sel);
}

function handleNameManualInput() {
    if (!document.getElementById('cohortId').value) {
        regenerateSlug();
    }
}

function regenerateSlug() {
    const name = document.getElementById('cohortName').value || '';
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('cohortSlug').value = slug;
}

function setCapacityPreset(val) {
    document.getElementById('cohortCapacity').value = val;
}

function calculateLiveDuration() {
    const startVal = document.getElementById('cohortStartDate').value;
    const endVal = document.getElementById('cohortEndDate').value;
    const bannerText = document.getElementById('liveDurationText');

    if (!startVal || !endVal) {
        bannerText.textContent = 'Select both start and end dates to preview computed duration';
        return;
    }

    const d1 = new Date(startVal);
    const d2 = new Date(endVal);

    if (d2 < d1) {
        bannerText.innerHTML = '<span class="text-danger fw-600">End date cannot precede start date</span>';
        return;
    }

    const diffTime = Math.abs(d2 - d1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // inclusive days

    const weeks = Math.floor(diffDays / 7);
    const remDays = diffDays % 7;

    let parts = [];
    if (weeks > 0) parts.push(weeks + (weeks === 1 ? ' Week' : ' Weeks'));
    if (remDays > 0) parts.push(remDays + (remDays === 1 ? ' Day' : ' Days'));

    const durationFormatted = parts.length > 0 ? parts.join(', ') : '1 Day';
    bannerText.innerHTML = `<strong>Calculated Duration:</strong> <span class="text-orange fw-700">${durationFormatted}</span> (${diffDays} calendar days)`;
}

function editCohort(data) {
    document.getElementById('modalTitle').innerText = 'Edit Cohort Configuration';
    document.getElementById('cohortId').value = data.id;
    document.getElementById('cohortTrainingId').value = data.training_id;
    document.getElementById('cohortNumber').value = data.cohort_number;
    document.getElementById('cohortName').value = data.cohort_name;
    document.getElementById('cohortSlug').value = data.slug;
    document.getElementById('cohortStartDate').value = data.start_date;
    document.getElementById('cohortEndDate').value = data.end_date;
    if (data.registration_deadline) {
        document.getElementById('cohortDeadline').value = data.registration_deadline.replace(' ', 'T').substring(0, 16);
    } else {
        document.getElementById('cohortDeadline').value = '';
    }
    document.getElementById('cohortCapacity').value = data.capacity || 0;
    document.getElementById('cohortPaymentAmount').value = (data.payment_amount && data.payment_amount > 0) ? (data.payment_amount / 100) : '';
    document.getElementById('cohortStatus').value = data.status || 'upcoming';
    document.getElementById('cohortRegOpen').checked = (data.registration_open == 1);
    document.getElementById('cohortShowTopbarBanner').checked = (data.show_topbar_banner == 1);
    document.getElementById('cohortCustomAnnouncement').value = data.custom_announcement || '';
    toggleCustomAnnouncementField(data.show_topbar_banner == 1);
    updateAnnouncementPreview();
    calculateLiveDuration();
    document.getElementById('cohortModal').style.display = 'flex';
}

async function submitCohortForm(e) {
    e.preventDefault();
    const btn = document.getElementById('cohortSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

    const formData = new FormData(document.getElementById('cohortForm'));

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/cohorts/save', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json.status === 'success') {
            closeCohortModal();
            location.reload();
        } else {
            alert(json.message || 'Failed to save cohort');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined fs-16 align-middle me-1">save</span> Save Cohort';
        }
    } catch (err) {
        alert('A network error occurred. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined fs-16 align-middle me-1">save</span> Save Cohort';
    }
}

async function toggleCohortRegistration(id) {
    const formData = new FormData();
    formData.append('id', id);

    try {
        const res = await fetch('<?= BASE_URL ?>/admin/cohorts/toggle', {
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

function deleteCohort(id) {
    if (window.Alpine && Alpine.store('actionModal')) {
        Alpine.store('actionModal').show({
            id: id,
            type: 'cohort',
            title: 'Delete Training Cohort',
            message: 'You are about to delete this cohort. This action is permanent and cannot be undone.',
            confirmText: 'Yes, Delete Cohort',
            variant: 'danger',
            icon: 'delete_forever',
            callback: async (cohortId) => {
                const formData = new FormData();
                formData.append('id', cohortId);
                try {
                    const res = await fetch('<?= BASE_URL ?>/admin/cohorts/delete', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const json = await res.json();
                    if (json.status === 'success') {
                        if (typeof showToast === 'function') {
                            showToast(json.message);
                        }
                        setTimeout(() => location.reload(), 600);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(json.message || 'Cannot delete cohort.', 'error');
                        } else {
                            alert(json.message || 'Cannot delete cohort.');
                        }
                    }
                } catch (err) {
                    if (typeof showToast === 'function') {
                        showToast('Network communication error.', 'error');
                    } else {
                        alert('Network communication error.');
                    }
                }
            }
        });
    }
}

function applyCohortParam(key, value) {
    const url = new URL(window.location.href);
    if (value === 'all' || value === '') {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

window.onclick = function(event) {
    const modal = document.getElementById('cohortModal');
    if (event.target === modal) {
        closeCohortModal();
    }
};
</script>
