<?php
/**
 * Forum Account Verification View — Engineered Precision Auth
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Account Verification') ?> — Spider Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-verify.css?v=<?= filemtime(ROOT_PATH . '/css/forum-verify.css') ?>" />
</head>
<body>
    <div class="auth-container">
        <div class="verification-card">
            <div class="logo-box">
                <a href="<?= BASE_URL ?>/home">
                    <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech">
                </a>
            </div>
            <div class="icon-box <?= $success ? 'success' : 'error' ?>">
                <?php if ($success): ?>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <?php else: ?>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">cancel</span>
                <?php endif; ?>
            </div>
            <h1 class="status-heading"><?= $success ? 'Account Verified!' : 'Verification Error'; ?></h1>
            <p class="status-text"><?= htmlspecialchars($message ?? ''); ?></p>
            <?php if ($success): ?>
                <a href="<?= BASE_URL ?>/forum/sign-in" class="btn-spider">
                    <span>Continue to Sign In</span>
                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/forum/sign-up" class="btn-outline-spider">
                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                    <span>Back to Registration</span>
                </a>
            <?php endif; ?>

            <div class="auth-trust-note">
                <span class="material-symbols-outlined">verified_user</span>
                <span>Spider Tech Industrial Network • End-to-End Moderated</span>
            </div>
        </div>
    </div>
</body>
</html>
