<?php
/**
 * Project Detail View
 */
?>
<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Project Detail</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/projects" title="Projects">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">Project Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<section id="portfolio_detail" class="py-5">
    <?php if($project): ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="project_screen mb-4">
                    <img src="<?= BASE_URL . '/' . ltrim(substr($project['project_pic'], 3), '/'); ?>" alt="Project" class="img-fluid rounded shadow" />
                </div>
                <div class="project_description">
                    <h3 class="mb-3"><?= htmlspecialchars($project['project_name']); ?></h3>
                    <div class="mb-4">Innovative digital solution leveraging cutting-edge technology for Spider Technologies.</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar p-4 border rounded" style="background-color: #f9f9f9;">
                    <h5 class="mb-3">Project Specs</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-calendar text-orange mr-2"></i> <strong>Launch:</strong> 2024</li>
                        <li class="mb-2"><i class="fas fa-tag text-orange mr-2"></i> <strong>Client:</strong> Spider Tech Partners</li>
                        <li class="mb-2"><i class="fas fa-layer-group text-orange mr-2"></i> <strong>Category:</strong> Technology Solutions</li>
                        <li class="mb-2"><i class="fas fa-link text-orange mr-2"></i> <strong>Website:</strong> <a href="#">Visit Live</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container"><p>Project not found.</p></div>
    <?php endif; ?>
</section>
