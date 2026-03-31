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
                    $_SESSION['member_id'] = $member['id'];
                    $_SESSION['member_uuid'] = $member['uuid'];
                    $_SESSION['member_name'] = $member['name'];
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
                        $member = $this->authModel->getMemberByUUID($uuid);
                        if ($member) {
                            $_SESSION['member_id'] = $member['id'];
                            $_SESSION['member_uuid'] = $uuid;
                            $_SESSION['member_name'] = $name;
                            $this->redirect('forum/feed');
                        } else {
                            $error = "Registration succeeded but session could not be established.";
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
