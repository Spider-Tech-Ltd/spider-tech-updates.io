<?php
/**
 * Forum Sign-Up View
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Join Community - Spider Tech Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }
        .auth-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            max-width: 480px;
            margin: 40px auto;
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
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: #111111;
            display: block;
            margin-bottom: 8px;
        }
        .auth-input {
            height: 56px;
            border-radius: 50px;
            padding: 0 24px;
            border: 1px solid #e9ecef;
            font-size: 1rem;
            width: 100%;
        }
        .auth-input:focus {
            border-color: #f48221;
            outline: none;
            box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1);
        }
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 45px;
            cursor: pointer;
            color: #797979;
            user-select: none;
            z-index: 5;
        }

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
            margin-top: 10px;
        }
        .auth-btn:hover {
            background-color: #e6751c;
        }
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
        }
        .auth-footer a {
            color: #f48221;
            font-weight: 600;
            text-decoration: none;
        }
        .back-to-forum {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-forum a {
            color: #797979;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .back-to-forum a:hover {
            color: #f48221;
        }
        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
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

        /* Toast Notification - pill shape */
        .pd-toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            padding: 11px 22px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.84rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 9999;
        }
        .pd-toast.success { background: #10b981; box-shadow: 0 4px 16px rgba(16,185,129,0.3); }
        .pd-toast.error   { background: #ef4444; box-shadow: 0 4px 16px rgba(239,68,68,0.3); }
        .pd-toast .material-symbols-outlined { font-size: 17px; }

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
    </style>
</head>
<body x-data="signUpForm()">
<div class="container">
    <div class="auth-card">
        <h1 class="auth-heading">Join Community</h1>
        <p class="auth-subtext">Create an account to start discussing</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form @submit.prevent="submitRegistration()">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="auth-input" placeholder="Enter your full name" x-model="name">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="auth-input" placeholder="Enter your email" required x-model="email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input :type="showPw1 ? 'text' : 'password'" name="password" class="auth-input"
                       placeholder="Choose a password" required x-model="password" style="padding-right: 56px;">
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

            <button type="submit" class="auth-btn" :disabled="!isFormValid || loading">
                <span x-show="!loading">Sign Up</span>
                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"></span>
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="<?= BASE_URL ?>/forum/sign-in">Sign In</a>
        </div>

        <div class="back-to-forum">
            <a href="<?= BASE_URL ?>/forum">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                Back to Forum
            </a>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="pd-toast" :class="toastSuccess ? 'success' : 'error'"
     x-show="toastShow" x-transition.duration.300ms style="display:none;">
  <span class="material-symbols-outlined" x-text="toastSuccess ? 'check_circle' : 'error'"></span>
  <span x-text="toastMessage"></span>
</div>

<script>
function signUpForm() {
    return {
        name: '',
        email: '',
        password: '',
        showPw1: false,
        loading: false,

        toastShow: false,
        toastSuccess: true,
        toastMessage: '',

        init() {
            const err = '<?= addslashes($error) ?>';
            const scs = '<?= addslashes($success) ?>';
            if (err) this.showToast(err, false);
            if (scs) this.showToast(scs, true);
        },

        showToast(msg, success = true) {
            this.toastMessage = msg;
            this.toastSuccess = success;
            this.toastShow = true;
            setTimeout(() => this.toastShow = false, 3500);
        },

        get rules() {
            return {
                min8:   this.password.length >= 8,
                upper:  /[A-Z]/.test(this.password),
                lower:  /[a-z]/.test(this.password),
                number: /[0-9]/.test(this.password),
                special:/[!@#$%^&*(),.?":{}|<>]/.test(this.password)
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
            return this.name.length > 0 &&
                   this.email.length > 0 &&
                   r.upper && r.lower && r.number && r.special && r.min8;
        },

        async submitRegistration() {
            if (!this.isFormValid || this.loading) return;

            this.loading = true;
            try {
                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('csrf_token', '<?= $csrf_token ?>');

                const response = await fetch('<?= BASE_URL ?>/forum/sign-up', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    this.showToast(data.message || 'Account created!', true);
                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 2500);
                    }
                } else {
                    this.showToast(data.message || 'Registration failed.', false);
                }
            } catch (error) {
                this.showToast('Network error. Please try again.', false);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
</body>
</html>
