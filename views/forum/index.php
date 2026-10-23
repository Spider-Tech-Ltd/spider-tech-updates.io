<?php
/**
 * Forum Index View
 */
?>
<!-- Google Fonts for Forum styling & Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-index.css" />

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
