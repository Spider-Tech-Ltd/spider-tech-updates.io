<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password - Spider Tech Forum</title>
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
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem; color: #111111; display: block; margin-bottom: 8px; }
        .auth-input { height: 56px; border-radius: 50px; padding: 0 24px; border: 1px solid #e9ecef; font-size: 1rem; width: 100%; }
        .auth-input:focus { border-color: #f48221; outline: none; box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1); }
        .password-toggle { position: absolute; right: 20px; top: 45px; cursor: pointer; color: #797979; user-select: none; }
        .auth-btn { background-color: #f48221; color: #ffffff; height: 56px; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; width: 100%; border: none; transition: background-color 0.3s; cursor: pointer; margin-top: 10px; }
        .auth-btn:hover { background-color: #e6751c; }
        .alert { padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-danger { background-color: #fff5f5; color: #e53e3e; border: 1px solid #feb2b2; }
    </style>
</head>
<body>
<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Set New Password</h1>
        <p class="auth-subtext">Choose a secure password for your account</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/reset-password" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" id="pw1" class="auth-input" placeholder="Enter new password" required>
                <span class="material-symbols-outlined password-toggle" onclick="toggle('pw1')">visibility</span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="pw2" class="auth-input" placeholder="Confirm new password" required>
                <span class="material-symbols-outlined password-toggle" onclick="toggle('pw2')">visibility</span>
            </div>

            <button type="submit" class="auth-btn">Update Password</button>
        </form>
    </div>
</div>

<script>
    function toggle(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
