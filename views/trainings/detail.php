<?php
/**
 * Training Detail View
 */
?>
<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Training Detail</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Training Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<section id="portfolio_detail" class="py-5">
    <?php if($training): ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="project_screen mb-4">
                    <img src="<?= (strpos($training['training_image'], 'http') === 0) ? htmlspecialchars($training['training_image']) : BASE_URL . '/' . ltrim(substr($training['training_image'], 3), '/'); ?>" alt="Training" class="img-fluid rounded" />
                </div>
                <div class="project_description">
                    <h3 class="mb-3"><?= htmlspecialchars($training['training_name']); ?></h3>
                    <div class="mb-4"><?= nl2br(htmlspecialchars($training['training_description'])); ?></div>
                    <div class="mb-4">
                        <?= $training['training_details']; ?>
                    </div>
                    <a href="<?= BASE_URL ?>/trainings/register?id=<?= $training['id']; ?>" class="btn btn-primary" style="background-color: #f48221; border: none;">Register Now</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar p-4 border rounded" style="background-color: #f9f9f9;">
                    <h5 class="mb-3">Course Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-clock text-orange mr-2"></i> <strong>Duration:</strong> 24 Weeks</li>
                        <li class="mb-2"><i class="fas fa-users text-orange mr-2"></i> <strong>Enrolled:</strong> 41,000+</li>
                        <li class="mb-2"><i class="fas fa-star text-orange mr-2"></i> <strong>Rating:</strong> 4.9/5</li>
                        <li class="mb-2"><i class="fas fa-certificate text-orange mr-2"></i> <strong>Certified:</strong> Yes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container"><p>Training program not found.</p></div>
    <?php endif; ?>
</section>
