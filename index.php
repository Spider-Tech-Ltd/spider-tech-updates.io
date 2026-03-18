<?php
require('includes/connect.php');
require('home_functions.php');
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
  
  <!-- ====== Slider Start ====== -->
  <?php require('includes/slider-section.php'); ?>
  
  <!-- ====== Slider End ====== --> 

  <!-- ====== Upcoming Event Slider ====== -->
<section id="upcoming" class="index-2">
          <div class="container">
            <div class="section_heading mt-5 mb-3">
                <h2>Upcoming <span>Events</span></h2>
            </div>
<?php
    // Select only events with event_status as 'upcoming'
    $select_events = $conn->prepare("SELECT * FROM `events` WHERE `event_status` = 'upcoming'");
    $select_events->execute();
    

    // Check if there are any upcoming events
    if($select_events->rowCount() > 0) {
    ?>
            <div class="event-slider owl-eight owl-carousel owl-theme">
            <?php
            // Fetch and display each upcoming event
            while($fetch_event = $select_events->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="item">
                    <div class="col-lg-12 col-md-12 col-xs-12 mt-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
                                <h2 id="event-title">
                                    <a class="orange-hover" href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>">
                                        <?php echo stripslashes($fetch_event['event_title']); ?>
                                    </a>
                                </h2>
                                <div><?php echo stripslashes($fetch_event['event_detail']); ?></div>
                                <div class="event-grid">
                                    <div class="event-item">
                                        <div class="content">
                                            <p>
                                                <span class="icon"><i class="fa-solid fa-clock fa-lg"></i></span>
                                                <span style="font-size:16px"><?php echo stripslashes($fetch_event['event_time']); ?> - 5:00pm daily</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="event-item">
                                        <div class="content">
                                            <p>
                                                <?php 
                                                $date = date_create(stripslashes($fetch_event['event_date']));
                                                if($fetch_event['event_date2'] != NULL) {
                                                    $date2 = date_create(stripslashes($fetch_event['event_date2']));
                                                }
                                                ?>
                                                <span class="icon"><i class="fa-solid fa-calendar-days fa-lg"></i></span>
                                                <span style="font-size:16px">
                                                    <?php echo date_format($date, "D F j"); ?>
                                                    <?php if($fetch_event['event_date2'] != NULL) { echo ' - ' . date_format($date2, "D F j, Y"); } ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="event-item">
                                        <div class="content">
                                            <p>
                                                <span class="icon"><i class="fa-solid fa-location-dot fa-lg"></i></span>
                                                <span style="font-size:16px"><?php echo stripslashes($fetch_event['event_address']); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <p></p>
                                <p>
                                    <a style="background-color: #f48221; color: #fff" class="btn btn-md p-2 px-4" href="training-detail.php?id=<?php echo stripslashes($fetch_training['id']); ?>#registerNow">Register Now</a>
                                </p>
                                <h4>#SpiderTechEmpowers</h4>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 img-area">
                                <img class="img-area" src="<?php echo substr($fetch_event['event_img'], 3); ?>" alt="Event" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="section_heading mb-3">
                <h3>There are no upcoming events. Check out <a href="past-events.php" class="orange-hover">past events here</a>.</h3>
            </div>
        </div>
    <?php
    }
?>
</section>
<!-- ====== Upcoming Event Slider End ====== -->


  <!-- ====== About Us Start ====== -->
  <section id="about-us" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h1>About <span>Us</span></h1>
        <div class="separator">
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
        <div class="heading_content">
        <?php echo stripslashes($fetch_about['details']); ?>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
        <div class="row row-safari">
          <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 img-area"> <img class="img_sec" src="images/timeline/<?php echo stripslashes($fetch_about['image']); ?>" alt="About" /> </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 content-area">
            <h5><?php echo stripslashes($fetch_about['title']); ?></h5>
            <p>We design innovative digital solutions leveraging cutting-edge technology.</p>
            <a class="defualt-button view_more" href="about-us.php">View More</a> </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="qualities col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 column">
            <div class="icon"><i class="flat flaticon-reward"></i></div>
            <div class="description">
              <h5><?php echo stripslashes($fetch_about2['title']); ?></h5>
              <p><?php echo stripslashes($fetch_about2['details']); ?></p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 column">
            <div class="icon"><i class="flat flaticon-enterprise"></i></div>
            <div class="description">
              <h5><?php echo stripslashes($fetch_about3['title']); ?></h5>
              <p><?php echo stripslashes($fetch_about3['details']); ?></p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 column">
            <div class="icon"><i class="flat flaticon-certificate"></i></div>
            <div class="description">
              <h5><?php echo stripslashes($fetch_about4['title']); ?></h5>
              <p><?php echo stripslashes($fetch_about4['details']); ?></p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 column">
            <div class="icon"><i class="flat flaticon-working-team"></i></div>
            <div class="description">
              <h5><?php echo stripslashes($fetch_about5['title']); ?></h5>
              <p><?php echo stripslashes($fetch_about5['details']); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ====== About Us End ====== --> 
  
  <!-- ====== Services Start ====== -->
  <section id="services" class="gray-bg index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Services</h2>
        <div class="separator">
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
        <div class="heading_content">
        We are dedicated to shaping a digital future where technology empowers and connects, driving towards a brighter and more inclusive tomorrow for everyone.
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
  <!-- ====== Work Status End ====== --> 
  
  <!-- ====== Project Start ====== -->
  <section id="portfolio" class="index-2">
    <div class="container">
      <div class="section_heading">
        <h2>Projects</h2>
        <div class="separator">
          <ul>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
        <div class="heading_content">
        We design innovative digital solutions leveraging cutting-edge technology.
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-xs-12 content_sec ">
          <div class="row portfolio-gallary">
          <?php 
                $select_project = $conn->query("SELECT * FROM projects_tb p INNER JOIN services_tb s ON p.service_id = s.id LIMIT 6");
                while ($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item">
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
    <div class="overlay"></div>
  </section>
  <!-- ====== Project End ====== --> 
  <section id="counter" class="gray-bg index-2">
    <div class="container">
      <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="row row-safari">
          <div class="counter-column col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="count_icon"> <i class="flat flaticon-happiness"></i> </div>
            <div class="separator left-align">
              <ul>
                <li></li>
                <li></li>
                <li></li>
              </ul>
            </div>
            <div class="counter_content">
              <h2><span class="counter">200</span>+</h2>
              <div class="title">Happy Client</div>
            </div>
          </div>
          <div class="counter-column col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="count_icon"> <i class="flat flaticon-coffee-cup"></i> </div>
            <div class="separator left-align">
              <ul>
                <li></li>
                <li></li>
                <li></li>
              </ul>
            </div>
            <div class="counter_content">
              <h2><span class="counter">10000</span>+</h2>
              <div class="title">Hours Worked</div>
            </div>
          </div>
          <div class="counter-column col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="count_icon"> <i class="flat flaticon-like"></i> </div>
            <div class="separator left-align">
              <ul>
                <li></li>
                <li></li>
                <li></li>
              </ul>
            </div>
            <div class="counter_content">
              <h2><span class="counter">1800</span>+</h2>
              <div class="title">Projects Done</div>
            </div>
          </div>
          <div class="counter-column col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="count_icon"> <i class="flat flaticon-building"></i> </div>
            <div class="separator left-align">
              <ul>
                <li></li>
                <li></li>
                <li></li>
              </ul>
            </div>
            <div class="counter_content">
              <h2><span class="counter">1</span></h2>
              <div class="title">Office Locations</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- ====== Event Start ====== -->
  
  <section id="blog_post" class="index-2">
  <div class="container">
    <div class="section_heading">
      <h2>Event <span>Lists</span></h2>
      <div class="separator">
        <ul>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <div class="heading_content">
        Join our tech events to stay updated with the latest trends and innovations. From conferences and workshops to networking meetups and webinars, our events provide valuable learning and networking opportunities for professionals and enthusiasts alike. Check out our events calendar and register today!
      </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12 content_sec">
      <div class="blog-slider owl-five owl-carousel owl-theme">
        <?php
            $select_events = $conn->prepare("SELECT * FROM `events` ORDER BY `event_date` DESC");
            $select_events->execute();
            if($select_events->rowCount() > 0){
                while($fetch_event = $select_events->fetch(PDO::FETCH_ASSOC)){
        ?>
          <div class="item blog_card">
            <div class="post-img"> 
              <img src="<?php echo substr($fetch_event['event_img'],3); ?>" alt="Events" />
              <div class="posted_on"> 
                <span class="date"><?php echo stripslashes($fetch_event['event_date']); ?></span>  
              </div>
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
                <a href="event-detail.php?id=<?php echo stripslashes($fetch_event['event_id']); ?>" class="view_more" title="View More">View More</a> 
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        <?php
        }
        } else {
          echo '<p class="empty">No events found!</p>';
        }
        ?>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</section>

  <!-- ====== Event End ====== --> 
   
  <!-- ====== Testimonials Start ====== -->

<section id="testimonials" class="gray-bg index-2">
<div class="container">
  <div class="row row-reverse">
  <div class="col-lg-6 col-md-6 col-xs-12 content_sec">
    <div class="section_heading">
      <h2>What <span>People Say</span></h2>
      <div class="separator left-align">
        <ul>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>
    <div class="testimonials-slider owl-seven owl-carousel owl-theme">
      <?php
         $select_testimonials = $conn->prepare("SELECT * FROM `testimonials_tb` LIMIT 6");
         $select_testimonials->execute();
         if($select_testimonials->rowCount() > 0){
          while($fetch_testimonial = $select_testimonials->fetch(PDO::FETCH_ASSOC)){
      ?>
        <div class="item">
        <div class="comment-box">
        <div class="comment">
          <p><?= $fetch_testimonial['testimonial']; ?> </p>
        </div>
        </div>
        <div class="client_detail">
              <div class="client_dp"> <img src="<?php echo  substr($fetch_testimonial['image'], 3); ?>" alt="Client DP"/> </div>
              <div class="name_designation">
                <h5><?= $fetch_testimonial['name']; ?></h5>
                <span>Client</span> </div>
            </div>
        </div>
        <?php
           }
          }else{
           echo '<p class="empty">No testimonial found!</p>';
          }
        ?>

  </div>
</div>
</div>
<div class="clearfix"></div>
</section>

<section id="quick-connect" class="index-2">
    <div class="container">
       <div class="row">
           <!-- Newsletter Subscription -->
           <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="newsletter">
              <div class="section_heading">
                <h4>Subscribe Our Newsletter</h4>
                <div class="separator">
                  <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                  </ul>
                </div>
                <div class="heading_content">
                  Provide your email address and stay informed with our latest resources
                </div>
              </div>
              <div class="col-lg-12 col-md-6 mb10">
                 <div id="newsletterMessage">
                   <?php if(!empty($success_email)) { echo $success_email; } ?>
                   <?php if(!empty($error_msg)){ echo $error_msg; } ?>
                 </div>
              </div>
              <form id="newsletterForm" method="post">
                <input name="email" type="text" placeholder="Enter your Email Id">
                <button id="newsletterSubmit" name="subscribe" type="submit">Subscribe</button>
              </form>
              <div id="newsletterEmailError"></div>
             </div>
           </div>

           <!-- Quick Info -->
           <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="quick-info">
               <div class="section_heading">
                <h4>For Quick Info</h4>
                <div class="separator">
                  <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                  </ul>
                </div>
               </div>
               <div class="content">
                 <div class="sub-heading">Call Us On</div>
                 <div class="contact-no"><?php echo stripslashes($fetch_contact['contact_pno']); ?></div>
               </div>
             </div>
           </div>
       </div>
    </div>
</section>

<!-- ====== Testimonials End ====== --> 
</div>
<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 
<?php require('javascript-section.html'); ?>
<script type="text/javascript">
    $(document).ready(function() {
    $("#newsletterForm").validate({
        rules: {
            email: { required: true, email: true }, // Validate email format
        },
        messages: {
            email: { 
                required: "<font color='#FF0000'>Email is required!</font>",
                email: "<font color='#FF0000'>Please enter a valid email address!</font>" 
            },
        },
        submitHandler: function(form) {
            var subscribeButton = $("#newsletterSubmit");
            var msg = $('#newsletterMessage');

            // Disable button and show sending state
            subscribeButton.prop('disabled', true).html('Sending...');

            $.ajax({
                url: 'includes/subscribe_function.php',
                type: 'POST',
                dataType: 'html',
                data: $(form).serialize(),
                success: function(data) {
                    // Show the message after the "Sending..." text has been displayed for 1.5 seconds
                    setTimeout(function() {
                        // Reset the button text
                        subscribeButton.prop('disabled', false).html('Subscribe');
                        
                        // Show the message and hide it after 3 seconds
                        msg.html(data).fadeIn().delay(3000).fadeOut("slow");
                        
                        // Reset the form using jQuery
                        form.reset();
                    }, 1000); // Delay of 1 second
                },
                error: function(e) {
                    console.log("AJAX call failed. Error: " + e);
                    msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                    subscribeButton.prop('disabled', false).html('Subscribe');
                }
            });
            return false; // Prevent the default form submission
        }
    });
});
</script>
</body>
</html>