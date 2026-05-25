<?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
<div class="pagination-wrapper mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination-custom">
            <?php
                $queryParams = $_GET;
                unset($queryParams['page']);
                $queryStr = http_build_query($queryParams);
                $queryStr = $queryStr ? '&' . $queryStr : '';
            ?>
            <li class="<?= ($pagination['current_page'] <= 1) ? 'disabled' : '' ?>">
                <a href="?page=<?= $pagination['current_page'] - 1 ?><?= $queryStr ?>" aria-label="Previous">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <li class="<?= ($i == $pagination['current_page']) ? 'active' : '' ?>">
                    <a href="?page=<?= $i ?><?= $queryStr ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="<?= ($pagination['current_page'] >= $pagination['total_pages']) ? 'disabled' : '' ?>">
                <a href="?page=<?= $pagination['current_page'] + 1 ?><?= $queryStr ?>" aria-label="Next">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>
