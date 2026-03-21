<?php
/**
 * Global Footer Section — Phase 7 Redesign
 * Features: Minimalist 4-Column Grid, Brand Navigation, Social Integration, Africa Pride
 * Generated via Stitch Design Principles & Brand Alliance
 */
?>

<style>
  /* ====== Modern Footer Reset & Base ====== */
  .site-footer {
    background-color: #ffffff;
    padding: 80px 0 40px 0;
    font-family: 'Open Sans', sans-serif;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    color: #555555;
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
    gap: 40px;
    margin-bottom: 60px;
  }

  /* Column Typography */
  .footer-col h4 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #111111;
    margin-bottom: 24px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .footer-col p {
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 24px;
  }

  /* Footer Links */
  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .footer-links li {
    margin-bottom: 12px;
  }
  .footer-links a {
    color: #555555;
    text-decoration: none !important;
    font-size: 0.9rem;
    transition: color 0.3s;
  }
  .footer-links a:hover {
    color: #f48221;
  }

  /* Branding & Social */
  .footer-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    text-decoration: none !important;
  }
  .footer-logo-icon {
    width: 32px;
    height: 32px;
    background-color: #f48221;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
  }
  .footer-logo-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    color: #111111;
  }

  .social-links {
    display: flex;
    gap: 12px;
  }
  .social-icon {
    width: 36px;
    height: 36px;
    border: 1px solid #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #555555;
    transition: all 0.3s;
    text-decoration: none !important;
  }
  .social-icon:hover {
    background-color: #f48221;
    border-color: #f48221;
    color: #ffffff;
    transform: translateY(-3px);
  }

  /* Contact Specifics */
  .contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 0.9rem;
  }
  .contact-item i {
    color: #f48221;
    font-size: 1.1rem;
  }
  .contact-item span {
    font-weight: 600;
    color: #111111;
  }

  /* Bottom Bar */
  .footer-bottom {
    border-top: 1px solid #edf2f7;
    padding-top: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #718096;
  }
  .heart-icon { color: #f48221; }

  /* Responsive Adjustments */
  @media (max-width: 992px) {
    .footer-grid { grid-template-columns: 1fr 1fr; }
  }
  @media (max-width: 576px) {
    .footer-grid { grid-template-columns: 1fr; gap: 40px; }
    .footer-bottom { flex-direction: column; gap: 16px; text-align: center; }
  }
</style>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-grid">
      
      <!-- Col 1: Branding -->
      <div class="footer-col">
        <a href="index.php" class="footer-logo">
          <div class="footer-logo-icon">
            <span class="material-symbols-outlined" style="font-size: 20px;">hub</span>
          </div>
          <span class="footer-logo-text">Spider Tech</span>
        </a>
        <p>Empowering African Tech Innovators since 2020. We build, nurture, and scale the next generation of digital solutions.</p>
        <div class="social-links">
          <a target="_blank" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="javascript:void(0)" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a target="_blank" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" class="social-icon" title="Youtube"><i class="fab fa-youtube"></i></a>
          <a href="javascript:void(0)" class="social-icon" title="Linkedin"><i class="fab fa-linkedin-in"></i></a>
          <a target="_blank" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Col 2: Company -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul class="footer-links">
          <li><a href="about-us.php">About Us</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="projects.php">Projects</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press Kit</a></li>
        </ul>
      </div>

      <!-- Col 3: Community -->
      <div class="footer-col">
        <h4>Community</h4>
        <ul class="footer-links">
          <li><a href="pages/forum/index.php">Forum</a></li>
          <li><a href="pages/blog/index.php">Blog</a></li>
          <li><a href="upcoming-events.php">Upcoming Events</a></li>
          <li><a href="#">Developer Hub</a></li>
          <li><a href="#">Resources</a></li>
        </ul>
      </div>

      <!-- Col 4: Support -->
      <div class="footer-col">
        <h4>Support</h4>
        <ul class="footer-links" style="margin-bottom: 24px;">
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="faq.php">FAQ's</a></li>
        </ul>
        <div class="contact-item">
          <span class="material-symbols-outlined" style="font-size: 18px; color: #f48221;">mail</span>
          <a href="mailto:<?= $fetch_contact['contact_email']; ?>" style="color: #111111; font-weight: 600; text-decoration: none;"><?= $fetch_contact['contact_email']; ?></a>
        </div>
        <div class="contact-item">
          <span class="material-symbols-outlined" style="font-size: 18px; color: #f48221;">call</span>
          <span style="font-weight: 600; color: #111111;"><?= $fetch_contact['contact_pno']; ?></span>
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
