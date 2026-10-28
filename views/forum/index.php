<?php
/**
 * Forum Index View
 */
?>




<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-index.css?v=<?= filemtime(ROOT_PATH . '/css/forum-index.css') ?>" />

<!-- Inject Forum Hero Component -->
<?php include ROOT_PATH . '/views/forum/includes/hero.php'; ?>

<!-- Inject Forum Categories Grid Component -->
<?php include ROOT_PATH . '/views/forum/includes/categories.php'; ?>

<!-- Filter Bar -->
<?php include ROOT_PATH . '/views/forum/includes/feed-filter-bar.php'; ?>

<!-- Main Content Section: Feed + Sidebar -->
<section class="forum-main-content py-5">
    <div class="container">
        <div class="row">
            <!-- Left Column: Discussion Feed -->
            <div class="col-lg-8">
                <?php include ROOT_PATH . '/views/forum/includes/feed.php'; ?>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="col-lg-4">
                <?php include ROOT_PATH . '/views/forum/includes/sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>
