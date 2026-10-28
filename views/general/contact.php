<link rel="stylesheet" href="<?= BASE_URL ?>/css/contact.css?v=<?= filemtime(ROOT_PATH . '/css/contact.css') ?>" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Get in <span>Touch</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom">
                            <a href="<?= BASE_URL ?>/">Home</a>
                        </li>
                        <li class="breadcrumb-item-custom active" aria-current="page">
                            Contact Us
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- ====== Contact Section ====== -->
<section class="section-padding contact-page-section">
    <div class="container">

        <!-- Section Header -->
        <div class="row justify-content-between align-items-end mb-4">
            <div class="col-lg-7">
                <span class="section-eyebrow">
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    </svg>
                    <span class="eyebrow-label-text">Let's Talk</span>
                    <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                        <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    </svg>
                </span>
                <br>
                <h2 class="contact-section-title">We'd Love to <span>Hear From You</span></h2>
                <p class="contact-section-subtitle">Whether you have an enterprise engineering challenge, a technical question, or an innovation idea — our team is ready to collaborate.</p>
            </div>
        </div>

        <!-- Form + Map Row -->
        <div class="row g-4 align-items-stretch">

            <!-- Contact Form -->
            <div class="col-lg-6 col-md-12">
                <div class="contact-form-wrap">
                    <div class="form-header-row mb-3">
                        <span class="form-label-eyebrow">Send a Direct Message</span>
                        <p class="text-muted small mb-0">Fill in the fields below and our team will get back to you within 24 hours.</p>
                    </div>
                    <form id="contactForm" action="" method="post" novalidate>
                        <div id="contactMessage"></div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input
                                        name="name"
                                        type="text"
                                        class="contact-input"
                                        placeholder="e.g. John Doe"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input
                                        name="email"
                                        type="email"
                                        class="contact-input"
                                        placeholder="e.g. john@example.com"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">Phone Number</label>
                                    <input
                                        name="phone"
                                        type="text"
                                        class="contact-input"
                                        placeholder="e.g. +234 800 000 0000" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input
                                        name="subject"
                                        type="text"
                                        class="contact-input"
                                        placeholder="e.g. Project Consultation"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label class="form-label">Your Message <span class="text-danger">*</span></label>
                                    <textarea
                                        name="message"
                                        class="contact-input"
                                        placeholder="Tell us about your project or inquiry..."
                                        rows="4"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" id="sendContact" name="send" class="cta-button">
                                    <span>Send Message</span>
                                    <span class="material-symbols-outlined">send</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Google Map -->
            <div class="col-lg-6 col-md-12">
                <div class="contact-map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3903.003920638522!2d8.527376073868246!3d11.97420553637172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x11ae7721df2669e9%3A0xc6ed7693596954a2!2sAbinsa%20House!5e0!3m2!1sen!2sng!4v1722339383618!5m2!1sen!2sng"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Spider Tech Limited Office Location">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Contact Info Cards Strip -->
        <div class="row g-4 contact-info-strip">
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <div class="contact-info-text">
                        <p class="contact-info-label">Office Headquarters</p>
                        <p class="contact-info-value">Abinsa House, Zaria Road, Kano, Nigeria</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div class="contact-info-text">
                        <p class="contact-info-label">Direct Inquiries</p>
                        <p class="contact-info-value"><a href="mailto:info@spidertechltd.com">info@spidertechltd.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div class="contact-info-text">
                        <p class="contact-info-label">Operating Hours</p>
                        <p class="contact-info-value">Mon – Fri: 8:00 AM – 5:00 PM (WAT)</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ====== Premium CTA Block ====== -->
<section class="section-padding pt-0 contact-cta-section">
    <div class="container">
        <div class="premium-cta">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 mb-3 mb-lg-0 text-lg-left text-center">
                    <span class="section-eyebrow cta-eyebrow">
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                            <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="rgba(255,255,255,0.4)"/>
                        </svg>
                        <span class="eyebrow-label-text">Partner With Us</span>
                        <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="rgba(255,255,255,0.4)"/>
                            <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                        </svg>
                    </span>
                    <h2 class="premium-cta-title">Ready to Build Something <span>Extraordinary?</span></h2>
                    <p class="premium-cta-desc">
                        From enterprise platforms to community ecosystems, we transform complex challenges into scalable, reliable digital reality.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-right text-center d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    <a href="<?= BASE_URL ?>/services" class="cta-button" style="width: auto;">
                        <span>Explore Services</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Form Submission Script ====== -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#contactForm").submit(function(e) {
            e.preventDefault();
            var btn = $("#sendContact");
            var msg = $("#contactMessage");

            btn.prop('disabled', true).html('<span>Sending...</span> <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;">hourglass_top</span>');

            $.ajax({
                url: '<?= BASE_URL ?>/includes/contact-form-function.php',
                type: 'POST',
                data: $(this).serialize() + '&send=1',
                success: function(data) {
                    btn.prop('disabled', false).html('<span>Send Message</span> <span class="material-symbols-outlined">send</span>');
                    msg.html(data).fadeIn().delay(6000).fadeOut();
                    if (data.indexOf('alert-success') !== -1) {
                        $("#contactForm")[0].reset();
                        if (typeof grecaptcha !== 'undefined') grecaptcha.reset();
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<span>Send Message</span> <span class="material-symbols-outlined">send</span>');
                    msg.html('<div class="alert alert-danger">Something went wrong. Please try again.</div>').fadeIn().delay(6000).fadeOut();
                }
            });
        });
    });
</script>

<!-- ====== Newsletter Module ====== -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
