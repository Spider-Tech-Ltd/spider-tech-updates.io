<?php
/**
 * Service Detail View
 */
?>
<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Service Detail</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/services" title="Services">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">Service Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<section id="portfolio_detail" class="py-5">
    <?php if($service): ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="project_description">
                    <div class="service_icon mb-4"><i class="<?= $service['service_icon']; ?> fa-4x text-orange"></i></div>
                    <h3 class="mb-3"><?= htmlspecialchars($service['service_name']); ?></h3>
                    <div class="mb-4"><?= nl2br(htmlspecialchars($service['service_description'])); ?></div>
                    <a href="<?= BASE_URL ?>/contact" class="btn btn-primary" style="background-color: #f48221; border: none;">Get a Quote</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar p-4 border rounded" style="background-color: #f9f9f9;">
                    <h5 class="mb-3">Expertise</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-orange mr-2"></i> Professional Support</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-orange mr-2"></i> Quality Assurance</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-orange mr-2"></i> Scalable Solutions</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-orange mr-2"></i> 24/7 Availability</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container"><p>Service not found.</p></div>
    <?php endif; ?>
</section>
