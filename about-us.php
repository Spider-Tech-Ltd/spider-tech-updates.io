<?php
   
  require('includes/connect.php');

  $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
  $contact_details->execute();
  $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

  $about_banner = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 7 ");
  $about_banner->execute();
  $fetch_banner = $about_banner->fetch(PDO::FETCH_ASSOC);
  
  $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id = 1 LIMIT 1");
  $about_info->execute();
  $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);
                  
  $mission = $conn->prepare("SELECT * FROM `about_mission` WHERE id = 1 LIMIT 1");
  $mission->execute();
  $fetch_mission = $mission->fetch(PDO::FETCH_ASSOC);

  $vision = $conn->prepare("SELECT * FROM `about_vision` WHERE id = 1 LIMIT 1");
  $vision->execute();
  $fetch_vision = $vision->fetch(PDO::FETCH_ASSOC);
  
  $value = $conn->prepare("SELECT * FROM `about_value` WHERE id = 1 LIMIT 1");
  $value->execute();
  $fetch_value = $value->fetch(PDO::FETCH_ASSOC);

              

?>   

<!doctype html>
<html lang="en">

<head>
    <?php require('head-section.html'); ?>
</head>
<body>
    <!-- ====== Preloader ====== -->
    <?php require('includes/preloader.html'); ?>

<div class="wraper-v2-inner">
<!-- ====== Header Starts ====== -->
    <?php require('header-section.php'); ?>
<!-- ====== Header End ====== --> 

<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>About Us</h2>
        <div class="separator left-align">
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="index.php" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 

<!-- ====== About Content Start ====== -->
<section id="about-us-inner" class="index-2">
  <div class="container">
   <h2 class="d-none">Heading</h2>
    <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 img-area"> <img class="img-area" src="images/timeline/<?php echo stripslashes($fetch_about['image']); ?>" alt="About" /> </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
          <div class="about-heading"><?php echo stripslashes($fetch_about['title']); ?></div>
          <p><?php echo stripslashes($fetch_about['details']); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ====== About Content End ====== --> 


<!-- ====== Qualities Start ====== -->
<section id="qualities" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="content">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 column">
          <div class="icon"><i class="<?php echo stripslashes($fetch_mission['icon']); ?>"></i></div>
            <div class="heading">
              <h5><?php echo stripslashes($fetch_mission['title']); ?></h5>
            </div>
            <div class="description">
              <p><?php echo stripslashes($fetch_mission['details']); ?></p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 column">
            <div class="icon"><i class="<?php echo stripslashes($fetch_vision['icon']); ?>"></i></div>
            <div class="heading">
              <h5><?php echo stripslashes($fetch_vision['title']); ?></h5>
            </div>
            <div class="description">
              <p><?php echo stripslashes($fetch_vision['details']); ?></p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 column">
            <div class="icon"><i class="<?php echo stripslashes($fetch_value['icon']); ?>"></i></div>
            <div class="heading">
              <h5><?php echo stripslashes($fetch_value['title']); ?></h5>
            </div>
            <div class="description">
              <p><?php echo stripslashes($fetch_value['details']); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ====== Qualities End ====== --> 

<!-- ====== Counter Start ====== -->
<?php require('includes/counter.html'); ?>
<!-- ====== Counter End ====== --> 
  
  <!-- ====== Team Start ====== 
  <section id="our_team" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Our <span>Team</span></h2>
        <div class="separator">
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
        <div class="heading_content">
          Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="team-slider owl-one owl-carousel owl-theme">
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Alec Thompson</a></h5>
                <span>Developer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic3.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Tania Andrew</a></h5>
                <span>Designer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic4.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Christian Mike</a></h5>
                <span>Developer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic2.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Rebecca Stormville</a></h5>
                <span>Designer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
           <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Alec Thompson</a></h5>
                <span>Developer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic3.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Tania Andrew</a></h5>
                <span>Designer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic4.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Christian Mike</a></h5>
                <span>Developer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="client_dp"> <img src="img/team-member-pic2.jpg" alt="Team" /> </div>
            <div class="team-card">
              <div class="name_designation">
                <h5><a href="team-member-detail.html">Rebecca Stormville</a></h5>
                <span>Designer</span> </div>
              <div class="description">
                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              </div>
              <div class="social_links">
                <ul>
                  <li><a href="javascript:void(0)" title="Facebook" ><i class="flat flaticon-facebook-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="flat flaticon-twitter"></i></a></li>
                  <li><a href="javascript:void(0)" title="Google" ><i class="flat flaticon-google-plus-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="flat flaticon-linkedin-logo"></i></a></li>
                  <li><a href="javascript:void(0)" title="Instagram" ><i class="flat flaticon-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </section>
  ====== Team End ====== -->
</div>
<!-- ====== Footer Start ====== -->
<?php require('includes/mini-footer.php'); ?>
<!-- ====== Footer End ====== --> 
<?php require('javascript-section.html'); ?>
</body>

</html>