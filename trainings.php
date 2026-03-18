<?php
  
   require('includes/connect.php');
   $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
   $contact_details->execute();
   $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

   $services_banner = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 6 ");
   $services_banner->execute();
   $fetch_banner = $services_banner->fetch(PDO::FETCH_ASSOC);

   $select_trainings = $conn->prepare("SELECT * FROM `services_tb`");
   $select_trainings->execute();
   $fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC);

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
        <h2>Trainings</h2>
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
            <li class="breadcrumb-item active" aria-current="page">Trainings</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
  <!-- ====== Banner End ====== --> 
  
  <!-- ====== Trainings Start ====== -->
  <section id="services" class="index-2 padding">
    <div class="container">
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="service-slider owl-one owl-carousel owl-theme">
        <?php
              $select_trainings = $conn->prepare("SELECT * FROM `trainings_tb`");
              $select_trainings->execute();
              if($select_trainings->rowCount() > 0){
              while($fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC)){
             ?>
          <div class="item"> 
            <div class="service_icon"><i class="<?= $fetch_training['training_icon']; ?>"></i></div>
            <div class="connector"> <span></span> </div>
            <div class="service-card">
              <div class="service_detail">
                <h5><a href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>" title="Training"><?= $fetch_training['training_name']; ?></a></h5>
                <p><?= $fetch_training['training_description']; ?></p>
                <a href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>#registerNow" class="view_more" title="Register Now">Register Now</a>
              </div>
            </div>
            </div>
            <?php
                        }
                       }else{
                        echo '<p class="empty">No trainings found!</p>';
                       }
                   ?>
          
        </div>
        <div class="h-border"><span></span></div>
      </div>
    </div>
  </section>
  <!-- ====== Trainings End ====== --> 
  
  <!-- ====== Work Status Start ====== -->
  <?php require('includes/work-status.html'); ?>
  <!-- ====== Work Status End ====== --> 
  
  
  
  
</div>
<!-- ====== Footer Start ====== -->
<?php require('includes/mini-footer.php'); ?>
<!-- ====== Footer End ====== --> 
<?php require('javascript-section.html'); ?>
</body>

</html>