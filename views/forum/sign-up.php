<?php
/**
 * Forum Sign-Up View — Engineered Precision Auth
 */
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Join Community — Spider Tech Forum</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-sign-up.css?v=<?= filemtime(ROOT_PATH . '/css/forum-sign-up.css') ?>" />
</head>

<body x-data="signUpForm()">
    <div class="auth-container">

        <!-- Official Brand Link -->
        <div class="auth-brand">
            <a href="<?= BASE_URL ?>/home" title="Spider Tech Home">
                <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" class="auth-brand-logo">
            </a>
        </div>

        <!-- Main Auth Card -->
        <div class="auth-card">

            <!-- Engineering Eyebrow -->
            <div class="auth-eyebrow">
                <span class="auth-eyebrow-accent">|–</span>
                <span>MEMBER ONBOARDING</span>
                <span class="auth-eyebrow-accent">–|</span>
            </div>

            <h1 class="auth-heading">Create Your Account</h1>
            <p class="auth-subtext">Join thousands of industrial automation and systems engineers</p>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">error</span>
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success text-center">
                    <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">check_circle</span>
                    <?= htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form @submit.prevent="submitRegistration()">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="nameInput">Full Name</label>
                    <div class="input-field-wrapper">
                        <span class="material-symbols-outlined input-field-icon">person</span>
                        <input type="text" id="nameInput" name="name" class="auth-input" placeholder="e.g. Alex Henderson" x-model="name" required autocomplete="name">
                    </div>
                </div>

                <!-- Email Address Field -->
                <div class="form-group">
                    <label for="emailInput">Work / Technical Email</label>
                    <div class="input-field-wrapper">
                        <span class="material-symbols-outlined input-field-icon">mail</span>
                        <input type="email" id="emailInput" name="email" class="auth-input" placeholder="name@company.com" required x-model="email" autocomplete="email">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="passwordInput">Choose Password</label>
                    <div class="input-field-wrapper">
                        <span class="material-symbols-outlined input-field-icon">lock</span>
                        <input :type="showPw1 ? 'text' : 'password'" id="passwordInput" name="password" class="auth-input"
                            placeholder="Create a strong password" required x-model="password" style="padding-right: 48px;" autocomplete="new-password">
                        <button type="button" class="password-toggle-btn" @click="showPw1 = !showPw1" aria-label="Toggle password visibility">
                            <span class="material-symbols-outlined" x-text="showPw1 ? 'visibility_off' : 'visibility'"></span>
                        </button>
                    </div>
                </div>

                <!-- Password Security Checklist -->
                <div class="pw-guide" x-show="password.length > 0" x-transition>
                    <span class="pw-guide-title">Password Security Checklist</span>
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
                        <li class="pw-guide-item" :class="rules.special ? 'valid' : 'invalid'" style="grid-column: span 2;">
                            <span class="material-symbols-outlined" x-text="rules.special ? 'check_circle' : 'cancel'"></span>
                            Special Symbol (!@#$%^&*)
                        </li>
                    </ul>

                    <!-- Strength Meter -->
                    <div class="strength-meter">
                        <div class="strength-bar" :style="`width: ${strengthPercent}%; background-color: ${strengthColor};`"></div>
                    </div>
                    <span class="strength-text" :style="`color: ${strengthColor};`" x-text="strengthLabel"></span>
                </div>

                <div class="mb-3 text-start">
                    <p class="text-muted" style="font-size: 0.76rem; line-height: 1.5; margin: 0;">
                        By registering, you agree to our <a href="<?= BASE_URL ?>/forum/terms" target="_blank" style="color: #f48221; font-weight: 600;">Community Terms & Guidelines</a>.
                    </p>
                </div>

                <!-- Fully Rounded Submit Pill -->
                <button type="submit" class="auth-btn" :disabled="!isFormValid || loading">
                    <span x-show="!loading" class="d-inline-flex align-items-center gap-2">
                        <span>Complete Registration</span>
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </span>
                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status"></span>
                </button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="<?= BASE_URL ?>/forum/sign-in">Sign In</a>
            </div>

            <div class="back-to-forum">
                <a href="<?= BASE_URL ?>/forum">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span>Return to Community Forum</span>
                </a>
            </div>

            <div class="auth-trust-note">
                <span class="material-symbols-outlined">verified_user</span>
                <span>Spider Tech Verified Community • 256-Bit SSL Encrypted</span>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
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
                    const err = '<?= addslashes($error ?? '') ?>';
                    const scs = '<?= addslashes($success ?? '') ?>';
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
                    return this.name.trim().length > 0 &&
                        this.email.trim().length > 0 &&
                        r.min8 && r.upper && r.lower && r.number && r.special;
                },

                async submitRegistration() {
                    if (!this.isFormValid) return;
                    this.loading = true;

                    try {
                        const formData = new FormData();
                        formData.append('csrf_token', '<?= htmlspecialchars($csrf_token ?? '') ?>');
                        formData.append('name', this.name);
                        formData.append('email', this.email);
                        formData.append('password', this.password);

                        const response = await fetch('<?= BASE_URL ?>/forum/sign-up', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            this.showToast(data.message, true);
                            setTimeout(() => {
                                window.location.href = data.redirect || '<?= BASE_URL ?>/forum/sign-in';
                            }, 1500);
                        } else {
                            this.showToast(data.message || 'Registration failed', false);
                        }
                    } catch (e) {
                        this.showToast('Network error, please try again.', false);
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
