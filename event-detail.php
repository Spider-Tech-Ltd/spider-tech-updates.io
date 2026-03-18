<?php
require('includes/connect.php');

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

$select_training = $conn->prepare("SELECT * FROM trainings_tb");
$select_training->execute();
$fetch_training = $select_training->fetch(PDO::FETCH_ASSOC);

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
        <h2>Event Detail</h2>
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
             <li class="breadcrumb-item"><a href="events.php" title="Events">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
  <!-- ====== Banner End ====== --> 
  

    <!-- ====== Event Start ====== -->
    <section id="portfolio_detail">
   <?php
    $select_event = $conn->prepare("SELECT * FROM `events` WHERE event_id=?");
    $select_event->execute([$get_id]);
    if($select_event->rowCount() > 0){
    while($fetch_event = $select_event->fetch(PDO::FETCH_ASSOC)){
  ?>
      <div class="container">
        <h3 class="d-none">heading</h3>
        
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="project_screen">
            <img src="<?php echo substr($fetch_event['event_img'],3); ?>" alt="Event" />
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about_project">
            <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="icon">
                <i class="fas fa-clock"></i> 
              </div>
              <div class="content">
                <h6>Time</h6>
                <div class="value"><?php echo stripslashes($fetch_event['event_time']); ?></div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="icon">
                <i class="flat flaticon-facebook-placeholder-for-locate-places-on-maps"></i> 
              </div>
              <div class="content">
                <h6>Location</h6>
                <div class="value"><?php echo stripslashes($fetch_event['event_address']); ?></div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="icon">
                <i class="flat flaticon-calendar"></i> 
              </div>
              <div class="content">
                <h6>Date</h6>
                <div class="value"><?php echo stripslashes($fetch_event['event_date']); ?></div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="icon">
                <i class="flat flaticon-check"></i> 
              </div>
              <div class="content">
                <h6>Status</h6>
                <div class="value"><?php echo stripslashes($fetch_event['event_status']); ?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 project_description">
            <h4><?php echo stripslashes($fetch_event['event_title']); ?></h4>
            <div><?php echo stripslashes($fetch_event['event_detail']); ?></div>
             <!-- Display the "Register Now" link if event is upcoming -->
          <?php
          // Fetch event status
          $eventStatus = trim(strtolower(stripslashes($fetch_event['event_status'])));

          if ($eventStatus === "upcoming") {
            // Concatenate the training_id within the echo statement
            echo '<a style="color:#f48221; display:inline-block;" class="mt-2 mb-4" href="training-detail.php?id=' . stripslashes($fetch_training['id']) .'#registerNow">
                    Register Now > #SpiderTechEmpowers</a>';
        }
        
          ?>
        </div>
      </div>
      </div>
      <?php
              }
        }
     ?>
  </section>
<!-- ====== Event End ====== --> 
       
   
  <!-- ====== Event Media Start ====== --> 
<section id="portfolio" class="gray-bg">
    <div class="container">
       <div class="section_heading">
      <h2>Event <span>Media</span></h2>
      <div class="separator">
        <ul>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
      <div class="row">
      <?php 
              $select_event = $conn->prepare("SELECT * FROM events WHERE event_id=?");
              $select_event->execute([$get_id]);
              $fetch_event = $select_event->fetch(PDO::FETCH_ASSOC);

               $select_media = $conn->prepare("SELECT * FROM events_media WHERE event_id=?");
               $select_media->execute([$get_id]);
                while ($fetch_media = $select_media->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item design development">
                        <div class="project portfolio-inner">
                            <img src="<?php echo substr($fetch_media['event_pics_name'],3); ?>" alt="project">
                            <div class="label">
                                <div class="label-text">  <span class="text-title"><?php echo stripslashes($fetch_event['event_date']); ?></span></div>
                                <div class="label-bg"></div>
                            </div>
                            <div class="zoom"> <a href="<?php echo substr($fetch_media['event_pics_name'],3); ?>" class="popup-box"  data-lightbox="image" 
                            data-title="<?php echo stripslashes($fetch_event['event_title']); ?>"> <i class="flat flaticon-magnifying-glass"></i> </a> </div>
                        </div>
                    </div>

                    <?php endwhile; ?>

                  
                   
          
      </div>
    </div>
  </div>
</section>
<!-- ====== Event Media End ====== -->
  
  <!-- ====== Counter Start ====== -->
  <?php require('includes/counter.html'); ?>
<!-- ====== Counter End ====== --> 
</div>

<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 

<?php require('javascript-section.html'); ?>

</body>

</html>