<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>About Us</h2>
        <div class="separator left-align"><ul><li></li><li></li><li></li></ul></div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<section id="about-us" class="index-2 padding">
  <div class="container">
    <div class="section_heading">
      <h1>About <span>Us</span></h1>
      <div class="separator"><ul><li></li><li></li><li></li></ul></div>
      <div class="heading_content"><?= stripslashes($about[0]['details'] ?? ''); ?></div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
      <div class="row row-safari">
        <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 img-area"> <img class="img_sec" src="<?= BASE_URL ?>/images/timeline/<?= stripslashes($about[0]['image'] ?? ''); ?>" alt="About" /> </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
          <h5><?= stripslashes($about[0]['title'] ?? ''); ?></h5>
          <p>We design innovative digital solutions leveraging cutting-edge technology.</p>
        </div>
      </div>
    </div>
  </div>
</section>
