<link rel="stylesheet" href="<?= BASE_URL ?>/css/site-footer.css" />

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-grid">

      <!-- Col 1: Branding -->
      <div class="footer-col">
        <a href="<?= BASE_URL ?>/home" class="footer-logo">
          <img src="<?= BASE_URL ?>/images/spider-tech.png" class="footer-logo-img" alt="Spider Tech">
        </a>
        <p>Empowering African Tech Innovators since 2020. We build, nurture, and scale the next generation of digital solutions.</p>
        <div class="social-links">
          <?php
            $gm = new GeneralModel($this->db);
            if (empty($contact)) {
              $contact = $gm->getContactDetails();
            }
            $socialLinks = $gm->getSocialLinks();
            foreach ($socialLinks as $sl):
              if (!empty($sl['url']) && $sl['url'] !== '#'):
          ?>
            <a target="_blank" href="<?= htmlspecialchars($sl['url']) ?>" class="social-icon" title="<?= $sl['platform'] ?>">
              <i class="<?= $sl['icon_class'] ?>"></i>
            </a>
          <?php
              endif;
            endforeach;
            if (empty($socialLinks)):
          ?>
            <a target="_blank" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a target="_blank" href="https://x.com/spidertech_hub" class="social-icon" title="Twitter"><i class="fab fa-x-twitter"></i></a>
            <a target="_blank" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" class="social-icon" title="Youtube"><i class="fab fa-youtube"></i></a>
            <a target="_blank" href="https://linkedin.com/company/spider-technologies-limited" class="social-icon" title="Linkedin"><i class="fab fa-linkedin-in"></i></a>
            <a target="_blank" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Col 2: Company -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul class="footer-links">
          <li><a href="<?= BASE_URL ?>/about">About Us</a></li>
          <li><a href="<?= BASE_URL ?>/services">Services</a></li>
          <li><a href="<?= BASE_URL ?>/projects">Projects</a></li>
        </ul>
      </div>

      <!-- Col 3: Community -->
      <div class="footer-col">
        <h4>Community</h4>
        <ul class="footer-links">
          <li><a href="<?= BASE_URL ?>/forum">Forum</a></li>
          <li><a href="<?= BASE_URL ?>/blog">Blog</a></li>
          <li><a href="<?= BASE_URL ?>/events">Events</a></li>
          <li><a href="<?= BASE_URL ?>/trainings">Developer Hub</a></li>
          <li><a href="<?= BASE_URL ?>/blog">Resources</a></li>
        </ul>
      </div>

      <!-- Col 4: Support -->
      <div class="footer-col">
        <h4>Support</h4>
        <ul class="footer-links" style="margin-bottom: 24px;">
          <li><a href="<?= BASE_URL ?>/forum/terms">Privacy Policy</a></li>
          <li><a href="<?= BASE_URL ?>/forum/terms">Terms & Conditions</a></li>
          <li><a href="<?= BASE_URL ?>/faq">FAQ's</a></li>
        </ul>
        <div class="contact-item">
          <span class="material-symbols-outlined" style="font-size: 18px; color: #f48221;">mail</span>
          <a href="mailto:<?= $contact['contact_email'] ?? ''; ?>" style="color: #111111; font-weight: 600; text-decoration: none;"><?= $contact['contact_email'] ?? ''; ?></a>
        </div>
        <div class="contact-item">
          <span class="material-symbols-outlined" style="font-size: 18px; color: #f48221;">call</span>
          <span style="font-weight: 600; color: #111111;"><?= $contact['contact_pno'] ?? ''; ?></span>
        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
      <div>© <?php echo date('Y'); ?> Spider Technologies Limited. All Rights Reserved.</div>
      <div>Made with <span class="heart-icon">❤️</span> in Africa</div>
    </div>
  </div>
</footer>
<script src="<?= BASE_URL ?>/js/popper.min.js"></script>
<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>/js/jquery.validate.js"></script>
<script src="<?= BASE_URL ?>/js/owl.carousel.js"></script>
<script src="<?= BASE_URL ?>/js/owl.custom.js"></script>
<script src="<?= BASE_URL ?>/js/lightbox.js"></script>
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