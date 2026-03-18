<?php
  
   require('includes/connect.php');

   $get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

   $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
   $contact_details->execute();
   $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

   $select_services = $conn->prepare("SELECT * FROM `services_tb`");
   $select_services->execute();
   $fetch_service = $select_services->fetch(PDO::FETCH_ASSOC);

   $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id = 1 LIMIT 1");
   $about_info->execute();
   $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
  <?php require('head-section.html'); ?>
</head>
<body>

  <!-- ====== Preloader ====== -->
  <?php require('includes/preloader.html'); ?>

        <div class="wraper"> 
<!-- ====== Header Starts ====== -->
<?php require('header-section.php'); ?>
<!-- ====== Header End ====== --> 

<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Service Detail</h2>
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
             <li class="breadcrumb-item"><a href="services.php" title="Services">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">Service Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 

<!-- ====== Services Start ====== -->
<section id="services-top">
  <div class="container">
    <h3 class="d-none">heading</h3>
    <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
    <?php
        $select_service = $conn->prepare("SELECT * FROM `services_tb` WHERE id=?");
        $select_service->execute([$get_id]);
        if($select_service->rowCount() > 0){
            while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
        ?>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 img-area"> <img src="images/timeline/<?php echo stripslashes($fetch_about['image']); ?>" alt="About" /> </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
        <h5><?php echo stripslashes($fetch_service['service_name']); ?></h5>
        <div><?php echo stripslashes($fetch_service['service_detail']); ?></div>
      </div>
   </div>
   <?php
                             }
                        }
                    ?>
  </div>
  </div>
</section>
<!-- ====== Services End ====== --> 

<!-- ====== Work Status Start ====== -->
<?php require('includes/work-status.html'); ?>
  <!-- ====== Work Status End ====== --> 

<!-- ====== Other Services Start ====== -->
<section id="services" class="gray-bg">
  <div class="container">
    <div class="section_heading">
      <h2>Other <span>Services</span></h2>
      <div class="separator">
        <ul>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <div class="heading_content">
      We are dedicated to shaping a digital future where technology empowers, connects, and sustains, driving towards a brighter, more efficient, and inclusive tomorrow for everyone.
      </div>
    </div>
    
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="service-slider owl-one owl-carousel owl-theme">
        <?php
              $select_services = $conn->prepare("SELECT * FROM `services_tb`");
              $select_services->execute();
              if($select_services->rowCount() > 0){
              while($fetch_service = $select_services->fetch(PDO::FETCH_ASSOC)){
             ?>
          <div class="item service-card">
            <div class="service_icon"><i class="<?php echo stripslashes($fetch_service['service_icon']); ?>"></i></div>
            <div class="service_detail">
              <h5> <a href="service-detail.php?id=<?php echo stripslashes($fetch_service['id']); ?>" title="Service name" ><?php echo stripslashes($fetch_service['service_name']); ?></a></h5>
              <p><?php echo stripslashes($fetch_service['service_description']); ?></p>
            </div>
            </div>
            <?php
                        }
                       }else{
                        echo '<p class="empty">No services found!</p>';
                       }
                   ?>

        </div>
      </div>
   
  </div>
</section>
<!-- ====== Other Services End ====== --> 
</div>
<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 
<?php require('javascript-section.html'); ?>
</body>

</html>