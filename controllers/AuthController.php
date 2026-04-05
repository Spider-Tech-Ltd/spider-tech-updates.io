<?php

class AuthController extends BaseController {
    private $authModel;

    public function __construct() {
        parent::__construct();
        $this->authModel = new AuthModel($this->db);
    }

    public function signIn() {
        if ($this->isLoggedIn()) {
            $this->redirect('forum/feed');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $login = $_POST['login'] ?? '';
                $password = $_POST['password'] ?? '';

                $member = $this->authModel->findByEmailOrUsername($login);
                if ($member && password_verify($password, $member['password_hash'])) {
                    if ($member['is_verified'] == 0) {
                        $error = "Please verify your email address before signing in.";
                    } else {
                        $_SESSION['member_id'] = $member['id'];
                        $_SESSION['member_uuid'] = $member['uuid'];
                        $_SESSION['member_name'] = $member['name'];
                        $this->redirect('forum/feed');
                    }
                } else {
                    $error = "Invalid username/email or password.";
                }
            }
        }

        $this->render('forum/sign-in', [
            'title' => 'Sign In - Spider Tech Forum',
            'error' => $error,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function signUp() {
        if ($this->isLoggedIn()) {
            $this->redirect('forum/feed');
        }

        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $name = $_POST['name'] ?? '';
                $username = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Simple validation
                if (empty($name) || empty($username) || empty($email) || empty($password)) {
                    $error = "All fields are required.";
                } elseif ($this->authModel->findByEmailOrUsername($email) || $this->authModel->findByEmailOrUsername($username)) {
                    $error = "Username or Email already exists.";
                } else {
                    $uuid = $this->authModel->register($username, $email, $password, $name);
                    if ($uuid) {
                        // Email Verification Flow
                        $token = bin2hex(random_bytes(32)); // 64-char hex
                        $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

                        if ($this->authModel->storeVerificationToken($uuid, $token, $expiry)) {
                            $emailSent = $this->authModel->sendVerificationEmail($email, $name, $token);

                            if ($emailSent) {
                                $success = "Registration successful! Please check your email to verify your account.";
                            } else {
                                $success = "Registration successful, but we couldn't send the verification email. Please contact support.";
                            }
                        } else {
                            $error = "An error occurred while setting up verification. Please try again.";
                        }
                    } else {
                        $error = "Registration failed. Please try again.";
                    }
                }
            }
        }

        $this->render('forum/sign-up', [
            'title' => 'Join Community - Spider Tech Forum',
            'error' => $error,
            'success' => $success,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('forum');
    }
}
