<style>
    /* ====================================================
       CONTACT PAGE — Industrial-Grade Design System
       Consistent with Events & Projects pages
    ==================================================== */
    :root {
        --primary-orange: #f48221;
        --dark-bg: #111111;
        --text-body: #374151;
        --text-muted: #888888;
        --card-bg: #ffffff;
        --border-light: #f0f0f0;
    }

    /* ====== Page Header ====== */
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('<?= BASE_URL ?>/images/bg/inner-banner.jpg') center/cover;
        background-color: var(--dark-bg);
        padding: 140px 0 80px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .page-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(244, 130, 33, 0.05) 0%, transparent 60%);
        pointer-events: none;
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 3.8rem);
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }

    .page-title span {
        color: var(--primary-orange);
    }

    /* ====== Professional Breadcrumbs ====== */
    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 15px;
    }

    .breadcrumb-item-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .breadcrumb-item-custom a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item-custom a:hover {
        color: var(--primary-orange);
    }

    .breadcrumb-item-custom.active {
        color: var(--primary-orange);
    }

    .breadcrumb-separator {
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ====== Section Utilities ====== */
    .section-padding {
        padding: 120px 0;
    }

    .tag-eyebrow {
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .tag-eyebrow-light {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.85);
    }

    .contact-section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--dark-bg);
        margin-bottom: 1rem;
        letter-spacing: -1.5px;
        line-height: 1.2;
    }

    .contact-section-title span {
        color: var(--primary-orange);
    }

    .contact-section-subtitle {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        max-width: 560px;
        margin-bottom: 0;
    }

    /* ====== Contact Form Card ====== */
    .contact-form-wrap {
        background: var(--card-bg);
        border: 1px solid var(--border-light);
        border-radius: 30px;
        padding: 45px 40px;
        height: 100%;
        transition: box-shadow 0.4s ease;
    }

    .contact-form-wrap:hover {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        border-color: rgba(244, 130, 33, 0.15);
    }

    .form-label-eyebrow {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary-orange);
        margin-bottom: 1.5rem;
        display: block;
    }

    /* ====== Form Inputs ====== */
    .contact-input {
        width: 100%;
        border: 1.5px solid #e8e8e8;
        border-radius: 14px;
        padding: 14px 18px;
        font-size: 0.95rem;
        color: var(--text-body);
        background: #fafafa;
        transition: all 0.3s ease;
        outline: none;
        font-family: inherit;
        display: block;
        margin-bottom: 0;
    }

    .contact-input:focus {
        border-color: var(--primary-orange);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.08);
    }

    .contact-input::placeholder {
        color: #bbb;
        font-size: 0.9rem;
    }

    textarea.contact-input {
        resize: vertical;
        min-height: 140px;
    }

    .contact-mb {
        margin-bottom: 18px;
    }

    /* ====== Submit Button ====== */
    .cta-button {
        background: var(--primary-orange);
        color: #fff;
        padding: 16px 36px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.4s ease;
        text-decoration: none !important;
        font-size: 0.95rem;
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.3);
        border: none;
        cursor: pointer;
        width: 100%;
        justify-content: center;
    }

    .cta-button:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(244, 130, 33, 0.4);
        background: #e6751c;
        color: #fff;
    }

    .cta-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .cta-button .material-symbols-outlined {
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .cta-button:hover .material-symbols-outlined {
        transform: translateX(4px);
    }

    /* ====== Alert Message ====== */
    #contactMessage .alert {
        border-radius: 14px;
        font-size: 0.9rem;
        margin-bottom: 20px;
        border: none;
    }

    #contactMessage .alert-success {
        background: rgba(40, 167, 69, 0.08);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
    }

    #contactMessage .alert-danger {
        background: rgba(220, 53, 69, 0.08);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.15);
    }

    /* ====== Map Wrapper ====== */
    .contact-map-wrap {
        border-radius: 30px;
        overflow: hidden;
        height: 100%;
        min-height: 460px;
        border: 1px solid var(--border-light);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .contact-map-wrap iframe {
        width: 100%;
        height: 100%;
        min-height: 460px;
        border: 0;
        display: block;
    }

    /* ====== Contact Info Strip ====== */
    .contact-info-strip {
        margin-top: 60px;
    }

    .contact-info-card {
        background: var(--card-bg);
        border: 1px solid var(--border-light);
        border-radius: 24px;
        padding: 30px 28px;
        height: 100%;
        display: flex;
        align-items: flex-start;
        gap: 18px;
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .contact-info-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
        border-color: rgba(244, 130, 33, 0.2);
    }

    .contact-info-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: rgba(244, 130, 33, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .contact-info-card:hover .contact-info-icon {
        background: var(--primary-orange);
        color: #ffffff;
    }

    .contact-info-icon .material-symbols-outlined {
        font-size: 1.5rem;
    }

    .contact-info-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .contact-info-value {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        color: var(--dark-bg);
        line-height: 1.4;
        margin: 0;
    }

    /* ====== Premium CTA Block ====== */
    .premium-cta {
        background: var(--dark-bg);
        border-radius: 40px;
        padding: 70px 40px;
        position: relative;
        overflow: hidden;
        text-align: center;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1);
    }

    .premium-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 10% 20%, rgba(244, 130, 33, 0.1) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(244, 130, 33, 0.1) 0%, transparent 40%);
        pointer-events: none;
    }

    .premium-cta-title {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1.25rem;
        letter-spacing: -1px;
    }

    .premium-cta-title span {
        color: var(--primary-orange);
    }

    .premium-cta-subtitle {
        color: rgba(255, 255, 255, 0.65);
        font-size: 1.05rem;
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }

    .cta-button-outline {
        background: transparent;
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        box-shadow: none;
    }

    .cta-button-outline:hover {
        background: rgba(255, 255, 255, 0.08);
        box-shadow: none;
        color: #fff;
    }

    /* ====== Responsive ====== */
    @media (max-width: 991px) {
        .page-header {
            padding: 120px 0 60px;
        }

        .section-padding {
            padding: 80px 0;
        }

        .contact-form-wrap {
            padding: 35px 28px;
            margin-bottom: 30px;
        }

        .contact-map-wrap,
        .contact-map-wrap iframe {
            min-height: 340px;
        }

        .contact-section-title {
            font-size: 2.2rem;
        }

        .premium-cta {
            padding: 60px 28px;
        }
    }

    @media (max-width: 576px) {
        .contact-form-wrap {
            padding: 28px 20px;
        }

        .premium-cta {
            border-radius: 28px;
            padding: 50px 20px;
        }
    }
</style>

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
                <h2 class="contact-section-title">We'd Love to <span>Hear From You</span></h2>
                <p class="contact-section-subtitle">Whether you have a project in mind, a question, or just want to say hello — our team is ready to help.</p>
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
                    <h2 class="premium-cta-title">Ready to Build Something <span>Extraordinary?</span></h2>
                    <p class="premium-cta-subtitle">
                        From enterprise platforms to community-driven apps, we turn ambitious ideas into elegant digital realities. Let's collaborate.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="<?= BASE_URL ?>/services" class="cta-button" style="width: auto;">
                            Explore Our Services
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="<?= BASE_URL ?>/projects" class="cta-button cta-button-outline" style="width: auto;">
                            View Our Projects
                            <span class="material-symbols-outlined">folder_open</span>
                        </a>
                    </div>
                    <div class="mt-4">
                        <span style="color: var(--primary-orange); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px;">
                            <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px; margin-right: 4px;">verified</span>
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

            btn.prop('disabled', true).html('Sending... <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;">hourglass_top</span>');

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
