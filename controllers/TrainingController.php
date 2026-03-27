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
        $data = [
            'training' => $model->getTrainingById($id),
            'contact' => $model->getContactDetails()
        ];
        $this->render("trainings/detail", $data);
    }

    public function register() {
        $id = $_GET['id'] ?? null;
        $model = new TrainingModel($this->db);
        $training = $model->getTrainingById($id);

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

            if (empty($firstname)) $errors[] = "First name is required.";
            if (empty($lastname)) $errors[] = "Last name is required.";
            if (empty($email)) $errors[] = "Email is required.";
            if (empty($phone)) $errors[] = "Phone is required.";

            $user_data = ['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'phone' => $phone];
        }

        session_start();
        if (!empty($errors)) {
            $_SESSION['registration_error'] = implode("<br>", $errors);
            header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
            exit();
        }

        try {
            $user_data_json = json_encode($user_data);
            $result = $model->submitRegistration($program_id, $user_data_json);

            if ($result) {
                $_SESSION['registration_success'] = "Thank you for registering! We have received your application.";
                header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                exit();
            } else {
                $_SESSION['registration_error'] = "An error occurred while processing your registration.";
                header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['registration_error'] = "A database error occurred. Please try again later.";
            header("Location: " . BASE_URL . "/trainings/register?id=" . $program_id);
            exit();
        }
    }
}
?>