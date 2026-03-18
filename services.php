<?php
  
   require('includes/connect.php');
   $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
   $contact_details->execute();
   $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

   $services_banner = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 6 ");
   $services_banner->execute();
   $fetch_banner = $services_banner->fetch(PDO::FETCH_ASSOC);

   $select_services = $conn->prepare("SELECT * FROM `services_tb`");
   $select_services->execute();
   $fetch_service = $select_services->fetch(PDO::FETCH_ASSOC);

   $misc_image1 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 4 ");
   $misc_image1->execute();
   $fetch_misc1 = $misc_image1->fetch(PDO::FETCH_ASSOC);  

   $misc_image2 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 5 ");
   $misc_image2->execute();
   $fetch_misc2 = $misc_image2->fetch(PDO::FETCH_ASSOC);


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
        <h2>Services</h2>
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
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="service-slider owl-one owl-carousel owl-theme">
        <?php
              $select_services = $conn->prepare("SELECT * FROM `services_tb`");
              $select_services->execute();
              if($select_services->rowCount() > 0){
              while($fetch_service = $select_services->fetch(PDO::FETCH_ASSOC)){
             ?>
          <div class="item"> 
            <div class="service_icon"><i class="<?= $fetch_service['service_icon']; ?>"></i></div>
            <div class="connector"> <span></span> </div>
            <div class="service-card">
              <div class="service_detail">
                <h5><a href="service-detail.php?id=<?php echo stripslashes($fetch_service['id']); ?>" title="Service"><?= $fetch_service['service_name']; ?></a></h5>
                <p><?= $fetch_service['service_description']; ?></p>
              </div>
            </div>
            </div>
            <?php
                        }
                       }else{
                        echo '<p class="empty">No services found!</p>';
                       }
                   ?>
          
        </div>
        <div class="h-border"><span></span></div>
      </div>
    </div>
  </section>
  <!-- ====== Services End ====== --> 
  
  <!-- ====== Work Status Start ====== -->
  <?php require('includes/work-status.html'); ?>
  <!-- ====== Work Status End ====== --> 
  
  <!-- ====== Pricing Start ====== 
  
  <section id="pricing" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Our <span>Pricing</span></h2>
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
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 content_sec">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 price_card">
            <div class="plan-title">
              <h4>Personal</h4>
              <div class="separator">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
            </div>
            <div class="price_amount"> From<strong>$9</strong>/mo </div>
            <div class="features">
              <ul>
                <li>One Feature</li>
                <li class="deactive">Another Feature</li>
                <li class="deactive">More Feature</li>
                <li class="deactive">Extra Feature</li>
              </ul>
            </div>
            <div class="purchase"> <a class="purchase_now" href="javascript:void(0)" title="Purchase Now">Purchase Now</a> </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 price_card ultimate">
            <div class="plan-title">
              <h4>Ultimate</h4>
              <div class="separator">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
            </div>
            <div class="price_amount"> From<strong>$199</strong>/mo </div>
            <div class="features">
              <ul>
                <li>One Feature</li>
                <li>Another Feature</li>
                <li>More Feature</li>
                <li>Extra Feature</li>
              </ul>
            </div>
            <div class="purchase"> <a class="purchase_now" href="javascript:void(0)" title="Purchase Now">Purchase Now</a> </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 price_card">
            <div class="plan-title">
              <h4>Business</h4>
              <div class="separator">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
            </div>
            <div class="price_amount"> From<strong>$99</strong>/mo </div>
            <div class="features">
              <ul>
                <li>One Feature</li>
                <li>Another Feature</li>
                <li>More Feature</li>
                <li class="deactive">Extra Feature</li>
              </ul>
            </div>
            <div class="purchase"> <a class="purchase_now" href="javascript:void(0)" title="Purchase Now">Purchase Now</a> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </section>
  
   ====== Pricing End ====== -->
  
  
</div>
<!-- ====== Footer Start ====== -->
<?php require('includes/mini-footer.php'); ?>
<!-- ====== Footer End ====== --> 
<?php require('javascript-section.html'); ?>
</body>

</html>