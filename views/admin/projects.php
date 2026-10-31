<!-- Project Portfolio Management — Spider Tech Admin -->
<?php
$allList = $all_projects ?? $projects ?? [];
$totalCount = count($allList);
?>

<!-- Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="dashboard-title mb-0">Projects</h1>
                <span class="title-badge-count"><?= $totalCount ?> total</span>
            </div>
            <p class="dashboard-subtitle">Manage project portfolio showcase, client deliverables, and case studies.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/admin/projects/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Add Project</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="admin-card" x-data="projectTable()">
    <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
    <div class="table-toolbar">
        <div class="table-toolbar-left">
            <!-- Integrated Search Bar -->
            <form method="GET" action="<?= BASE_URL ?>/admin/projects" class="m-0">
                <?php if (!empty($current_limit)): ?>
                    <input type="hidden" name="limit" value="<?= htmlspecialchars($current_limit) ?>">
                <?php endif; ?>
                <?php if (!empty($current_sort)): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                <?php endif; ?>
                <?php if (!empty($current_service) && $current_service !== 'all'): ?>
                    <input type="hidden" name="service" value="<?= htmlspecialchars($current_service) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search projects...">
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= BASE_URL ?>/admin/projects" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (!empty($search_query) || (isset($current_service) && $current_service !== 'all')): ?>
                <a href="<?= BASE_URL ?>/admin/projects" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Service Category Filter -->
            <?php
                $activeServiceLabel = 'All Services';
                if (!empty($current_service) && $current_service !== 'all' && !empty($services)) {
                    foreach ($services as $s) {
                        if ((string)$s['id'] === (string)$current_service) {
                            $activeServiceLabel = $s['service_name'];
                            break;
                        }
                    }
                }
            ?>
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_service ?? 'all' ?>',
                label: '<?= htmlspecialchars($activeServiceLabel) ?>'
            }" @click.outside="open = false">
                <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                    <span class="d-flex align-items-center">
                        <span class="custom-dropdown-label">Category:</span>
                        <strong class="custom-dropdown-val" x-text="label"></strong>
                    </span>
                    <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="custom-dropdown-menu" style="min-width: 220px; max-height: 280px; overflow-y: auto;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyProjectParam('service', 'all'); open = false;">
                        <span>All Services</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $srv): ?>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current == '<?= $srv['id'] ?>' }" @click="applyProjectParam('service', '<?= $srv['id'] ?>'); open = false;">
                                <span class="text-truncate" style="max-width: 175px;"><?= htmlspecialchars($srv['service_name']) ?></span>
                                <svg class="check-icon" x-show="current == '<?= $srv['id'] ?>'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Sort -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_sort ?? 'id_desc' ?>',
                label: '<?= match($current_sort ?? 'id_desc') { 'id_asc' => 'Oldest First', 'name_asc' => 'Name (A to Z)', 'name_desc' => 'Name (Z to A)', 'year_desc' => 'Year (Recent)', 'year_asc' => 'Year (Oldest)', default => 'Newest First' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyProjectParam('sort', 'id_desc'); open = false;">
                        <span>Newest First</span>
                        <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_asc' }" @click="applyProjectParam('sort', 'id_asc'); open = false;">
                        <span>Oldest First</span>
                        <svg class="check-icon" x-show="current === 'id_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_asc' }" @click="applyProjectParam('sort', 'name_asc'); open = false;">
                        <span>Name (A &rarr; Z)</span>
                        <svg class="check-icon" x-show="current === 'name_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_desc' }" @click="applyProjectParam('sort', 'name_desc'); open = false;">
                        <span>Name (Z &rarr; A)</span>
                        <svg class="check-icon" x-show="current === 'name_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'year_desc' }" @click="applyProjectParam('sort', 'year_desc'); open = false;">
                        <span>Year (Recent First)</span>
                        <svg class="check-icon" x-show="current === 'year_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'year_asc' }" @click="applyProjectParam('sort', 'year_asc'); open = false;">
                        <span>Year (Oldest First)</span>
                        <svg class="check-icon" x-show="current === 'year_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Strictly Bounded Table: ZERO Horizontal Scroll on X-Axis -->
    <div class="table-nowrap-container">
        <table class="table table-custom table-fixed">
            <thead>
                <tr>
                    <th style="width: 58px;">#ID</th>
                    <th style="width: 42%;">Project</th>
                    <th style="width: 38%;">Description</th>
                    <th style="width: 85px;" class="text-center">Year</th>
                    <th style="width: 140px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project):
                        $cleanTitle = htmlspecialchars($project['project_name']);
                        $displayTitle = mb_strimwidth($cleanTitle, 0, 42, '...');
                        $cleanDesc = htmlspecialchars(strip_tags($project['project_description'] ?? ''));
                        $displayDesc = !empty($cleanDesc) ? mb_strimwidth($cleanDesc, 0, 68, '...') : 'No description provided';
                        $serviceName = htmlspecialchars($project['service_name'] ?? 'Solution');
                        $year = htmlspecialchars($project['project_year'] ?? '—');
                        $idPad = str_pad($project['project_id'], 2, '0', STR_PAD_LEFT);

                        // Robust thumbnail image resolution matching public website
                        $rawPic = trim($project['project_pic'] ?? '');
                        $hasPic = false;
                        $finalPic = '';
                        if ($rawPic !== '') {
                            if (preg_match('#^https?://#i', $rawPic)) {
                                $finalPic = $rawPic;
                                $hasPic = true;
                            } else {
                                $relPath = ltrim(preg_replace('#^(\.\./)+#', '', $rawPic), '/');
                                if (file_exists(ROOT_PATH . '/' . $relPath)) {
                                    $finalPic = BASE_URL . '/' . $relPath;
                                    $hasPic = true;
                                }
                            }
                        }
                    ?>
                    <tr>
                        <!-- ID -->
                        <td>
                            <span class="chip-id">#<?= $idPad ?></span>
                        </td>

                        <!-- Thumbnail & Project Title (Truncated, Bounded) -->
                        <td>
                            <div class="d-flex align-items-center" style="gap: 12px; min-width: 0; max-width: 100%;">
                                <!-- Thumbnail with SVG Fallback -->
                                <div class="project-thumb-container" style="width: 50px; height: 38px; flex-shrink: 0;">
                                    <?php if ($hasPic): ?>
                                        <img src="<?= htmlspecialchars($finalPic) ?>"
                                             alt="<?= $cleanTitle ?>"
                                             class="project-thumb-img"
                                             loading="lazy"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <?php endif; ?>
                                    <div class="project-thumb-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true" title="No thumbnail available">
                                        <svg width="20" height="20" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="10" width="52" height="44" rx="8" stroke="#94a3b8" stroke-width="3" stroke-dasharray="4 3"/>
                                            <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="3"/>
                                            <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="#94a3b8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Title and Category Tag (Strictly Bounded) -->
                                <div class="min-w-0 flex-grow-1" style="overflow: hidden;">
                                    <a href="javascript:void(0)" class="project-title-text" title="<?= $cleanTitle ?>" @click="showProjectModal(<?= htmlspecialchars(json_encode(array_merge($project, ['resolved_pic' => $finalPic, 'has_pic' => $hasPic]))) ?>)">
                                        <?= $displayTitle ?>
                                    </a>
                                    <div class="mt-1">
                                        <span class="project-category-badge text-truncate d-inline-block" style="max-width: 100%;"><?= $serviceName ?></span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Description (Truncated, Bounded) -->
                        <td>
                            <span class="project-desc-cell" title="<?= $cleanDesc ?>">
                                <?= $displayDesc ?>
                            </span>
                        </td>

                        <!-- Year -->
                        <td class="text-center">
                            <span class="project-year-chip">
                                <span class="material-symbols-outlined" style="font-size: 13px;">calendar_today</span>
                                <span><?= $year ?></span>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="action-btns">
                                <button type="button" class="btn-action" title="Quick View" @click="showProjectModal(<?= htmlspecialchars(json_encode(array_merge($project, ['resolved_pic' => $finalPic, 'has_pic' => $hasPic]))) ?>)">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <a href="<?= BASE_URL ?>/admin/projects/edit/<?= $project['project_id'] ?>" class="btn-action edit" title="Edit Project">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <button type="button" class="btn-action delete" title="Delete Project" onclick="deleteItem(<?= $project['project_id'] ?>, 'project')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4">
                                <span class="material-symbols-outlined text-muted mb-2" style="font-size: 40px;">folder_special</span>
                                <h5 class="fw-bold mb-1">No Projects Found</h5>
                                <p class="text-muted small mb-3">
                                    <?= !empty($search_query) ? 'No projects matched "' . htmlspecialchars($search_query) . '".' : 'There are no projects matching this criteria.' ?>
                                </p>
                                <?php if (!empty($search_query) || (isset($current_service) && $current_service !== 'all')): ?>
                                    <a href="<?= BASE_URL ?>/admin/projects" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined">restart_alt</span>
                                        <span>Reset Filters</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/admin/projects/add" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined fs-18">add_circle</span>
                                        <span>Add First Project</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Enhanced Controllable Pagination Footer with Custom Dropdown -->
    <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>

    <!-- Project Detail Quick Preview Modal -->
    <div class="modal fade" id="projectPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-bottom p-4" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="project-thumb-container" style="width: 50px; height: 38px;">
                            <template x-if="activeProject.has_pic">
                                <img :src="activeProject.resolved_pic" :alt="activeProject.project_name" class="project-thumb-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            </template>
                            <div class="project-thumb-fallback" :style="{ display: activeProject.has_pic ? 'none' : 'flex' }">
                                <svg width="20" height="20" viewBox="0 0 64 64" fill="none">
                                    <rect x="6" y="10" width="52" height="44" rx="8" stroke="#94a3b8" stroke-width="3" stroke-dasharray="4 3"/>
                                    <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="3"/>
                                    <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="#94a3b8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.8px;">Project #<span x-text="activeProject.project_id"></span></span>
                            <h4 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;" x-text="activeProject.project_name"></h4>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Service Category</span>
                                <span class="project-category-badge" x-text="activeProject.service_name || 'Technology Solution'"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Project Year</span>
                                <span class="fw-bold fs-09" style="font-family: 'Poppins', sans-serif;" x-text="activeProject.project_year || '—'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Full Preview Photo if Available -->
                    <template x-if="activeProject.has_pic">
                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Primary Visual Asset</label>
                            <div class="rounded-3 overflow-hidden border" style="max-height: 260px; background: #0f172a;">
                                <img :src="activeProject.resolved_pic" :alt="activeProject.project_name" style="width: 100%; height: 240px; object-fit: contain;">
                            </div>
                        </div>
                    </template>

                    <div class="mb-2">
                        <label class="form-label text-muted small text-uppercase fw-bold">Project Overview & Description</label>
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.88rem; line-height: 1.6;" x-text="activeProject.project_description || 'No description provided.'"></div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn-admin-cancel px-4" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex align-items-center gap-2">
                        <a :href="'<?= BASE_URL ?>/projects/detail?id=' + activeProject.project_id" target="_blank" class="btn btn-sm btn-pill-cancel px-3">
                            <span class="material-symbols-outlined" style="font-size: 15px;">open_in_new</span>
                            <span>Public View</span>
                        </a>
                        <a :href="'<?= BASE_URL ?>/admin/projects/edit/' + activeProject.project_id" class="btn-primary-custom px-4">
                            <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                            <span>Edit Project</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function projectTable() {
    return {
        activeProject: {},
        showProjectModal(project) {
            this.activeProject = project;
            const modalEl = document.getElementById('projectPreviewModal');
            if (modalEl) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                } else {
                    $(modalEl).modal('show');
                }
            }
        }
    };
}

function applyProjectParam(key, value) {
    const url = new URL(window.location.href);
    if (value === 'all' || value === '') {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
}
</script>
