<?php
/**
 * Forum Sign-In View
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sign-in.css?v=<?= filemtime(ROOT_PATH . '/css/forum-sign-in.css') ?>" />
</head>
<body>
<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Sign In</h1>
        <p class="auth-subtext">Welcome back to Spider Tech Community</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/sign-in" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="login" class="auth-input" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="passwordInput" class="auth-input" placeholder="Enter password" required>
                <span class="material-symbols-outlined password-toggle" onclick="togglePassword()">visibility</span>
            </div>
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="<?= BASE_URL ?>/forum/forgot-password" style="font-size: 0.85rem; color: #f48221; font-weight: 600; text-decoration: none;">Forgot Password?</a>
            </div>
            <button type="submit" class="auth-btn">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="<?= BASE_URL ?>/forum/sign-up">Sign Up</a>
        </div>

        <div class="back-to-forum">
            <a href="<?= BASE_URL ?>/forum">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                Back to Forum
            </a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.querySelector('.password-toggle');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
