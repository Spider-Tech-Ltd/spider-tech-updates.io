<?php
/**
 * Sign-In Page — Spider Tech Forum
 * Logic: Handles user login using Auth class.
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
$redirect = $_GET['redirect'] ?? 'pages/forum/feed.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth($conn);
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $auth->loginUser($identifier, $password);

    if ($result['status'] === 'success') {
        header('Location: ' . $result['redirect']);
        die();
    } else {
        $status = $result['status'];
        $message = $result['message'];
    }
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

  <title>Sign In — Spider Tech</title>

  <style>
    :root {
      --brand-orange: #f48221;
      --bg-light: #f8fafc;
      --text-main: #1e293b;
      --text-muted: #64748b;
    }

    html, body {
      height: 100%;
      margin: 0;
      background-color: var(--bg-light);
      color: var(--text-main);
      font-family: 'Open Sans', sans-serif;
      overflow: hidden;
    }

    .signin-page {
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    /* --- Back Link --- */
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

    /* --- Form Card --- */
    .signin-form-wrapper {
      width: 100%;
      max-width: 480px;
      background: #ffffff;
      border-radius: 24px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
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

    /* Heading */
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
      margin-bottom: 32px;
    }

    .card-divider {
      border: 0;
      height: 1px;
      background: #f1f5f9;
      margin-bottom: 32px;
    }

    /* --- Input Fields --- */
    .input-pill-wrapper {
      margin-bottom: 24px;
      position: relative;
    }

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

    /* Forgot Password */
    .forgot-link {
      display: block;
      text-align: right;
      font-family: 'Open Sans', sans-serif;
      font-weight: 600;
      font-size: 0.85rem;
      color: var(--brand-orange);
      text-decoration: none !important;
      margin-top: -16px;
      margin-bottom: 32px;
    }

    /* --- Buttons --- */
    .btn-signin {
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
    }

    .btn-signin:hover {
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
      gap: 16px;
      margin-bottom: 32px;
    }

    .btn-social {
      flex: 1;
      height: 48px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
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
    }

    .btn-social:hover {
      border-color: var(--brand-orange);
      box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
    }

    .btn-social .social-icon { width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .btn-social-google .social-icon { color: #DB4437; }
    .btn-social-linkedin .social-icon { color: #0A66C2; }

    /* Register Link */
    .register-text {
      text-align: center;
      font-family: 'Open Sans', sans-serif;
      font-size: 0.95rem;
      color: var(--text-muted);
      margin-bottom: 0;
    }

    .register-text a {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      color: var(--brand-orange);
      text-decoration: none !important;
    }

    /* --- Footer Note --- */
    .signin-footer-note {
      position: absolute;
      bottom: 24px;
      left: 0;
      right: 0;
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

    .signin-footer-note .sep { margin: 0 10px; opacity: 0.5; }

    @media (max-height: 750px) {
      html, body { overflow: auto; }
      .signin-page { justify-content: flex-start; padding-top: 60px; padding-bottom: 80px; }
      .signin-footer-note { position: static; margin-top: 40px; }
    }
  </style>
</head>

<body>

  <div class="signin-page">

    <!-- Back to Forum -->
    <a href="pages/forum/index.php" class="back-link">
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

      <?php if ($message): ?>
          <div class="alert alert-danger text-center">
              <?php echo htmlspecialchars($message); ?>
          </div>
      <?php endif; ?>

      <form id="signinForm" action="pages/forum/sign-in.php" method="POST" novalidate>
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

        <!-- Identifier (Email or Username) -->
        <div class="input-pill-wrapper">
          <label class="form-label-custom" for="identifierInput">Email or Username</label>
          <input
            type="text"
            id="identifierInput"
            name="identifier"
            class="input-pill"
            placeholder="you@company.com or username"
            required
            value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>">
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
            required>
          <button type="button" class="input-toggle-btn" id="pwToggle">
            <span class="material-symbols-outlined" id="pwToggleIcon">visibility_off</span>
          </button>
        </div>

        <!-- Forgot Password -->
        <a href="pages/forum/forgot-password.php" class="forgot-link">Forgot Password?</a>

        <!-- Sign In Button -->
        <button type="submit" class="btn-signin" id="signinBtn">
          <span class="btn-label">Sign In</span>
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

      <!-- Register Link -->
      <p class="register-text">
        New to Spider Tech?
        <a href="pages/forum/sign-up.php">Create a free account &rarr;</a>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const pwToggle = document.getElementById('pwToggle');
      const pwInput = document.getElementById('passwordInput');
      const pwIcon = document.getElementById('pwToggleIcon');

      pwToggle.addEventListener('click', function() {
        const isVisible = pwInput.type === 'text';
        pwInput.type = isVisible ? 'password' : 'text';
        pwIcon.textContent = isVisible ? 'visibility_off' : 'visibility';
      });
    });
  </script>

</body>
</html>
