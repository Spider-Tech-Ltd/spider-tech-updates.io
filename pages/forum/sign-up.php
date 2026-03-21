<?php
/**
 * Sign-Up Page (sign-up.php) — Phase 8 Redesign
 * Goal: Generate a high-conversion registration page for new industrial professionals.
 * Uses: Bootstrap 4, Vanilla CSS, Material Symbols
 * Follows Existing Architecture from sign-in.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Network | Spider Tech Ltd</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts: Poppins (Headlines), Open Sans (Body), Inter (Technical) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;800&family=Open+Sans:wght@400;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />

    <!-- Font Awesome (for social icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
      /* ======================================
         CORE VARIABLES & RESET
         ====================================== */
      :root {
        --deep-charcoal: #111319;
        --electric-blue: #3b82f6;
        --on-surface: #e2e2eb;
        --on-surface-variant: #94a3b8;
        --surface-container-high: rgba(40, 42, 48, 0.4);
        --brand-orange: #f48221;
      }

      * { margin: 0; padding: 0; box-sizing: border-box; }

      body, html {
        height: 100%;
        font-family: 'Open Sans', sans-serif;
        background-color: var(--deep-charcoal);
        color: var(--on-surface);
        overflow-x: hidden;
      }

      /* ======================================
         LAYOUT: SPLIT-SCREEN
         ====================================== */
      .signup-page {
        display: flex;
        min-height: 100vh;
        width: 100%;
      }

      /* Left Side: Value Proposition (Desktop Only) */
      .signup-visual {
        flex: 1.2;
        background: linear-gradient(135deg, rgba(17, 19, 25, 0.95), rgba(17, 19, 25, 0.8)),
                    url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070');
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px;
        position: relative;
        overflow: hidden;
        border-right: 1px solid rgba(59, 130, 246, 0.1);
      }

      .signup-visual::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
      }

      .visual-content {
        position: relative;
        z-index: 10;
        max-width: 600px;
      }

      .visual-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 3.5rem;
        line-height: 1.1;
        margin-bottom: 48px;
        letter-spacing: -0.02em;
        color: #fff;
      }

      .visual-heading span {
        color: var(--electric-blue);
      }

      .value-props {
        list-style: none;
        padding: 0;
      }

      .prop-item {
        display: flex;
        gap: 24px;
        margin-bottom: 40px;
        align-items: flex-start;
      }

      .prop-icon {
        width: 56px;
        height: 56px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--electric-blue);
        flex-shrink: 0;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      }

      .prop-text h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #fff;
      }

      .prop-text p {
        font-size: 1rem;
        color: var(--on-surface-variant);
        line-height: 1.6;
      }

      /* Right Side: Form Container */
      .signup-form-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        background-color: var(--deep-charcoal);
        position: relative;
      }

      /* ======================================
         REGISTRATION CARD (GLASSMORPHISM)
         ====================================== */
      .signup-card {
        width: 100%;
        max-width: 500px;
        background: var(--surface-container-high);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 32px;
        padding: 56px;
        position: relative;
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.5);
        animation: pulseBorder 5s infinite alternate;
      }

      @keyframes pulseBorder {
        from { border-color: rgba(59, 130, 246, 0.2); box-shadow: 0 32px 64px rgba(0, 0, 0, 0.5); }
        to { border-color: rgba(59, 130, 246, 0.4); box-shadow: 0 32px 64px rgba(59, 130, 246, 0.1); }
      }

      .card-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        margin-bottom: 40px;
      }

      .logo-icon {
        width: 40px;
        height: 40px;
        background: var(--brand-orange);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 4px 10px rgba(244, 130, 33, 0.3);
      }

      .logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--on-surface);
        letter-spacing: -0.02em;
      }

      .logo-text span { color: var(--brand-orange); }

      .card-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 32px;
        margin-bottom: 12px;
        color: #fff;
      }

      .card-subtext {
        color: var(--on-surface-variant);
        font-size: 1rem;
        margin-bottom: 40px;
      }

      /* ======================================
         FORM STYLES (Matching sign-in.php)
         ====================================== */
      .input-pill-wrapper {
        position: relative;
        margin-bottom: 24px;
      }

      .form-label-custom {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--on-surface-variant);
        margin-bottom: 10px;
        padding-left: 4px;
      }

      .input-pill {
        width: 100%;
        background: rgba(12, 14, 20, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 14px;
        padding: 16px 22px;
        color: var(--on-surface);
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }

      .input-pill:focus {
        outline: none;
        border-color: var(--electric-blue);
        background: rgba(12, 14, 20, 0.9);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
      }

      /* Consent Checkbox */
      .consent-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 28px 0;
      }

      .custom-checkbox {
        width: 22px;
        height: 22px;
        border: 2px solid rgba(148, 163, 184, 0.3);
        border-radius: 7px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        background: transparent;
        flex-shrink: 0;
      }

      .custom-checkbox.checked {
        background: var(--electric-blue);
        border-color: var(--electric-blue);
      }

      .custom-checkbox span {
        font-size: 16px;
        color: #fff;
        display: none;
      }

      .custom-checkbox.checked span { display: block; }

      .consent-text {
        font-size: 0.9rem;
        color: var(--on-surface-variant);
        margin-bottom: 0;
      }

      .consent-text a { color: var(--electric-blue); text-decoration: none; font-weight: 600; }
      .consent-text a:hover { text-decoration: underline; }

      /* CTA Button */
      .btn-signup {
        width: 100%;
        background: var(--brand-orange);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 18px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 24px rgba(244, 130, 33, 0.25);
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
      }

      .btn-signup:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(244, 130, 33, 0.4);
        background: #e6751c;
      }

      /* Social Sign-Up */
      .or-divider {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 28px;
      }

      .or-line { flex: 1; height: 1px; background: rgba(148, 163, 184, 0.15); }
      .or-text { font-size: 0.8rem; text-transform: uppercase; color: var(--on-surface-variant); font-weight: 700; letter-spacing: 0.12em; }

      .social-btns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 40px;
      }

      .btn-social {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 14px;
        border-radius: 14px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none !important;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(148, 163, 184, 0.1);
        color: var(--on-surface);
      }

      .btn-social:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--brand-orange);
      }

      .btn-social i { font-size: 1.1rem; }
      .btn-social.btn-linkedin i { color: #0A66C2; }
      .btn-social.btn-google i { color: #DB4437; }

      .footer-link {
        text-align: center;
        font-size: 1rem;
        color: var(--on-surface-variant);
      }

      .footer-link a {
        color: var(--brand-orange);
        font-weight: 700;
        text-decoration: none !important;
      }

      .footer-link a:hover { text-decoration: underline !important; }

      /* Footer Note (Matching sign-in.php) */
      .signin-footer-note {
        position: absolute;
        bottom: 24px;
        left: 0; right: 0;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.8rem;
        color: #94a3b8;
        z-index: 2;
      }

      .signin-footer-note a {
        color: #64748b;
        text-decoration: none !important;
        transition: color 0.2s;
      }

      .signin-footer-note a:hover { color: var(--brand-orange); }
      .signin-footer-note .sep { margin: 0 10px; opacity: 0.5; }

      /* Mobile Adjustments */
      @media (max-width: 1024px) {
        .signup-visual { display: none; }
        .signup-form-container { padding: 30px 20px; }
        .signup-card {
            padding: 40px 24px;
            border-radius: 0;
            min-height: 100vh;
            max-width: 100%;
            border: none;
            box-shadow: none;
            animation: none;
            background: transparent;
        }
        .signin-footer-note { position: static; margin-top: 40px; }
      }
    </style>
</head>
<body>

<div class="signup-page">

    <!-- Left: Value Prop Visual -->
    <div class="signup-visual">
        <div class="visual-content">
            <h1 class="visual-heading">Precision Engineering <span>Starts Here.</span></h1>

            <ul class="value-props">
                <li class="prop-item">
                    <div class="prop-icon"><span class="material-symbols-outlined">hub</span></div>
                    <div class="prop-text">
                        <h3>Exclusive Industry Updates</h3>
                        <p>Direct feeds from our R&D labs and industrial partners, keeping you ahead of the technical curve.</p>
                    </div>
                </li>
                <li class="prop-item">
                    <div class="prop-icon"><span class="material-symbols-outlined">engineering</span></div>
                    <div class="prop-text">
                        <h3>Solve Engineering Challenges</h3>
                        <p>Access proprietary toolsets and collaborative frameworks designed for complex industrial problem-solving.</p>
                    </div>
                </li>
                <li class="prop-item">
                    <div class="prop-icon"><span class="material-symbols-outlined">bolt</span></div>
                    <div class="prop-text">
                        <h3>Accelerate Tech Growth</h3>
                        <p>Tools built for the high-velocity precision of tomorrow, ensuring your infrastructure is future-proof.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right: Form Container -->
    <div class="signup-form-container">
        <div class="signup-card">

            <a href="index.php" class="card-logo">
                <div class="logo-icon"><span class="material-symbols-outlined">hub</span></div>
                <span class="logo-text">Spider <span>Tech</span></span>
            </a>

            <h2 class="card-heading">Join the Network</h2>
            <p class="card-subtext">Get exclusive access to the industrial tech of tomorrow.</p>

            <form id="signupForm" novalidate>
                <div class="input-pill-wrapper">
                    <label class="form-label-custom">Full Name</label>
                    <input type="text" class="input-pill" placeholder="e.g. Alan Turing" required>
                </div>

                <div class="input-pill-wrapper">
                    <label class="form-label-custom">Professional Email</label>
                    <input type="email" class="input-pill" placeholder="name@company.tech" required>
                </div>

                <div class="input-pill-wrapper">
                    <label class="form-label-custom">Company / Role</label>
                    <input type="text" class="input-pill" placeholder="Senior Systems Architect" required>
                </div>

                <div class="input-pill-wrapper">
                    <label class="form-label-custom">Password</label>
                    <input type="password" class="input-pill" placeholder="••••••••" required>
                </div>

                <div class="consent-wrapper">
                    <div class="custom-checkbox" id="consentCheckbox">
                        <span class="material-symbols-outlined">check</span>
                    </div>
                    <p class="consent-text">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a></p>
                </div>

                <button type="submit" class="btn-signup">
                    <span>Create My Free Account</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <div class="or-divider">
                <div class="or-line"></div>
                <span class="or-text">or continue with</span>
                <div class="or-line"></div>
            </div>

            <div class="social-btns">
                <a href="#" class="btn-social btn-linkedin">
                    <i class="fab fa-linkedin-in"></i>
                    LinkedIn
                </a>
                <a href="#" class="btn-social btn-google">
                    <i class="fab fa-google"></i>
                    Google
                </a>
            </div>

            <p class="footer-link">
                Already a member? <a href="pages/forum/sign-in.php">Sign in here &rarr;</a>
            </p>

        </div>

        <!-- Footer note -->
        <div class="signin-footer-note">
            &copy; <?php echo date('Y'); ?> Spider Tech Ltd
            <span class="sep">&middot;</span>
            <a href="pages/privacy.php">Privacy Policy</a>
            <span class="sep">&middot;</span>
            <a href="pages/terms.php">Terms of Service</a>
        </div>
    </div>

</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('consentCheckbox');
        checkbox.addEventListener('click', () => {
            checkbox.classList.toggle('checked');
        });

        const form = document.getElementById('signupForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Basic validation check for checkbox
            if (!checkbox.classList.contains('checked')) {
                alert('Please agree to the Terms and Privacy Policy.');
                return;
            }
            alert('Registration processing...');
        });
    });
</script>

</body>
</html>
