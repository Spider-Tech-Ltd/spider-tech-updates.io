<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>Contact Us</h2>
        <div class="separator left-align"><ul><li></li><li></li><li></li></ul></div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<section id="contact-us" class="index-2 padding">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section_heading">
          <h2>Get in <span>Touch</span></h2>
          <div class="separator"><ul><li></li><li></li><li></li></ul></div>
          <div class="heading_content">We are here to help you. Reach out to us for any inquiries.</div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row row-safari">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 contact-form">
            <form id="contactForm" action="" method="post">
              <div id="contactMessage"></div>
              <div class="row row-safari">
                <div class="col-lg-6 col-md-6 mb10"><input name="name" type="text" placeholder="Full Name" required /></div>
                <div class="col-lg-6 col-md-6 mb10"><input name="email" type="email" placeholder="Email Address" required /></div>
                <div class="col-lg-6 col-md-6 mb10"><input name="phone" type="text" placeholder="Phone Number" /></div>
                <div class="col-lg-6 col-md-6 mb10"><input name="subject" type="text" placeholder="Subject" required /></div>
                <div class="col-lg-12 col-md-12 mb10"><textarea name="message" placeholder="Message" required></textarea></div>
                <div class="col-lg-12 col-md-12 mb10"><div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div></div>
                <div class="col-lg-12 col-md-12 mb10"><button type="submit" id="sendContact" name="send">Send Message</button></div>
              </div>
            </form>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3903.003920638522!2d8.527376073868246!3d11.97420553637172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x11ae7721df2669e9%3A0xc6ed7693596954a2!2sAbinsa%20House!5e0!3m2!1sen!2sng!4v1722339383618!5m2!1sen!2sng" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $("#contactForm").submit(function(e) {
            e.preventDefault();
            var btn = $("#sendContact");
            var msg = $("#contactMessage");
            btn.prop('disabled', true).text('Sending...');
            $.ajax({
                url: '<?= BASE_URL ?>/includes/contact-form-function.php',
                type: 'POST',
                data: $(this).serialize() + '&send=1',
                success: function(data) {
                    btn.prop('disabled', false).text('Send Message');
                    msg.html(data).fadeIn().delay(5000).fadeOut();
                    if(data.indexOf('alert-success') !== -1) {
                        $("#contactForm")[0].reset();
                        if(typeof grecaptcha !== 'undefined') grecaptcha.reset();
                    }
                }
            });
        });
    });
</script>
