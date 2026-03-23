<?php
/**
 * Sign-Up Page — Spider Tech Forum
 * Logic: Handles user registration using Auth class.
 */
require_once '../../config/db.php';
require_once '../../auth/Auth.php';
require_once '../../auth/middleware.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: feed.php');
    die();
}

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth($conn);
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $auth->registerUser($username, $email, $password);
    $status = $result['status'];
    $message = $result['message'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Material Symbols & Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Create Account — Spider Tech</title>

    <style>
      :root {
        --brand-orange: #f48221;
        --deep-charcoal: #111319;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
      }

      html, body {
        height: 100%;
        margin: 0;
        background-color: var(--bg-light);
        color: var(--text-main);
        font-family: 'Open Sans', sans-serif;
        overflow-x: hidden;
      }

      .signup-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
      }

      /* Back link */
      .back-link {
        position: absolute;
        top: 40px;
        left: 40px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
        color: var(--text-muted);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.2s;
        z-index: 10;
      }
      .back-link:hover { color: var(--brand-orange); }

      /* Form Card Wrapper */
      .signup-form-wrapper {
        width: 100%;
        max-width: 580px;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        padding: 48px;
        z-index: 2;
      }

      /* Logo */
      .card-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        margin-bottom: 32px;
        justify-content: center;
      }
      .card-logo-icon {
        width: 40px;
        height: 40px;
        background: var(--brand-orange);
        color: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .card-logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        color: #111;
        letter-spacing: -0.5px;
      }
      .card-logo-text span { color: var(--brand-orange); }

      /* Headings */
      .card-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        text-align: center;
        margin-bottom: 8px;
        color: #0f172a;
      }
      .card-subtext {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 40px;
      }

      /* Inputs */
      .input-pill-wrapper { margin-bottom: 24px; position: relative; }
      .form-label-custom {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 8px;
        padding-left: 4px;
      }

      .input-pill {
        width: 100%;
        height: 52px;
        background: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 14px;
        padding: 0 20px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
      }
      .input-pill:focus {
        outline: none;
        background: #ffffff;
        border-color: var(--brand-orange);
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1);
      }

      /* Password Toggle */
      .input-toggle-btn {
        position: absolute;
        right: 16px;
        top: 40px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
      }

      /* Checkbox */
      .consent-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 32px;
        padding: 0 4px;
      }
      .custom-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 2px;
        flex-shrink: 0;
      }
      .custom-checkbox.checked {
        background: var(--brand-orange);
        border-color: var(--brand-orange);
        color: #fff;
      }
      .custom-checkbox .material-symbols-outlined { font-size: 14px; font-weight: 800; }
      .consent-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
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
        height: 54px;
        background: linear-gradient(135deg, #f48221 0%, #e6751c 100%);
        color: #ffffff;
        border: none;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 32px;
        max-width: 320px;
        margin-left: auto;
        margin-right: auto;
      }
      .btn-signup:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 130, 33, 0.3);
      }

      /* OR Divider */
      .or-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
      }
      .or-line { flex: 1; height: 1px; background: #e9ecef; max-width: 150px; }
      .or-text {
        padding: 0 16px;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.85rem;
        color: #94a3b8;
      }

      /* Social Buttons */
      .social-btn-row {
        display: flex;
        gap: 16px;
        margin-bottom: 40px;
        justify-content: center;
      }
      .btn-social {
        width: 180px;
        height: 48px;
        border: 1px solid #e9ecef;
        border-radius: 50px;
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
        background: #ffffff;
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
        margin-top: 100px;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.8rem;
        color: #94a3b8;
        width: 100%;
      }
      .signup-footer-note a {
        color: #64748b;
        text-decoration: none !important;
        transition: color 0.2s;
      }
      .signup-footer-note a:hover { color: var(--brand-orange); }
      .signup-footer-note .sep { margin: 0 10px; opacity: 0.5; }

      /* Mobile Adjustments */
      @media (max-width: 768px) {
        .signup-form-wrapper { max-width: 100%; padding: 0 10px; }
        .back-link { top: 24px; left: 20px; position: static; margin-bottom: 40px; align-self: flex-start; }
        .signup-page { padding-top: 60px; }
        .social-btn-row { flex-direction: column; align-items: center; }
        .btn-social { width: 100%; max-width: 320px; }
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
        <h1 class="card-heading">Create Account</h1>
        <p class="card-subtext">Join the industrial tech conversations.</p>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?> text-center">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form id="signupForm" action="pages/forum/sign-up.php" method="POST" novalidate>

            <div class="row">
                <!-- Username -->
                <div class="col-md-6">
                    <div class="input-pill-wrapper">
                        <label class="form-label-custom">Username</label>
                        <input type="text" name="username" class="input-pill" placeholder="alanturing" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="input-pill-wrapper">
                        <label class="form-label-custom">Email Address</label>
                        <input type="email" name="email" class="input-pill" placeholder="you@company.tech" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- Password (Full Width) -->
            <div class="row">
                <div class="col-12">
                    <div class="input-pill-wrapper">
                        <label class="form-label-custom">Password</label>
                        <input type="password" name="password" id="passwordInput" class="input-pill" placeholder="••••••••" required>
                        <button type="button" class="input-toggle-btn" id="pwToggle">
                            <span class="material-symbols-outlined" id="pwToggleIcon">visibility_off</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Consent -->
            <div class="consent-wrapper">
                <div class="custom-checkbox" id="consentCheckbox">
                    <span class="material-symbols-outlined" style="display: none;">check</span>
                </div>
                <input type="hidden" name="consent" id="consentInput" value="0">
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

<!-- jQuery -->
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
    const consentInput = document.getElementById('consentInput');
    const checkIcon = checkbox.querySelector('.material-symbols-outlined');

    checkbox.addEventListener('click', () => {
        const isChecked = checkbox.classList.toggle('checked');
        checkIcon.style.display = isChecked ? 'block' : 'none';
        consentInput.value = isChecked ? '1' : '0';
    });

    /**
     * Form Submission (Client-side validation)
     */
    const form = document.getElementById('signupForm');
    form.addEventListener('submit', (e) => {
        if (consentInput.value !== '1') {
            e.preventDefault();
            alert('Please agree to the Terms and Privacy Policy.');
            return;
        }
    });

  });
</script>

</body>
</html>
