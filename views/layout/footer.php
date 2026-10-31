<link rel="stylesheet" href="<?= BASE_URL ?>/css/site-footer.css" />

<?php
  $gm = new GeneralModel($this->db);
  if (empty($contact)) {
    $contact = $gm->getContactDetails();
  }
  $socialLinks = $gm->getSocialLinks();
  $footerEmail = trim($contact['contact_email'] ?? 'info@spidertech.com.ng');
  $footerPhone = trim($contact['contact_pno'] ?? '+234 9116265708');
  $footerAddress = trim($contact['contact_address'] ?? 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano');
?>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-grid">

      <!-- Col 1: Branding -->
      <div class="footer-col footer-col-brand">
        <a href="<?= BASE_URL ?>/home" class="footer-logo" aria-label="Spider Technologies Limited Home">
          <img src="<?= BASE_URL ?>/images/spider-tech.png" class="footer-logo-img" alt="Spider Tech">
        </a>
        <p class="footer-brand-desc">Empowering African Tech Innovators since 2020. We build, nurture, and scale the next generation of digital solutions.</p>
        <div class="social-links">
          <?php
            $renderedSocial = false;
            if (!empty($socialLinks)):
              foreach ($socialLinks as $sl):
                if (!empty($sl['url']) && $sl['url'] !== '#'):
                  $renderedSocial = true;
          ?>
            <a target="_blank" rel="noopener noreferrer" href="<?= htmlspecialchars($sl['url']) ?>" class="social-icon" title="<?= htmlspecialchars($sl['platform']) ?>" aria-label="<?= htmlspecialchars($sl['platform']) ?>">
              <i class="<?= htmlspecialchars($sl['icon_class']) ?>" aria-hidden="true"></i>
            </a>
          <?php
                endif;
              endforeach;
            endif;
            if (!$renderedSocial):
          ?>
            <a target="_blank" rel="noopener noreferrer" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" class="social-icon" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://x.com/spidertech_hub" class="social-icon" title="X (Twitter)" aria-label="X (Twitter)"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" class="social-icon" title="YouTube" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://linkedin.com/company/spider-technologies-limited" class="social-icon" title="LinkedIn" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" class="social-icon" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Col 2: Company -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul class="footer-links">
          <li><a href="<?= BASE_URL ?>/about">About Us</a></li>
          <li><a href="<?= BASE_URL ?>/services">Our Services</a></li>
          <li><a href="<?= BASE_URL ?>/projects">Projects</a></li>
          <li><a href="<?= BASE_URL ?>/trainings">Trainings</a></li>
          <li><a href="<?= BASE_URL ?>/contact">Contact Us</a></li>
        </ul>
      </div>

      <!-- Col 3: Community & Resources -->
      <div class="footer-col">
        <h4>Community</h4>
        <ul class="footer-links">
          <li><a href="<?= BASE_URL ?>/forum">Community Forum</a></li>
          <li><a href="<?= BASE_URL ?>/blog">Tech Blog</a></li>
          <li><a href="<?= BASE_URL ?>/events">Events</a></li>
          <li><a href="<?= BASE_URL ?>/trainings">Developer Hub</a></li>
          <li><a href="<?= BASE_URL ?>/faq">FAQ's</a></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Support -->
      <div class="footer-col">
        <h4>Get In Touch</h4>
        <div class="footer-contact-list">
          <?php if ($footerAddress !== ''): ?>
          <div class="contact-item">
            <span class="contact-icon-wrap" aria-hidden="true">
              <span class="material-symbols-outlined">location_on</span>
            </span>
            <span class="contact-text"><?= htmlspecialchars($footerAddress); ?></span>
          </div>
          <?php endif; ?>
          <?php if ($footerEmail !== ''): ?>
          <div class="contact-item">
            <span class="contact-icon-wrap" aria-hidden="true">
              <span class="material-symbols-outlined">mail</span>
            </span>
            <a href="mailto:<?= htmlspecialchars($footerEmail); ?>" class="contact-link"><?= htmlspecialchars($footerEmail); ?></a>
          </div>
          <?php endif; ?>
          <?php if ($footerPhone !== ''): ?>
          <div class="contact-item">
            <span class="contact-icon-wrap" aria-hidden="true">
              <span class="material-symbols-outlined">call</span>
            </span>
            <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $footerPhone)); ?>" class="contact-link"><?= htmlspecialchars($footerPhone); ?></a>
          </div>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
      <div class="footer-copyright">© <?php echo date('Y'); ?> Spider Technologies Limited. All Rights Reserved.</div>
      <div class="footer-bottom-right">
        <a href="<?= BASE_URL ?>/forum/terms" class="footer-bottom-link">Privacy Policy</a>
        <span class="footer-bottom-sep" aria-hidden="true">&bull;</span>
        <a href="<?= BASE_URL ?>/forum/terms" class="footer-bottom-link">Terms &amp; Conditions</a>
        <span class="footer-bottom-sep" aria-hidden="true">&bull;</span>
        <span class="footer-made-in">Made with <span class="heart-icon">❤️</span> in Africa</span>
      </div>
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