<?php
/**
 * Sign-In Page — Spider Tech Forum
 * Logic: Handles member login using updated Auth class.
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
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $auth->loginUser($email, $password);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Sign In — Spider Tech</title>
    <style>
      :root { --brand-orange: #f48221; --bg-light: #f8fafc; --text-main: #1e293b; --text-muted: #64748b; }
      body { background-color: var(--bg-light); font-family: 'Open Sans', sans-serif; color: var(--text-main); }
      .signin-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
      .signin-form-wrapper { width: 100%; max-width: 450px; background: #ffffff; border-radius: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); padding: 48px; }
      .card-logo { display: flex; align-items: center; gap: 12px; text-decoration: none !important; margin-bottom: 32px; justify-content: center; }
      .card-logo-icon { width: 40px; height: 40px; background: var(--brand-orange); color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
      .card-logo-text { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.4rem; color: #111; }
      .card-logo-text span { color: var(--brand-orange); }
      .input-pill-wrapper { margin-bottom: 24px; }
      .form-label-custom { display: block; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.85rem; color: #475569; margin-bottom: 8px; }
      .input-pill { width: 100%; height: 52px; background: #f1f5f9; border: 2px solid transparent; border-radius: 50px; padding: 0 24px; font-size: 0.95rem; transition: all 0.2s; }
      .input-pill:focus { outline: none; border-color: var(--brand-orange); background: #fff; box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1); }
      .btn-signin { width: 100%; height: 54px; background: linear-gradient(135deg, #f48221, #e6751c); color: #fff; border: none; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 700; cursor: pointer; transition: all 0.3s; margin-top: 10px; }
      .btn-signin:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(244, 130, 33, 0.3); }
      .signup-link { text-align: center; margin-top: 32px; font-size: 0.95rem; color: var(--text-muted); }
      .signup-link a { color: var(--brand-orange); font-weight: 700; text-decoration: none !important; }
    </style>
</head>
<body>
<div class="signin-page">
    <div class="signin-form-wrapper">
        <a href="index.php" class="card-logo">
            <div class="card-logo-icon"><span class="material-symbols-outlined">hub</span></div>
            <span class="card-logo-text">Spider <span>Tech</span></span>
        </a>
        <h2 class="text-center font-weight-bold mb-4">Welcome Back</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger text-center rounded-pill">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="pages/forum/sign-in.php">
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Email Address</label>
                <input type="email" name="email" class="input-pill" placeholder="you@company.tech" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            <div class="input-pill-wrapper">
                <label class="form-label-custom">Password</label>
                <input type="password" name="password" class="input-pill" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-signin">Sign In</button>
        </form>
        <p class="signup-link">New here? <a href="pages/forum/sign-up.php">Create an account</a></p>
    </div>
</div>
</body>
</html>
