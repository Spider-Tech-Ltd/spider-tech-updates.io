  <!-- ====== Slider Start ====== -->
  <section id="slider">
      <div id="home-slider" class="owl-carousel owl-theme">
          <?php foreach ($banners as $banner): ?>
          <div class="item">
              <img src="<?= $banner['banner_img']; ?>" alt="Slider">
              <div class="slider-content">
                  <div class="container">
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="content-inner">
                                  <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.2s"><?= $banner['banner_title']; ?></h2>
                                  <p class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s"><?= $banner['banner_subtitle']; ?></p>
                                  <a href="/about-us.php" class="defualt-button wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">Learn More</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <?php endforeach; ?>
      </div>
  </section>
  <!-- ====== Slider End ====== -->

  <!-- ====== Upcoming Event Slider ====== -->
<section id="upcoming" class="index-2">
    <div class="container">
        <div class="section_heading mt-5 mb-3">
            <h2>Upcoming <span>Events</span></h2>
        </div>
        <?php if(!empty($upcoming_events)): ?>
        <div class="event-slider owl-eight owl-carousel owl-theme">
            <?php foreach($upcoming_events as $event): ?>
                <div class="item">
                    <div class="col-lg-12 col-md-12 col-xs-12 mt-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
                                <h2 id="event-title">
                                    <a class="orange-hover" href="/?route=events/detail&id=<?= $event['event_id']; ?>">
                                        <?= stripslashes($event['event_title']); ?>
                                    </a>
                                </h2>
                                <div><?= stripslashes($event['event_detail']); ?></div>
                                <div class="event-grid">
                                    <div class="event-item">
                                        <div class="content"><p><span class="icon"><i class="fa-solid fa-clock fa-lg"></i></span><span style="font-size:16px"><?= stripslashes($event['event_time']); ?> - 5:00pm daily</span></p></div>
                                    </div>
                                    <div class="event-item">
                                        <div class="content"><p><span class="icon"><i class="fa-solid fa-calendar-days fa-lg"></i></span><span style="font-size:16px"><?= date_format(date_create(stripslashes($event['event_date'])), "D F j"); ?><?php if($event['event_date2'] != NULL) { echo ' - ' . date_format(date_create(stripslashes($event['event_date2'])), "D F j, Y"); } ?></span></p></div>
                                    </div>
                                    <div class="event-item">
                                        <div class="content"><p><span class="icon"><i class="fa-solid fa-location-dot fa-lg"></i></span><span style="font-size:16px"><?= stripslashes($event['event_address']); ?></span></p></div>
                                    </div>
                                </div>
                                <p><a style="background-color: #f48221; color: #fff" class="btn btn-md p-2 px-4" href="/?route=events/detail&id=<?= $event['event_id']; ?>#registerNow">Register Now</a></p>
                                <h4>#SpiderTechEmpowers</h4>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 img-area">
                                <img class="img-area" src="<?= substr($event['event_img'], 3); ?>" alt="Event" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="section_heading mb-3">
                <h3>There are no upcoming events. Check out <a href="/?route=events/past" class="orange-hover">past events here</a>.</h3>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- ====== Upcoming Event Slider End ====== -->

  <!-- ====== About Us Start ====== -->
  <section id="about-us" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h1>About <span>Us</span></h1>
        <div class="separator"><ul><li></li><li></li><li></li></ul></div>
        <div class="heading_content"><?= stripslashes($about[0]['details'] ?? ''); ?></div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="row row-safari">
          <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 img-area"> <img class="img_sec" src="/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About" /> </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
            <h5><?= stripslashes($about[0]['title'] ?? ''); ?></h5>
            <p>We design innovative digital solutions leveraging cutting-edge technology.</p>
            <a class="defualt-button view_more" href="/about-us.php">View More</a> </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="qualities col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <?php for($i=1; $i<5; $i++): if(isset($about[$i])): ?>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 column">
            <div class="icon"><i class="flat flaticon-reward"></i></div>
            <div class="description"><h5><?= stripslashes($about[$i]['title']); ?></h5><p><?= stripslashes($about[$i]['details']); ?></p></div>
          </div>
          <?php endif; endfor; ?>
        </div>
      </div>
    </div>
  </section>
  <!-- ====== About Us End ====== -->

  <!-- ====== Services Start ====== -->
  <section id="services" class="gray-bg index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Services</h2>
        <div class="separator"><ul><li></li><li></li><li></li></ul></div>
        <div class="heading_content">We are dedicated to shaping a digital future where technology empowers and connects.</div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="service-slider owl-one owl-carousel owl-theme">
        <?php foreach($services as $service): ?>
          <div class="item">
            <div class="service_icon"><i class="<?= $service['service_icon']; ?>"></i></div>
            <div class="connector"> <span></span> </div>
            <div class="service-card"><div class="service_detail"><h5><a href="/?route=services/detail&id=<?= $service['id']; ?>" title="Service"><?= $service['service_name']; ?></a></h5><p><?= $service['service_description']; ?></p></div></div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== Project Start ====== -->
  <section id="portfolio" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Projects</h2>
        <div class="separator"><ul><li></li><li></li><li></li></ul></div>
        <div class="heading_content">We design innovative digital solutions leveraging cutting-edge technology.</div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec ">
          <div class="row portfolio-gallary">
          <?php foreach ($projects as $project): ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item">
                    <div class="project portfolio-inner">
                        <img src="<?= substr($project['project_pic'], 3); ?>" alt="project">
                        <div class="label">
                            <div class="label-text"><a href="/?route=projects/detail&id=<?= $project['project_id']; ?>" class="text-title"><?= stripslashes($project['project_name']); ?></a></div>
                            <div class="label-bg"></div>
                        </div>
                        <div class="zoom"><a href="<?= substr($project['project_pic'], 3); ?>" class="popup-box" data-lightbox="image" data-title="Project"><i class="flat flaticon-magnifying-glass"></i></a></div>
                    </div>
                </div>
            <?php endforeach; ?>
          </div>
      </div>
    </div>
  </section>
