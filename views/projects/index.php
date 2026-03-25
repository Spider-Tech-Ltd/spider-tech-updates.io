<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Projects</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Projects</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<!-- ====== Projects Start ====== -->
<section id="portfolio" class="index-2 padding">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="row portfolio-gallary">
        <?php foreach($projects as $project): ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item">
          <div class="project portfolio-inner">
            <img src="<?= substr($project['project_pic'], 3); ?>" alt="project">
            <div class="label">
              <div class="label-text">
                <a href="<?= BASE_URL ?>/projects/detail?id=<?= $project['project_id']; ?>" class="text-title"><?= stripslashes($project['project_name']); ?></a>
              </div>
              <div class="label-bg"></div>
            </div>
            <div class="zoom">
              <a href="<?= substr($project['project_pic'], 3); ?>" class="popup-box" data-lightbox="image" data-title="Project">
                <i class="flat flaticon-magnifying-glass"></i>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- ====== Projects End ====== -->
