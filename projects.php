<?php
require('includes/connect.php');

$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

// Fetch project services for filter buttons
$services_query = $conn->query("SELECT DISTINCT service_name FROM services_tb");
$services = $services_query->fetchAll(PDO::FETCH_ASSOC);


function sanitize_class_name($string) {
    return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $string));
}
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
<header class="header ">
<?php require('header-section.php'); ?>
</header>
<!-- ====== Header End ====== --> 

<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Projects</h2>
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
            <li class="breadcrumb-item active" aria-current="page">Projects</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 

<!-- ====== Portfolio Start ====== -->
<section id="portfolio">
    <div class="container">
        <h3 class="d-none">heading</h3>
        
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="portfolio-sort">
                <ul class="sorting clearfix center-grid">
                    <li class="sort-btn active" data-filter="*">All</li>
                    <?php foreach ($services as $service): ?>
                        <li class="sort-btn" data-filter=".<?php echo sanitize_class_name($service['service_name']); ?>">
                            <?php echo stripslashes($service['service_name']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="row portfolio-gallary">
            <?php 
                $select_project = $conn->query("SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id");
                while ($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item <?php echo sanitize_class_name($fetch_project['service_name']); ?>">
                    <div class="project portfolio-inner">
                        <img src="<?php echo substr($fetch_project['project_pic'], 3); ?>" alt="project">
                        <div class="label">
                            <div class="label-text">
                                <a href="project-detail.php?id=<?php echo stripslashes($fetch_project['project_id']); ?>" class="text-title">
                                    <?php echo stripslashes($fetch_project['project_name']); ?>
                                </a>
                            </div>
                            <div class="label-bg"></div>
                        </div>
                        <div class="zoom">
                            <a href="<?php echo substr($fetch_project['project_pic'], 3); ?>" class="popup-box" data-lightbox="image" data-title="Project">
                                <i class="flat flaticon-magnifying-glass"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<!-- ====== Portfolio End ====== --> 

<!-- ====== Counter Start ====== -->
<?php require('includes/counter.html'); ?>
<!-- ====== Counter End ====== --> 
</div>
<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 

<!-- JS Scripts -->
<?php require('javascript-section.html'); ?>
<script>
$(document).ready(function() {
    // Debugging: Ensure jQuery is loaded
    console.log("jQuery version: " + $.fn.jquery);

    // Filter projects
    $('.sort-btn').click(function() {
        var filterValue = $(this).attr('data-filter');
        console.log("Filter clicked: " + filterValue);

        if (filterValue == '*') {
            $('.port-item').show('1000');
        } else {
            $('.port-item').not(filterValue).hide('3000');
            $('.port-item').filter(filterValue).show('3000');
        }

        // Remove active class from all buttons
        $('.sort-btn').removeClass('active');
        // Add active class to the clicked button
        $(this).addClass('active');
    });
});
</script>
</body>

</html>
