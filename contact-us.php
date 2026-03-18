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

<!-- ====== Banner Start ====== -->
<section id="inner-banner">
  <div class="container">
    <div class="row">
      <div class="inner-heading">
        <h2>Contact Us</h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ====== Banner End ====== --> 


<!-- ====== Contact Detail Start ====== -->
<section id="contact-us">
  <div class="container">

     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contact-detail">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="contact-card">
        <div class="icon"><i class="flat flaticon-phone-receiver"></i></div>
        <div class="heading">
          <h5>Phone No.</h5>
        </div>
        <div class="description">
          <p><?=$fetch_contact['contact_pno'];?></p>
        </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="contact-card">
        <div class="icon"><i class="flat flaticon-facebook-placeholder-for-locate-places-on-maps"></i></div>
        <div class="heading">
          <h5>Address</h5>
        </div>
        <div class="description">
          <p><?=$fetch_contact['contact_address'];?></p>
        </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="contact-card">
        <div class="icon"><i class="flat flaticon-mail-black-envelope-symbol"></i></div>
        <div class="heading">
          <h5>Email</h5>
        </div>
        <div class="description">
          <p><?=$fetch_contact['contact_email'];?> </p>
        </div>
        </div>
      </div>
     </div>
	<div class="mid-content">
    <div class="row">    
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           <h3>Let’s Get In Touch!</h3>
           <div class="separator left-align ">
            <ul>
              <li></li>
              <li></li>
              <li></li>
            </ul>
          </div>
          <div class="description">
            It would be great to hear from you! If you got any questions, please do not hesitate to submit us a message. We are looking forward to hearing from you ! <span> We reply within 24 hours!</span>
          </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <form method="post" id="contactForm">
              <div class="row">
              <div id="ajaxMessage" class="col-lg-12 col-md-6 mb10">
                
              </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                  <input name="name" value="<?php if (isset($_POST['submit']) && !empty($name)) { echo $name; } ?>" 
                  type="text" placeholder="Full Name" />
                  <?php if (isset($_POST['submit'])) { echo $nameError; } ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                  <input name="email" value="<?php if (isset($_POST['submit']) && !empty($email)) { echo $email; } ?>"
                   type="text" placeholder="Email" />
                  <?php if (isset($_POST['submit'])) { echo $emailError; } ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                  <input name="phone_no" value="<?php if (isset($_POST['submit']) && !empty($phone_no)) { echo $phone_no; } ?>" 
                  type="text" placeholder="Phone No." />
                  <?php if (isset($_POST['submit'])) { echo $phone_noError; } ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                  <input name="subject" value="<?php if (isset($_POST['submit']) && !empty($subject)) { echo $subject; } ?>"
                   type="text" placeholder="Subject" />
                  <?php if (isset($_POST['submit'])) { echo $subjectError; } ?>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                  <textarea name="message" placeholder="Message"><?php if (isset($_POST['submit']) && !empty($message)) { echo $message; } ?></textarea>
                  <?php if (isset($_POST['submit'])) { echo $messageError; } ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                  <div id="example3"></div>
                  <div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                  <button id="submit" type="submit" name="submit">Send Message <i class="flat flaticon-plane"></i></button>
                </div>
              </div>
            </form>
        </div>
    </div>
    </div>
  </div>
</div>
</section>
<!-- ====== Contact Detail End ====== --> 
<!-- ====== Location Map Start ====== --> 
  <div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1910.6112255508242!2d8.535275604718812!3d11.983663862885235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x11ac2bfc1bd85fab%3A0x29627f19091c196e!2sSpider%20Technologies%20Limited!5e0!3m2!1sen!2sng!4v1722262074605!5m2!1sen!2sng"  style="border:0" allowfullscreen></iframe>
  </div>
<!-- ====== Location Map End ====== --> 
</div>

<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 

<?php require('javascript-section.html'); ?>
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#contactForm").validate({
            rules: {
                name: { required: true },
                email: { required: true },          
                phone_no: { required: true },
                subject: { required: true },
                message: { required: true },
            },
            messages: {
                name: { required: "<font color='#FF0000'>Name is required!</font>" },
                email: { required: "<font color='#FF0000'>Email is required!</font>" },
                phone_no: { required: "<font color='#FF0000'>Phone number is required!</font>" },
                subject: { required: "<font color='#FF0000'>Subject is required!</font>" },
                message: { required: "<font color='#FF0000'>Message is required!</font>" },                    
            },
            submitHandler: function(form) {
                var submitButton = $("#submit");
                var msg = $('#ajaxMessage');

                // Disable button and show sending state
                submitButton.prop('disabled', true).html('Sending...');

                $.ajax({
                    url: 'includes/contact-form-function.php',
                    type: 'POST',
                    dataType: 'html',
                    data: $(form).serialize(),
                    success: function(data) {
                        alert(data);
                        if(data == "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>")
                        {
                          // Reset the button text
                          submitButton.prop('disabled', false).html('Send Message <i class="flat flaticon-plane"></i>');
                            
                          // Show the success message and hide it after 3 seconds
                          msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                        }
                        else{
                        // Show the success message after the "Sending..." text has been displayed for 1.5 seconds
                        setTimeout(function() {
                            // Reset the button text
                            submitButton.prop('disabled', false).html('Send Message <i class="flat flaticon-plane"></i>');
                            
                            // Show the success message and hide it after 3 seconds
                            msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                            
                            // Reset the form
                            //form.reset();
                        }, 100); // Delay of 1 second
                        // Reinitialize recaptcha widget
                        //grecaptcha.reset();
                        }
                        
                    },
                    error: function(e) {
                        console.log("AJAX call failed. Error: " + e);
                        msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                        submitButton.prop('disabled', false).html('Send Message <i class="flat flaticon-plane"></i>');
                    }
                    
                });
                return false; // Prevent the default form submission
            }
        });
    });
</script>



      
</body>

</html>