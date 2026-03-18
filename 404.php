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


        <div class="wraper"> 
  <!-- ====== Header Starts ====== -->
  <?php require('header-section.php'); ?>
  <!-- ====== Header End ====== --> 
 

<!-- ====== Page Not Found Start ====== -->
<section id="page-not-found" class="gray-bg">
  <div class="container">
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 text-center img_sec">
            <img src="img/error_404.png" alt="Errow 404" />
        </div>
        <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 text-center content_sec">
            <div class="errow-heading">
                <img src="img/oops.png" alt="oops" />
            </div>
            <div class="error-content">
              <h4>Page Not Found!</h4>
              <div class="separator">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
              <p>This is not the page your are looking for. Reach out with your feelings and try refining your search or return to base.</p>
              <a href="index.php" title="Homepage">Back to Home</a>
            </div>
        </div>
    </div>
  </div>
</section>
<!-- ====== Page Not Found Start ====== -->



</div>
<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 
<!-- popper js--> 
<script src="js/popper.min.js"></script> 
<!-- bootstrap js--> 
<script src="js/bootstrap.min.js"></script> 
<!-- Waypoints js plugin -->
<script src="js/waypoints.min.js"></script>
<!-- Counter-up js plugin -->
<script src="js/jquery.counterup.min.js"></script>
<!-- Preloadinator --> 
<script src="js/jquery.preloadinator.min.js"></script>
<script>
      $('.js-preloader').preloadinator({
        minTime: 2000
      });
</script> 
<!-- Lightbox--> 
<script src="js/lightbox.js"></script> 
<!--imageloaded js plugin -->
<script src="js/imagesloaded.js"></script>
<!-- isotope js -->
<script src="js/isotope.min.js"></script>
<!-- Owl Slider js--> 
<script src="js/owl.carousel.js"></script> 
<script src="js/owl.custom.js"></script> 
<!-- parallax js--> 
<script src="js/jquery.parallax-1.1.3.js"></script> 
<script src="js/jquery.localscroll-1.2.7-min.js"></script> 
<!-- Header menu -->
<script src="js/jquery.smartmenus.min.js"></script>
<!-- Custome js--> 
<script src="js/custom.js"></script>
</body>


</html>