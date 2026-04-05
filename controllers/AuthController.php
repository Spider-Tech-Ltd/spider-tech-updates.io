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

                $member = $this->authModel->findByEmailOrUsername($login); // Currently handles both, but we'll focus UI on email
                if ($member && password_verify($password, $member['password_hash'])) {
                    $_SESSION['member_id'] = $member['id'];
                    $_SESSION['member_uuid'] = $member['uuid'];
                    $_SESSION['member_name'] = $member['name'];
                    $_SESSION['member_avatar'] = $member['avatar'];
                    $this->redirect('forum/feed');
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
                        $member = $this->authModel->getMemberByUUID($uuid);
                        if ($member) {
                            $_SESSION['member_id'] = $member['id'];
                            $_SESSION['member_uuid'] = $uuid;
                            $_SESSION['member_name'] = $name;
                            $_SESSION['member_avatar'] = $member['avatar'];

                            if ($this->isAjax()) {
                                echo json_encode(['success' => true, 'message' => 'Account created! Redirecting...', 'redirect' => BASE_URL . '/forum/feed']);
                                return;
                            }
                            $this->redirect('forum/feed');
                        } else {
                            $error = "Registration succeeded but session could not be established.";
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

    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('forum');
    }
}
