<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        .password-toggle { position: absolute; right: 20px; top: 45px; cursor: pointer; color: #797979; user-select: none; z-index: 5; }

        /* Password Guide */
        .pw-guide {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        .pw-guide-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            color: #111;
            margin-bottom: 10px;
            display: block;
        }
        .pw-guide-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .pw-guide-item {
            font-size: 0.75rem;
            color: #797979;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .pw-guide-item.valid { color: #2f855a; }
        .pw-guide-item.valid .material-symbols-outlined { color: #2f855a; font-variation-settings: 'FILL' 1; }
        .pw-guide-item.invalid { color: #ef4444; }
        .pw-guide-item.invalid .material-symbols-outlined { color: #ef4444; }
        .pw-guide-item .material-symbols-outlined { font-size: 14px; transition: all 0.2s ease; }

        .auth-btn { background-color: #f48221; color: #ffffff; height: 56px; border-radius: 50px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; width: 100%; border: none; transition: background-color 0.3s; cursor: pointer; margin-top: 10px; }
        .auth-btn:hover { background-color: #e6751c; }
        .auth-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        /* Strength Meter */
        .strength-meter {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
            position: relative;
        }
        .strength-bar {
            height: 100%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        .strength-text {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
            text-align: right;
        }

        .alert { padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-danger { background-color: #fff5f5; color: #e53e3e; border: 1px solid #feb2b2; }
    </style>
</head>
<body x-data="resetForm()">
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
                <input :type="showPw1 ? 'text' : 'password'" name="password" class="auth-input"
                       placeholder="Enter new password" required x-model="password" style="padding-right: 56px;">
                <span class="material-symbols-outlined password-toggle" @click="showPw1 = !showPw1"
                      x-text="showPw1 ? 'visibility_off' : 'visibility'"></span>
            </div>

            <!-- Password Guide -->
            <div class="pw-guide" x-show="password.length > 0" x-transition>
                <span class="pw-guide-title">Password Security Checklist:</span>
                <ul class="pw-guide-list">
                    <li class="pw-guide-item" :class="rules.min8 ? 'valid' : 'invalid'">
                        <span class="material-symbols-outlined" x-text="rules.min8 ? 'check_circle' : 'cancel'"></span>
                        8+ Characters
                    </li>
                    <li class="pw-guide-item" :class="rules.upper ? 'valid' : 'invalid'">
                        <span class="material-symbols-outlined" x-text="rules.upper ? 'check_circle' : 'cancel'"></span>
                        Uppercase
                    </li>
                    <li class="pw-guide-item" :class="rules.lower ? 'valid' : 'invalid'">
                        <span class="material-symbols-outlined" x-text="rules.lower ? 'check_circle' : 'cancel'"></span>
                        Lowercase
                    </li>
                    <li class="pw-guide-item" :class="rules.number ? 'valid' : 'invalid'">
                        <span class="material-symbols-outlined" x-text="rules.number ? 'check_circle' : 'cancel'"></span>
                        Number
                    </li>
                    <li class="pw-guide-item" :class="rules.special ? 'valid' : 'invalid'">
                        <span class="material-symbols-outlined" x-text="rules.special ? 'check_circle' : 'cancel'"></span>
                        Special Char
                    </li>
                </ul>

                <!-- Strength Meter -->
                <div class="strength-meter">
                    <div class="strength-bar" :style="`width: ${strengthPercent}%; background-color: ${strengthColor};`"></div>
                </div>
                <span class="strength-text" :style="`color: ${strengthColor};`" x-text="strengthLabel"></span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input :type="showPw2 ? 'text' : 'password'" name="confirm_password" class="auth-input"
                       placeholder="Confirm new password" required x-model="confirm_password" style="padding-right: 56px;">
                <span class="material-symbols-outlined password-toggle" @click="showPw2 = !showPw2"
                      x-text="showPw2 ? 'visibility_off' : 'visibility'"></span>
            </div>

            <button type="submit" class="auth-btn" :disabled="!isFormValid">Update Password</button>
        </form>
    </div>
</div>

<script>
function resetForm() {
    return {
        password: '',
        confirm_password: '',
        showPw1: false,
        showPw2: false,

        get rules() {
            return {
                min8:   this.password.length >= 8,
                upper:  /[A-Z]/.test(this.password),
                lower:  /[a-z]/.test(this.password),
                number: /[0-9]/.test(this.password),
                special:/[!@#$%^&*(),.?\":{}|<>]/.test(this.password)
            };
        },

        get strength() {
            const r = this.rules;
            let score = 0;
            if (r.min8)   score++;
            if (r.upper)  score++;
            if (r.lower)  score++;
            if (r.number) score++;
            if (r.special)score++;
            return score;
        },

        get strengthLabel() {
            if (this.password.length === 0) return '';
            const labels = ['Weak', 'Weak', 'Fair', 'Medium', 'Strong', 'Very Strong'];
            return labels[this.strength];
        },

        get strengthPercent() {
            return (this.strength / 5) * 100;
        },

        get strengthColor() {
            if (this.strength <= 2) return '#ef4444'; // Red
            if (this.strength <= 4) return '#f48221'; // Orange
            return '#10b981'; // Green
        },

        get isFormValid() {
            const r = this.rules;
            return this.password.length > 0 &&
                   this.password === this.confirm_password &&
                   r.upper && r.lower && r.number && r.special && r.min8;
        }
    }
}
</script>
</body>
</html>
