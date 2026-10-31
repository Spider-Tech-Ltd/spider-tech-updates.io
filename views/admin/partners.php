<!-- Partnerships & Collaborators — Spider Tech Admin Operations Console -->
<?php
$allList = $partners ?? [];
$totalPartners = $stats['total'] ?? count($allList);
$activePartners = $stats['active'] ?? 0;
$inactivePartners = $stats['inactive'] ?? 0;
$hasActiveFilters = (!empty($search_query) || ($current_status ?? 'all') !== 'all' || ($current_sort ?? 'order_asc') !== 'order_asc');
?>

<style>
/* ========================================================
   PARTNERS MANAGEMENT CONSOLE STYLES
   ======================================================== */
.partner-logo-preview-box {
    width: 90px;
    height: 48px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 10px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    transition: all 0.2s ease;
}
.partner-logo-preview-box:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
}
.partner-logo-preview-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.partner-order-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    font-weight: 700;
    font-size: 0.82rem;
    color: #475569;
    font-family: 'Chakra Petch', monospace, sans-serif;
}

/* Custom Interactive Switch */
.switch-partner {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    margin: 0;
}
.switch-partner input {
    opacity: 0;
    width: 0;
    height: 0;
}
.switch-partner-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: 0.25s ease;
    border-radius: 24px;
}
.switch-partner-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.25s ease;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.25);
}
.switch-partner input:checked + .switch-partner-slider {
    background-color: #10b981;
}
.switch-partner input:checked + .switch-partner-slider:before {
    transform: translateX(20px);
}

/* Status Indicator Pill */
.status-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}
.status-pill-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.25);
}
.status-pill-badge.inactive {
    background: rgba(148, 163, 184, 0.12);
    color: #64748b;
    border: 1px solid rgba(148, 163, 184, 0.3);
}

/* Modal Form Specifics */
.partner-field-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}
.partner-field-wrapper .input-leading-icon {
    position: absolute;
    left: 12px;
    color: #94a3b8;
    pointer-events: none;
    font-size: 20px;
}
.partner-field-wrapper .form-control-custom {
    padding-left: 42px !important;
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    height: 44px;
    font-size: 0.88rem;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.2s ease;
}
.partner-field-wrapper .form-control-custom:focus {
    border-color: #f48221;
    box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.12);
    outline: none;
}

/* Logo Upload Dropzone */
.partner-logo-uploader {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
}
.partner-logo-uploader:hover {
    border-color: #f48221;
    background: #fffaf5;
}
.partner-logo-uploader.has-preview {
    border-style: solid;
    border-color: #e2e8f0;
    background: #ffffff;
}
.partner-logo-preview-image {
    max-height: 60px;
    max-width: 180px;
    object-fit: contain;
    margin-bottom: 8px;
}

/* Section Header Badge */
.partner-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    border-radius: 6px;
    padding: 4px 10px;
    margin-bottom: 14px;
}
.partner-section-badge .section-icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    background: #ffffff;
    border-radius: 4px;
    color: #f48221;
}
.partner-section-badge .section-title {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #475569;
}
</style>

<div>
    <!-- ====================================================
         HEADER
         ==================================================== -->
    <div class="dashboard-header mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center mb-1">
                    <h1 class="dashboard-title mb-0">Partnerships &amp; Collaborators</h1>
                    <span class="title-badge-count ms-2"><?= (int)$totalPartners ?> total</span>
                </div>
                <p class="dashboard-subtitle">Manage corporate partners, innovation hubs, and institutional affiliations showcased in the homepage marquee ticker.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/partners" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" style="border-radius: 50px !important;">
                        <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                        <span>Reset Filters</span>
                    </a>
                <?php endif; ?>
                <button type="button" class="btn-primary-custom" onclick="openPartnerModal()">
                    <span class="material-symbols-outlined fs-18">add_circle</span>
                    <span>Add Partner</span>
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
                <span class="stat-label">Total Partners</span>
                <span class="stat-icon bg-soft-blue text-blue">
                    <span class="material-symbols-outlined">handshake</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;"><?= number_format($totalPartners) ?></div>
            <div class="stat-desc">Configured brand affiliations</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Active in Marquee</span>
                <span class="stat-icon bg-soft-green text-green">
                    <span class="material-symbols-outlined">verified</span>
                </span>
            </div>
            <div class="stat-value text-green" style="font-size: 1.35rem;"><?= number_format($activePartners) ?></div>
            <div class="stat-desc">Live on public homepage ticker</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Hidden / Inactive</span>
                <span class="stat-icon bg-soft-orange text-orange">
                    <span class="material-symbols-outlined">visibility_off</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;"><?= number_format($inactivePartners) ?></div>
            <div class="stat-desc">Excluded from ticker stream</div>
        </div>
    </div>

    <!-- ====================================================
         DATA TABLE & FILTER TOOLBAR
         ==================================================== -->
    <div class="admin-card">
        <div class="table-toolbar">
            <div class="table-toolbar-left">
                <!-- Integrated Search Form -->
                <form method="GET" action="<?= BASE_URL ?>/admin/partners" class="m-0">
                    <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                        <input type="hidden" name="status" value="<?= htmlspecialchars((string)$current_status) ?>">
                    <?php endif; ?>
                    <?php if (!empty($current_sort) && $current_sort !== 'order_asc'): ?>
                        <input type="hidden" name="sort" value="<?= htmlspecialchars((string)$current_sort) ?>">
                    <?php endif; ?>

                    <div class="search-bar-integrated">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search partner name or URL...">
                        <?php if (!empty($search_query)): ?>
                            <a href="<?= BASE_URL ?>/admin/partners" class="search-clear-btn" title="Clear Search">
                                <span class="material-symbols-outlined fs-16">close</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/partners" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                        <span class="material-symbols-outlined fs-14">close</span>
                        <span>Clear Filters</span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="table-toolbar-right">
                <!-- Status Filter Dropdown -->
                <?php
                    $statusOptions = [
                        'all' => 'All Status',
                        'active' => 'Active Only',
                        'inactive' => 'Inactive Only'
                    ];
                    $activeStatusLabel = $statusOptions[$current_status ?? 'all'] ?? 'All Status';
                ?>
                <div class="custom-dropdown" x-data="{ open: false, label: '<?= htmlspecialchars($activeStatusLabel) ?>' }" @click.outside="open = false">
                    <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                        <span class="d-flex align-items-center">
                            <span class="custom-dropdown-label">Status:</span>
                            <strong class="custom-dropdown-val" x-text="label"></strong>
                        </span>
                        <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="custom-dropdown-menu" style="min-width: 170px;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                        <?php foreach ($statusOptions as $val => $text): ?>
                            <?php
                                $url = BASE_URL . '/admin/partners?' . http_build_query(array_merge($_GET, ['status' => $val]));
                                $isSelected = (($current_status ?? 'all') === $val);
                            ?>
                            <a href="<?= $url ?>" class="custom-dropdown-item <?= $isSelected ? 'selected' : '' ?>">
                                <span><?= htmlspecialchars($text) ?></span>
                                <?php if ($isSelected): ?>
                                    <span class="material-symbols-outlined item-check fs-16">check</span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Sort Order Dropdown -->
                <?php
                    $sortOptions = [
                        'order_asc'  => 'Sort Order (Low to High)',
                        'order_desc' => 'Sort Order (High to Low)',
                        'name_asc'   => 'Partner Name (A-Z)',
                        'name_desc'  => 'Partner Name (Z-A)',
                        'id_desc'    => 'Recently Added'
                    ];
                    $activeSortLabel = $sortOptions[$current_sort ?? 'order_asc'] ?? 'Sort Order (Low to High)';
                ?>
                <div class="custom-dropdown" x-data="{ open: false, label: '<?= htmlspecialchars($activeSortLabel) ?>' }" @click.outside="open = false">
                    <button type="button" class="custom-dropdown-trigger" @click="open = !open">
                        <span class="d-flex align-items-center">
                            <span class="custom-dropdown-label">Sort:</span>
                            <strong class="custom-dropdown-val" x-text="label"></strong>
                        </span>
                        <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="custom-dropdown-menu" style="min-width: 210px;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                        <?php foreach ($sortOptions as $val => $text): ?>
                            <?php
                                $url = BASE_URL . '/admin/partners?' . http_build_query(array_merge($_GET, ['sort' => $val]));
                                $isSelected = (($current_sort ?? 'order_asc') === $val);
                            ?>
                            <a href="<?= $url ?>" class="custom-dropdown-item <?= $isSelected ? 'selected' : '' ?>">
                                <span><?= htmlspecialchars($text) ?></span>
                                <?php if ($isSelected): ?>
                                    <span class="material-symbols-outlined item-check fs-16">check</span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">Order</th>
                        <th style="width: 140px;">Logo Preview</th>
                        <th>Partner &amp; Affiliation</th>
                        <th>Website Link</th>
                        <th style="width: 120px;" class="text-center">Marquee Visibility</th>
                        <th style="width: 110px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($partners)): ?>
                        <?php foreach ($partners as $item): ?>
                            <?php
                                $logoPath = $item['logo'];
                                if (preg_match('#^https?://#i', $logoPath)) {
                                    $logoUrl = $logoPath;
                                } elseif (strpos($logoPath, '/') !== false) {
                                    $logoUrl = BASE_URL . '/' . ltrim($logoPath, './');
                                } else {
                                    $logoUrl = BASE_URL . '/images/partners/' . $logoPath;
                                }
                                $isActive = (int)$item['is_active'] === 1;
                            ?>
                            <tr id="partner-row-<?= (int)$item['id'] ?>">
                                <!-- Sort Order -->
                                <td class="text-center">
                                    <span class="partner-order-badge" title="Sort Order #<?= (int)$item['sort_order'] ?>">
                                        <?= (int)$item['sort_order'] ?>
                                    </span>
                                </td>

                                <!-- Logo Preview -->
                                <td>
                                    <div class="partner-logo-preview-box">
                                        <img src="<?= htmlspecialchars($logoUrl) ?>"
                                             alt="<?= htmlspecialchars($item['name']) ?>"
                                             loading="lazy"
                                             onerror="this.onerror=null; this.src='<?= BASE_URL ?>/images/placeholder.png';">
                                    </div>
                                </td>

                                <!-- Partner Name -->
                                <td>
                                    <div class="fw-700 text-dark" style="font-size: 0.92rem; font-family: 'Poppins', sans-serif;">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.74rem;">
                                        Record #<?= (int)$item['id'] ?> &bull; Added <?= !empty($item['created_at']) ? date('M d, Y', strtotime($item['created_at'])) : 'Standard' ?>
                                    </span>
                                </td>

                                <!-- Website Link -->
                                <td>
                                    <?php if (!empty($item['website_url'])): ?>
                                        <a href="<?= htmlspecialchars($item['website_url']) ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center gap-1 text-primary text-decoration-none fw-500" style="font-size: 0.82rem;">
                                            <span><?= htmlspecialchars(preg_replace('#^https?://(www\.)?#i', '', $item['website_url'])) ?></span>
                                            <span class="material-symbols-outlined fs-14">open_in_new</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.8rem;">&mdash;</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Marquee Visibility Toggle -->
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <label class="switch-partner" title="Toggle Marquee Visibility">
                                            <input type="checkbox" <?= $isActive ? 'checked' : '' ?> onchange="togglePartnerStatus(<?= (int)$item['id'] ?>, this)">
                                            <span class="switch-partner-slider"></span>
                                        </label>
                                        <span class="status-pill-badge <?= $isActive ? 'active' : 'inactive' ?>" id="status-badge-<?= (int)$item['id'] ?>">
                                            <?= $isActive ? 'Active' : 'Hidden' ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="text-end">
                                    <div class="action-btns justify-content-end">
                                        <button type="button" class="btn-action edit"
                                                onclick='openPartnerModal(<?= json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                                title="Edit Partner">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <button type="button" class="btn-action delete"
                                                onclick="deleteItem(<?= (int)$item['id'] ?>, 'partner')"
                                                title="Delete Partner">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 60px; height: 60px; background: #f8fafc; border: 1px dashed #cbd5e1; color: #94a3b8;">
                                        <span class="material-symbols-outlined" style="font-size: 32px;">handshake</span>
                                    </div>
                                    <h5 class="fw-700 text-dark mb-1">No Partners Found</h5>
                                    <p class="text-muted mb-3" style="max-width: 380px; font-size: 0.84rem;">
                                        <?= !empty($search_query) ? 'No partner records match your current search criteria. Try clearing search filters.' : 'There are currently no corporate partners or logos configured in the system.' ?>
                                    </p>
                                    <button type="button" class="btn-primary-custom" onclick="openPartnerModal()">
                                        <span class="material-symbols-outlined fs-18">add_circle</span>
                                        <span>Add First Partner</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================
     ADD / EDIT PARTNER MODAL
     ==================================================== -->
<div id="partnerModal" class="modal-custom" style="display: none;">
    <div class="modal-content-custom" style="max-width: 540px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);">
        
        <!-- Modal Header -->
        <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(244, 130, 33, 0.1); color: #f48221; flex-shrink: 0;">
                    <span class="material-symbols-outlined fs-22">handshake</span>
                </div>
                <div>
                    <h5 class="m-0 fw-700 text-dark" style="font-family: 'Poppins', sans-serif; font-size: 1.05rem;" id="partnerModalTitle">Add Partner Organization</h5>
                    <p class="text-muted m-0 mt-0-5" style="font-size: 0.78rem;">Configure partner branding and homepage ticker visibility.</p>
                </div>
            </div>
            <button type="button" class="btn-action border-0 bg-transparent text-muted p-1" onclick="closePartnerModal()" style="cursor: pointer;" title="Close modal">
                <span class="material-symbols-outlined fs-20">close</span>
            </button>
        </div>

        <!-- Form Body -->
        <form id="partnerForm" onsubmit="submitPartnerForm(event)">
            <input type="hidden" name="id" id="partnerId" value="">
            <input type="hidden" name="type" value="partner">

            <div class="modal-body-custom px-4 py-3" style="max-height: calc(85vh - 130px); overflow-y: auto;">
                
                <!-- Section 1: Partner Identity -->
                <div class="mb-3">
                    <div class="partner-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined fs-14">domain</span>
                        </div>
                        <span class="section-title">Organization Details</span>
                    </div>

                    <!-- Partner Name -->
                    <div class="mb-3">
                        <label class="form-label fw-600 text-dark mb-1" style="font-size: 0.82rem;">Partner / Organization Name <span class="text-danger">*</span></label>
                        <div class="partner-field-wrapper">
                            <span class="material-symbols-outlined input-leading-icon">business</span>
                            <input type="text" name="name" id="partnerName" class="form-control-custom" placeholder="e.g., NITDA, Google for Startups, Microsoft" required>
                        </div>
                    </div>

                    <!-- Website URL -->
                    <div class="mb-3">
                        <label class="form-label fw-600 text-dark mb-1" style="font-size: 0.82rem;">Official Website URL <span class="text-muted fw-400">(Optional)</span></label>
                        <div class="partner-field-wrapper">
                            <span class="material-symbols-outlined input-leading-icon">link</span>
                            <input type="url" name="website_url" id="partnerUrl" class="form-control-custom" placeholder="https://example.com">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Logo Asset -->
                <div class="mb-3">
                    <div class="partner-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined fs-14">image</span>
                        </div>
                        <span class="section-title">Logo Asset</span>
                    </div>

                    <label class="form-label fw-600 text-dark mb-1" style="font-size: 0.82rem;">
                        Brand Logo File <span id="logoRequiredStar" class="text-danger">*</span>
                    </label>

                    <input type="file" name="logo" id="partnerLogoInput" accept="image/svg+xml,image/png,image/jpeg,image/webp" style="display: none;" onchange="handlePartnerLogoSelect(this)">

                    <div class="partner-logo-uploader" id="partnerLogoDropzone" onclick="document.getElementById('partnerLogoInput').click()">
                        <div id="partnerLogoPreviewWrapper" style="display: none;">
                            <img id="partnerLogoImgPreview" src="" alt="Preview" class="partner-logo-preview-image">
                            <div class="text-muted" style="font-size: 0.75rem;">Click to change logo file</div>
                        </div>
                        <div id="partnerLogoPlaceholder">
                            <span class="material-symbols-outlined text-muted mb-1" style="font-size: 28px;">cloud_upload</span>
                            <div class="fw-600 text-dark" style="font-size: 0.84rem;">Click to upload partner logo</div>
                            <div class="text-muted" style="font-size: 0.72rem;">SVG, PNG, JPG, or WEBP &bull; Max 2MB &bull; Transparent background recommended</div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Ordering & Visibility -->
                <div class="mb-2">
                    <div class="partner-section-badge">
                        <div class="section-icon-box">
                            <span class="material-symbols-outlined fs-14">tune</span>
                        </div>
                        <span class="section-title">Display Settings</span>
                    </div>

                    <div class="row g-3 align-items-center">
                        <div class="col-sm-6">
                            <label class="form-label fw-600 text-dark mb-1" style="font-size: 0.82rem;">Sort Priority Order</label>
                            <div class="partner-field-wrapper">
                                <span class="material-symbols-outlined input-leading-icon">tag</span>
                                <input type="number" name="sort_order" id="partnerSortOrder" class="form-control-custom" value="0" min="0" step="1">
                            </div>
                            <span class="text-muted" style="font-size: 0.7rem;">Lower numbers appear first in the marquee ticker.</span>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label fw-600 text-dark mb-1" style="font-size: 0.82rem;">Marquee Stream Status</label>
                            <div class="d-flex align-items-center gap-2 pt-1">
                                <label class="switch-partner" style="margin: 0;">
                                    <input type="checkbox" name="is_active" id="partnerIsActive" value="1" checked>
                                    <span class="switch-partner-slider"></span>
                                </label>
                                <span class="fw-600 text-dark" id="partnerActiveLabel" style="font-size: 0.84rem;">Active in Marquee</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.7rem;">Toggle to show or hide from public visitors.</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-custom d-flex justify-content-between align-items-center px-4 py-3 border-top" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                <button type="button" class="btn-pill-cancel px-3 py-2" onclick="closePartnerModal()">
                    Cancel
                </button>
                <button type="submit" id="partnerSubmitBtn" class="btn-primary-custom px-4 py-2">
                    <span class="material-symbols-outlined fs-16 align-middle me-1">save</span>
                    <span id="partnerSubmitText">Save Partner</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ====================================================
// MODAL & LIVE INTERACTION LOGIC
// ====================================================

function openPartnerModal(data = null) {
    const form = document.getElementById('partnerForm');
    form.reset();

    const titleElem = document.getElementById('partnerModalTitle');
    const submitTextElem = document.getElementById('partnerSubmitText');
    const idElem = document.getElementById('partnerId');
    const nameElem = document.getElementById('partnerName');
    const urlElem = document.getElementById('partnerUrl');
    const orderElem = document.getElementById('partnerSortOrder');
    const activeElem = document.getElementById('partnerIsActive');
    const logoRequiredStar = document.getElementById('logoRequiredStar');
    const logoDropzone = document.getElementById('partnerLogoDropzone');
    const logoPreviewWrap = document.getElementById('partnerLogoPreviewWrapper');
    const logoImgPreview = document.getElementById('partnerLogoImgPreview');
    const logoPlaceholder = document.getElementById('partnerLogoPlaceholder');
    const activeLabel = document.getElementById('partnerActiveLabel');

    if (data) {
        // Edit Mode
        titleElem.innerText = 'Edit Partner Organization';
        submitTextElem.innerText = 'Update Partner';
        idElem.value = data.id || '';
        nameElem.value = data.name || '';
        urlElem.value = data.website_url || '';
        orderElem.value = data.sort_order || 0;
        activeElem.checked = (parseInt(data.is_active) === 1);
        activeLabel.innerText = activeElem.checked ? 'Active in Marquee' : 'Hidden from Marquee';

        // Logo is not strictly required when editing (keeps existing if not changed)
        logoRequiredStar.style.display = 'none';

        if (data.logo) {
            let logoSrc = data.logo;
            if (!logoSrc.startsWith('http://') && !logoSrc.startsWith('https://')) {
                logoSrc = '<?= BASE_URL ?>/' + logoSrc.replace(/^\/+/, '');
            }
            logoImgPreview.src = logoSrc;
            logoPreviewWrap.style.display = 'block';
            logoPlaceholder.style.display = 'none';
            logoDropzone.classList.add('has-preview');
        } else {
            logoPreviewWrap.style.display = 'none';
            logoPlaceholder.style.display = 'block';
            logoDropzone.classList.remove('has-preview');
        }
    } else {
        // Add Mode
        titleElem.innerText = 'Add Partner Organization';
        submitTextElem.innerText = 'Save Partner';
        idElem.value = '';
        orderElem.value = '<?= (int)$totalPartners + 1 ?>';
        activeElem.checked = true;
        activeLabel.innerText = 'Active in Marquee';
        logoRequiredStar.style.display = 'inline';

        logoPreviewWrap.style.display = 'none';
        logoPlaceholder.style.display = 'block';
        logoDropzone.classList.remove('has-preview');
    }

    document.getElementById('partnerModal').style.display = 'flex';
}

function closePartnerModal() {
    document.getElementById('partnerModal').style.display = 'none';
}

function handlePartnerLogoSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const logoDropzone = document.getElementById('partnerLogoDropzone');
            const logoPreviewWrap = document.getElementById('partnerLogoPreviewWrapper');
            const logoImgPreview = document.getElementById('partnerLogoImgPreview');
            const logoPlaceholder = document.getElementById('partnerLogoPlaceholder');

            logoImgPreview.src = e.target.result;
            logoPreviewWrap.style.display = 'block';
            logoPlaceholder.style.display = 'none';
            logoDropzone.classList.add('has-preview');
        };
        reader.readAsDataURL(file);
    }
}

document.getElementById('partnerIsActive').addEventListener('change', function() {
    document.getElementById('partnerActiveLabel').innerText = this.checked ? 'Active in Marquee' : 'Hidden from Marquee';
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePartnerModal();
    }
});

// ====================================================
// AJAX FORM SUBMISSION
// ====================================================
async function submitPartnerForm(e) {
    e.preventDefault();

    const form = document.getElementById('partnerForm');
    const btn = document.getElementById('partnerSubmitBtn');
    const isEdit = Boolean(document.getElementById('partnerId').value);
    const logoInput = document.getElementById('partnerLogoInput');

    if (!isEdit && (!logoInput.files || logoInput.files.length === 0)) {
        alert('Please choose a partner logo image.');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

    const formData = new FormData(form);

    try {
        const response = await fetch('<?= BASE_URL ?>/admin/partners/save', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const res = await response.json();

        if (res.status === 'success') {
            if (typeof showToast === 'function') {
                showToast(res.message);
            }
            closePartnerModal();
            setTimeout(() => window.location.reload(), 400);
        } else {
            alert(res.message || 'Failed to save partner record.');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined fs-16 align-middle me-1">save</span> <span>' + (isEdit ? 'Update Partner' : 'Save Partner') + '</span>';
        }
    } catch (err) {
        console.error('Submission error:', err);
        alert('Network communication error. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined fs-16 align-middle me-1">save</span> <span>' + (isEdit ? 'Update Partner' : 'Save Partner') + '</span>';
    }
}

// ====================================================
// AJAX TOGGLE VISIBILITY
// ====================================================
async function togglePartnerStatus(id, checkbox) {
    const originalState = !checkbox.checked;
    checkbox.disabled = true;

    const formData = new FormData();
    formData.append('id', id);

    try {
        const response = await fetch('<?= BASE_URL ?>/admin/partners/toggle', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const res = await response.json();

        if (res.status === 'success') {
            const badge = document.getElementById('status-badge-' + id);
            if (badge) {
                if (checkbox.checked) {
                    badge.className = 'status-pill-badge active';
                    badge.innerText = 'Active';
                } else {
                    badge.className = 'status-pill-badge inactive';
                    badge.innerText = 'Hidden';
                }
            }
            if (typeof showToast === 'function') {
                showToast(res.message);
            }
        } else {
            alert(res.message || 'Failed to toggle partner status.');
            checkbox.checked = originalState;
        }
    } catch (err) {
        console.error('Toggle error:', err);
        alert('Network communication error.');
        checkbox.checked = originalState;
    } finally {
        checkbox.disabled = false;
    }
}
</script>
