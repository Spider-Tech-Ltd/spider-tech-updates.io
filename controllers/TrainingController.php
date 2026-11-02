<?php

class TrainingController extends BaseController {
    public function index() {
        $model = new TrainingModel($this->db);
        $trainings = $model->getAllTrainings();

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel($this->db);

        foreach ($trainings as &$t) {
            $t['active_cohort'] = $cohortModel->getActiveCohort($t['id']);
            if (!$t['active_cohort']) {
                $t['upcoming_cohort'] = $cohortModel->getUpcomingCohort($t['id']);
            }
        }
        unset($t);

        $data = [
            'trainings' => $trainings,
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/index", $data);
    }

    public function detail($id = null) {
        $id = $id ?? $_GET['id'] ?? null;
        $model = new TrainingModel($this->db);
        $training = $model->getTrainingById($id);

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel($this->db);

        $activeCohort = $cohortModel->getActiveCohort($id);
        $upcomingCohort = $cohortModel->getUpcomingCohort($id);
        $allCohorts = $cohortModel->getCohortsByTrainingId($id);

        $data = [
            'training'        => $training,
            'active_cohort'   => $activeCohort,
            'upcoming_cohort' => $upcomingCohort,
            'all_cohorts'     => $allCohorts,
            'contact'         => $model->getContactDetails()
        ];
        $this->render("trainings/detail", $data);
    }

    public function register() {
        $id = $_GET['id'] ?? null;
        $type = $_GET['type'] ?? 'training';
        $cohortParam = $_GET['cohort'] ?? null;

        $model = new TrainingModel($this->db);
        $training = $model->getTrainingById($id);

        // Master switch check
        if (!$training || empty($training['registration_available'])) {
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel($this->db);

        // Resolve cohort: explicit query param (id, number, or slug) or active cohort
        $cohort = null;
        if (!empty($cohortParam)) {
            if (is_numeric($cohortParam)) {
                $cohort = $cohortModel->getCohortById((int)$cohortParam);
                if (!$cohort) {
                    $cohort = $cohortModel->getCohortByNumber($id, (int)$cohortParam);
                }
            } else {
                $cohort = $cohortModel->getCohortBySlug($cohortParam);
            }
        }
        if (!$cohort) {
            $cohort = $cohortModel->getActiveCohort($id);
        }

        // Validate cohort enrollment eligibility if training has cohorts
        $trainingCohorts = $cohortModel->getCohortsByTrainingId($id);
        if (!empty($trainingCohorts)) {
            if (!$cohort) {
                $_SESSION['registration_error'] = "Registration is currently closed for this training program.";
                header("Location: " . BASE_URL . "/trainings/detail?id=" . $id);
                exit();
            }

            $isClosed = empty($cohort['registration_open']) || $cohort['status'] === 'completed';
            $isDeadlinePassed = !empty($cohort['registration_deadline']) && strtotime($cohort['registration_deadline']) < time();
            $isFull = $cohortModel->isCohortFull($cohort['id']);

            if ($isClosed || $isDeadlinePassed || $isFull) {
                if ($isFull) {
                    $_SESSION['registration_error'] = "Registration for {$cohort['cohort_name']} is currently at full capacity.";
                } elseif ($isDeadlinePassed) {
                    $_SESSION['registration_error'] = "The application deadline for {$cohort['cohort_name']} has passed.";
                } else {
                    $_SESSION['registration_error'] = "Registration is currently closed for {$cohort['cohort_name']}.";
                }
                header("Location: " . BASE_URL . "/trainings/detail?id=" . $id);
                exit();
            }
        }

        $form_fields = $model->getFormFieldsByProgramId($id);

        // Strict 4-tier section order required: Basic Info -> Demographic Info -> Professional / Business Info -> Additional Info
        $orderedSectionKeys = [
            'Basic Info',
            'Demographic Info',
            'Professional / Business Info',
            'Additional Info'
        ];
        $sectionBuckets = array_fill_keys($orderedSectionKeys, []);

        foreach ($form_fields as $field) {
            $name = strtolower(trim($field['field_name'] ?? ''));
            $fsec = strtolower(trim($field['field_section'] ?? ''));
            $sec = strtolower(trim($field['section'] ?? ''));

            if (str_contains($fsec, 'basic') || str_contains($sec, 'personal info')) {
                if (in_array($name, ['age', 'gender', 'state_of_origin', 'local_government'])) {
                    $assigned = 'Demographic Info';
                } else {
                    $assigned = 'Basic Info';
                }
            } elseif (in_array($name, [
                'first_name', 'last_name', 'middle_name', 'firstname', 'lastname', 'full_name',
                'student_full_name', 'name', 'email', 'email_alt', 'phone', 'phone_alt', 'phone_no',
                'parent_name', 'parent_phone', 'parent_email', 'parent_relationship'
            ])) {
                $assigned = 'Basic Info';
            } elseif (in_array($name, [
                'age', 'gender', 'sex', 'date_of_birth', 'dob',
                'state_of_origin', 'state', 'local_government', 'lga', 'city',
                'address', 'parent_address', 'school_name', 'current_class', 'nationality', 'marital_status'
            ]) || str_contains($sec, 'demographic') || str_contains($fsec, 'demographic') || str_contains($fsec, 'background')) {
                $assigned = 'Demographic Info';
            } elseif (
                str_contains($name, 'business') || str_contains($name, 'work') || str_contains($name, 'company') ||
                str_contains($name, 'experience') || str_contains($name, 'qualification') || str_contains($name, 'laptop') ||
                str_contains($name, 'prior_experience') || str_contains($name, 'occupation') || str_contains($name, 'employment') ||
                str_contains($sec, 'professional') || str_contains($sec, 'business') || str_contains($sec, 'education') ||
                str_contains($fsec, 'professional')
            ) {
                if ($field['field_type'] === 'file') {
                    $assigned = 'Additional Info';
                } else {
                    $assigned = 'Professional / Business Info';
                }
            } else {
                $assigned = 'Additional Info';
            }

            $sectionBuckets[$assigned][] = $field;
        }

        $sections = [];
        foreach ($orderedSectionKeys as $sKey) {
            if (!empty($sectionBuckets[$sKey])) {
                $sections[$sKey] = $sectionBuckets[$sKey];
            }
        }

        $paymentInfo = $model->getEffectivePaymentAmount($id, $cohort['id'] ?? null);

        $data = [
            'training'          => $training,
            'cohort'            => $cohort,
            'sections'          => $sections,
            'program_id'        => $id,
            'registration_type' => $type,
            'contact'           => $model->getContactDetails(),
            'payment_info'      => $paymentInfo
        ];
        $this->render("trainings/register", $data);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        // Optional CSRF check if submitted with form
        if (!empty($_POST['csrf_token']) && !CSRF::validateToken($_POST['csrf_token'])) {
            $msg = "Invalid form submission session. Please refresh and try again.";
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit();
            }
            $_SESSION['registration_error'] = $msg;
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        $program_id = (int)($_POST['program_id'] ?? 0);
        $cohort_id  = (int)($_POST['cohort_id'] ?? 0);

        $model = new TrainingModel($this->db);
        $training = $model->getTrainingById($program_id);

        if (!$training || empty($training['registration_available'])) {
            $msg = "Registration is currently closed for this program.";
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit();
            }
            $_SESSION['registration_error'] = $msg;
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        require_once ROOT_PATH . '/models/CohortModel.php';
        $cohortModel = new CohortModel($this->db);

        // Resolve cohort
        $cohort = null;
        if ($cohort_id > 0) {
            $cohort = $cohortModel->getCohortById($cohort_id);
        }
        if (!$cohort) {
            $cohort = $cohortModel->getActiveCohort($program_id);
        }

        $errors = [];

        // Validate cohort status, deadline, and capacity
        if ($cohort) {
            if (empty($cohort['registration_open']) || $cohort['status'] === 'completed') {
                $errors['cohort'] = "Registration is closed for {$cohort['cohort_name']}.";
            } elseif (!empty($cohort['registration_deadline']) && strtotime($cohort['registration_deadline']) < time()) {
                $errors['cohort'] = "The application deadline for {$cohort['cohort_name']} has passed.";
            } elseif ($cohortModel->isCohortFull($cohort['id'])) {
                $errors['cohort'] = "{$cohort['cohort_name']} has reached maximum candidate capacity.";
            }
        }

        $form_fields = $model->getFormFieldsByProgramId($program_id);
        $user_data = [];

        if (!empty($form_fields)) {
            $validation = FormBuilder::validate_dynamic_inputs($form_fields, $_POST, $_FILES);
            $errors = array_merge($errors, $validation['errors']);
            $user_data = $validation['data'];

            // Scope email and phone check to the specific cohort (permits alumni re-registration)
            $checkCohortId = $cohort['id'] ?? null;
            if (isset($user_data['email']) && $model->isEmailRegistered($user_data['email'], $program_id, $checkCohortId)) {
                $errors['email'] = "This email address is already registered for this session.";
            }
            if (isset($user_data['phone']) && $model->isPhoneRegistered($user_data['phone'], $program_id, $checkCohortId)) {
                $errors['phone'] = "This phone number is already registered for this session.";
            }

            // Handle file uploads
            foreach ($form_fields as $field) {
                if ($field['field_type'] === 'file' && isset($_FILES[$field['field_name']]) && $_FILES[$field['field_name']]['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES[$field['field_name']];
                    $filename = time() . '_' . basename($file['name']);
                    $upload_dir = ROOT_PATH . '/images/registrations/';

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
                        $user_data[$field['field_name']] = 'images/registrations/' . $filename;
                    } else {
                        $errors[] = "Failed to upload " . $field['field_label'];
                    }
                }
            }
        } else {
            // Fallback for simple forms
            $firstname = $_POST['firstname'] ?? '';
            $lastname  = $_POST['lastname'] ?? '';
            $email     = $_POST['email'] ?? '';
            $phone     = $_POST['phone_no'] ?? '';

            if (empty($firstname)) $errors['firstname'] = "First name is required.";
            if (empty($lastname))  $errors['lastname']  = "Last name is required.";

            $checkCohortId = $cohort['id'] ?? null;
            if (empty($email)) {
                $errors['email'] = "Email is required.";
            } elseif ($model->isEmailRegistered($email, $program_id, $checkCohortId)) {
                $errors['email'] = "This email is already registered.";
            }

            if (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            } elseif ($model->isPhoneRegistered($phone, $program_id, $checkCohortId)) {
                $errors['phone'] = "This phone number is already registered.";
            }

            $user_data = ['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'phone' => $phone];
        }

        if (!empty($errors)) {
            if ($this->isAjax()) {
                $message = 'Please fix the errors in the form.';
                if (isset($errors['cohort'])) {
                    $message = $errors['cohort'];
                } elseif (isset($errors['email']) && strpos($errors['email'], 'already registered') !== false) {
                    $message = 'Email already registered for this cohort.';
                } elseif (isset($errors['phone']) && strpos($errors['phone'], 'already registered') !== false) {
                    $message = 'Phone number already registered for this cohort.';
                } elseif (count($errors) === 1) {
                    $message = reset($errors);
                }

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $message,
                    'errors' => $errors
                ]);
                exit();
            }
            $_SESSION['registration_errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $redirectUrl = BASE_URL . "/trainings/register?id=" . $program_id;
            if ($cohort) $redirectUrl .= "&cohort=" . $cohort['id'];
            header("Location: " . $redirectUrl);
            exit();
        }

        try {
            $user_data_json = json_encode($user_data);
            $regType = $_POST['registration_type'] ?? 'training';
            $assignedCohortId = $cohort['id'] ?? null;

            // Resolve payment gating
            $paymentInfo = $model->getEffectivePaymentAmount($program_id, $assignedCohortId);
            $paymentsEnabled = !empty($paymentInfo['payments_enabled']);
            $requiredAmountKobo = (int)($paymentInfo['amount_kobo'] ?? 0);

            // Path 1: PAID TRAINING FLOW
            if ($paymentsEnabled) {
                if ($requiredAmountKobo <= 0) {
                    $errMsg = "Payment is required for this program but the fee is not configured. Please contact support.";
                    if ($this->isAjax()) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $errMsg]);
                        exit();
                    }
                    $_SESSION['registration_error'] = $errMsg;
                    header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                    exit();
                }

                // Check gateway configuration
                if (!PaystackService::isConfigured()) {
                    $errMsg = "Online payment is currently undergoing maintenance. Please try again shortly or contact support.";
                    if ($this->isAjax()) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $errMsg]);
                        exit();
                    }
                    $_SESSION['registration_error'] = $errMsg;
                    header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                    exit();
                }

                // Generate unique transaction reference
                $reference = 'STP_' . $program_id . '_' . ($assignedCohortId ?: '0') . '_' . time() . '_' . substr(bin2hex(random_bytes(4)), 0, 8);

                // Insert application with status pending
                $applicationId = $model->submitRegistration($program_id, $user_data_json, $regType, $assignedCohortId, [
                    'payment_status'    => 'pending',
                    'payment_reference' => $reference,
                    'amount_paid'       => 0,
                    'currency'          => 'NGN'
                ]);

                if (!$applicationId) {
                    throw new Exception("Failed to persist registration record.");
                }

                $applicantEmail = $user_data['email'] ?? ($user_data['email_address'] ?? '');
                $applicantName  = trim(($user_data['first_name'] ?? $user_data['firstname'] ?? '') . ' ' . ($user_data['last_name'] ?? $user_data['lastname'] ?? ''));
                if (empty($applicantName)) $applicantName = $user_data['full_name'] ?? 'Applicant';

                // Initialize Paystack checkout transaction
                $initPayload = [
                    'email'        => $applicantEmail,
                    'amount'       => $requiredAmountKobo,
                    'reference'    => $reference,
                    'callback_url' => BASE_URL . '/trainings/payment/callback',
                    'metadata'     => [
                        'application_id' => $applicationId,
                        'program_id'     => $program_id,
                        'cohort_id'      => $assignedCohortId,
                        'program_name'   => $training['training_name'],
                        'applicant_name' => $applicantName,
                        'cancel_action'  => BASE_URL . '/trainings/register?id=' . $program_id . ($assignedCohortId ? '&cohort=' . $assignedCohortId : '')
                    ]
                ];

                $initResult = PaystackService::initializeTransaction($initPayload);

                if (!$initResult['success'] || empty($initResult['authorization_url'])) {
                    $payModel = new PaymentModel($this->db);
                    $payModel->markTransactionFailed($reference, $initResult['message'] ?? 'Gateway initialization error');

                    $errMsg = "Could not initialize payment: " . ($initResult['message'] ?? 'Please try again.');
                    if ($this->isAjax()) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $errMsg]);
                        exit();
                    }
                    $_SESSION['registration_error'] = $errMsg;
                    header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                    exit();
                }

                // Record initial transaction attempt
                $payModel = new PaymentModel($this->db);
                $payModel->createTransaction(
                    $applicationId,
                    $program_id,
                    $assignedCohortId,
                    $reference,
                    $requiredAmountKobo,
                    $applicantEmail,
                    $initPayload['metadata']
                );

                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success'          => true,
                        'requires_payment' => true,
                        'redirect_url'     => $initResult['authorization_url'],
                        'reference'        => $reference,
                        'message'          => 'Application registered. Redirecting to payment checkout...'
                    ]);
                    exit();
                }

                header("Location: " . $initResult['authorization_url']);
                exit();
            }

            // Path 2: FREE TRAINING FLOW (Existing behavior preserved 100%)
            $result = $model->submitRegistration($program_id, $user_data_json, $regType, $assignedCohortId, [
                'payment_status'    => 'not_required',
                'payment_reference' => null,
                'amount_paid'       => 0,
                'currency'          => 'NGN'
            ]);

            if ($result) {
                // Trigger Admin Notification
                $adminModel = new AdminModel();
                $applicant = trim(($user_data['first_name'] ?? $user_data['firstname'] ?? '') . ' ' . ($user_data['last_name'] ?? $user_data['lastname'] ?? ''));
                if (empty($applicant)) $applicant = $user_data['full_name'] ?? 'Applicant';

                $cohortLabel = $cohort ? " ({$cohort['cohort_name']})" : "";
                $adminModel->addNotification(
                    'New Cohort Application',
                    "{$applicant} registered for {$training['training_name']}{$cohortLabel}.",
                    "admin/applications"
                );

                // Send transactional confirmation email to applicant via PHPMailer
                if (!empty($user_data['email'])) {
                    require_once ROOT_PATH . '/utils/MailHelper.php';
                    MailHelper::sendCohortRegistrationConfirmation(
                        $user_data['email'],
                        $applicant,
                        $training['training_name'],
                        $cohort
                    );
                }

                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success'          => true,
                        'requires_payment' => false,
                        'message'          => 'Thank you for registering! We have received your application.',
                        'redirect'         => BASE_URL . "/trainings/detail?id=" . $program_id
                    ]);
                    exit();
                }
                $_SESSION['registration_success'] = "Thank you for registering! We have received your application.";
                header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                exit();
            } else {
                $err = "An error occurred while processing your registration.";
                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $err]);
                    exit();
                }
                $_SESSION['registration_error'] = $err;
                header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                exit();
            }
        } catch (Exception $e) {
            $err = "A database error occurred. Please try again later.";
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $err]);
                exit();
            }
            $_SESSION['registration_error'] = $err;
            header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
            exit();
        }
    }

    /**
     * Paystack Callback URL Handler (Browser Return)
     */
    public function paymentCallback() {
        $reference = trim($_GET['reference'] ?? '');
        if (empty($reference)) {
            $_SESSION['registration_error'] = "Missing payment reference.";
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        $payModel = new PaymentModel($this->db);
        $transaction = $payModel->getTransactionByReference($reference);
        $application = $payModel->getApplicationByReference($reference);

        if (!$application) {
            $_SESSION['registration_error'] = "Application not found for transaction reference {$reference}.";
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        // Call Paystack verification API
        $verifyResult = PaystackService::verifyTransaction($reference);

        if ($verifyResult['success'] && $verifyResult['paid']) {
            $expectedAmountKobo = (int)($transaction['amount'] ?? 0);

            // Amount and currency validation
            if ($verifyResult['currency'] !== 'NGN' || $verifyResult['amount'] !== $expectedAmountKobo) {
                $payModel->markTransactionFailed($reference, "Amount or currency mismatch: expected {$expectedAmountKobo} NGN, got {$verifyResult['amount']} {$verifyResult['currency']}");
                $this->render("trainings/payment-failed", [
                    'error'       => "Payment amount mismatch detected. Please contact admissions support with reference: {$reference}.",
                    'reference'   => $reference,
                    'application' => $application
                ]);
                return;
            }

            // Atomically mark success (guaranteed exactly once)
            $isFirstSuccess = $payModel->markTransactionSuccess(
                $reference,
                (string)($verifyResult['data']['id'] ?? ''),
                $verifyResult['channel'],
                $verifyResult['gateway_response'],
                $verifyResult['paid_at']
            );

            $invoiceNumber = $application['invoice_number'] ?: $payModel->generateInvoiceNumber((int)$application['id']);

            $payModel->updateApplicationPaymentSuccess(
                (int)$application['id'],
                $reference,
                $verifyResult['amount'],
                $invoiceNumber,
                $verifyResult['paid_at']
            );

            // Refresh application data
            $application = $payModel->getApplicationById((int)$application['id']);

            // Send Invoice Email exactly once
            if ($isFirstSuccess || empty($application['invoice_sent_at'])) {
                $userData = json_decode($application['user_data'] ?? '{}', true) ?: [];
                $applicantName = trim(($userData['first_name'] ?? $userData['firstname'] ?? '') . ' ' . ($userData['last_name'] ?? $userData['lastname'] ?? ''));
                if (empty($applicantName)) $applicantName = $userData['full_name'] ?? 'Applicant';
                $applicantEmail = $userData['email'] ?? ($userData['email_address'] ?? ($transaction['customer_email'] ?? ''));

                $token = PaystackService::generateInvoiceToken($reference);
                $receiptUrl = BASE_URL . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($token);

                require_once ROOT_PATH . '/utils/MailHelper.php';
                MailHelper::sendPaymentReceipt($applicantEmail, $applicantName, [
                    'invoice_number' => $invoiceNumber,
                    'program_name'   => $application['training_name'],
                    'cohort_name'    => $application['cohort_name'] ?? 'Upcoming Cohort',
                    'amount_kobo'    => $verifyResult['amount'],
                    'paid_at'        => $verifyResult['paid_at'] ?? date('Y-m-d H:i:s'),
                    'channel'        => $verifyResult['channel'],
                    'reference'      => $reference,
                    'receipt_url'    => $receiptUrl
                ]);

                $payModel->markInvoiceSent((int)$application['id']);

                // Notify admin
                $adminModel = new AdminModel();
                $adminModel->addNotification(
                    'Enrollment Payment Confirmed',
                    "Payment of " . PaystackService::formatKobo($verifyResult['amount']) . " received from {$applicantName} for {$application['training_name']}.",
                    "admin/applications"
                );
            }

            $token = PaystackService::generateInvoiceToken($reference);
            $this->render("trainings/payment-success", [
                'application'    => $application,
                'invoice_number' => $invoiceNumber,
                'reference'      => $reference,
                'invoice_token'  => $token,
                'amount_kobo'    => $verifyResult['amount']
            ]);
            return;
        } else {
            $payModel->markTransactionFailed($reference, $verifyResult['message'] ?? 'Transaction was not completed.');
            $this->render("trainings/payment-failed", [
                'error'       => $verifyResult['message'] ?? 'Payment was cancelled or unsuccessful. You may try again.',
                'reference'   => $reference,
                'application' => $application
            ]);
            return;
        }
    }

    /**
     * Paystack Authoritative Webhook Receiver (Server-to-Server)
     */
    public function paymentWebhook() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $rawBody = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] ?? '';

        if (!PaystackService::verifyWebhookSignature($rawBody, $signature)) {
            http_response_code(400);
            exit('Invalid signature');
        }

        $event = json_decode($rawBody, true);
        if (!$event || empty($event['event'])) {
            http_response_code(400);
            exit('Invalid payload');
        }

        if ($event['event'] === 'charge.success') {
            $tx = $event['data'] ?? [];
            $reference = $tx['reference'] ?? '';

            if (!empty($reference)) {
                $payModel = new PaymentModel($this->db);
                $transaction = $payModel->getTransactionByReference($reference);
                $application = $payModel->getApplicationByReference($reference);

                if ($application && $transaction) {
                    $expectedAmountKobo = (int)$transaction['amount'];
                    $paidAmountKobo = (int)($tx['amount'] ?? 0);
                    $paidCurrency = $tx['currency'] ?? 'NGN';

                    if ($paidCurrency === 'NGN' && $paidAmountKobo === $expectedAmountKobo) {
                        $isFirstSuccess = $payModel->markTransactionSuccess(
                            $reference,
                            (string)($tx['id'] ?? ''),
                            $tx['channel'] ?? 'card',
                            $tx['gateway_response'] ?? 'Successful',
                            $tx['paid_at'] ?? null
                        );

                        $invoiceNumber = $application['invoice_number'] ?: $payModel->generateInvoiceNumber((int)$application['id']);

                        $payModel->updateApplicationPaymentSuccess(
                            (int)$application['id'],
                            $reference,
                            $paidAmountKobo,
                            $invoiceNumber,
                            $tx['paid_at'] ?? null
                        );

                        if ($isFirstSuccess || empty($application['invoice_sent_at'])) {
                            $userData = json_decode($application['user_data'] ?? '{}', true) ?: [];
                            $applicantName = trim(($userData['first_name'] ?? $userData['firstname'] ?? '') . ' ' . ($userData['last_name'] ?? $userData['lastname'] ?? ''));
                            if (empty($applicantName)) $applicantName = $userData['full_name'] ?? 'Applicant';
                            $applicantEmail = $userData['email'] ?? ($userData['email_address'] ?? ($transaction['customer_email'] ?? ''));

                            $token = PaystackService::generateInvoiceToken($reference);
                            $receiptUrl = BASE_URL . "/trainings/invoice?ref=" . urlencode($reference) . "&token=" . urlencode($token);

                            require_once ROOT_PATH . '/utils/MailHelper.php';
                            MailHelper::sendPaymentReceipt($applicantEmail, $applicantName, [
                                'invoice_number' => $invoiceNumber,
                                'program_name'   => $application['training_name'],
                                'cohort_name'    => $application['cohort_name'] ?? 'Upcoming Cohort',
                                'amount_kobo'    => $paidAmountKobo,
                                'paid_at'        => $tx['paid_at'] ?? date('Y-m-d H:i:s'),
                                'channel'        => $tx['channel'] ?? 'card',
                                'reference'      => $reference,
                                'receipt_url'    => $receiptUrl
                            ]);

                            $payModel->markInvoiceSent((int)$application['id']);

                            $adminModel = new AdminModel();
                            $adminModel->addNotification(
                                'Enrollment Payment Confirmed (Webhook)',
                                "Payment of " . PaystackService::formatKobo($paidAmountKobo) . " received from {$applicantName} for {$application['training_name']}.",
                                "admin/applications"
                            );
                        }
                    }
                }
            }
        }

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit();
    }

    /**
     * Standalone Official Printable Invoice / Receipt View
     */
    public function viewInvoice() {
        $reference = trim($_GET['ref'] ?? '');
        $token     = trim($_GET['token'] ?? '');

        if (empty($reference)) {
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        $isAdmin = !empty($_SESSION['admin_id']);

        // Non-admin viewers must provide a valid cryptographic token to prevent ID enumeration
        if (!$isAdmin && !PaystackService::validateInvoiceToken($reference, $token)) {
            http_response_code(403);
            echo "Access denied: Invalid or expired invoice link.";
            exit();
        }

        $payModel = new PaymentModel($this->db);
        $application = $payModel->getApplicationByReference($reference);

        if (!$application || $application['payment_status'] !== 'success') {
            http_response_code(404);
            echo "Paid invoice not found for reference: " . htmlspecialchars($reference);
            exit();
        }

        $this->render("trainings/invoice", [
            'application' => $application,
            'reference'   => $reference
        ]);
    }
}
