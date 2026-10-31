<?php
/**
 * Forum Verify Reset Code View — Engineered Precision Auth
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verify Reset Code — Spider Tech Forum</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-verify-reset-code.css?v=<?= filemtime(ROOT_PATH . '/css/forum-verify-reset-code.css') ?>" />
</head>
<body>
<div class="auth-container">

    <div class="auth-brand">
        <a href="<?= BASE_URL ?>/home" title="Spider Tech Home">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" class="auth-brand-logo">
        </a>
    </div>

    <div class="auth-card">

        <div class="auth-eyebrow">
            <span class="auth-eyebrow-accent">|–</span>
            <span>SECURITY CHALLENGE</span>
            <span class="auth-eyebrow-accent">–|</span>
        </div>

        <h1 class="auth-heading">Verify Reset Code</h1>
        <p class="auth-subtext">Enter the 6-digit verification code sent to <strong><?= htmlspecialchars($email) ?></strong></p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">error</span>
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/verify-reset-code" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-group">
                <label for="codeInput">6-Digit Code</label>
                <input type="text" id="codeInput" name="code" class="auth-code-input" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>
            <button type="submit" class="auth-btn">
                <span>Confirm Code</span>
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
            </button>
        </form>

        <div class="back-to-login">
            <a href="<?= BASE_URL ?>/forum/forgot-password">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Use Different Email</span>
            </a>
        </div>

        <div class="auth-trust-note">
            <span class="material-symbols-outlined">verified_user</span>
            <span>Spider Tech Industrial Network • End-to-End Moderated</span>
        </div>
    </div>
</div>
</body>
</html>
