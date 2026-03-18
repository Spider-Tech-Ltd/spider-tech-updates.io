<?php
require('includes/connect.php');

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

<!-- ====== Banner Start ====== -->
<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Project Detail</h2>
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
             <li class="breadcrumb-item"><a href="projects.php" title="Projects">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">Project Detail</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 

<!-- ====== Portfolio Start ====== -->
<section id="portfolio_detail">
  <?php
    $select_project = $conn->prepare("SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id WHERE project_id=?");
    $select_project->execute([$get_id]);
    if($select_project->rowCount() > 0){
    while($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)){
  ?>
  <div class="container">
    <h3 class="d-none">heading</h3>
   
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
    <div class="project_screen">
       <img src="<?php echo substr($fetch_project['project_pic'], 3); ?>" alt="Project" />
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 about_project">
        <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="icon">
            <i class="flat flaticon-calendar"></i> 
          </div>
          <div class="content">
            <h6>Year</h6>
            <div class="value"><?php echo stripslashes($fetch_project['project_year']); ?></div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="icon">
            <i class="flat flaticon-folder"></i> 
          </div>
          <div class="content">
            <h6>Service</h6>
            <div class="value"><?php echo stripslashes($fetch_project['service_name']); ?></div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 project_description">
        <h4><?php echo stripslashes($fetch_project['project_name']); ?></h4>
        <p><?php echo stripslashes($fetch_project['project_description']); ?></p>
    </div>
  </div>
  </div>
  <?php
      }
      }else{
      echo '<p class="empty">No projects found!</p>';
      }
  ?>
</section>
<!-- ====== Portfolio End ====== --> 

<!-- ====== Recent Project Start ====== --> 
<section id="portfolio" class="gray-bg">
    <div class="container">
       <div class="section_heading">
      <h2>Other <span>Projects</span></h2>
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
                $select_project = $conn->query("SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id LIMIT 6");
                while ($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item design development">
                        <div class="project portfolio-inner">
                            <img src="<?php echo substr($fetch_project['project_pic'], 3); ?>" alt="project">
                            <div class="label">
                                <div class="label-text"> <a href="project-detail.php?id=<?php echo stripslashes($fetch_project['project_id']); ?>" class="text-title"><?php echo stripslashes($fetch_project['project_name']); ?></a> </div>
                                <div class="label-bg"></div>
                            </div>
                            <div class="zoom"> <a href="<?php echo substr($fetch_project['project_pic'], 3); ?>" class="popup-box"  data-lightbox="image" data-title="Project"> <i class="flat flaticon-magnifying-glass"></i> </a> </div>
                        </div>
                    </div>

                    <?php endwhile; ?>

                  
                   
          
      </div>
    </div>
  </div>
</section>
<!-- ====== Recent Project End ====== --> 

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