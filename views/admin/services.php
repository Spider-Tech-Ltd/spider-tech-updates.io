<!-- Services Management — Spider Tech Admin -->
<?php
$allList = $all_services ?? $services ?? [];
$totalCount = count($allList);

// Smart icon rendering helper
if (!function_exists('renderServiceIconBadge')) {
    function renderServiceIconBadge($iconClass, $name) {
        $iconClass = trim($iconClass ?? '');
        if (empty($iconClass)) {
            $lower = strtolower($name);
            if (str_contains($lower, 'software') || str_contains($lower, 'develop')) $icon = 'fas fa-laptop-code';
            elseif (str_contains($lower, 'data')) $icon = 'fas fa-database';
            elseif (str_contains($lower, 'mobile') || str_contains($lower, 'app')) $icon = 'fas fa-mobile-screen';
            elseif (str_contains($lower, 'network')) $icon = 'fas fa-network-wired';
            elseif (str_contains($lower, 'train')) $icon = 'fas fa-users';
            elseif (str_contains($lower, 'consult')) $icon = 'fas fa-handshake';
            elseif (str_contains($lower, 'market')) $icon = 'fas fa-bullhorn';
            elseif (str_contains($lower, 'procure') || str_contains($lower, 'equip')) $icon = 'fas fa-boxes-packing';
            elseif (str_contains($lower, 'monitor') || str_contains($lower, 'evaluat')) $icon = 'fas fa-chart-line';
            else $icon = 'fas fa-lightbulb';
        } else {
            $icon = $iconClass;
        }
        return '<i class="' . htmlspecialchars($icon) . '"></i>';
    }
}
?>

<!-- Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="dashboard-title mb-0">Services</h1>
                <span class="title-badge-count"><?= $totalCount ?> total</span>
            </div>
            <p class="dashboard-subtitle">Manage service catalog offerings, descriptions, and display priority.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/admin/services/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>Add Service</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="admin-card" x-data="serviceTable()">
    <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
    <div class="table-toolbar">
        <div class="table-toolbar-left">
            <!-- Integrated Search Bar -->
            <form method="GET" action="<?= BASE_URL ?>/admin/services" class="m-0">
                <?php if (!empty($current_limit)): ?>
                    <input type="hidden" name="limit" value="<?= htmlspecialchars($current_limit) ?>">
                <?php endif; ?>
                <?php if (!empty($current_sort)): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                <?php endif; ?>
                <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($current_status) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search services...">
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= BASE_URL ?>/admin/services" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (!empty($search_query) || (isset($current_status) && $current_status !== 'all')): ?>
                <a href="<?= BASE_URL ?>/admin/services" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Visibility -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_status ?? 'all' ?>',
                label: '<?= ($current_status === '1') ? 'Featured on Home' : (($current_status === '0') ? 'Standard Only' : 'All Services') ?>'
            }" @click.outside="open = false">
                <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                    <span class="d-flex align-items-center">
                        <span class="custom-dropdown-label">Visibility:</span>
                        <strong class="custom-dropdown-val" x-text="label"></strong>
                    </span>
                    <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="custom-dropdown-menu" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyServiceParam('status', 'all'); open = false;">
                        <span>All Services</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '1' }" @click="applyServiceParam('status', '1'); open = false;">
                        <span>Featured on Home</span>
                        <svg class="check-icon" x-show="current === '1'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === '0' }" @click="applyServiceParam('status', '0'); open = false;">
                        <span>Standard Only</span>
                        <svg class="check-icon" x-show="current === '0'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Sort -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_sort ?? 'id_desc' ?>',
                label: '<?= match($current_sort ?? 'id_desc') { 'id_asc' => 'Oldest First', 'name_asc' => 'Name (A to Z)', 'name_desc' => 'Name (Z to A)', 'order_asc' => 'Display Priority', default => 'Newest First' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyServiceParam('sort', 'id_desc'); open = false;">
                        <span>Newest First</span>
                        <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_asc' }" @click="applyServiceParam('sort', 'id_asc'); open = false;">
                        <span>Oldest First</span>
                        <svg class="check-icon" x-show="current === 'id_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_asc' }" @click="applyServiceParam('sort', 'name_asc'); open = false;">
                        <span>Name (A &rarr; Z)</span>
                        <svg class="check-icon" x-show="current === 'name_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_desc' }" @click="applyServiceParam('sort', 'name_desc'); open = false;">
                        <span>Name (Z &rarr; A)</span>
                        <svg class="check-icon" x-show="current === 'name_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'order_asc' }" @click="applyServiceParam('sort', 'order_asc'); open = false;">
                        <span>Display Priority</span>
                        <svg class="check-icon" x-show="current === 'order_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Spacious, Balanced Table (Homepage Status Column Removed) -->
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 70px;">#ID</th>
                    <th style="width: 320px;">Service Name</th>
                    <th>Description</th>
                    <th style="width: 100px;" class="text-center">Order</th>
                    <th style="width: 130px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service):
                        $cleanTitle = htmlspecialchars($service['service_name']);
                        $cleanDesc = htmlspecialchars(strip_tags($service['service_description']));
                        $order = (int)($service['sort_order'] ?? 0);
                        $idPad = str_pad($service['id'], 2, '0', STR_PAD_LEFT);
                    ?>
                    <tr>
                        <!-- ID -->
                        <td>
                            <span class="chip-id">#<?= $idPad ?></span>
                        </td>

                        <!-- Icon & Service Name with Generous Spacing -->
                        <td>
                            <div class="d-flex align-items-center" style="gap: 16px;">
                                <div class="service-icon-box" title="<?= htmlspecialchars($service['service_name']) ?>">
                                    <?= renderServiceIconBadge($service['service_icon'] ?? '', $service['service_name']) ?>
                                </div>
                                <div class="min-w-0">
                                    <a href="javascript:void(0)" class="service-title-link text-truncate d-block" @click="showServiceModal(<?= htmlspecialchars(json_encode($service)) ?>)">
                                        <?= $cleanTitle ?>
                                    </a>
                                </div>
                            </div>
                        </td>

                        <!-- Description with Balanced Spacing -->
                        <td>
                            <div class="text-muted" style="font-size: 0.85rem; line-height: 1.6; max-width: 620px;" title="<?= $cleanDesc ?>">
                                <?= mb_strimwidth($cleanDesc, 0, 110, '...') ?>
                            </div>
                        </td>

                        <!-- Display Order -->
                        <td class="text-center">
                            <span class="chip-order">
                                <span class="material-symbols-outlined" style="font-size: 13px;">reorder</span>
                                <span><?= $order ?></span>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="action-btns">
                                <button type="button" class="btn-action" title="Quick View" @click="showServiceModal(<?= htmlspecialchars(json_encode($service)) ?>)">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <a href="<?= BASE_URL ?>/admin/services/edit/<?= $service['id'] ?>" class="btn-action edit" title="Edit Service">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <button type="button" class="btn-action delete" title="Delete Service" onclick="deleteItem(<?= $service['id'] ?>, 'service')">
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
                                <span class="material-symbols-outlined text-muted mb-2" style="font-size: 40px;">design_services</span>
                                <h5 class="fw-bold mb-1">No Services Found</h5>
                                <p class="text-muted small mb-3">
                                    <?= !empty($search_query) ? 'No results matched "' . htmlspecialchars($search_query) . '".' : 'There are no services matching this criteria.' ?>
                                </p>
                                <?php if (!empty($search_query) || (isset($current_status) && $current_status !== 'all')): ?>
                                    <a href="<?= BASE_URL ?>/admin/services" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined">restart_alt</span>
                                        <span>Reset Filters</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/admin/services/add" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined fs-18">add_circle</span>
                                        <span>Add First Service</span>
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

    <!-- Service Detail Quick Preview Modal -->
    <div class="modal fade" id="servicePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-bottom p-4" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-service-badge m-0">
                            <i :class="activeService.service_icon || 'fas fa-cog'"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.8px;">Service #<span x-text="activeService.id"></span></span>
                            <h4 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;" x-text="activeService.service_name"></h4>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Homepage Visibility</span>
                                <template x-if="activeService.show_on_home == 1">
                                    <span class="status-pill featured">
                                        <span class="status-pill-dot"></span>
                                        <span>Featured on Homepage</span>
                                    </span>
                                </template>
                                <template x-if="activeService.show_on_home != 1">
                                    <span class="status-pill standard">
                                        <span class="status-pill-dot"></span>
                                        <span>Standard Catalog Service</span>
                                    </span>
                                </template>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Display Priority Order</span>
                                <span class="fw-bold fs-09" style="font-family: 'Poppins', sans-serif;">Order Rank #<span x-text="activeService.sort_order || 0"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Short Summary</label>
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.88rem; line-height: 1.6;" x-text="activeService.service_description"></div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-muted small text-uppercase fw-bold">Detailed Content</label>
                        <div class="p-3 rounded-3" style="background: #ffffff; border: 1px solid #e2e8f0; max-height: 240px; overflow-y: auto; font-size: 0.88rem; line-height: 1.7;" x-html="activeService.service_detail || '<p class=\"text-muted\">No detailed rich text content provided.</p>'"></div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn-admin-cancel px-4" data-bs-dismiss="modal">Close</button>
                    <a :href="'<?= BASE_URL ?>/admin/services/edit/' + activeService.id" class="btn-primary-custom px-4">
                        <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                        <span>Edit Service</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function serviceTable() {
    return {
        activeService: {},
        showServiceModal(service) {
            this.activeService = service;
            const modalEl = document.getElementById('servicePreviewModal');
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

function applyServiceParam(key, value) {
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
