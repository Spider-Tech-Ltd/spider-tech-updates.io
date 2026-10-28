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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-reset-password.css?v=<?= filemtime(ROOT_PATH . '/css/forum-reset-password.css') ?>" />
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
