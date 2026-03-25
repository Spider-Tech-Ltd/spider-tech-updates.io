<footer class="home index-2">
  <div class="container">
    <div class="col-lg-12">
      <div class="row row-safari">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="section_heading">
            <h2>Contact Info</h2>
              <div class="separator left-align"><ul><li></li><li></li><li></li></ul></div>
          </div>
          <div class="contact_info">
             <ul>
               <li><div class="icon"><i class="flat flaticon-facebook-placeholder-for-locate-places-on-maps"></i></div><div class="detail"><h5>Address</h5><div class="content">Head Office : <span class="value"> <?= $contact['contact_address'] ?? ''; ?></span></div></div></li>
               <li><div class="icon"><i class="flat flaticon-phone-receiver"></i></div><div class="detail"><h5>Call Us On</h5><div class="content">Main Office : <span class="value"><?= $contact['contact_pno'] ?? ''; ?></span></div></div></li>
               <li><div class="icon"><i class="flat flaticon-mail-black-envelope-symbol"></i></div><div class="detail"><h5>Mail Us On</h5><div class="content">Customer Support : <span class="value"><a href="javascript:void(0)" title="<?= $contact['contact_email'] ?? ''; ?>"><?= $contact['contact_email'] ?? ''; ?></a></span></div></div></li>
               <li><div class="icon"><i class="flat flaticon-share"></i></div><div class="detail"><h5>Follow Us On</h5><div class="content">
                      <a target="_blank" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" title="Facebook" ><i class="fab fa-facebook-f"></i></a>
                      <a href="javascript:void(0)" title="Twitter" ><i class="fab fa-twitter"></i></a>
                      <a target="_blank" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" title="Youtube" ><i class="fab fa-youtube"></i></a>
                      <a href="javascript:void(0)" title="Linkedin" ><i class="fab fa-linkedin-in"></i></a>
                      <a target="_blank" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" title="Instagram" ><i class="fab fa-instagram"></i></a>
                   </div></div></li>
             </ul>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
           <div class="section_heading"><h2>Contact Form</h2><div class="separator left-align"><ul><li></li><li></li><li></li></ul></div></div>
           <div class="contact-form">
              <form id="footerForm" action="" method="post">
                <div class="col-lg-12 col-md-6 mb10" id="footerMessage"></div>
                <div class="form-group"><input name="name" type="text" placeholder="Full Name" /></div>
                <div class="form-group"><input name="email" type="text" placeholder="Email" /></div>
                <div class="form-group"><input name="subject" type="text" placeholder="Subject" /></div>
                <div class="form-group"><textarea name="message" placeholder="Message"></textarea></div>
                <div class="form-group"><div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div></div>
                <div class="form-group"><button id="send" name="send" type="submit">Submit</button></div>
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
          <li><a href="<?= BASE_URL ?>/home" title="Homepage">Home</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="<?= BASE_URL ?>/about" title="About Us">About Us</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="<?= BASE_URL ?>/services" title="Services">Services</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="<?= BASE_URL ?>/projects" title="Projects">Project</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a></li>
          <li class="separator-pipesign white"></li>
          <li><a href="<?= BASE_URL ?>/contact" title="Contact Us">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <hr />
    <div class="container">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 copyright">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> Copyright &copy;<span id="copyright-year"></span> <span class="separator-pipesign white"></span> All Rights Reserved</div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right"> <a href="javascript:void(0)">Privacy Policy</a><span class="separator-pipesign white"></span><a href="javascript:void(0)">Terms &amp; Conditions</a><span class="separator-pipesign white"></span><a href="<?= BASE_URL ?>/faq">FAQ's</a> </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="<?= BASE_URL ?>/js/jquery-2.2.4.min.js"></script>
<script src="<?= BASE_URL ?>/js/jquery.validate.js"></script>
<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>/js/owl.carousel.min.js"></script>
<script src="<?= BASE_URL ?>/js/lightbox.js"></script>
<script src="<?= BASE_URL ?>/js/wow.min.js"></script>
<script src="<?= BASE_URL ?>/js/custom.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#footerForm").validate({
            rules: { name: { required: true }, email: { required: true }, subject: { required: true }, message: { required: true } },
            messages: { name: { required: "Name is required!" }, email: { required: "Email is required!" }, subject: { required: "Subject is required!" }, message: { required: "Message is required!" } },
            submitHandler: function(form) {
                var sendButton = $("#send");
                var msg = $('#footerMessage');
                sendButton.prop('disabled', true).html('Submitting...');
                $.ajax({
                    url: '<?= BASE_URL ?>/includes/footer-form-function.php',
                    type: 'POST',
                    dataType: 'html',
                    data: $(form).serialize(),
                    success: function(data) {
                        setTimeout(function() {
                            sendButton.prop('disabled', false).html('Submit');
                            msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                            if(!data.includes('alert-danger')) {
                                form.reset();
                                if(typeof grecaptcha !== 'undefined') grecaptcha.reset();
                            }
                        }, 1000);
                    },
                    error: function(e) {
                        msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                        sendButton.prop('disabled', false).html('Submit');
                    }
                });
                return false;
            }
        });
        const currentYear = new Date().getFullYear();
        $('#copyright-year').text(currentYear);
    });
</script>
</body>
</html>