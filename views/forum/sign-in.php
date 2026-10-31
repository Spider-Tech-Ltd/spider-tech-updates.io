<?php
/**
 * Forum Sign-In View — Engineered Precision Auth
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In — Spider Tech Forum</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sign-in.css?v=<?= filemtime(ROOT_PATH . '/css/forum-sign-in.css') ?>" />
</head>
<body>
<div class="auth-container">

    <!-- Official Brand Link -->
    <div class="auth-brand">
        <a href="<?= BASE_URL ?>/home" title="Spider Tech Home">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" class="auth-brand-logo">
        </a>
    </div>

    <!-- Main Auth Card -->
    <div class="auth-card">

        <!-- Engineering Eyebrow -->
        <div class="auth-eyebrow">
            <span class="auth-eyebrow-accent">|–</span>
            <span>SECURE MEMBER ACCESS</span>
            <span class="auth-eyebrow-accent">–|</span>
        </div>

        <h1 class="auth-heading">Sign In to Your Account</h1>
        <p class="auth-subtext">Access industrial engineering discussions, documentation, and peer intelligence</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">error</span>
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success text-center">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">check_circle</span>
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/sign-in" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <!-- Email Field -->
            <div class="form-group">
                <label for="loginInput">Email Address</label>
                <div class="input-field-wrapper">
                    <span class="material-symbols-outlined input-field-icon">mail</span>
                    <input type="email" id="loginInput" name="login" class="auth-input" placeholder="name@company.com" required autocomplete="email">
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="passwordInput" class="mb-0">Password</label>
                    <a href="<?= BASE_URL ?>/forum/forgot-password" class="auth-forgot-link">Forgot Password?</a>
                </div>
                <div class="input-field-wrapper">
                    <span class="material-symbols-outlined input-field-icon">lock</span>
                    <input type="password" name="password" id="passwordInput" class="auth-input" placeholder="Enter your password" required autocomplete="current-password">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword()" aria-label="Toggle password visibility">
                        <span class="material-symbols-outlined password-toggle-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Fully Rounded Submit Pill -->
            <button type="submit" class="auth-btn">
                <span>Sign In</span>
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="<?= BASE_URL ?>/forum/sign-up">Create an Account</a>
        </div>

        <div class="back-to-forum">
            <a href="<?= BASE_URL ?>/forum">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Return to Community Forum</span>
            </a>
        </div>

        <div class="auth-trust-note">
            <span class="material-symbols-outlined">verified_user</span>
            <span>Spider Tech Industrial Network • End-to-End Moderated</span>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.querySelector('.password-toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
