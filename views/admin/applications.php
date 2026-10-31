<?php
/**
 * Program Applications — Spider Tech Admin Operations Console
 * Modern Data Visualization & Cohort Enrollment Management
 */

function getAvatarColor($name) {
    $colors = ['#f48221', '#2563eb', '#059669', '#7c3aed', '#db2777', '#0891b2', '#d97706'];
    $hash = crc32($name);
    return $colors[abs($hash) % count($colors)];
}

function getInitials($fullName) {
    $parts = preg_split('/\s+/', trim($fullName));
    if (empty($parts) || empty($parts[0])) return 'AP';
    if (count($parts) === 1) return strtoupper(substr($parts[0], 0, 2));
    return strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
}

$hasActiveFilters = ($current_program !== 'all' || ($current_cohort ?? 'all') !== 'all' || !empty($current_search));

// Build CSV Export URL preserving current filter parameters
$exportParams = [];
if ($current_program !== 'all') $exportParams['program'] = $current_program;
if (($current_cohort ?? 'all') !== 'all') $exportParams['cohort'] = $current_cohort;
if (!empty($current_search)) $exportParams['search'] = $current_search;
$exportParams['export'] = 'csv';
$exportUrl = BASE_URL . '/admin/applications?' . http_build_query($exportParams);
?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Program Applications</h1>
            <p>Review candidate submissions, manage cohort enrollments, and export application registers.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/applications" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                    <span>Reset Filters</span>
                </a>
            <?php endif; ?>
            <a href="<?= htmlspecialchars($exportUrl) ?>" class="btn btn-sm btn-outline-custom d-inline-flex align-items-center gap-1" title="Download Excel-compatible CSV of filtered applications">
                <span class="material-symbols-outlined fs-16">download</span>
                <span>Export CSV</span>
            </a>
        </div>
    </div>
</div>

<!-- ====================================================
     KPI SUMMARY CARDS
     ==================================================== -->
<div class="apps-stats-grid">
    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Total Applications</span>
            <span class="stat-icon bg-soft-blue text-blue">
                <span class="material-symbols-outlined">assignment</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div>
        <div class="stat-desc">Lifetime registrations recorded</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">DSE Cohort 4</span>
            <span class="stat-icon bg-soft-orange text-orange">
                <span class="material-symbols-outlined">groups_2</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['cohort4'] ?? 0) ?></div>
        <div class="stat-desc">Active cohort enrollment intake</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Today's Intake</span>
            <span class="stat-icon bg-soft-green text-green">
                <span class="material-symbols-outlined">today</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['today'] ?? 0) ?></div>
        <div class="stat-desc">Submissions received today</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Active Programs</span>
            <span class="stat-icon bg-soft-purple text-purple">
                <span class="material-symbols-outlined">school</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['programs'] ?? 0) ?></div>
        <div class="stat-desc">Tracks with candidate registrations</div>
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
            <form method="GET" action="<?= BASE_URL ?>/admin/applications" class="m-0">
                <?php if (!empty($current_program) && $current_program !== 'all'): ?>
                    <input type="hidden" name="program" value="<?= htmlspecialchars((string)$current_program) ?>">
                <?php endif; ?>
                <?php if (!empty($current_cohort) && $current_cohort !== 'all'): ?>
                    <input type="hidden" name="cohort" value="<?= htmlspecialchars((string)$current_cohort) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="search" value="<?= htmlspecialchars($current_search ?? '') ?>" class="search-input-clean" placeholder="Search applicant name, email, phone...">
                    <?php if (!empty($current_search)): ?>
                        <a href="<?= BASE_URL ?>/admin/applications" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined fs-16">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/applications" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined fs-14">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Program -->
            <?php
                $activeProgramLabel = 'All Programs';
                if (!empty($current_program) && $current_program !== 'all') {
                    foreach ($programs as $prog) {
                        if ((string)$prog['id'] === (string)$current_program) {
                            $activeProgramLabel = $prog['training_name'];
                            break;
                        }
                    }
                }
            ?>
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_program ?? 'all' ?>',
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyAppParam('program', 'all'); open = false;">
                        <span>All Programs</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <?php foreach ($programs as $prog): ?>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current == '<?= $prog['id'] ?>' }" @click="applyAppParam('program', '<?= $prog['id'] ?>'); open = false;">
                            <span class="text-truncate" style="max-width: 175px;"><?= htmlspecialchars($prog['training_name']) ?></span>
                            <svg class="check-icon" x-show="current == '<?= $prog['id'] ?>'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Cohort -->
            <?php
                $activeCohortLabel = 'All Cohorts';
                if (!empty($current_cohort) && $current_cohort !== 'all') {
                    foreach (($cohorts ?? []) as $c) {
                        if ((string)$c['id'] === (string)$current_cohort) {
                            $activeCohortLabel = $c['cohort_name'];
                            break;
                        }
                    }
                }
            ?>
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_cohort ?? 'all' ?>',
                label: '<?= htmlspecialchars($activeCohortLabel) ?>'
            }" @click.outside="open = false">
                <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                    <span class="d-flex align-items-center">
                        <span class="custom-dropdown-label">Cohort:</span>
                        <strong class="custom-dropdown-val" x-text="label"></strong>
                    </span>
                    <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="custom-dropdown-menu" style="min-width: 220px; max-height: 280px; overflow-y: auto;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyAppParam('cohort', 'all'); open = false;">
                        <span>All Cohorts</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <?php foreach (($cohorts ?? []) as $c): ?>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current == '<?= $c['id'] ?>' }" @click="applyAppParam('cohort', '<?= $c['id'] ?>'); open = false;">
                            <span class="text-truncate" style="max-width: 175px;"><?= htmlspecialchars($c['cohort_name']) ?></span>
                            <svg class="check-icon" x-show="current == '<?= $c['id'] ?>'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th style="min-width: 230px;">Applicant</th>
                        <th style="min-width: 220px;">Program &amp; Track</th>
                        <th style="min-width: 170px;">Contact &amp; Location</th>
                        <th style="min-width: 170px;">Enterprise / Background</th>
                        <th style="min-width: 125px;">Applied</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state-wrap py-4">
                                <span class="material-symbols-outlined fs-3rem text-muted mb-2">person_search</span>
                                <h5 class="fw-700 text-dark">No Applications Found</h5>
                                <p class="text-muted fs-085 mb-3">No registrations match your current filter and search criteria.</p>
                                <?php if ($hasActiveFilters): ?>
                                    <a href="<?= BASE_URL ?>/admin/applications" class="btn btn-sm btn-outline-custom">Clear All Filters</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php
                        $i = ($pagination['current_page'] - 1) * 10 + 1;
                        foreach ($applications as $app):
                            $userData = json_decode($app['user_data'], true) ?: [];

                            // Extract Name
                            $firstName = $userData['first_name'] ?? $userData['firstname'] ?? '';
                            $middleName = $userData['middle_name'] ?? '';
                            $lastName = $userData['last_name'] ?? $userData['lastname'] ?? '';
                            $fullName = $userData['full_name'] ?? $userData['name'] ?? trim($firstName . ' ' . $middleName . ' ' . $lastName);
                            if (!$fullName) $fullName = trim($firstName . ' ' . $lastName) ?: 'Anonymous Candidate';

                            $email = $userData['email'] ?? $userData['email_address'] ?? 'N/A';
                            $phone = $userData['phone'] ?? $userData['phone_no'] ?? $userData['phone_number'] ?? 'N/A';
                            $gender = $userData['gender'] ?? '';
                            $age = $userData['age'] ?? '';
                            $state = $userData['state_of_origin'] ?? $userData['state'] ?? '';
                            $lga = $userData['local_government'] ?? $userData['lga'] ?? '';

                            // Enterprise details
                            $bizName = $userData['business_name'] ?? '';
                            $bizSection = $userData['business_section'] ?? $userData['business_type'] ?? '';
                            $bizStage = $userData['business_stage'] ?? '';

                            $avatarColor = getAvatarColor($fullName);
                            $initials = getInitials($fullName);

                            // Program & Cohort resolution
                            $programName = $app['program_name'] ?: 'General Program';
                            $cohortName = $app['cohort_name'] ?? '';
                            $cohortNumber = $app['cohort_number'] ?? '';
                            $cohortId = (int)($app['cohort_id'] ?? 0);

                            // JSON payload for rich modal preview
                            $recordPayload = [
                                'id'           => $app['id'],
                                'program_name' => $programName,
                                'cohort_name'  => $cohortName,
                                'cohort_number'=> $cohortNumber,
                                'cohort_id'    => $cohortId,
                                'created_at'   => $app['created_at'],
                                'user_data'    => $userData
                            ];
                        ?>
                        <tr>
                            <td class="text-muted fs-08 fw-600"><?= $i++ ?></td>
                            <td>
                                <div class="applicant-cell-wrap">
                                    <div class="applicant-avatar-circle" style="background-color: <?= $avatarColor ?>;">
                                        <?= htmlspecialchars($initials) ?>
                                    </div>
                                    <div class="applicant-info-block">
                                        <span class="applicant-primary-name"><?= htmlspecialchars($fullName) ?></span>
                                        <span class="applicant-sub-email"><?= htmlspecialchars($email) ?></span>
                                        <?php if ($gender || $age): ?>
                                            <div class="applicant-meta-chips">
                                                <?php if ($gender): ?>
                                                    <span class="applicant-meta-chip"><?= htmlspecialchars($gender) ?></span>
                                                <?php endif; ?>
                                                <?php if ($age): ?>
                                                    <span class="applicant-meta-chip"><?= htmlspecialchars($age) ?> yrs</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="program-name-text"><?= htmlspecialchars($programName) ?></div>
                                <?php if (!empty($cohortName)): ?>
                                    <?php $isActiveCohort = ($cohortId === 4); ?>
                                    <span class="cohort-tag-pill <?= $isActiveCohort ? 'active' : 'historical' ?>" title="<?= htmlspecialchars($cohortName) ?>">
                                        <?php if ($isActiveCohort): ?>
                                            <span class="cohort-tag-dot"></span>
                                        <?php else: ?>
                                            <span class="material-symbols-outlined fs-12 align-middle">groups</span>
                                        <?php endif; ?>
                                        <span><?= !empty($cohortNumber) ? 'Cohort ' . (int)$cohortNumber : htmlspecialchars(mb_strimwidth($cohortName, 0, 22, '…')) ?></span>
                                    </span>
                                <?php else: ?>
                                    <span class="cohort-tag-pill general">
                                        <span class="material-symbols-outlined fs-12 align-middle">open_in_new</span>
                                        <span>General Intake</span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($phone !== 'N/A'): ?>
                                    <a href="tel:<?= htmlspecialchars($phone) ?>" class="phone-contact-link">
                                        <span class="material-symbols-outlined fs-14 text-orange">call</span>
                                        <span><?= htmlspecialchars($phone) ?></span>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted fs-08">No phone</span>
                                <?php endif; ?>
                                <?php if ($state || $lga): ?>
                                    <div class="location-badge-text">
                                        <span class="material-symbols-outlined">location_on</span>
                                        <span><?= htmlspecialchars(trim(($lga ? $lga . ', ' : '') . $state)) ?></span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($bizName): ?>
                                    <div class="fw-600 fs-085 text-dark"><?= htmlspecialchars($bizName) ?></div>
                                    <?php if ($bizSection || $bizStage): ?>
                                        <span class="applicant-meta-chip mt-1">
                                            <?= htmlspecialchars(trim(($bizSection ? $bizSection . ($bizStage ? ' • ' : '') : '') . $bizStage)) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted fs-08">Individual Candidate</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-600 fs-08 text-dark"><?= date('M d, Y', strtotime($app['created_at'])) ?></div>
                                <span class="text-muted fs-075"><?= date('H:i', strtotime($app['created_at'])) ?></span>
                            </td>
                            <td class="text-end">
                                <button type="button"
                                        class="btn-app-review"
                                        title="View Structured Application File"
                                        onclick='openApplicationModal(<?= json_encode($recordPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                    <span class="material-symbols-outlined">visibility</span>
                                    <span>Review</span>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
        </div>
    </div>
</div>

<!-- ====================================================
     STRUCTURED APPLICATION DETAILS MODAL
     ==================================================== -->
<div id="appModal" class="modal-custom">
    <div class="modal-content-custom modal-app-dialog">
        <div class="modal-header-custom">
            <div class="d-flex align-items-center gap-3">
                <div id="modalAvatar" class="applicant-avatar-circle" style="width: 44px; height: 44px; font-size: 0.95rem;"></div>
                <div>
                    <h5 class="m-0 poppins fw-700" id="modalApplicantName">Applicant Details</h5>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <span id="modalProgramBadge" class="badge bg-soft-orange text-orange"></span>
                        <span id="modalCohortBadge" class="badge-app-cohort active fs-07"></span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-action" onclick="closeAppModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="modal-body-custom p-4" id="modalBodyContent">
            <!-- Dynamically populated structured cards -->
        </div>

        <div class="modal-footer-custom p-3 border-top d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-sm btn-outline-custom d-inline-flex align-items-center gap-1" onclick="window.print()">
                <span class="material-symbols-outlined fs-15">print</span>
                <span>Print Application</span>
            </button>
            <button type="button" class="btn btn-sm btn-secondary-custom" onclick="closeAppModal()">
                <span>Close</span>
            </button>
        </div>
    </div>
</div>

<script>
function clearSearch() {
    const url = new URL(window.location.href);
    url.searchParams.delete('search');
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function openApplicationModal(record) {
    const u = record.user_data || {};
    
    // Names
    const first = u.first_name || u.firstname || '';
    const middle = u.middle_name || '';
    const last = u.last_name || u.lastname || '';
    let fullName = u.full_name || u.name || (first + ' ' + middle + ' ' + last).trim();
    if (!fullName) fullName = (first + ' ' + last).trim() || 'Anonymous Candidate';

    const email = u.email || u.email_address || 'Not Provided';
    const phone = u.phone || u.phone_no || u.phone_number || 'Not Provided';
    const initials = fullName.split(/\s+/).map(p => p[0]).slice(0, 2).join('').toUpperCase();

    // Set Header
    document.getElementById('modalApplicantName').textContent = fullName;
    const avatarEl = document.getElementById('modalAvatar');
    avatarEl.textContent = initials || 'AP';
    avatarEl.style.backgroundColor = '#f48221';

    document.getElementById('modalProgramBadge').textContent = record.program_name || 'Program';
    const cohortBadge = document.getElementById('modalCohortBadge');
    if (record.cohort_name) {
        cohortBadge.textContent = record.cohort_name;
        cohortBadge.style.display = 'inline-flex';
    } else {
        cohortBadge.textContent = 'General Enrollment';
        cohortBadge.style.display = 'inline-flex';
    }

    // Build Structured Sections
    let html = '';

    // Section 1: Basic & Demographic Info
    html += `
    <div class="modal-app-card">
        <div class="modal-app-card-title">
            <span class="material-symbols-outlined">badge</span>
            <span>Personal Credentials & Demographics</span>
        </div>
        <div class="row g-3">
            <div class="col-md-6 modal-data-item">
                <span class="modal-data-label">Full Legal Name</span>
                <div class="modal-data-value">${escapeHtml(fullName)}</div>
            </div>
            <div class="col-md-6 modal-data-item">
                <span class="modal-data-label">Email Address</span>
                <div class="modal-data-value">
                    <a href="mailto:${escapeHtml(email)}" class="text-orange fw-600">${escapeHtml(email)}</a>
                </div>
            </div>
            <div class="col-md-6 modal-data-item">
                <span class="modal-data-label">Primary Telephone</span>
                <div class="modal-data-value">
                    <a href="tel:${escapeHtml(phone)}" class="text-dark">${escapeHtml(phone)}</a>
                </div>
            </div>
            <div class="col-md-3 col-6 modal-data-item">
                <span class="modal-data-label">Gender</span>
                <div class="modal-data-value">${escapeHtml(u.gender || 'Not specified')}</div>
            </div>
            <div class="col-md-3 col-6 modal-data-item">
                <span class="modal-data-label">Age Bracket</span>
                <div class="modal-data-value">${escapeHtml(u.age ? u.age + ' years' : 'Not specified')}</div>
            </div>
            <div class="col-md-6 modal-data-item">
                <span class="modal-data-label">State of Origin</span>
                <div class="modal-data-value">${escapeHtml(u.state_of_origin || u.state || 'Not specified')}</div>
            </div>
            <div class="col-md-6 modal-data-item">
                <span class="modal-data-label">Local Government Area</span>
                <div class="modal-data-value">${escapeHtml(u.local_government || u.lga || 'Not specified')}</div>
            </div>
            ${u.disability && u.disability !== 'No' ? `
            <div class="col-md-12 modal-data-item">
                <span class="modal-data-label">Special Needs / Disability Status</span>
                <div class="modal-data-value text-danger fw-600">${escapeHtml(u.disability_type || u.disability)}</div>
            </div>` : ''}
        </div>
    </div>
    `;

    // Section 2: Enterprise & Business Details (if present)
    const hasBusiness = u.business_name || u.business_section || u.business_type || u.business_stage || u.years_of_experience || u.business_address;
    if (hasBusiness) {
        html += `
        <div class="modal-app-card">
            <div class="modal-app-card-title">
                <span class="material-symbols-outlined">storefront</span>
                <span>Enterprise & Professional Track</span>
            </div>
            <div class="row g-3">
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Business Venture Name</span>
                    <div class="modal-data-value fw-600">${escapeHtml(u.business_name || 'Individual Track')}</div>
                </div>
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Industry Sector</span>
                    <div class="modal-data-value">${escapeHtml(u.business_section || u.business_type || 'General')}</div>
                </div>
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Venture Stage</span>
                    <div class="modal-data-value">${escapeHtml(u.business_stage || 'Operating')}</div>
                </div>
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Years of Operation</span>
                    <div class="modal-data-value">${escapeHtml(u.years_of_experience ? u.years_of_experience + ' years' : 'N/A')}</div>
                </div>
                ${u.business_address ? `
                <div class="col-md-12 modal-data-item">
                    <span class="modal-data-label">Operational / Venture Address</span>
                    <div class="modal-data-value">${escapeHtml(u.business_address)}</div>
                </div>` : ''}
            </div>
        </div>
        `;
    }

    // Section 3: Academic standing & Intent
    const hasAcademic = u.educational_qualification || u.highest_qualification || u.employment_status || u.reason || u.reason_for_joining || u.comments;
    if (hasAcademic) {
        html += `
        <div class="modal-app-card">
            <div class="modal-app-card-title">
                <span class="material-symbols-outlined">school</span>
                <span>Education Background & Statement of Intent</span>
            </div>
            <div class="row g-3">
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Highest Academic Qualification</span>
                    <div class="modal-data-value">${escapeHtml(u.educational_qualification || u.highest_qualification || 'Not provided')}</div>
                </div>
                <div class="col-md-6 modal-data-item">
                    <span class="modal-data-label">Employment Standing</span>
                    <div class="modal-data-value">${escapeHtml(u.employment_status || 'Self-Employed')}</div>
                </div>
                ${(u.reason || u.reason_for_joining) ? `
                <div class="col-md-12 modal-data-item">
                    <span class="modal-data-label">Motivation / Reason for Joining</span>
                    <div class="modal-data-value text-muted" style="white-space: pre-wrap;">${escapeHtml(u.reason || u.reason_for_joining)}</div>
                </div>` : ''}
                ${u.comments ? `
                <div class="col-md-12 modal-data-item">
                    <span class="modal-data-label">Additional Comments / Inquiries</span>
                    <div class="modal-data-value text-muted" style="white-space: pre-wrap;">${escapeHtml(u.comments)}</div>
                </div>` : ''}
            </div>
        </div>
        `;
    }

    // Section 4: File Uploads & Documents
    let fileItems = [];
    for (let k in u) {
        let v = u[k];
        if (typeof v === 'string' && (v.includes('images/registrations/') || v.endsWith('.pdf') || v.endsWith('.jpg') || v.endsWith('.png') || v.endsWith('.jpeg'))) {
            let label = k.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            let baseUrl = '<?= BASE_URL ?>/';
            let fullUrl = v.startsWith('http') ? v : baseUrl + v.replace(/^\.\.\//, '');
            fileItems.push({ label, url: fullUrl, filename: v.split('/').pop() });
        }
    }

    if (fileItems.length > 0) {
        html += `
        <div class="modal-app-card">
            <div class="modal-app-card-title">
                <span class="material-symbols-outlined">attach_file</span>
                <span>Uploaded Documents & Proofs</span>
            </div>
            <div class="d-flex flex-column gap-2">
                ${fileItems.map(f => `
                    <div class="p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-orange">description</span>
                            <div>
                                <div class="fw-600 fs-085">${escapeHtml(f.label)}</div>
                                <span class="text-muted fs-075">${escapeHtml(f.filename)}</span>
                            </div>
                        </div>
                        <a href="${f.url}" target="_blank" class="btn btn-sm btn-outline-custom">
                            <span>Open File</span>
                            <span class="material-symbols-outlined fs-13 align-middle">open_in_new</span>
                        </a>
                    </div>
                `).join('')}
            </div>
        </div>
        `;
    }

    // Submission Metadata
    html += `
    <div class="text-muted fs-075 d-flex align-items-center justify-content-between pt-2">
        <span>Application ID: <strong>#${record.id}</strong></span>
        <span>Submitted on: <strong>${record.created_at}</strong></span>
    </div>
    `;

    document.getElementById('modalBodyContent').innerHTML = html;
    document.getElementById('appModal').classList.add('show');
}

function closeAppModal() {
    document.getElementById('appModal').classList.remove('show');
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function applyAppParam(key, value) {
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
    let modal = document.getElementById('appModal');
    if (event.target === modal) {
        closeAppModal();
    }
};
</script>
