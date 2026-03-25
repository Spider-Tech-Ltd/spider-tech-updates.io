<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Event Detail</h2>
        <div class="separator left-align">
          <ul><li></li><li></li><li></li></ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="/" title="Home">Home</a></li>
             <li class="breadcrumb-item"><a href="/pages/events/index.php" title="Events">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== -->

<section id="portfolio_detail">
    <?php if($event): ?>
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="project_screen">
                <img src="<?= substr($event['event_img'],3); ?>" alt="Event" />
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about_project">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="icon"><i class="fas fa-clock"></i></div>
                        <div class="content"><h6>Time</h6><div class="value"><?= stripslashes($event['event_time']); ?></div></div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="icon"><i class="flat flaticon-facebook-placeholder-for-locate-places-on-maps"></i></div>
                        <div class="content"><h6>Location</h6><div class="value"><?= stripslashes($event['event_address']); ?></div></div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="icon"><i class="flat flaticon-calendar"></i></div>
                        <div class="content"><h6>Date</h6><div class="value"><?= stripslashes($event['event_date']); ?></div></div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="icon"><i class="flat flaticon-check"></i></div>
                        <div class="content"><h6>Status</h6><div class="value"><?= stripslashes($event['event_status']); ?></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 project_description">
                <h4><?= stripslashes($event['event_title']); ?></h4>
                <div><?= stripslashes($event['event_detail']); ?></div>
                <?php if (trim(strtolower(stripslashes($event['event_status']))) === "upcoming"): ?>
                <a style="color:#f48221; display:inline-block;" class="mt-2 mb-4" href="/pages/trainings/index.php">
                    Register Now > #SpiderTechEmpowers</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container"><p>Event not found.</p></div>
    <?php endif; ?>
</section>
