<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Services</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="/" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Services</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<!-- ====== Services Start ====== -->
<section id="services" class="index-2 padding">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="row">
        <?php foreach($services as $service): ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <div class="item">
            <div class="service_icon"><i class="<?= $service['service_icon']; ?>"></i></div>
            <div class="connector"> <span></span> </div>
            <div class="service-card">
              <div class="service_detail">
                <h5><a href="/pages/services/detail.php?id=<?= $service['id']; ?>" title="Service"><?= $service['service_name']; ?></a></h5>
                <p><?= $service['service_description']; ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- ====== Services End ====== -->
