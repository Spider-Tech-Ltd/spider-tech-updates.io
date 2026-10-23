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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sign-up.css" />
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
                        min8: this.password.length >= 8,
                        upper: /[A-Z]/.test(this.password),
                        lower: /[a-z]/.test(this.password),
                        number: /[0-9]/.test(this.password),
                        special: /[!@#$%^&*(),.?":{}|<>]/.test(this.password)
                    };
                },

                get strength() {
                    const r = this.rules;
                    let score = 0;
                    if (r.min8) score++;
                    if (r.upper) score++;
                    if (r.lower) score++;
                    if (r.number) score++;
                    if (r.special) score++;
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
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
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