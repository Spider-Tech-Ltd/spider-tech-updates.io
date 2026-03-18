<?php
require('includes/connect.php');

$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);


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
        <h2>Upcoming Events</h2>
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
            <li class="breadcrumb-item active" aria-current="page">Upcoming Events</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 


<!-- ====== Blog Posts Start ====== -->
<section id="blog_post" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="row">
        <?php
            $select_events = $conn->prepare("SELECT * FROM `events` WHERE event_status = 'upcoming'");
            $select_events->execute();
            if($select_events->rowCount() > 0){
            while($fetch_event = $select_events->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <div class="item blog_card">
            <div class="post-img"> <img src="<?php echo substr($fetch_event['event_img'],3); ?>" alt="Post" />
              <div class="posted_on"> <span class="date"><?php echo stripslashes($fetch_event['event_date']); ?></span></div>
            </div>
            <div class="post-detail">
              <h5><a href="event-detail.php?id=<?php echo stripslashes($fetch_event['event_id']); ?>"><?php echo stripslashes($fetch_event['event_title']); ?></a></h5>
              <div class="post-status">
                <ul>
                  <li><i class="flat flaticon-check"></i> <span><?php echo stripslashes($fetch_event['event_status']); ?></span></li>
                </ul>
              </div>
              <div class="description">
                <p><?php echo stripslashes($fetch_event['event_content']); ?></p>
                <a href="event-detail.php?id=<?php echo stripslashes($fetch_event['event_id']); ?>" class="view_more" title="View More">View More</a> </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <?php
              }
              }else{
              echo '<p class="empty">Stay Tuned for Upcoming Events</p>';
              }
          ?>
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1"><i class="flat flaticon-back"></i></a> </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"> <a class="page-link" href="#"><i class="flat flaticon-arrow"></i></a> </li>
      </ul>
    </nav>
  </div> 
</section>
<!-- ====== Blog Posts End ====== --> 

 


</div>
<!-- ====== Footer Start ====== -->
<?php require('includes/mini-footer.php'); ?>
<!-- ====== Footer End ====== --> 

<?php require('javascript-section.html'); ?>

</body>

</html>