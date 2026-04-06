<?php

class AuthController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        parent::__construct();
        $this->authModel = new AuthModel($this->db);
    }

    public function signIn()
    {
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

                $member = $this->authModel->findByEmailOrUsername($login); // Currently handles both, but we'll focus UI on email
                if ($member && password_verify($password, $member['password_hash'])) {
                    if ($member['is_verified'] == 0) {
                        $error = "Please verify your email address before signing in.";
                    } else {
                        $_SESSION['member_id'] = $member['id'];
                        $_SESSION['member_uuid'] = $member['uuid'];
                        $_SESSION['member_name'] = $member['name'];
                        $_SESSION['terms_accepted'] = $member['terms_accepted'];

                        if ($member['terms_accepted'] == 0) {
                            $this->redirect('forum/terms');
                        }
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

    public function signUp()
    {
        if ($this->isLoggedIn()) {
            if ($this->isAjax()) {
                echo json_encode(['success' => true, 'redirect' => BASE_URL . '/forum/feed']);
                return;
            }
            $this->redirect('forum/feed');
        }

        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
                $error = "Invalid CSRF token.";
            } else {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Password Regex: 1 Uppercase, 1 Lowercase, 1 Special Char, 1 Number, min 8 chars
                $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/';

                // Validation
                if (empty($name) || empty($email) || empty($password)) {
                    $error = "All fields are required.";
                } elseif (!preg_match($regex, $password)) {
                    $error = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
                } elseif ($this->authModel->findByEmailOrUsername($email)) {
                    $error = "Email address already exists.";
                } else {
                    $uuid = $this->authModel->register($email, $email, $password, $name); // Use email as username as well to maintain integrity
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

            if ($this->isAjax()) {
                echo json_encode(['success' => false, 'message' => $error]);
                return;
            }
        }

        $this->render('forum/sign-up', [
            'title' => 'Join Community - Spider Tech Forum',
            'error' => $error,
            'success' => $success,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('forum');
    }
}
