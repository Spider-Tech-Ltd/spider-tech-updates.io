<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <style>
        body { background-color: #f8f9fa; font-family: 'Open Sans', sans-serif; }
        .auth-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            max-width: 450px;
            margin: 80px auto;
        }
        .auth-heading { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; color: #111111; margin-bottom: 8px; text-align: center; }
        .auth-subtext { font-size: 1rem; color: #555555; margin-bottom: 32px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-group label { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem; color: #111111; display: block; margin-bottom: 8px; }
        .auth-input { height: 56px; border-radius: 50px; padding: 0 24px; border: 1px solid #e9ecef; font-size: 1rem; width: 100%; }
        .auth-input:focus { border-color: #f48221; outline: none; box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1); }
        .auth-btn { background-color: #f48221; color: #ffffff; height: 56px; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; width: 100%; border: none; transition: background-color 0.3s; cursor: pointer; margin-top: 10px; }
        .auth-btn:hover { background-color: #e6751c; }
        .back-to-login { text-align: center; margin-top: 20px; }
        .back-to-login a { color: #797979; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .back-to-login a:hover { color: #f48221; }
        .alert { padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-danger { background-color: #fff5f5; color: #e53e3e; border: 1px solid #feb2b2; }
    </style>
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
