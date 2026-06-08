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

                $member = $this->authModel->findByEmail($login);

                if ($member && password_verify($password, $member['password_hash'])) {
                    if ($member['is_verified'] == 0) {
                        $error = "Please verify your email address before signing in.";
                    } else {
                        $_SESSION['member_id'] = $member['id'];
                        $_SESSION['member_uuid'] = $member['uuid'];
                        $_SESSION['member_name'] = $member['name'] ?? $member['username'];
                        $_SESSION['member_status'] = $member['status'] ?? 'Active';
                        $_SESSION['terms_accepted'] = $member['terms_accepted'];

                        if ($_SESSION['member_status'] === 'Suspended') {
                            $this->redirect('forum/suspended');
                        } elseif ((int)$member['terms_accepted'] === 0) {
                            $this->redirect('forum/terms');
                        } else {
                            $this->redirect('forum/feed');
                        }
                    }
                } else {
                    $error = "Incorrect email or password.";
                }
            }
        }

        $success = $_SESSION['success_message'] ?? '';
        unset($_SESSION['success_message']);

        $this->render('forum/sign-in', [
            'title' => 'Sign In - Spider Tech Forum',
            'error' => $error,
            'success' => $success,
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
                } elseif ($this->authModel->findByEmail($email)) {
                    $error = "Email address already exists.";
                } else {
                    $uuid = $this->authModel->register($email, $email, $password, $name); // Use email as username as well to maintain integrity
                    if ($uuid) {
                        // Email Verification Flow
                        $token = bin2hex(random_bytes(32)); // 64-char hex
                        $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

                        if ($this->authModel->storeVerificationToken($uuid, $token, $expiry)) {
                            $verificationController = new VerificationController();
                            $emailSent = $verificationController->sendVerificationEmail($email, $name, $token);

                            if ($emailSent) {
                                $success = "Registration successful! Please check your email to verify your account.";
                            } else {
                                $success = "Registration successful, but we couldn't send the verification email. Please contact support.";
                            }
                            // Trigger Admin Notification
                            $adminModel = new AdminModel();
                            $adminModel->addNotification('New Member', "$name has registered as a new member.", "admin/members");
                        } else {
                            $error = "An error occurred while setting up verification. Please try again.";
                        }
                    } else {
                        $error = "Registration failed. Please try again.";
                    }
                }
            }

            if ($this->isAjax()) {
                $response = [
                    'success' => !empty($success),
                    'message' => $success ?: $error
                ];

                if (!empty($success)) {
                    $response['redirect'] = BASE_URL . '/forum/sign-in';
                    $_SESSION['success_message'] = $success;
                }

                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            if (!empty($success)) {
                $_SESSION['success_message'] = $success;
                $this->redirect('forum/sign-in');
            }
        }

        $this->render('forum/sign-up', [
            'title' => 'Join Community - Spider Tech Forum',
            'error' => $error,
            'success' => $success,
            'csrf_token' => CSRF::generateToken()
        ], false);
    }

    public function suspended()
    {
        $pendingReview = $this->authModel->getPendingReview($_SESSION['member_id'] ?? 0);
        $this->render('forum/suspended', [
            'title' => 'Account Suspended - Spider Tech Forum',
            'isUnderReview' => !empty($pendingReview)
        ], true);
    }

    public function requestReview()
    {
        header('Content-Type: application/json');
        if (!$this->isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            exit;
        }

        if (!$this->isLoggedIn()) {
            echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a review.']);
            exit;
        }

        $reason = $_POST['reason'] ?? '';
        if (empty($reason)) {
            echo json_encode(['status' => 'error', 'message' => 'Please provide a reason for the review.']);
            exit;
        }

        try {
            if ($this->authModel->submitSuspensionReview($_SESSION['member_id'], $reason)) {
                // Trigger Admin Notification
                $adminModel = new AdminModel();
                $memberName = $_SESSION['member_name'] ?? 'A member';
                $adminModel->addNotification(
                    'Review Request',
                    "$memberName has submitted an appeal for account reinstatement.",
                    "admin/members"
                );
                echo json_encode(['status' => 'success', 'message' => 'Your review request has been submitted.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to submit review request.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
        }
        exit;
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
