<!-- Client Testimonials — Spider Tech Admin Operations Console -->
<?php
$allList = $testimonials ?? [];
$totalCount = $pagination['total_records'] ?? count($allList);
$hasActiveFilters = (!empty($search_query) || ($current_sort ?? 'id_desc') !== 'id_desc');
?>

<div x-data="{
    previewModalOpen: false,
    previewName: '',
    previewOrg: '',
    previewTitle: '',
    previewText: '',
    previewImg: '',
    previewInitials: '',
    previewId: null,
    openPreview(name, org, title, text, img, initials, id) {
        this.previewName = name;
        this.previewOrg = org;
        this.previewTitle = title;
        this.previewText = text;
        this.previewImg = img;
        this.previewInitials = initials;
        this.previewId = id;
        this.previewModalOpen = true;
    },
    closePreview() {
        this.previewModalOpen = false;
    }
}">

    <!-- ====================================================
         HEADER
         ==================================================== -->
    <div class="dashboard-header mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center mb-1">
                    <h1 class="dashboard-title mb-0">Client Testimonials</h1>
                    <span class="title-badge-count"><?= (int)$totalCount ?> total</span>
                </div>
                <p class="dashboard-subtitle">Manage client feedback, corporate endorsements, and executive success stories.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/testimonials" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" style="border-radius: 50px !important;">
                        <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                        <span>Reset</span>
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/admin/testimonials/add" class="btn-primary-custom">
                    <span class="material-symbols-outlined fs-18">add_circle</span>
                    <span>Add Testimonial</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ====================================================
         KPI SUMMARY CARDS (Refined, Balanced Typography)
         ==================================================== -->
    <div class="apps-stats-grid mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Total Testimonials</span>
                <span class="stat-icon bg-soft-blue text-blue">
                    <span class="material-symbols-outlined">reviews</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;"><?= number_format($stats['total_testimonials'] ?? $totalCount) ?></div>
            <div class="stat-desc">Published client reviews</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Partner Institutions</span>
                <span class="stat-icon bg-soft-green text-green">
                    <span class="material-symbols-outlined">domain</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;"><?= number_format($stats['total_organizations'] ?? 0) ?></div>
            <div class="stat-desc">Organizations represented</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Verified Portraits</span>
                <span class="stat-icon bg-soft-orange text-orange">
                    <span class="material-symbols-outlined">badge</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;">
                <?= number_format($stats['with_photos'] ?? 0) ?>
                <span class="text-muted fw-500" style="font-size: 0.8rem;">with photo</span>
            </div>
            <div class="stat-desc">Authentic client headshots</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Public Endorsement</span>
                <span class="stat-icon bg-soft-purple text-purple">
                    <span class="material-symbols-outlined">verified</span>
                </span>
            </div>
            <div class="stat-value text-success d-inline-flex align-items-center gap-1" style="font-size: 1.2rem;">
                <span class="material-symbols-outlined fs-18">check_circle</span>
                <span>Active 24/7</span>
            </div>
            <div class="stat-desc">Live on web & landing pages</div>
        </div>
    </div>

    <!-- ====================================================
         MAIN TABLE CARD WITH TOOLBAR
         ==================================================== -->
    <div class="admin-card">
        <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
        <div class="table-toolbar">
            <div class="table-toolbar-left">
                <!-- Integrated Search Bar (340px) -->
                <form method="GET" action="<?= BASE_URL ?>/admin/testimonials" class="m-0">
                    <?php if (!empty($current_limit)): ?>
                        <input type="hidden" name="limit" value="<?= htmlspecialchars((string)$current_limit) ?>">
                    <?php endif; ?>
                    <?php if (!empty($current_sort)): ?>
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                    <?php endif; ?>

                    <div class="search-bar-integrated">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search client, company, role, or review...">
                        <?php if (!empty($search_query)): ?>
                            <a href="<?= BASE_URL ?>/admin/testimonials" class="search-clear-btn" title="Clear Search">
                                <span class="material-symbols-outlined fs-16">close</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/testimonials" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                        <span class="material-symbols-outlined fs-14">close</span>
                        <span>Reset</span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="table-toolbar-right">
                <!-- Custom Brand Dropdown: Sort -->
                <div class="custom-dropdown" x-data="{
                    open: false,
                    current: '<?= $current_sort ?? 'id_desc' ?>',
                    label: '<?= match($current_sort ?? 'id_desc') { 'id_asc' => 'Oldest First', 'name_asc' => 'Client Name (A to Z)', 'name_desc' => 'Client Name (Z to A)', 'org_asc' => 'Organization (A to Z)', default => 'Newest First' } ?>'
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
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyTestimonialParam('sort', 'id_desc'); open = false;">
                            <span>Newest First</span>
                            <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_asc' }" @click="applyTestimonialParam('sort', 'id_asc'); open = false;">
                            <span>Oldest First</span>
                            <svg class="check-icon" x-show="current === 'id_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_asc' }" @click="applyTestimonialParam('sort', 'name_asc'); open = false;">
                            <span>Client Name (A to Z)</span>
                            <svg class="check-icon" x-show="current === 'name_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'name_desc' }" @click="applyTestimonialParam('sort', 'name_desc'); open = false;">
                            <span>Client Name (Z to A)</span>
                            <svg class="check-icon" x-show="current === 'name_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'org_asc' }" @click="applyTestimonialParam('sort', 'org_asc'); open = false;">
                            <span>Organization (A to Z)</span>
                            <svg class="check-icon" x-show="current === 'org_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="card-body-custom p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 65px;" class="text-center">#</th>
                            <th style="width: 28%;">Client & Organization</th>
                            <th style="width: 18%;">Designation / Role</th>
                            <th>Endorsement Statement</th>
                            <th class="text-end" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($testimonials)): ?>
                            <?php foreach ($testimonials as $testimonial):
                                $rawImg = ltrim(str_replace('../', '', $testimonial['image'] ?? ''), '/');
                                $isStockCartoon = empty($rawImg) || in_array(basename($rawImg), ['1682465155.png', '1089348657.png', '924472772.png', '1261654621.png']);
                                $hasRealPhoto = !$isStockCartoon && file_exists(ROOT_PATH . '/' . $rawImg);
                                $imgUrl = $hasRealPhoto ? BASE_URL . '/' . $rawImg : null;
                                
                                $nameParts = explode(' ', trim($testimonial['name'] ?? 'Client'));
                                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                                if (!$initials) $initials = 'C';
                                
                                $cleanQuote = trim(trim($testimonial['testimonial'] ?? ''), '"\'');
                            ?>
                                <tr>
                                    <!-- ID Badge -->
                                    <td class="text-center align-middle">
                                        <span class="badge bg-light text-muted border px-2 py-0-5 fw-600" style="font-size: 0.72rem; border-radius: 6px;">
                                            #<?= str_pad((string)$testimonial['id'], 2, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <!-- Client Details with Avatar -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center min-w-0">
                                            <?php if ($hasRealPhoto): ?>
                                                <img src="<?= $imgUrl ?>" 
                                                     alt="<?= htmlspecialchars($testimonial['name']) ?>" 
                                                     class="flex-shrink-0" 
                                                     style="width: 38px; height: 38px; border-radius: 10px; object-fit: cover; border: 1px solid #e2e8f0; margin-right: 14px;">
                                            <?php else: ?>
                                                <!-- Modern Custom SVG User Avatar Icon -->
                                                <div class="user-avatar-modern flex-shrink-0 d-flex align-items-center justify-content-center"
                                                     style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid #fed7aa; margin-right: 14px;">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="12" cy="7.5" r="4.25" fill="#f48221"/>
                                                        <path d="M4 19.5C4 16.0 7.5 13.2 12 13.2C16.5 13.2 20 16.0 20 19.5C20 20.3 19.3 21 18.5 21H5.5C4.7 21 4 20.3 4 19.5Z" fill="#ea580c"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div class="min-w-0">
                                                <div class="fw-700 text-dark fs-09 text-truncate mb-0-5" style="letter-spacing: -0.2px;">
                                                    <?= htmlspecialchars($testimonial['name']) ?>
                                                </div>
                                                <div class="text-muted text-truncate d-inline-flex align-items-center gap-1" style="font-size: 0.74rem;">
                                                    <span class="material-symbols-outlined fs-13 text-light">domain</span>
                                                    <span class="fw-500 text-slate"><?= htmlspecialchars($testimonial['organization']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role / Job Title -->
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-600" style="font-size: 0.74rem; border-radius: 6px;">
                                            <?= htmlspecialchars($testimonial['title'] ?? 'Partner') ?>
                                        </span>
                                    </td>

                                    <!-- Testimonial Quote -->
                                    <td class="align-middle">
                                        <div class="text-muted" style="font-size: 0.82rem; line-height: 1.55; color: #475569 !important;">
                                            <span class="text-orange fw-700">&ldquo;</span>
                                            <span><?= htmlspecialchars(substr($cleanQuote, 0, 130)) ?><?= strlen($cleanQuote) > 130 ? '...' : '' ?></span>
                                            <span class="text-orange fw-700">&rdquo;</span>
                                            <button type="button" 
                                                    class="btn btn-link p-0 text-orange fw-600 text-decoration-none d-inline-flex align-items-center gap-0-5 ms-1"
                                                    style="font-size: 0.75rem; vertical-align: baseline;"
                                                    @click="openPreview(
                                                        <?= htmlspecialchars(json_encode($testimonial['name'])) ?>,
                                                        <?= htmlspecialchars(json_encode($testimonial['organization'])) ?>,
                                                        <?= htmlspecialchars(json_encode($testimonial['title'])) ?>,
                                                        <?= htmlspecialchars(json_encode($cleanQuote)) ?>,
                                                        <?= htmlspecialchars(json_encode($imgUrl ?? '')) ?>,
                                                        <?= htmlspecialchars(json_encode($initials)) ?>,
                                                        <?= (int)$testimonial['id'] ?>
                                                    )">
                                                <span>Read Full</span>
                                                <span class="material-symbols-outlined" style="font-size: 13px;">open_in_new</span>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end align-middle">
                                        <div class="action-btns justify-content-end">
                                            <button type="button" 
                                                    class="btn-action preview" 
                                                    title="Quick Preview Endorsement" 
                                                    @click="openPreview(
                                                        <?= htmlspecialchars(json_encode($testimonial['name'])) ?>,
                                                        <?= htmlspecialchars(json_encode($testimonial['organization'])) ?>,
                                                        <?= htmlspecialchars(json_encode($testimonial['title'])) ?>,
                                                        <?= htmlspecialchars(json_encode($cleanQuote)) ?>,
                                                        <?= htmlspecialchars(json_encode($imgUrl ?? '')) ?>,
                                                        <?= htmlspecialchars(json_encode($initials)) ?>,
                                                        <?= (int)$testimonial['id'] ?>
                                                    )">
                                                <span class="material-symbols-outlined fs-15">visibility</span>
                                            </button>
                                            <a href="<?= BASE_URL ?>/admin/testimonials/edit/<?= $testimonial['id'] ?>" class="btn-action edit" title="Edit Testimonial">
                                                <span class="material-symbols-outlined fs-15">edit</span>
                                            </a>
                                            <button type="button" class="btn-action delete" onclick="deleteItem(<?= $testimonial['id'] ?>, 'testimonial')" title="Delete Testimonial">
                                                <span class="material-symbols-outlined fs-15">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <span class="material-symbols-outlined text-muted" style="font-size: 48px;">reviews</span>
                                        <p class="text-muted mt-2 mb-3">No testimonials match your criteria.</p>
                                        <?php if ($hasActiveFilters): ?>
                                            <a href="<?= BASE_URL ?>/admin/testimonials" class="btn btn-sm btn-outline-custom">Reset Search</a>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>/admin/testimonials/add" class="btn btn-sm btn-primary-custom">Add First Testimonial</a>
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
         TESTIMONIAL QUICK PREVIEW MODAL
         ==================================================== -->
    <div class="modal-custom" :class="{ 'show': previewModalOpen }" x-show="previewModalOpen" x-cloak>
        <div class="modal-content-custom" style="max-width: 620px;" @click.outside="closePreview()">
            <!-- Modal Header -->
            <div class="modal-header-custom d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">reviews</span>
                    <h5 class="modal-title m-0 fw-700 text-dark fs-095" style="font-family: 'Poppins', sans-serif;">Client Endorsement Preview</h5>
                    <span class="badge bg-light text-muted border px-2 py-0-5 fs-07" x-text="'#' + String(previewId || '').padStart(2, '0')"></span>
                </div>
                <button type="button" class="btn-close-modal border-0 bg-transparent text-muted p-1" @click="closePreview()" style="cursor: pointer;">
                    <span class="material-symbols-outlined fs-18">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4" style="max-height: 520px; overflow-y: auto;">
                <!-- Client Profile Header Card -->
                <div class="d-flex align-items-center p-3 rounded-2 mb-3" style="background: #f8fafc; border: 1px solid #edf2f7;">
                    <template x-if="previewImg">
                        <img :src="previewImg" :alt="previewName" style="width: 46px; height: 46px; border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0; margin-right: 14px;">
                    </template>
                    <template x-if="!previewImg">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid #fed7aa; margin-right: 14px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="7.5" r="4.25" fill="#f48221"/>
                                <path d="M4 19.5C4 16.0 7.5 13.2 12 13.2C16.5 13.2 20 16.0 20 19.5C20 20.3 19.3 21 18.5 21H5.5C4.7 21 4 20.3 4 19.5Z" fill="#ea580c"/>
                            </svg>
                        </div>
                    </template>
                    <div class="min-w-0 flex-grow-1">
                        <h6 class="fw-700 text-dark mb-0-5" style="font-size: 0.98rem;" x-text="previewName"></h6>
                        <div class="text-muted fs-075 d-flex align-items-center gap-1">
                            <span class="badge bg-white text-dark border px-2 py-0-5 fw-600" x-text="previewTitle"></span>
                            <span class="mx-1 text-light">&bull;</span>
                            <span class="fw-600 text-slate" x-text="previewOrg"></span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Quote -->
                <div class="p-3-5 rounded-2 position-relative" style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid var(--primary-orange); padding: 18px 20px;">
                    <div class="d-flex align-items-center gap-1 text-muted mb-2" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
                        <span class="material-symbols-outlined text-orange" style="font-size: 16px;">format_quote</span>
                        <span>Client Statement</span>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem; line-height: 1.65; color: #334155 !important; font-style: italic;" x-text="'&ldquo;' + previewText + '&rdquo;'"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-custom d-flex justify-content-between align-items-center p-3 px-4 border-top" style="border-color: #f1f5f9 !important; background: #fafafa;">
                <button type="button" class="btn btn-sm btn-light border px-3" @click="closePreview()" style="font-size: 0.8rem; border-radius: 50px !important;">
                    Close
                </button>
                <a :href="'<?= BASE_URL ?>/admin/testimonials/edit/' + previewId" class="btn btn-sm btn-primary-custom px-3 d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; border-radius: 50px !important;">
                    <span class="material-symbols-outlined fs-15">edit</span>
                    <span>Edit Testimonial</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function applyTestimonialParam(key, value) {
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
