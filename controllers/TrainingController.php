<?php
class TrainingController extends BaseController {
    public function index() {
        $model = new TrainingModel($this->db);
        $data = [
            'trainings' => $model->getAllTrainings(),
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/index", $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $model = new TrainingModel($this->db);
        $training = $model->getTrainingById($id);

        $data = [
            'training' => $training,
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/detail", $data);
    }

    public function register() {
        $id = $_GET['id'] ?? null;
        $type = $_GET['type'] ?? 'training';
        $model = new TrainingModel($this->db);

        $training = $model->getTrainingById($id);

        if (!$training || !$training['registration_available']) {
            $this->redirect('home');
        }

        $form_fields = $model->getFormFieldsByProgramId($id);
        $sections = [];
        foreach ($form_fields as $field) {
            $section_name = $field['field_section'] ?: 'Additional Information';
            $sections[$section_name][] = $field;
        }

        $data = [
            'training' => $training,
            'sections' => $sections,
            'program_id' => $id,
            'registration_type' => $type,
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/register", $data);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/trainings");
            exit();
        }

        $program_id = $_POST['program_id'] ?? 0;
        $model = new TrainingModel($this->db);
        $form_fields = $model->getFormFieldsByProgramId($program_id);

        $errors = [];
        $user_data = [];

        if (!empty($form_fields)) {
            $validation = FormBuilder::validate_dynamic_inputs($form_fields, $_POST, $_FILES);
            $errors = $validation['errors'];
            $user_data = $validation['data'];

            // Strict check for email and phone duplication
            if (isset($user_data['email']) && $model->isEmailRegistered($user_data['email'], $program_id)) {
                $errors['email'] = "This email address is already registered for this program.";
            }
            if (isset($user_data['phone']) && $model->isPhoneRegistered($user_data['phone'], $program_id)) {
                $errors['phone'] = "This phone number is already registered for this program.";
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
            // Fallback
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone_no'] ?? '';

            if (empty($firstname)) $errors['firstname'] = "First name is required.";
            if (empty($lastname)) $errors['lastname'] = "Last name is required.";

            if (empty($email)) {
                $errors['email'] = "Email is required.";
            } elseif ($model->isEmailRegistered($email, $program_id)) {
                $errors['email'] = "This email is already registered.";
            }

            if (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            } elseif ($model->isPhoneRegistered($phone, $program_id)) {
                $errors['phone'] = "This phone number is already registered.";
            }

            $user_data = ['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'phone' => $phone];
        }

        if (!empty($errors)) {
            if ($this->isAjax()) {
                $message = 'Please fix the errors in the form.';
                if (isset($errors['email']) && strpos($errors['email'], 'already registered') !== false) {
                    $message = 'Email already taken, please try again.';
                } elseif (isset($errors['phone']) && strpos($errors['phone'], 'already registered') !== false) {
                    $message = 'Phone number already registered.';
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
            header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
            exit();
        }

        try {
            $user_data_json = json_encode($user_data);

            // Use explicit registration type if provided, otherwise default to training
            $regType = $_POST['registration_type'] ?? 'training';

            $result = $model->submitRegistration($program_id, $user_data_json, $regType);

            if ($result) {
                // Trigger Admin Notification
                $adminModel = new AdminModel();
                $regData = json_decode($user_data_json, true);
                $applicant = ($regData['firstname'] ?? '') . ' ' . ($regData['lastname'] ?? '');
                $adminModel->addNotification('New Application', "$applicant has registered for a training program.", "admin/applications");

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
                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'An error occurred while processing your registration.'
                    ]);
                    exit();
                }
                $_SESSION['registration_error'] = "An error occurred while processing your registration.";
                header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                exit();
            }
        } catch (Exception $e) {
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'A database error occurred. Please try again later.'
                ]);
                exit();
            }
            $_SESSION['registration_error'] = "A database error occurred. Please try again later.";
            header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
            exit();
        }
    }
}
?>