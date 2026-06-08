<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Spider Tech CMS</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin-custom.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="admin-login-body">
    <div class="login-container" x-data="loginForm()">
        <div class="login-card">
            <div class="login-header">
                <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech Logo" class="login-logo">
                <h1>CMS Control Center</h1>
                <p>Welcome back! Please enter your credentials.</p>
            </div>

            <form @submit.prevent="submitLogin">
                <div class="form-group mb-4">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fa fa-user"></i>
                        <input type="text" id="username" x-model="formData.username" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock"></i>
                        <input type="password" id="password" x-model="formData.password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div x-show="errorMessage" x-transition class="alert alert-danger mb-4" x-text="errorMessage"></div>

                <button type="submit" class="btn btn-login w-100" :disabled="loading">
                    <span x-show="!loading">Sign In</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin me-2"></i>Authenticating...</span>
                </button>
            </form>

            <div class="login-footer">
                <p>&copy; <?= date('Y') ?> Spider Technologies. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                formData: {
                    username: '',
                    password: ''
                },
                loading: false,
                errorMessage: '',
                submitLogin() {
                    this.loading = true;
                    this.errorMessage = '';

                    const params = new URLSearchParams();
                    params.append('username', this.formData.username);
                    params.append('password', this.formData.password);

                    fetch('<?= BASE_URL ?>/admin/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: params
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.location.href = data.redirect;
                        } else {
                            this.errorMessage = data.message;
                            this.loading = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.errorMessage = 'An unexpected error occurred. Please try again.';
                        this.loading = false;
                    });
                }
            }
        }
    </script>
</body>
</html>
