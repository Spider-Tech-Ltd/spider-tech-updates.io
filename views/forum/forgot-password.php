<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-forgot-password.css?v=<?= filemtime(ROOT_PATH . '/css/forum-forgot-password.css') ?>" />
</head>
<body>
<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Forgot Password</h1>
        <p class="auth-subtext">Enter your email to receive a reset code</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/forgot-password" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="auth-input" placeholder="Enter your email address" required>
            </div>
            <button type="submit" class="auth-btn">Send Reset Code</button>
        </form>

        <div class="back-to-login">
            <a href="<?= BASE_URL ?>/forum/sign-in">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                Back to Sign In
            </a>
        </div>
    </div>
</div>
</body>
</html>
