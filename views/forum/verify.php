<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
</head>
<body>
    <div class="verification-card">
        <div class="logo-box">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech">
        </div>
        <div class="icon-box">
            <?php if ($success): ?>
                <span class="material-symbols-outlined success-icon">check_circle</span>
            <?php else: ?>
                <span class="material-symbols-outlined error-icon">cancel</span>
            <?php endif; ?>
        </div>
        <h1 class="status-heading"><?php echo $success ? 'Account Verified!' : 'Verification Error'; ?></h1>
        <p class="status-text"><?php echo $message; ?></p>
        <?php if ($success): ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-in" class="btn-spider">Sign In Now</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-up" class="btn-outline-spider">Back to Sign Up</a>
        <?php endif; ?>
    </div>
</body>
</html>
