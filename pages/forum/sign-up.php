<?php
/**
 * Sign-Up Page (sign-up.php) — Phase 8 Redesign (V4)
 * Goal: Clean, full-page registration form matching sign-in.php design exactly.
 * Uses: Bootstrap 4, Vanilla CSS, Material Symbols
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Spider Tech Ltd</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts: Poppins (Headlines), Open Sans (Body) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
      /* ======================================
         CORE RESET & BASE STYLES
         ====================================== */
      :root {
        --brand-orange: #f48221;
        --brand-orange-hover: #e6751c;
        --bg-light: #f8fafc;
        --text-dark: #111111;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
      }

      * { margin: 0; padding: 0; box-sizing: border-box; }

      body, html {
        height: 100%;
        font-family: 'Open Sans', sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
      }

      /* ======================================
         PAGE CONTAINER
         ====================================== */
      .signup-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
      }

      /* Back link */
      .back-link {
        position: absolute;
        top: 32px;
        left: 32px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none !important;
        transition: color 0.2s;
      }

      .back-link:hover { color: var(--brand-orange); }
      .back-link .material-symbols-outlined { font-size: 20px; }

      /* ======================================
         SIGN-UP FORM WRAPPER
         ====================================== */
      .signup-form-wrapper {
        width: 100%;
        max-width: 450px;
        background: #ffffff;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02), 0 4px 10px rgba(0, 0, 0, 0.01);
        border: 1px solid rgba(0, 0, 0, 0.05);
        z-index: 5;
      }

      /* Logo */
      .card-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 24px;
        text-decoration: none !important;
      }

      .card-logo-icon {
        width: 36px;
        height: 36px;
        background-color: var(--brand-orange);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 4px 10px rgba(244, 130, 33, 0.2);
      }

      .card-logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: #111111;
        letter-spacing: -0.02em;
      }

      .card-logo-text span { color: var(--brand-orange); }

      /* Typography */
      .card-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 8px;
        color: #111111;
      }

      .card-subtext {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 24px;
      }

      .card-divider {
        border: 0;
        height: 1px;
        background: #f1f5f9;
        margin: 24px 0;
      }

      /* ======================================
         FORM COMPONENTS
         ====================================== */
      .input-pill-wrapper {
        position: relative;
        margin-bottom: 20px;
      }

      .form-label-custom {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #111111;
        margin-bottom: 8px;
        padding-left: 20px;
      }

      .input-pill {
        width: 100%;
        height: 50px;
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        padding: 0 24px;
        font-size: 0.9rem;
        color: #111111;
        transition: all 0.2s ease;
        outline: none;
      }

      .input-pill:hover { border-color: #ced4da; }

      .input-pill:focus {
        border-color: var(--brand-orange);
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1);
      }

      /* Password Toggle */
      .input-toggle-btn {
        position: absolute;
        right: 20px;
        bottom: 13px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
        outline: none !important;
      }

      .input-toggle-btn:hover { color: var(--brand-orange); }

      /* Consent */
      .consent-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin: 20px 0;
        padding-left: 10px;
      }

      .custom-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #e9ecef;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        margin-top: 2px;
      }

      .custom-checkbox.checked {
        background-color: var(--brand-orange);
        border-color: var(--brand-orange);
      }

      .custom-checkbox span {
        font-size: 12px;
        color: #fff;
        display: none;
      }

      .custom-checkbox.checked span { display: block; }

      .consent-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.4;
        margin-bottom: 0;
      }

      .consent-text a {
        color: var(--brand-orange);
        font-weight: 700;
        text-decoration: none !important;
      }

      /* Submit Button */
      .btn-signup {
        width: 100%;
        height: 52px;
        background-color: var(--brand-orange);
        color: #ffffff;
        border: none;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 24px;
      }

      .btn-signup:hover {
        background-color: var(--brand-orange-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 130, 33, 0.3);
      }

      /* OR Divider */
      .or-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
      }

      .or-line { flex: 1; height: 1px; background: #e9ecef; }
      .or-text {
        padding: 0 16px;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.85rem;
        color: #94a3b8;
      }

      /* Social Buttons */
      .social-btn-row {
        display: flex;
        gap: 12px;
        margin-bottom: 32px;
      }

      .btn-social {
        flex: 1;
        height: 48px;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #111111;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
        white-space: nowrap;
      }

      .btn-social:hover {
        border-color: var(--brand-orange);
        box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
      }

      .btn-social .social-icon { width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
      .btn-social-google .social-icon { color: #DB4437; }
      .btn-social-linkedin .social-icon { color: #0A66C2; }

      /* Footer Link */
      .signin-text {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        color: var(--text-muted);
      }

      .signin-text a {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--brand-orange);
        text-decoration: none !important;
      }

      .signin-text a:hover { opacity: 0.8; text-decoration: underline !important; }

      /* Footer note */
      .signup-footer-note {
        position: absolute;
        bottom: 24px;
        left: 0; right: 0;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.8rem;
        color: #94a3b8;
        z-index: 2;
      }

      .signup-footer-note a {
        color: #64748b;
        text-decoration: none !important;
        transition: color 0.2s;
      }

      .signup-footer-note a:hover { color: var(--brand-orange); }
      .signup-footer-note .sep { margin: 0 10px; opacity: 0.5; }

      /* Mobile Adjustments */
      @media (max-width: 576px) {
        .signup-form-wrapper { padding: 32px 24px; border-radius: 0; box-shadow: none; border: none; }
        .back-link { top: 20px; left: 20px; }
        .signup-page { padding: 0; align-items: flex-start; }
        .signup-footer-note { position: static; margin-top: 40px; padding-bottom: 24px; }
        .social-btn-row { flex-direction: column; }
      }
    </style>
</head>
<body>

<div class="signup-page">

    <!-- Back to Forum -->
    <a href="pages/forum/index.php" class="back-link">
        <span class="material-symbols-outlined">arrow_back</span>
        Back to Forum
    </a>

    <!-- ====== Sign-Up Form ====== -->
    <div class="signup-form-wrapper">

        <!-- Logo -->
        <a href="index.php" class="card-logo">
            <div class="card-logo-icon">
                <span class="material-symbols-outlined">hub</span>
            </div>
            <span class="card-logo-text">Spider <span>Tech</span></span>
        </a>

        <!-- Heading -->
        <h1 class="card-heading">Join the Network</h1>
        <p class="card-subtext">Sign up to join the conversation.</p>

        <hr class="card-divider">

        <form id="signupForm" novalidate>

            <!-- Full Name -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Full Name</label>
                <input type="text" class="input-pill" placeholder="Alan Turing" required>
            </div>

            <!-- Email -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Email Address</label>
                <input type="email" class="input-pill" placeholder="you@company.tech" required>
            </div>

            <!-- Company / Role -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Company / Role</label>
                <input type="text" class="input-pill" placeholder="Senior Systems Architect" required>
            </div>

            <!-- Password -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Password</label>
                <input type="password" id="passwordInput" class="input-pill" placeholder="••••••••" required>
                <button type="button" class="input-toggle-btn" id="pwToggle" aria-label="Show or hide password">
                    <span class="material-symbols-outlined" id="pwToggleIcon">visibility_off</span>
                </button>
            </div>

            <!-- Consent -->
            <div class="consent-wrapper">
                <div class="custom-checkbox" id="consentCheckbox">
                    <span class="material-symbols-outlined">check</span>
                </div>
                <p class="consent-text">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </p>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-signup">
                <span class="btn-label">Create Free Account</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>

        </form>

        <!-- OR Divider -->
        <div class="or-divider">
            <div class="or-line"></div>
            <span class="or-text">or continue with</span>
            <div class="or-line"></div>
        </div>

        <!-- Social Logins -->
        <div class="social-btn-row">
            <a href="#" class="btn-social btn-social-google">
                <span class="social-icon"><i class="fab fa-google"></i></span>
                Google
            </a>
            <a href="#" class="btn-social btn-social-linkedin">
                <span class="social-icon"><i class="fab fa-linkedin-in"></i></span>
                LinkedIn
            </a>
        </div>

        <!-- Sign In Link -->
        <p class="signin-text">
            Already a member?
            <a href="pages/forum/sign-in.php">Sign in here &rarr;</a>
        </p>

    </div>

    <!-- Footer note -->
    <div class="signup-footer-note">
        &copy; <?php echo date('Y'); ?> Spider Tech Ltd
        <span class="sep">&middot;</span>
        <a href="pages/privacy.php">Privacy Policy</a>
        <span class="sep">&middot;</span>
        <a href="pages/terms.php">Terms of Service</a>
    </div>

</div>

<!-- jQuery (required for Bootstrap 4) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    /**
     * Password Show / Hide Toggle
     */
    const pwToggle   = document.getElementById('pwToggle');
    const pwInput    = document.getElementById('passwordInput');
    const pwIcon     = document.getElementById('pwToggleIcon');

    pwToggle.addEventListener('click', function () {
      const isVisible = pwInput.type === 'text';
      pwInput.type    = isVisible ? 'password' : 'text';
      pwIcon.textContent = isVisible ? 'visibility_off' : 'visibility';
    });

    /**
     * Consent Checkbox
     */
    const checkbox = document.getElementById('consentCheckbox');
    checkbox.addEventListener('click', () => {
        checkbox.classList.toggle('checked');
    });

    /**
     * Form Submission
     */
    const form = document.getElementById('signupForm');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
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
