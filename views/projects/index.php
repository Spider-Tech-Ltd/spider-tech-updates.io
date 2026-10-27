<link rel="stylesheet" href="<?= BASE_URL ?>/css/projects.css?v=<?= filemtime(ROOT_PATH . '/css/projects.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Project <span>Showcase</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Projects
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Projects Section ====== -->
<?php
if (!function_exists('truncateProjectDescWordAware')) {
    function truncateProjectDescWordAware($text, $limit = 112) {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags(stripslashes($text))));
        if ($text === '' || mb_strlen($text) <= $limit) {
            return $text;
        }
        $truncated = mb_substr($text, 0, $limit);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }
        return rtrim($truncated, ".,;:- ") . '...';
    }
}

$allProjects = is_array($projects) ? array_values($projects) : [];
$initialProjects = array_slice($allProjects, 0, 6);
$extraProjects = array_slice($allProjects, 6);
$extraProjectRows = array_chunk($extraProjects, 3);
$totalExtraRows = count($extraProjectRows);
?>
<section
    class="section-padding projects-page-section"
    x-data="{
        visibleExtraRows: 0,
        totalExtraRows: <?= (int) $totalExtraRows ?>,
        toggleProjectRows() {
            if (this.visibleExtraRows < this.totalExtraRows) {
                this.visibleExtraRows++;
            } else {
                this.visibleExtraRows = 0;
            }
        }
    }">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Innovation in Action</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>
                <br>
                <h2 class="section-title">Building the <span>Future</span></h2>
                <p class="section-subtitle">Explore our portfolio of software platforms, enterprise systems, and digital infrastructure projects across Africa.</p>
            </div>
        </div>

        <!-- Default 6 Projects (2 Rows of 3 Cards) -->
        <div class="row g-4">
            <?php foreach ($initialProjects as $project):
                $rawPic = trim($project['project_pic'] ?? '');
                $hasPic = false;
                $finalPic = '';
                if ($rawPic !== '') {
                    if (preg_match('#^https?://#i', $rawPic)) {
                        $finalPic = $rawPic;
                        $hasPic = true;
                    } else {
                        $relPath = ltrim($rawPic, './');
                        if (file_exists(ROOT_PATH . '/' . $relPath)) {
                            $finalPic = BASE_URL . '/' . $relPath;
                            $hasPic = true;
                        }
                    }
                }
                $pTitle = trim(stripslashes($project['project_name'] ?? 'Untitled Project'));
                $pCategory = trim(stripslashes($project['service_name'] ?? 'Technology Solution'));
                $pDesc = truncateProjectDescWordAware($project['project_description'] ?? '', 112);
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="project-card">
                    <div class="project-img-wrap">
                        <span class="project-category-tag"><?= htmlspecialchars($pCategory); ?></span>
                        <?php if ($hasPic): ?>
                            <img src="<?= htmlspecialchars($finalPic) ?>"
                                 alt="<?= htmlspecialchars($pTitle); ?>"
                                 loading="lazy"
                                 decoding="async"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <?php endif; ?>
                        <div class="project-img-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true">
                            <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="2.5"/>
                                <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="fallback-label">Thumbnail Unavailable</span>
                        </div>
                    </div>
                    <div class="project-body">
                        <h3 class="project-title" title="<?= htmlspecialchars($pTitle); ?>"><?= htmlspecialchars($pTitle); ?></h3>
                        <div class="project-desc"><?= htmlspecialchars($pDesc); ?></div>
                        <a href="<?= BASE_URL ?>/projects/detail?id=<?= (int) $project['project_id']; ?>"
                           class="project-link"
                           aria-label="View case study for <?= htmlspecialchars($pTitle); ?>">
                            <span>View Case Study</span>
                            <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($extraProjectRows)): ?>
            <!-- Progressive Row-by-Row Reveal (3 Cards per Row) -->
            <?php foreach ($extraProjectRows as $rowIdx => $rowProjects):
                $rowNumber = $rowIdx + 1;
            ?>
            <div class="projects-extra-collapse" x-show="visibleExtraRows >= <?= (int) $rowNumber ?>" x-collapse.duration.450ms x-cloak>
                <div class="row g-4 projects-extra-row" :class="{ 'is-revealed': visibleExtraRows >= <?= (int) $rowNumber ?> }">
                    <?php foreach ($rowProjects as $cardIdx => $project):
                        $rawPic = trim($project['project_pic'] ?? '');
                        $hasPic = false;
                        $finalPic = '';
                        if ($rawPic !== '') {
                            if (preg_match('#^https?://#i', $rawPic)) {
                                $finalPic = $rawPic;
                                $hasPic = true;
                            } else {
                                $relPath = ltrim($rawPic, './');
                                if (file_exists(ROOT_PATH . '/' . $relPath)) {
                                    $finalPic = BASE_URL . '/' . $relPath;
                                    $hasPic = true;
                                }
                            }
                        }
                        $pTitle = trim(stripslashes($project['project_name'] ?? 'Untitled Project'));
                        $pCategory = trim(stripslashes($project['service_name'] ?? 'Technology Solution'));
                        $pDesc = truncateProjectDescWordAware($project['project_description'] ?? '', 112);
                        $delayMs = ($cardIdx + 1) * 75;
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4 project-extra-col" style="--stagger-delay: <?= (int) $delayMs ?>ms;">
                        <div class="project-card">
                            <div class="project-img-wrap">
                                <span class="project-category-tag"><?= htmlspecialchars($pCategory); ?></span>
                                <?php if ($hasPic): ?>
                                    <img src="<?= htmlspecialchars($finalPic) ?>"
                                         alt="<?= htmlspecialchars($pTitle); ?>"
                                         loading="lazy"
                                         decoding="async"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <?php endif; ?>
                                <div class="project-img-fallback" style="display: <?= $hasPic ? 'none' : 'flex' ?>;" aria-hidden="true">
                                    <svg class="fallback-svg-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="6" y="10" width="52" height="44" rx="6" stroke="currentColor" stroke-width="2.5" stroke-dasharray="4 3"/>
                                        <circle cx="22" cy="24" r="4.5" stroke="#f48221" stroke-width="2.5"/>
                                        <path d="M10 46L23 33C24.5 31.5 26.8 31.5 28.3 33L38 42.5L44.5 36C46 34.5 48.3 34.5 49.8 36L56 42.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="fallback-label">Thumbnail Unavailable</span>
                                </div>
                            </div>
                            <div class="project-body">
                                <h3 class="project-title" title="<?= htmlspecialchars($pTitle); ?>"><?= htmlspecialchars($pTitle); ?></h3>
                                <div class="project-desc"><?= htmlspecialchars($pDesc); ?></div>
                                <a href="<?= BASE_URL ?>/projects/detail?id=<?= (int) $project['project_id']; ?>"
                                   class="project-link"
                                   aria-label="View case study for <?= htmlspecialchars($pTitle); ?>">
                                    <span>View Case Study</span>
                                    <span class="material-symbols-outlined arrow-icon">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Show More / Show Less Action -->
            <div class="projects-more-actions">
                <button
                    type="button"
                    class="projects-show-more-btn"
                    @click="toggleProjectRows()"
                    :aria-expanded="(visibleExtraRows >= totalExtraRows).toString()">
                    <span x-text="visibleExtraRows >= totalExtraRows ? 'Show Less' : 'Show More'">Show More</span>
                    <span class="material-symbols-outlined toggle-chevron" :class="{ 'is-rotated': visibleExtraRows >= totalExtraRows }">expand_more</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Bottom Project Inquiry Banner -->
        <div class="premium-cta">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 mb-3 mb-lg-0 text-lg-left text-center">
                    <h2 class="premium-cta-title">Have a Visionary <span>Project in Mind?</span></h2>
                    <p class="premium-cta-desc">
                        We partner with ambitious organizations to turn complex engineering challenges into reliable digital products.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-right text-center">
                    <a href="<?= BASE_URL ?>/contact" class="cta-button">
                        <span>Start a Project</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Modular Newsletter -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
