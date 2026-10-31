<!-- Frequently Asked Questions — Spider Tech Admin Operations Console -->
<?php
$allList = $faqs ?? [];
$totalCount = $pagination['total_records'] ?? count($allList);
$hasActiveFilters = (!empty($search_query) || ($current_sort ?? 'id_desc') !== 'id_desc');
?>

<div x-data="{
    previewModalOpen: false,
    previewQuestion: '',
    previewAnswer: '',
    previewId: null,
    openPreview(q, a, id) {
        this.previewQuestion = q;
        this.previewAnswer = a;
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
                    <h1 class="dashboard-title mb-0">Frequently Asked Questions</h1>
                    <span class="title-badge-count"><?= (int)$totalCount ?> total</span>
                </div>
                <p class="dashboard-subtitle">Curate client support questions, knowledge base entries, and self-service documentation.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/faq" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" style="border-radius: 50px !important;">
                        <span class="material-symbols-outlined fs-14">filter_alt_off</span>
                        <span>Reset</span>
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/admin/faq/add" class="btn-primary-custom">
                    <span class="material-symbols-outlined fs-18">add_circle</span>
                    <span>Add FAQ</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ====================================================
         KPI SUMMARY CARDS (Balanced, Refined Typography)
         ==================================================== -->
    <div class="apps-stats-grid mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Total Questions</span>
                <span class="stat-icon bg-soft-blue text-blue">
                    <span class="material-symbols-outlined">quiz</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;"><?= number_format($stats['total_faqs'] ?? $totalCount) ?></div>
            <div class="stat-desc">Published support entries</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Average Detail</span>
                <span class="stat-icon bg-soft-orange text-orange">
                    <span class="material-symbols-outlined">menu_book</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;">
                <?= number_format($stats['avg_words'] ?? 0) ?>
                <span class="text-muted fw-500" style="font-size: 0.8rem;">words</span>
            </div>
            <div class="stat-desc">~<?= ceil(($stats['avg_words'] ?? 0) / 130) ?> min avg. reading depth</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Portal Coverage</span>
                <span class="stat-icon bg-soft-green text-green">
                    <span class="material-symbols-outlined">support_agent</span>
                </span>
            </div>
            <div class="stat-value text-success d-inline-flex align-items-center gap-1" style="font-size: 1.2rem;">
                <span class="material-symbols-outlined fs-18">check_circle</span>
                <span>Active 24/7</span>
            </div>
            <div class="stat-desc">Public self-service support</div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="stat-label">Knowledge Sync</span>
                <span class="stat-icon bg-soft-purple text-purple">
                    <span class="material-symbols-outlined">sync</span>
                </span>
            </div>
            <div class="stat-value" style="font-size: 1.35rem;">100%</div>
            <div class="stat-desc">Instant client web portal sync</div>
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
                <form method="GET" action="<?= BASE_URL ?>/admin/faq" class="m-0">
                    <?php if (!empty($current_limit)): ?>
                        <input type="hidden" name="limit" value="<?= htmlspecialchars((string)$current_limit) ?>">
                    <?php endif; ?>
                    <?php if (!empty($current_sort)): ?>
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($current_sort) ?>">
                    <?php endif; ?>

                    <div class="search-bar-integrated">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="search-input-clean" placeholder="Search questions or answer text...">
                        <?php if (!empty($search_query)): ?>
                            <a href="<?= BASE_URL ?>/admin/faq" class="search-clear-btn" title="Clear Search">
                                <span class="material-symbols-outlined fs-16">close</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <?php if ($hasActiveFilters): ?>
                    <a href="<?= BASE_URL ?>/admin/faq" class="btn-pill-cancel px-3 py-1" style="font-size: 0.78rem;" title="Reset Filters">
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
                    label: '<?= match($current_sort ?? 'id_desc') { 'id_asc' => 'Oldest First', 'question_asc' => 'Question (A to Z)', 'question_desc' => 'Question (Z to A)', default => 'Newest First' } ?>'
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
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_desc' }" @click="applyFaqParam('sort', 'id_desc'); open = false;">
                            <span>Newest First</span>
                            <svg class="check-icon" x-show="current === 'id_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'id_asc' }" @click="applyFaqParam('sort', 'id_asc'); open = false;">
                            <span>Oldest First</span>
                            <svg class="check-icon" x-show="current === 'id_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'question_asc' }" @click="applyFaqParam('sort', 'question_asc'); open = false;">
                            <span>Question (A to Z)</span>
                            <svg class="check-icon" x-show="current === 'question_asc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="custom-dropdown-item" :class="{ 'active': current === 'question_desc' }" @click="applyFaqParam('sort', 'question_desc'); open = false;">
                            <span>Question (Z to A)</span>
                            <svg class="check-icon" x-show="current === 'question_desc'" width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2.5 7.5L5.5 10.5L11.5 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
                            <th style="width: 42%;">Question & Knowledge Topic</th>
                            <th>Answer Preview</th>
                            <th class="text-end" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($faqs)): ?>
                            <?php foreach ($faqs as $faq):
                                $rawAnswer = strip_tags($faq['faq_answer'] ?? '');
                                $wordCount = str_word_count($rawAnswer);
                                $readMin = max(1, (int)ceil($wordCount / 130));
                            ?>
                                <tr>
                                    <!-- ID Badge -->
                                    <td class="text-center align-middle">
                                        <span class="badge bg-light text-muted border px-2 py-0-5 fw-600" style="font-size: 0.72rem; border-radius: 6px;">
                                            #<?= str_pad((string)$faq['faq_id'], 2, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <!-- Question Details -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-start gap-2">
                                            <span class="material-symbols-outlined text-orange fs-16 flex-shrink-0" style="margin-top: 2px;">help_outline</span>
                                            <div class="min-w-0">
                                                <div class="fw-600 text-dark mb-1" style="font-size: 0.88rem; line-height: 1.45;">
                                                    <?= htmlspecialchars($faq['faq_question']) ?>
                                                </div>
                                                <div class="d-inline-flex align-items-center gap-2 text-muted" style="font-size: 0.72rem;">
                                                    <span class="badge bg-light text-muted border px-2 py-0-5" style="border-radius: 4px; font-weight: 500;">
                                                        <?= number_format($wordCount) ?> words &bull; ~<?= $readMin ?> min read
                                                    </span>
                                                    <span class="text-success fw-500 d-inline-flex align-items-center gap-1">
                                                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                                        <span>Active</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Answer Preview with inline modal preview trigger -->
                                    <td class="align-middle">
                                        <div class="text-muted" style="font-size: 0.82rem; line-height: 1.55; color: #475569 !important;">
                                            <span><?= htmlspecialchars(substr($rawAnswer, 0, 140)) ?><?= strlen($rawAnswer) > 140 ? '...' : '' ?></span>
                                            <button type="button" 
                                                    class="btn btn-link p-0 text-orange fw-600 text-decoration-none d-inline-flex align-items-center gap-0-5 ms-1"
                                                    style="font-size: 0.75rem; vertical-align: baseline;"
                                                    @click="openPreview(<?= htmlspecialchars(json_encode($faq['faq_question'])) ?>, <?= htmlspecialchars(json_encode($faq['faq_answer'])) ?>, <?= (int)$faq['faq_id'] ?>)">
                                                <span>Preview</span>
                                                <span class="material-symbols-outlined" style="font-size: 13px;">open_in_new</span>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end align-middle">
                                        <div class="action-btns justify-content-end">
                                            <button type="button" 
                                                    class="btn-action preview" 
                                                    title="Quick Preview Full Answer" 
                                                    @click="openPreview(<?= htmlspecialchars(json_encode($faq['faq_question'])) ?>, <?= htmlspecialchars(json_encode($faq['faq_answer'])) ?>, <?= (int)$faq['faq_id'] ?>)">
                                                <span class="material-symbols-outlined fs-15">visibility</span>
                                            </button>
                                            <a href="<?= BASE_URL ?>/admin/faq/edit/<?= $faq['faq_id'] ?>" class="btn-action edit" title="Edit FAQ">
                                                <span class="material-symbols-outlined fs-15">edit</span>
                                            </a>
                                            <button type="button" class="btn-action delete" onclick="deleteItem(<?= $faq['faq_id'] ?>, 'faq')" title="Delete FAQ">
                                                <span class="material-symbols-outlined fs-15">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <span class="material-symbols-outlined text-muted" style="font-size: 48px;">quiz</span>
                                        <p class="text-muted mt-2 mb-3">No frequently asked questions match your criteria.</p>
                                        <?php if ($hasActiveFilters): ?>
                                            <a href="<?= BASE_URL ?>/admin/faq" class="btn btn-sm btn-outline-custom">Reset Search</a>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>/admin/faq/add" class="btn btn-sm btn-primary-custom">Add First FAQ</a>
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
         FAQ QUICK PREVIEW MODAL
         ==================================================== -->
    <div class="modal-custom" :class="{ 'show': previewModalOpen }" x-show="previewModalOpen" x-cloak>
        <div class="modal-content-custom" style="max-width: 650px;" @click.outside="closePreview()">
            <!-- Modal Header -->
            <div class="modal-header-custom d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-orange fs-20">help</span>
                    <h5 class="modal-title m-0 fw-700 text-dark fs-095" style="font-family: 'Poppins', sans-serif;">Knowledge Base Preview</h5>
                    <span class="badge bg-light text-muted border px-2 py-0-5 fs-07" x-text="'#' + String(previewId || '').padStart(2, '0')"></span>
                </div>
                <button type="button" class="btn-close-modal border-0 bg-transparent text-muted p-1" @click="closePreview()" style="cursor: pointer;">
                    <span class="material-symbols-outlined fs-18">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4" style="max-height: 520px; overflow-y: auto;">
                <!-- Question Heading -->
                <div class="mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <span class="text-muted fs-07 fw-700 text-uppercase d-block mb-1" style="letter-spacing: 0.5px;">Question</span>
                    <h5 class="fw-700 text-dark mb-0 fs-105" x-text="previewQuestion" style="line-height: 1.4;"></h5>
                </div>

                <!-- Answer Content -->
                <div>
                    <span class="text-muted fs-07 fw-700 text-uppercase d-block mb-2" style="letter-spacing: 0.5px;">Published Answer</span>
                    <div class="p-3 rounded-2" style="background: #f8fafc; border: 1px solid #edf2f7; font-size: 0.88rem; line-height: 1.65; color: #334155;" x-html="previewAnswer"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-custom d-flex justify-content-between align-items-center p-3 px-4 border-top" style="border-color: #f1f5f9 !important; background: #fafafa;">
                <button type="button" class="btn btn-sm btn-light border px-3" @click="closePreview()" style="font-size: 0.8rem; border-radius: 50px !important;">
                    Close
                </button>
                <a :href="'<?= BASE_URL ?>/admin/faq/edit/' + previewId" class="btn btn-sm btn-primary-custom px-3 d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; border-radius: 50px !important;">
                    <span class="material-symbols-outlined fs-15">edit</span>
                    <span>Edit FAQ</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function applyFaqParam(key, value) {
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
