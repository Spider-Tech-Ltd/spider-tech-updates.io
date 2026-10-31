<!-- Insights & Blog Management — Spider Tech Admin -->
<?php
$allList = $blogs ?? [];
$totalCount = $total_blogs_count ?? count($allList);
?>

<!-- Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="dashboard-title mb-0">Insights & Blog</h1>
                <span class="title-badge-count"><?= $totalCount ?> total</span>
            </div>
            <p class="dashboard-subtitle">Manage technical publications, research case studies, and corporate news updates.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/admin/blog/add" class="btn-primary-custom">
                <span class="material-symbols-outlined fs-18">add_circle</span>
                <span>New Post</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="admin-card" x-data="blogTable()">
    <!-- Table Controls Bar: Unified Search & Custom Brand Dropdowns -->
    <div class="table-toolbar">
        <div class="table-toolbar-left">
            <!-- Integrated Search Bar -->
            <form method="GET" action="<?= BASE_URL ?>/admin/blog" class="m-0">
                <?php if (!empty($current_limit)): ?>
                    <input type="hidden" name="limit" value="<?= htmlspecialchars($current_limit) ?>">
                <?php endif; ?>
                <?php if (!empty($current_sort)): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                <?php endif; ?>
                <?php if (!empty($current_category) && $current_category !== 'all'): ?>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($current_category) ?>">
                <?php endif; ?>
                <?php if (!empty($current_status) && $current_status !== 'all'): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($current_status) ?>">
                <?php endif; ?>

                <div class="search-bar-integrated">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search articles...">
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= BASE_URL ?>/admin/blog" class="search-clear-btn" title="Clear Search">
                            <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (!empty($search_query) || (isset($current_category) && $current_category !== 'all') || (isset($current_status) && $current_status !== 'all')): ?>
                <a href="<?= BASE_URL ?>/admin/blog" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
                    <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="table-toolbar-right">
            <!-- Custom Brand Dropdown: Category Filter -->
            <?php
                $activeCategoryLabel = 'All Categories';
                if (!empty($current_category) && $current_category !== 'all' && !empty($categories)) {
                    foreach ($categories as $cat) {
                        if ((string)$cat['id'] === (string)$current_category || (string)$cat['slug'] === (string)$current_category) {
                            $activeCategoryLabel = $cat['name'];
                            break;
                        }
                    }
                }
            ?>
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_category ?? 'all' ?>',
                label: '<?= htmlspecialchars($activeCategoryLabel) ?>'
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
                <div class="custom-dropdown-menu" style="min-width: 210px; max-height: 280px; overflow-y: auto;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyBlogParam('category', 'all'); open = false;">
                        <span>All Categories</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <button type="button" class="custom-dropdown-item" :class="{ 'active': current == '<?= $cat['id'] ?>' || current == '<?= $cat['slug'] ?>' }" @click="applyBlogParam('category', '<?= $cat['id'] ?>'); open = false;">
                                <span class="text-truncate" style="max-width: 165px;"><?= htmlspecialchars($cat['name']) ?></span>
                                <svg class="check-icon" x-show="current == '<?= $cat['id'] ?>' || current == '<?= $cat['slug'] ?>'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Status Filter -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_status ?? 'all' ?>',
                label: '<?= match($current_status ?? 'all') { 'published' => 'Published', 'draft' => 'Draft', default => 'All Statuses' } ?>'
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
                <div class="custom-dropdown-menu" style="min-width: 180px;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'all' }" @click="applyBlogParam('status', 'all'); open = false;">
                        <span>All Statuses</span>
                        <svg class="check-icon" x-show="current === 'all'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'published' }" @click="applyBlogParam('status', 'published'); open = false;">
                        <span>Published</span>
                        <svg class="check-icon" x-show="current === 'published'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'draft' }" @click="applyBlogParam('status', 'draft'); open = false;">
                        <span>Draft</span>
                        <svg class="check-icon" x-show="current === 'draft'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Custom Brand Dropdown: Sort -->
            <div class="custom-dropdown" x-data="{
                open: false,
                current: '<?= $current_sort ?? 'date_desc' ?>',
                label: '<?= match($current_sort ?? 'date_desc') { 'date_asc' => 'Oldest First', 'title_asc' => 'Title (A to Z)', 'title_desc' => 'Title (Z to A)', 'status_pub' => 'Published First', 'status_draft' => 'Drafts First', default => 'Newest First' } ?>'
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
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'date_desc' }" @click="applyBlogParam('sort', 'date_desc'); open = false;">
                        <span>Newest First</span>
                        <svg class="check-icon" x-show="current === 'date_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'date_asc' }" @click="applyBlogParam('sort', 'date_asc'); open = false;">
                        <span>Oldest First</span>
                        <svg class="check-icon" x-show="current === 'date_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'title_asc' }" @click="applyBlogParam('sort', 'title_asc'); open = false;">
                        <span>Title (A &rarr; Z)</span>
                        <svg class="check-icon" x-show="current === 'title_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'title_desc' }" @click="applyBlogParam('sort', 'title_desc'); open = false;">
                        <span>Title (Z &rarr; A)</span>
                        <svg class="check-icon" x-show="current === 'title_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'status_pub' }" @click="applyBlogParam('sort', 'status_pub'); open = false;">
                        <span>Published First</span>
                        <svg class="check-icon" x-show="current === 'status_pub'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
                    <th style="width: 38%;">Article</th>
                    <th style="width: 34%;">Summary</th>
                    <th style="width: 105px;" class="text-center">Status</th>
                    <th style="width: 110px;" class="text-center">Date</th>
                    <th style="width: 140px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $blog):
                        $cleanTitle = htmlspecialchars($blog['title'] ?? 'Untitled Article');
                        $displayTitle = mb_strimwidth($cleanTitle, 0, 44, '...');
                        $cleanSummary = htmlspecialchars(strip_tags($blog['summary'] ?? $blog['content'] ?? ''));
                        $displaySummary = !empty($cleanSummary) ? mb_strimwidth($cleanSummary, 0, 68, '...') : 'No summary provided';
                        $categoryName = htmlspecialchars($blog['category_name'] ?? $blog['name'] ?? 'Insights');
                        $isPublished = strtolower((string)($blog['status'] ?? '')) === 'published';
                        $createdDate = !empty($blog['created_at']) ? date('M j, Y', strtotime($blog['created_at'])) : '—';
                        $idPad = str_pad((string)($blog['id'] ?? '1'), 2, '0', STR_PAD_LEFT);

                        // Robust thumbnail image resolution matching public website
                        $rawPic = trim($blog['image_path'] ?? '');
                        $hasPic = false;
                        $finalPic = '';
                        if ($rawPic !== '') {
                            if (preg_match('#^https?://#i', $rawPic)) {
                                $finalPic = $rawPic;
                                $hasPic = true;
                            } else {
                                $cleanPath = ltrim(preg_replace('#^(\.\./)+#', '', $rawPic), './');
                                if (file_exists(ROOT_PATH . '/' . $cleanPath) && !is_dir(ROOT_PATH . '/' . $cleanPath)) {
                                    $finalPic = BASE_URL . '/' . $cleanPath;
                                    $hasPic = true;
                                } elseif (file_exists(ROOT_PATH . '/images/blog/' . basename($cleanPath)) && !is_dir(ROOT_PATH . '/images/blog/' . basename($cleanPath))) {
                                    $finalPic = BASE_URL . '/images/blog/' . basename($cleanPath);
                                    $hasPic = true;
                                } elseif (file_exists(ROOT_PATH . '/img/' . basename($cleanPath)) && !is_dir(ROOT_PATH . '/img/' . basename($cleanPath))) {
                                    $finalPic = BASE_URL . '/img/' . basename($cleanPath);
                                    $hasPic = true;
                                } else {
                                    $finalPic = BASE_URL . '/' . $cleanPath;
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

                        <!-- Thumbnail & Article Title (Truncated, Bounded) -->
                        <td>
                            <div class="d-flex align-items-center" style="gap: 12px; min-width: 0; max-width: 100%;">
                                <!-- Thumbnail with SVG Fallback -->
                                <div class="blog-thumb-container" style="width: 54px; height: 40px; flex-shrink: 0;">
                                    <?php if ($hasPic): ?>
                                        <img src="<?= htmlspecialchars($finalPic) ?>"
                                             alt="<?= $cleanTitle ?>"
                                             class="blog-thumb-img"
                                             loading="lazy"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <?php endif; ?>
                                    <div class="blog-thumb-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true" title="No thumbnail available">
                                        <svg width="22" height="22" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="10" width="52" height="44" rx="8" stroke="#94a3b8" stroke-width="3" stroke-dasharray="4 3"/>
                                            <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Title and Category Badge (Strictly Bounded) -->
                                <div class="min-w-0 flex-grow-1" style="overflow: hidden;">
                                    <a href="javascript:void(0)" class="blog-title-text" title="<?= $cleanTitle ?>" @click="showBlogModal(<?= htmlspecialchars(json_encode(array_merge($blog, ['resolved_pic' => $finalPic, 'has_pic' => $hasPic, 'formatted_date' => $createdDate]))) ?>)">
                                        <?= $displayTitle ?>
                                    </a>
                                    <div class="mt-1">
                                        <span class="blog-category-badge text-truncate d-inline-block" style="max-width: 100%;">
                                            <span class="material-symbols-outlined" style="font-size: 11px;">label</span>
                                            <span><?= $categoryName ?></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Summary (Truncated, Bounded) -->
                        <td>
                            <span class="blog-summary-cell" title="<?= $cleanSummary ?>">
                                <?= $displaySummary ?>
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            <?php if ($isPublished): ?>
                                <span class="badge-status-published">
                                    <span class="status-dot published"></span>
                                    <span>Published</span>
                                </span>
                            <?php else: ?>
                                <span class="badge-status-draft">
                                    <span class="status-dot draft"></span>
                                    <span>Draft</span>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Date -->
                        <td class="text-center">
                            <span class="blog-date-chip">
                                <span class="material-symbols-outlined" style="font-size: 13px;">calendar_today</span>
                                <span><?= $createdDate ?></span>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="action-btns">
                                <button type="button" class="btn-action" title="Quick Preview" @click="showBlogModal(<?= htmlspecialchars(json_encode(array_merge($blog, ['resolved_pic' => $finalPic, 'has_pic' => $hasPic, 'formatted_date' => $createdDate]))) ?>)">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <a href="<?= BASE_URL ?>/admin/blog/edit/<?= $blog['uuid'] ?>" class="btn-action edit" title="Edit Article">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <button type="button" class="btn-action delete" title="Delete Article" onclick="deleteItem('<?= $blog['uuid'] ?>', 'blog')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <span class="material-symbols-outlined text-muted mb-2" style="font-size: 40px;">feed</span>
                                <h5 class="fw-bold mb-1">No Blog Posts Found</h5>
                                <p class="text-muted small mb-3">
                                    <?= !empty($search_query) ? 'No articles matched "' . htmlspecialchars($search_query) . '".' : 'There are no blog posts matching your current filter criteria.' ?>
                                </p>
                                <?php if (!empty($search_query) || (isset($current_category) && $current_category !== 'all') || (isset($current_status) && $current_status !== 'all')): ?>
                                    <a href="<?= BASE_URL ?>/admin/blog" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined">restart_alt</span>
                                        <span>Reset Filters</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/admin/blog/add" class="btn-primary-custom d-inline-flex">
                                        <span class="material-symbols-outlined fs-18">add_circle</span>
                                        <span>Create First Post</span>
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

    <!-- Blog Article Detail Quick Preview Modal -->
    <div class="modal fade" id="blogPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-bottom p-4" style="background: #f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="blog-thumb-container" style="width: 50px; height: 38px;">
                            <template x-if="activeBlog.has_pic">
                                <img :src="activeBlog.resolved_pic" :alt="activeBlog.title" class="blog-thumb-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            </template>
                            <div class="blog-thumb-fallback" :style="{ display: activeBlog.has_pic ? 'none' : 'flex' }">
                                <svg width="20" height="20" viewBox="0 0 64 64" fill="none">
                                    <rect x="6" y="10" width="52" height="44" rx="8" stroke="#94a3b8" stroke-width="3" stroke-dasharray="4 3"/>
                                    <path d="M18 24H46M18 34H36" stroke="#f48221" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.8px;">Article #<span x-text="activeBlog.id || '1'"></span></span>
                                <span class="blog-category-badge" x-text="activeBlog.category_name || 'Insights'"></span>
                                <template x-if="activeBlog.status === 'published'">
                                    <span class="badge-status-published" style="padding: 2px 7px; font-size: 0.68rem;">
                                        <span class="status-dot published"></span>
                                        <span>Published</span>
                                    </span>
                                </template>
                                <template x-if="activeBlog.status !== 'published'">
                                    <span class="badge-status-draft" style="padding: 2px 7px; font-size: 0.68rem;">
                                        <span class="status-dot draft"></span>
                                        <span>Draft</span>
                                    </span>
                                </template>
                            </div>
                            <h4 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;" x-text="activeBlog.title"></h4>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Article Category</span>
                                <span class="fw-bold fs-09" style="font-family: 'Poppins', sans-serif;" x-text="activeBlog.category_name || 'Technical Insights'"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3">
                                <span class="text-muted d-block small mb-1">Date Created</span>
                                <span class="fw-bold fs-09" style="font-family: 'Poppins', sans-serif;" x-text="activeBlog.formatted_date || activeBlog.created_at || '—'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Full Preview Photo if Available -->
                    <template x-if="activeBlog.has_pic">
                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Cover Photo</label>
                            <div class="rounded-3 overflow-hidden border" style="max-height: 250px; background: #0f172a;">
                                <img :src="activeBlog.resolved_pic" :alt="activeBlog.title" style="width: 100%; height: 230px; object-fit: cover;">
                            </div>
                        </div>
                    </template>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Summary / Meta Description</label>
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.88rem; line-height: 1.6;" x-text="activeBlog.summary || 'No summary provided.'"></div>
                    </div>

                    <template x-if="activeBlog.content">
                        <div>
                            <label class="form-label text-muted small text-uppercase fw-bold">Article Content Excerpt</label>
                            <div class="p-3 rounded-3 bg-white" style="border: 1px solid #e2e8f0; max-height: 200px; overflow-y: auto; font-size: 0.85rem;" x-html="activeBlog.content"></div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer border-top p-3 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn-admin-cancel px-4" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex align-items-center gap-2">
                        <template x-if="activeBlog.slug">
                            <a :href="'<?= BASE_URL ?>/blog/' + activeBlog.slug" target="_blank" class="btn btn-sm btn-pill-cancel px-3">
                                <span class="material-symbols-outlined" style="font-size: 15px;">open_in_new</span>
                                <span>Public Article</span>
                            </a>
                        </template>
                        <a :href="'<?= BASE_URL ?>/admin/blog/edit/' + activeBlog.uuid" class="btn-primary-custom px-4">
                            <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                            <span>Edit Article</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function blogTable() {
    return {
        activeBlog: {},
        showBlogModal(blog) {
            this.activeBlog = blog;
            const modalEl = document.getElementById('blogPreviewModal');
            if (modalEl) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                } else if (typeof $ !== 'undefined') {
                    $(modalEl).modal('show');
                }
            }
        }
    };
}

function applyBlogParam(key, value) {
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
