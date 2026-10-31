<!-- Events Management — Spider Tech Admin Operations Console -->
<?php
$allList = $events ?? [];
$totalCount = $pagination['total_records'] ?? count($allList);
$hasActiveFilters = (($current_status ?? 'all') !== 'all' || !empty($search_query));
?>

<!-- Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="dashboard-title mb-0">Events Management</h1>
                <span class="title-badge-count"><?= (int)$totalCount ?> total</span>
            </div>
            <p class="dashboard-subtitle">Organize and manage upcoming conferences, workshops, ongoing meetups, and past archives.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/events" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/admin/events/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Add Event</span>
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
            <span class="stat-label">Total Events</span>
            <span class="stat-icon bg-soft-blue text-blue">
                <span class="material-symbols-outlined">event</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_events'] ?? 0) ?></div>
        <div class="stat-desc">Community sessions & workshops</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Upcoming</span>
            <span class="stat-icon bg-soft-green text-green">
                <span class="material-symbols-outlined">upcoming</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['upcoming_events'] ?? 0) ?></div>
        <div class="stat-desc">Scheduled future gatherings</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Ongoing</span>
            <span class="stat-icon bg-soft-orange text-orange">
                <span class="material-symbols-outlined">schedule</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['ongoing_events'] ?? 0) ?></div>
        <div class="stat-desc">Events currently taking place</div>
    </div>

    <div class="stat-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="stat-label">Past Archives</span>
            <span class="stat-icon bg-soft-purple text-purple">
                <span class="material-symbols-outlined">history_edu</span>
            </span>
        </div>
        <div class="stat-value"><?= number_format($stats['past_events'] ?? 0) ?></div>
        <div class="stat-desc">Completed events with galleries</div>
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
            <form method="GET" action="<?= BASE_URL ?>/admin/events" class="m-0">
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
                    <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search event title, venue, details...">
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= BASE_URL ?>/admin/events" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined fs-16">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($hasActiveFilters): ?>
                <a href="<?= BASE_URL ?>/admin/events" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
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
                label: '<?= match($current_status ?? 'all') { 'upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'past' => 'Past Archives', default => 'All Events' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyEventParam('status', 'all'); open = false;">
                        <span>All Events</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'upcoming' }" @click="applyEventParam('status', 'upcoming'); open = false;">
                        <span>Upcoming</span>
                        <svg class="check-icon" x-show="current === 'upcoming'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'ongoing' }" @click="applyEventParam('status', 'ongoing'); open = false;">
                        <span>Ongoing</span>
                        <svg class="check-icon" x-show="current === 'ongoing'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'past' }" @click="applyEventParam('status', 'past'); open = false;">
                        <span>Past Archives</span>
                        <svg class="check-icon" x-show="current === 'past'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Sort -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_sort ?? 'date_desc' ?>',
                label: '<?= match($current_sort ?? 'date_desc') { 'date_asc' => 'Date (Earliest)', 'title_asc' => 'Title (A to Z)', 'title_desc' => 'Title (Z to A)', 'id_desc' => 'Newest First', default => 'Date (Recent First)' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'date_desc' }" @click="applyEventParam('sort', 'date_desc'); open = false;">
                        <span>Date (Recent First)</span>
                        <svg class="check-icon" x-show="current === 'date_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'date_asc' }" @click="applyEventParam('sort', 'date_asc'); open = false;">
                        <span>Date (Earliest)</span>
                        <svg class="check-icon" x-show="current === 'date_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'title_asc' }" @click="applyEventParam('sort', 'title_asc'); open = false;">
                        <span>Title (A &rarr; Z)</span>
                        <svg class="check-icon" x-show="current === 'title_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'title_desc' }" @click="applyEventParam('sort', 'title_desc'); open = false;">
                        <span>Title (Z &rarr; A)</span>
                        <svg class="check-icon" x-show="current === 'title_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyEventParam('sort', 'id_desc'); open = false;">
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '6' }" @click="applyEventParam('limit', '6'); open = false;">
                        <span>6 rows</span>
                        <svg class="check-icon" x-show="current === '6'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '12' }" @click="applyEventParam('limit', '12'); open = false;">
                        <span>12 rows</span>
                        <svg class="check-icon" x-show="current === '12'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '24' }" @click="applyEventParam('limit', '24'); open = false;">
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
                        <th style="min-width: 280px;">Event Title &amp; Details</th>
                        <th style="min-width: 170px;">Date &amp; Schedule</th>
                        <th style="min-width: 180px;">Venue &amp; Location</th>
                        <th style="min-width: 110px;">Status</th>
                        <th style="min-width: 110px;">Visibility</th>
                        <th class="text-end" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event):
                            $imagePath = resolvePath($event['event_img']);
                            $status = strtolower($event['event_status'] ?? 'upcoming');
                            $showOnHome = !empty($event['show_on_home']);

                            $statusClass = 'badge-soft-muted';
                            if ($status === 'upcoming') $statusClass = 'badge-soft-green';
                            elseif ($status === 'ongoing') $statusClass = 'badge-soft-orange';
                            elseif ($status === 'past') $statusClass = 'badge-soft-muted';
                        ?>
                        <tr>
                            <!-- Event Identity -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="table-img-wrapper flex-shrink-0" style="width: 58px; height: 44px; border-radius: 8px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($event['event_title']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='<?= BASE_URL ?>/images/placeholder.jpg'">
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-600 text-dark" style="font-size: 0.88rem; line-height: 1.25;"><?= htmlspecialchars($event['event_title']) ?></div>
                                        <div class="text-muted text-truncate" style="font-size: 0.77rem; max-width: 250px; margin-top: 2px;">
                                            <?= htmlspecialchars(strip_tags($event['event_content'] ?? '')) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Date & Schedule -->
                            <td>
                                <div class="text-dark fw-600 text-nowrap" style="font-size: 0.83rem;">
                                    <span class="material-symbols-outlined fs-14 text-orange align-middle me-1">calendar_month</span>
                                    <span><?= date('M d, Y', strtotime($event['event_date'])) ?></span>
                                </div>
                                <?php if (!empty($event['event_time'])): ?>
                                    <div class="text-muted text-nowrap" style="font-size: 0.74rem; margin-top: 2px;">
                                        <span class="material-symbols-outlined fs-13 align-middle me-1">schedule</span>
                                        <span><?= htmlspecialchars($event['event_time']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Venue & Location -->
                            <td>
                                <div class="text-dark fw-500 text-truncate" style="font-size: 0.83rem; max-width: 200px;" title="<?= htmlspecialchars($event['event_address']) ?>">
                                    <span class="material-symbols-outlined fs-14 text-muted align-middle me-1">location_on</span>
                                    <span><?= htmlspecialchars($event['event_address'] ?? 'Online') ?></span>
                                </div>
                            </td>

                            <!-- Status Pill -->
                            <td>
                                <span class="badge <?= $statusClass ?>" style="font-size: 0.75rem; font-weight: 600; padding: 4px 9px; border-radius: 6px;">
                                    <?php if ($status === 'ongoing'): ?>
                                        <span class="status-pulse-dot me-1"></span>
                                    <?php endif; ?>
                                    <span><?= ucfirst($event['event_status']) ?></span>
                                </span>
                            </td>

                            <!-- Visibility / Featured -->
                            <td>
                                <?php if ($showOnHome): ?>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.09); color: #059669; font-size: 0.74rem; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fas fa-home me-1"></i> Featured
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.74rem;">Standard</span>
                                <?php endif; ?>
                            </td>

                            <!-- Action Buttons -->
                            <td class="text-end">
                                <div class="action-btns justify-content-end">
                                    <a href="<?= BASE_URL ?>/events/detail/<?= $event['event_id'] ?>" target="_blank" class="btn-action" title="Preview Public Page">
                                        <span class="material-symbols-outlined fs-16">open_in_new</span>
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/events/edit/<?= $event['event_id'] ?>" class="btn-action edit" title="Edit Event">
                                        <span class="material-symbols-outlined fs-16">edit</span>
                                    </a>
                                    <button type="button" class="btn-action delete" onclick="deleteItem(<?= $event['event_id'] ?>, 'event')" title="Delete Event">
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
                                    <span class="material-symbols-outlined text-muted" style="font-size: 48px;">event_busy</span>
                                    <p class="text-muted mt-2 mb-3">No events match your selected criteria.</p>
                                    <?php if ($hasActiveFilters): ?>
                                        <a href="<?= BASE_URL ?>/admin/events" class="btn btn-sm btn-outline-custom">Reset Filters</a>
                                    <?php else: ?>
                                        <a href="<?= BASE_URL ?>/admin/events/add" class="btn btn-sm btn-primary-custom">Add First Event</a>
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
function applyEventParam(key, value) {
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
