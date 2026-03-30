<?php
/**
 * Forum Sign-Up View
 */
?>
<style>
    .auth-card {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        max-width: 450px;
        margin: 80px auto;
    }
    .auth-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.8rem;
        color: #111111;
        margin-bottom: 8px;
        text-align: center;
    }
    .auth-subtext {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
        color: #555555;
        margin-bottom: 32px;
        text-align: center;
    }
    .form-group label {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #111111;
    }
    .auth-input {
        height: 56px;
        border-radius: 50px;
        padding: 0 24px;
        border: 1px solid #e9ecef;
        font-size: 1rem;
        width: 100%;
        margin-bottom: 20px;
    }
    .auth-input:focus {
        border-color: #f48221;
        outline: none;
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1);
    }
    .auth-btn {
        background-color: #f48221;
        color: #ffffff;
        height: 56px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        border: none;
        transition: background-color 0.3s;
        cursor: pointer;
    }
    .auth-btn:hover {
        background-color: #e6751c;
    }
    .auth-footer {
        text-align: center;
        margin-top: 24px;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.9rem;
    }
    .auth-footer a {
        color: #f48221;
        font-weight: 600;
        text-decoration: none;
    }
    .alert {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.9rem;
    }
    .alert-danger {
        background-color: #fff5f5;
        color: #e53e3e;
        border: 1px solid #feb2b2;
    }
    .alert-success {
        background-color: #f0fff4;
        color: #2f855a;
        border: 1px solid #9ae6b4;
    }
</style>

<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Join Community</h1>
        <p class="auth-subtext">Create an account to start discussing</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forum/sign-up" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="auth-input" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="auth-input" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="auth-input" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="auth-input" placeholder="Choose a password" required>
            </div>
            <button type="submit" class="auth-btn">Sign Up</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="<?= BASE_URL ?>/forum/sign-in">Sign In</a>
        </div>
    </div>
</div>
