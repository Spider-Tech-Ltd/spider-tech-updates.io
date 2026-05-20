<?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
<div class="pagination-wrapper mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination-custom">
            <li class="<?= ($pagination['current_page'] <= 1) ? 'disabled' : '' ?>">
                <a href="?page=<?= $pagination['current_page'] - 1 ?>" aria-label="Previous">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <li class="<?= ($i == $pagination['current_page']) ? 'active' : '' ?>">
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="<?= ($pagination['current_page'] >= $pagination['total_pages']) ? 'disabled' : '' ?>">
                <a href="?page=<?= $pagination['current_page'] + 1 ?>" aria-label="Next">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>
