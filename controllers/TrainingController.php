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

        $data = [
            'training'          => $training,
            'cohort'            => $cohort,
            'sections'          => $sections,
            'program_id'        => $id,
            'registration_type' => $type,
            'contact'           => $model->getContactDetails()
        ];
        $this->render("trainings/register", $data);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

            $result = $model->submitRegistration($program_id, $user_data_json, $regType, $assignedCohortId);

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
                        'success' => true,
                        'message' => 'Thank you for registering! We have received your application.',
                        'redirect' => BASE_URL . "/trainings/detail?id=" . $program_id
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
}
