
<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-title">Get in <span>Touch</span></h1>
                <div class="breadcrumb-custom">
                    <div class="breadcrumb-item-custom">
                        <a href="<?= BASE_URL ?>/">Home</a>
                    </div>
                    <div class="breadcrumb-separator"></div>
                    <div class="breadcrumb-item-custom active">
                        Contact Us
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Contact Section ====== -->
<section class="section-padding">
    <div class="container">

        <!-- Section Header -->
        <div class="row justify-content-between align-items-end mb-5">
            <div class="col-lg-6">
                <span class="tag-eyebrow">Let's Talk</span>
                <h2 class="section-title">We'd Love to <span>Hear From You</span></h2>
                <p class="section-subtitle">Whether you have a project in mind, a question, or just want to say hello — our team is ready to help.</p>
            </div>
        </div>

        <!-- Form + Map Row -->
        <div class="row g-4 align-items-stretch">

            <!-- Contact Form -->
            <div class="col-lg-6 col-md-12">
                <div class="contact-form-wrap">
                    <span class="form-label-eyebrow">Send a Message</span>
                    <form id="contactForm" action="" method="post" novalidate>
                        <div id="contactMessage"></div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 contact-mb">
                                <input
                                    name="name"
                                    type="text"
                                    class="contact-input"
                                    placeholder="Full Name"
                                    required />
                            </div>
                            <div class="col-lg-6 col-md-6 contact-mb">
                                <input
                                    name="email"
                                    type="email"
                                    class="contact-input"
                                    placeholder="Email Address"
                                    required />
                            </div>
                            <div class="col-lg-6 col-md-6 contact-mb">
                                <input
                                    name="phone"
                                    type="text"
                                    class="contact-input"
                                    placeholder="Phone Number" />
                            </div>
                            <div class="col-lg-6 col-md-6 contact-mb">
                                <input
                                    name="subject"
                                    type="text"
                                    class="contact-input"
                                    placeholder="Subject"
                                    required />
                            </div>
                            <div class="col-lg-12 contact-mb">
                                <textarea
                                    name="message"
                                    class="contact-input"
                                    placeholder="Your Message"
                                    required></textarea>
                            </div>
                            <div class="col-lg-12 contact-mb">
                                <div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" id="sendContact" name="send" class="cta-button">
                                    Send Message
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
                    <div>
                        <p class="contact-info-label">Our Location</p>
                        <p class="contact-info-value">Abinsa House, Kaduna, Nigeria</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div>
                        <p class="contact-info-label">Email Us</p>
                        <p class="contact-info-value">info@spidertechltd.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div>
                        <p class="contact-info-label">Working Hours</p>
                        <p class="contact-info-value">Mon – Fri, 8:00am – 5:00pm</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ====== Premium CTA Block ====== -->
<section class="section-padding pt-0">
    <div class="container">
        <div class="premium-cta">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="tag-eyebrow tag-eyebrow-light">Partner With Us</span>
                    <h2 class="section-title text-white">Ready to Build Something <span>Extraordinary?</span></h2>
                    <p class="section-subtitle mx-auto text-white opacity-75 mb-5 fs-18">
                        From enterprise platforms to community-driven apps, we turn ambitious ideas into elegant digital realities. Let's collaborate.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="<?= BASE_URL ?>/services" class="cta-button" class="w-auto">
                            Explore Our Services
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="<?= BASE_URL ?>/projects" class="cta-button cta-button-outline" class="w-auto">
                            View Our Projects
                            <span class="material-symbols-outlined">folder_open</span>
                        </a>
                    </div>
                    <div class="mt-4">
                        <span class="text-orange fs-14 fw-bold text-uppercase" class="ls-15">
                            <span class="material-symbols-outlined fs-18" class="v-align-middle mr-4">verified</span>
                            Industry Recognized Professional Standards
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Form Submission Script ====== -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#contactForm").submit(function (e) {
            e.preventDefault();
            var btn = $("#sendContact");
            var msg = $("#contactMessage");

            btn.prop('disabled', true).html('Sending... <span class="material-symbols-outlined fs-18" class="v-align-middle">hourglass_top</span>');

            $.ajax({
                url: '<?= BASE_URL ?>/includes/contact-form-function.php',
                type: 'POST',
                data: $(this).serialize() + '&send=1',
                success: function (data) {
                    btn.prop('disabled', false).html('Send Message <span class="material-symbols-outlined">send</span>');
                    msg.html(data).fadeIn().delay(6000).fadeOut();
                    if (data.indexOf('alert-success') !== -1) {
                        $("#contactForm")[0].reset();
                        if (typeof grecaptcha !== 'undefined') grecaptcha.reset();
                    }
                },
                error: function () {
                    btn.prop('disabled', false).html('Send Message <span class="material-symbols-outlined">send</span>');
                    msg.html('<div class="alert alert-danger">Something went wrong. Please try again.</div>').fadeIn().delay(6000).fadeOut();
                }
            });
        });
    });
</script>

<!-- ====== Newsletter Module ====== -->
<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
