<?php
if (isset($pagination)):
    $totalRecords = $pagination['total_records'] ?? 0;
    $currentPage = (int)($pagination['current_page'] ?? 1);
    $totalPages = (int)($pagination['total_pages'] ?? 1);
    $limit = (int)($pagination['limit'] ?? 6);
    if ($limit <= 0) $limit = 6;

    if ($totalRecords > 0) {
        $from = (($currentPage - 1) * $limit) + 1;
        $to = min($currentPage * $limit, $totalRecords);
    } else {
        $from = 0;
        $to = 0;
    }

    $queryParams = $_GET;
    unset($queryParams['page']);
    $queryStr = http_build_query($queryParams);
    $queryPrefix = $queryStr ? '&' . $queryStr : '';
?>
<div class="pagination-footer-wrapper d-flex flex-wrap justify-content-between align-items-center gap-3">
    <!-- Left: Summary Info -->
    <div class="pagination-summary-info">
        <?php if ($totalRecords > 0): ?>
            <span>Showing <strong class="text-dark"><?= $from ?></strong> &ndash; <strong class="text-dark"><?= $to ?></strong> of <strong class="text-dark"><?= $totalRecords ?></strong> records</span>
        <?php else: ?>
            <span>No records to display</span>
        <?php endif; ?>
    </div>

    <!-- Center: Pagination Controls -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination-custom mb-0">
            <!-- Previous Button -->
            <li class="<?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                <?php if ($currentPage <= 1): ?>
                    <a href="javascript:void(0)" class="text-muted" tabindex="-1" aria-disabled="true">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                <?php else: ?>
                    <a href="?page=<?= $currentPage - 1 ?><?= $queryPrefix ?>" aria-label="Previous">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                <?php endif; ?>
            </li>

            <!-- Page Number Logic with Ellipsis -->
            <?php
                $startPage = max(1, $currentPage - 2);
                $endPage = min($totalPages, $startPage + 4);
                if ($endPage - $startPage < 4) {
                    $startPage = max(1, $endPage - 4);
                }

                if ($startPage > 1): ?>
                    <li><a href="?page=1<?= $queryPrefix ?>">1</a></li>
                    <?php if ($startPage > 2): ?><li class="disabled"><span class="px-1 text-muted">&hellip;</span></li><?php endif; ?>
                <?php endif;

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?><?= $queryPrefix ?>"><?= $i ?></a>
                    </li>
                <?php endfor;

                if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?><li class="disabled"><span class="px-1 text-muted">&hellip;</span></li><?php endif; ?>
                    <li><a href="?page=<?= $totalPages ?><?= $queryPrefix ?>"><?= $totalPages ?></a></li>
                <?php endif; ?>

            <!-- Next Button -->
            <li class="<?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                <?php if ($currentPage >= $totalPages): ?>
                    <a href="javascript:void(0)" class="text-muted" tabindex="-1" aria-disabled="true">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php else: ?>
                    <a href="?page=<?= $currentPage + 1 ?><?= $queryPrefix ?>" aria-label="Next">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- Right: Custom Branded Page Size Dropdown -->
    <div class="custom-dropdown" x-data="{ open: false }" @click.outside="open = false">
        <button type="button" class="custom-dropdown-trigger" style="height: 34px; padding: 0 14px; font-size: 0.78rem;" @click="open = !open">
            <span class="d-flex align-items-center gap-1">
                <span class="text-muted">Rows per page:</span>
                <strong class="text-dark"><?= $limit ?></strong>
            </span>
            <span class="material-symbols-outlined dropdown-chevron" :class="{ 'rotate-180': open }" style="font-size: 16px;">expand_more</span>
        </button>
        <div class="custom-dropdown-menu" style="min-width: 145px; bottom: calc(100% + 5px); top: auto;" x-show="open" x-transition.opacity.duration.150ms x-cloak>
            <?php foreach ([6, 10, 25, 50] as $opt):
                $p = $queryParams;
                $p['limit'] = $opt;
                $p['page'] = 1;
                $url = '?' . http_build_query($p);
            ?>
                <a href="<?= $url ?>" class="custom-dropdown-item <?= ($limit == $opt) ? 'active' : '' ?>">
                    <span><?= $opt ?> records</span>
                    <?php if ($limit == $opt): ?><span class="material-symbols-outlined check-icon">check</span><?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
