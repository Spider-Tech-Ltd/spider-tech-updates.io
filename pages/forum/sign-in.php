<?php
/**
 * Forum Sign-In Gateway — Full Page Form (White)
 * Standalone authentication page.
 * Design: Full-page white background, centered form, no nested card box.
 * Stack: Bootstrap 4 + Vanilla CSS. No Tailwind.
 */

// Detect where to redirect after sign-in
$redirect = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : 'feed.php';
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In — Spider Tech Forum</title>
    <meta name="description" content="Sign in to Spider Tech Forum to join industry discussions, post replies, and connect with 5,200+ industrial tech professionals.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Open+Sans:wght@400;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Font Awesome (social icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
      /* ======================================
         SIGN-IN GATEWAY — FULL PAGE WHITE
         ====================================== */
      *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

      html, body {
        height: 100%;
        margin: 0;
        overflow: hidden; /* Prevent vertical overflow/scrolling */
        font-family: 'Open Sans', sans-serif;
        background-color: #ffffff;
      }

      /* ======================================
         FULL-PAGE CONTAINER
         ====================================== */
      .signin-page {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
        background-color: #ffffff;
      }

      /* Very subtle grid overlay (optional, soft gray) */
      .signin-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
          linear-gradient(rgba(0, 0, 0, 0.02) 1px, transparent 1px),
          linear-gradient(90deg, rgba(0, 0, 0, 0.02) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
        z-index: 0;
      }

      /* Orange top accent line (Moved to top of screen as a brand bar) */
      body::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f48221, #e6751c);
        z-index: 20;
      }

      /* ======================================
         BACK LINK — TOP LEFT
         ====================================== */
      .back-link {
        position: absolute;
        top: 24px;
        left: 28px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: none !important;
        transition: color 0.2s ease;
        z-index: 10;
      }

      .back-link:hover { color: #f48221; }

      .back-link .material-symbols-outlined {
        font-size: 18px;
        transition: transform 0.2s ease;
      }

      .back-link:hover .material-symbols-outlined { transform: translateX(-4px); }

      /* ======================================
         SIGN-IN FORM CENTERED
         ====================================== */
      .signin-form-wrapper {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        /* No background or shadow -> Form is floating directly */
      }

      /* --- Logo --- */
      .card-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-decoration: none !important;
        margin-bottom: 24px;
      }

      .card-logo-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #f48221, #e6751c);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(244, 130, 33, 0.3);
        flex-shrink: 0;
      }

      .card-logo-icon .material-symbols-outlined { font-size: 26px; }

      .card-logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        color: #111111;
        letter-spacing: -0.02em;
      }

      .card-logo-text span { color: #f48221; }

      /* --- Heading --- */
      .card-heading {
        font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: #111111;
        text-align: center;
        margin-bottom: 6px;
        letter-spacing: -0.02em;
        line-height: 1.2;
      }

      .card-subtext {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        color: #64748b;
        text-align: center;
        margin-bottom: 0;
        line-height: 1.5;
      }

      /* Thin divider */
      .card-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 28px 0;
      }

      /* --- Form Labels --- */
      .form-label-custom {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #111111;
        display: block;
        margin-bottom: 10px;
      }

      /* --- Pill Inputs --- */
      .input-pill-wrapper {
        position: relative;
        margin-bottom: 20px;
      }

      .input-pill {
        width: 100%;
        height: 52px;
        background-color: #f8f9fa;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        padding: 0 54px 0 22px;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        color: #262626;
        outline: none;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        -webkit-appearance: none;
        appearance: none;
      }

      .input-pill::placeholder { color: #b0b8c1; font-weight: 400; }

      .input-pill:focus {
        background-color: #ffffff;
        border-color: #f48221;
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.12);
      }

      /* Password toggle button */
      .input-toggle-btn {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 6px;
        margin: 0;
        cursor: pointer;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
      }
      .input-toggle-btn:focus { outline: none; }
      .input-toggle-btn:hover { color: #f48221; }
      .input-toggle-btn .material-symbols-outlined { font-size: 20px; line-height: 1; }

      /* Forgot password link */
      .forgot-link {
        display: block;
        text-align: right;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.82rem;
        color: #f48221;
        text-decoration: none !important;
        margin-top: -8px;
        margin-bottom: 30px;
        transition: opacity 0.2s;
      }

      .forgot-link:hover { opacity: 0.8; }

      /* --- Primary CTA Button --- */
      .btn-signin {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 54px;
        background: linear-gradient(135deg, #f48221 0%, #e6751c 100%);
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(244, 130, 33, 0.35);
        transition: all 0.25s ease;
        text-decoration: none !important;
        letter-spacing: 0.01em;
        margin-bottom: 28px;
      }

      .btn-signin:hover {
        background: linear-gradient(135deg, #e6751c 0%, #d9690e 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(244, 130, 33, 0.45);
      }

      .btn-signin:active { transform: translateY(0); }

      .btn-signin .material-symbols-outlined { font-size: 20px; }

      /* --- OR Divider --- */
      .or-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
      }

      .or-line {
        flex: 1;
        height: 1px;
        background-color: #f1f5f9;
      }

      .or-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.75rem;
        color: #94a3b8;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.05em;
      }

      /* --- Social Login Buttons --- */
      .social-btn-row {
        display: flex;
        gap: 16px;
        margin-bottom: 32px;
      }

      .btn-social {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        height: 50px;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
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
        border-color: #f48221;
        box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
      }

      .btn-social .social-icon {
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      /* Google G colors */
      .btn-social-google .social-icon { color: #DB4437; }
      /* LinkedIn blue */
      .btn-social-linkedin .social-icon { color: #0A66C2; }

      /* --- Register Link --- */
      .register-text {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 0;
      }

      .register-text a {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #f48221;
        text-decoration: none !important;
        transition: opacity 0.2s;
      }

      .register-text a:hover { opacity: 0.8; text-decoration: underline !important; }

      /* ======================================
         FOOTER NOTE BELOW FORM
         ====================================== */
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

      .signin-footer-note a:hover { color: #f48221; }
      .signin-footer-note .sep { margin: 0 10px; opacity: 0.5; }

      /* ======================================
         FORM VALIDATION STATES
         ====================================== */
      .input-pill.is-invalid {
        border-color: #e11d48;
        box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.1);
      }

      .input-pill.is-valid {
        border-color: #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
      }

      .field-error-msg {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.85rem;
        color: #e11d48;
        margin-top: 8px;
        padding-left: 20px;
        display: none;
      }

      .field-error-msg.visible { display: block; }

      /* Loading spinner on button */
      .btn-signin.is-loading {
        pointer-events: none;
        opacity: 0.85;
      }

      /* Minor fixes for small screens vertically */
      @media (max-height: 750px) {
         html, body { overflow: auto; } /* Allow scrolling ONLY on very short screens to prevent unreachability */
         .signin-page { justify-content: flex-start; padding-top: 60px; padding-bottom: 80px; }
         .signin-footer-note { position: static; margin-top: 40px; }
      }
    </style>
</head>
<body>

<div class="signin-page" id="signinPage">

    <!-- Back to Forum link -->
    <a href="pages/forum/index.php" class="back-link" id="backToForumLink">
        <span class="material-symbols-outlined">arrow_back</span>
        Back to Forum
    </a>

    <!-- ====== Sign-In Form ====== -->
    <div class="signin-form-wrapper">

        <!-- Logo -->
        <a href="index.php" class="card-logo">
            <div class="card-logo-icon">
                <span class="material-symbols-outlined">hub</span>
            </div>
            <span class="card-logo-text">Spider <span>Tech</span></span>
        </a>

        <!-- Heading -->
        <h1 class="card-heading">Welcome Back</h1>
        <p class="card-subtext">Sign in to join the conversation.</p>

        <hr class="card-divider">

        <form id="signinForm" novalidate>
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

            <!-- Email -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom" for="emailInput">Email Address</label>
                <input
                    type="email"
                    id="emailInput"
                    name="email"
                    class="input-pill"
                    placeholder="you@company.com"
                    autocomplete="email"
                    required
                >
                <span class="field-error-msg" id="emailError">Please enter a valid email address.</span>
            </div>

            <!-- Password -->
            <div class="input-pill-wrapper">
                <label class="form-label-custom" for="passwordInput">Password</label>
                <input
                    type="password"
                    id="passwordInput"
                    name="password"
                    class="input-pill"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="input-toggle-btn" id="pwToggle" aria-label="Show or hide password">
                    <span class="material-symbols-outlined" id="pwToggleIcon">visibility_off</span>
                </button>
                <span class="field-error-msg" id="passwordError">Password is required.</span>
            </div>

            <!-- Forgot Password -->
            <a href="pages/forum/forgot-password.php" class="forgot-link">Forgot Password?</a>

            <!-- Sign In Button -->
            <button type="submit" class="btn-signin" id="signinBtn">
                <span class="btn-label">Sign In</span>
                <span class="material-symbols-outlined" id="signinArrow">arrow_forward</span>
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
            <a href="#" class="btn-social btn-social-google" id="googleSignIn">
                <span class="social-icon"><i class="fab fa-google"></i></span>
                Google
            </a>
            <a href="#" class="btn-social btn-social-linkedin" id="linkedinSignIn">
                <span class="social-icon"><i class="fab fa-linkedin-in"></i></span>
                LinkedIn
            </a>
        </div>

        <!-- Register Link -->
        <p class="register-text">
            New to Spider Tech?
            <a href="pages/forum/sign-up.php">Create a free account &rarr;</a>
        </p>

    </div>
    <!-- /signin-form-wrapper -->

    <!-- Footer note -->
    <div class="signin-footer-note">
        &copy; 2026 Spider Tech Ltd
        <span class="sep">&middot;</span>
        <a href="pages/privacy.php">Privacy Policy</a>
        <span class="sep">&middot;</span>
        <a href="pages/terms.php">Terms of Service</a>
    </div>

</div>
<!-- /signin-page -->

<!-- jQuery (required for Bootstrap 4) -->
<script src="js/jquery.min.js"></script>
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
     * Form Validation & Submission
     */
    const form         = document.getElementById('signinForm');
    const emailInput   = document.getElementById('emailInput');
    const passwordInput= document.getElementById('passwordInput');
    const emailError   = document.getElementById('emailError');
    const passwordError= document.getElementById('passwordError');
    const signinBtn    = document.getElementById('signinBtn');

    function validateEmail(val) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim());
    }

    function setFieldState(input, errorEl, isValid) {
      input.classList.toggle('is-invalid', !isValid);
      input.classList.toggle('is-valid', isValid);
      errorEl.classList.toggle('visible', !isValid);
    }

    // Real-time validation on blur
    emailInput.addEventListener('blur', function () {
      setFieldState(emailInput, emailError, validateEmail(this.value));
    });

    passwordInput.addEventListener('blur', function () {
      setFieldState(passwordInput, passwordError, this.value.length >= 6);
    });

    // Clear error on input
    [emailInput, passwordInput].forEach(function (el) {
      el.addEventListener('input', function () {
        this.classList.remove('is-invalid');
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const emailOk    = validateEmail(emailInput.value);
      const passwordOk = passwordInput.value.length >= 6;

      setFieldState(emailInput, emailError, emailOk);
      setFieldState(passwordInput, passwordError, passwordOk);

      if (!emailOk || !passwordOk) return;

      // Simulate loading state
      signinBtn.classList.add('is-loading');
      signinBtn.querySelector('.btn-label').textContent = 'Signing in…';
      document.getElementById('signinArrow').textContent = 'hourglass_empty';

      // TODO: Replace with real AJAX / PHP form submission
      setTimeout(function () {
        // Simulate redirect to feed after login
        window.location.href = 'pages/forum/feed.php';
      }, 1200);
    });

  });
</script>

</body>
</html>
