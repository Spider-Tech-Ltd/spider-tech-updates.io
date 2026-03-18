<footer class="home index-2">
  <div class="container">
    <div class="col-lg-12">
      <div class="row row-safari">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="section_heading">
            <h2>Contact Info</h2>
              <div class="separator left-align">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
          </div>
          <div class="contact_info">
             <ul>
               <li>
                 <div class="icon">
                   <i class="flat flaticon-facebook-placeholder-for-locate-places-on-maps"></i>
                 </div>
                 <div class="detail">
                   <h5>Address</h5>
                   <div class="content">
                       Head Office : <span class="value"> <?php echo stripslashes($fetch_contact['contact_address']); ?></span>
                   </div>
                 </div>
               </li>
               <li>
                 <div class="icon">
                   <i class="flat flaticon-phone-receiver"></i>
                 </div>
                 <div class="detail">
                   <h5>Call Us On</h5>
                   <div class="content">
                      Main Office : <span class="value"><?php echo stripslashes($fetch_contact['contact_pno']); ?></span> <br /> 
                      
                   </div>
                 </div>
               </li>
               <li>
                 <div class="icon">
                   <i class="flat flaticon-mail-black-envelope-symbol"></i>
                 </div>
                  <div class="detail">
                   <h5>Mail Us On</h5>
                   <div class="content">
                      Customer Support : <span class="value"><a href="javascript:void(0)" title="<?= $fetch_contact['contact_email']; ?>"><?= $fetch_contact['contact_email']; ?></a></span><br />
                   </div>
                 </div>
               </li>
               <li>
                 <div class="icon">
                   <i class="flat flaticon-share"></i>
                 </div>
                 <div class="detail">
                   <h5>Follow Us On</h5>
                   <div class="content">
                      <a target="_blank" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" title="Facebook" ><i class="fab fa-facebook-f"></i></a>
                      <a href="javascript:void(0)" title="Twitter" ><i class="fab fa-twitter"></i></a>
                      <a target="_blank" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" title="Youtube" ><i class="fab fa-youtube"></i></a>
                      <a href="javascript:void(0)" title="Linkedin" ><i class="fab fa-linkedin-in"></i></a>
                      <a target="_blank" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" title="Instagram" ><i class="fab fa-instagram"></i></a>
                   </div>
                 </div>
               </li>
             </ul>    
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
           <div class="section_heading">
            <h2>Contact Form</h2>
              <div class="separator left-align">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
          </div>
           <div class="contact-form">
              <form id="footerForm" action="" method="post">
                <div class="col-lg-12 col-md-6 mb10" id="footerMessage">
                  <?php if(!empty($success_msg)) { echo $success_msg; } ?>
                </div>
                <div class="form-group">
                  <input name="name" type="text" placeholder="Full Name" value="<?php if (isset($_POST['send']) && !empty($name)) { echo $name; } ?>" />
                </div>
                <div class="form-group">
                  <input name="email" type="text" placeholder="Email" value="<?php if (isset($_POST['send']) && !empty($email)) { echo $email; } ?>" />
                </div>
                <div class="form-group">
                  <input name="subject" type="text" placeholder="Subject" value="<?php if (isset($_POST['send']) && !empty($subject)) { echo $subject; } ?>" />
                </div>
                <div class="form-group">
                  <textarea name="message" placeholder="Message"><?php if (isset($_POST['send']) && !empty($message)) { echo $message; } ?></textarea>
                </div>
                <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div>
                </div>
                <div class="form-group">
                  <button id="send" name="send" type="submit">Submit</button>
                </div>
              </form>
           </div>
        </div>
      </div>
    </div>
  </div>
<div class="bottom">
    <div class="container">
      <div class="navigation">
         <ul>
          <li><a href="index.php" title="Homepage">Home</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="about-us.php" title="About Us">About Us</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="services.php" title="Services">Services</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="projects.php" title="Projects">Project</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="trainings.php" title="Trainings">Trainings</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <hr />
    <div class="container">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 copyright">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> Copyright &copy;<span id="copyright-year"></span> 
            <span class="separator-pipesign white"></span>
            All Rights Reserved
            <span class="separator-pipesign white"></span>
            <a href="#"></a></div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right"> <a href="javascript:void(0)">Privacy Policy</a>
            <span class="separator-pipesign white"></span>
            <a href="javascript:void(0)">Terms &amp; Conditions</a>
            <span class="separator-pipesign white"></span>
            <a href="faq.php">FAQ's</a> </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#footerForm").validate({
            rules: {
                name: { required: true },
                email: { required: true },          
                subject: { required: true },
                message: { required: true },
            },
            messages: {
                name: { required: "<font color='#FF0000'>Name is required!</font>" },
                email: { required: "<font color='#FF0000'>Email is required!</font>" },
                subject: { required: "<font color='#FF0000'>Subject is required!</font>" },
                message: { required: "<font color='#FF0000'>Message is required!</font>" },                    
            },
            submitHandler: function(form) {
                var sendButton = $("#send");
                var msg = $('#footerMessage');

                // Disable button and show sending state
                sendButton.prop('disabled', true).html('Submitting...');

                $.ajax({
                    url: 'includes/footer-form-function.php',
                    type: 'POST',
                    dataType: 'html',
                    data: $(form).serialize(),
                    success: function(data) {
                        // Show the success message after the "Sending..." text has been displayed for 1.5 seconds
                      if(data == "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>")
                      {
                        setTimeout(function() {
                            // Reset the button text
                            sendButton.prop('disabled', false).html('Submit');
                            
                            // Show the success message and hide it after 3 seconds
                            msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                            
                            // Reset the form
                            //form.reset();
                        }, 1000); // Delay of 1 second
                      }
                      else
                      {
                        setTimeout(function() {
                            // Reset the button text
                            sendButton.prop('disabled', false).html('Submit');
                            
                            // Show the success message and hide it after 3 seconds
                            msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                            
                            // Reset the form
                            form.reset();
                        }, 1000); // Delay of 1 second
                        // Reinitialize recaptcha widget
                        grecaptcha.reset();
                      }
                    },
                    error: function(e) {
                        console.log("AJAX call failed. Error: " + e);
                        msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                        sendButton.prop('disabled', false).html('Submit');
                    }
                    
                });
                return false; // Prevent the default form submission
            }
        });
    });
</script>
<script>
    // JavaScript to update the copyright year dynamically
    document.addEventListener('DOMContentLoaded', function() {
        const currentYear = new Date().getFullYear();
        document.getElementById('copyright-year').textContent = currentYear;
    });
</script>
