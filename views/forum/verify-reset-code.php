<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verify Reset Code - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-verify-reset-code.css" />
</head>
<body>
<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Verification Code</h1>
        <p class="auth-subtext">Enter the 6-digit code sent to your email <strong><?= htmlspecialchars($email) ?></strong></p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/verify-reset-code" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-group">
                <label>Reset Code</label>
                <input type="text" name="code" class="auth-input" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>
            <button type="submit" class="auth-btn">Verify Code</button>
        </form>

        <div class="back-to-login">
            <a href="<?= BASE_URL ?>/forum/forgot-password">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                Change Email
            </a>
        </div>
    </div>
</div>
</body>
</html>
