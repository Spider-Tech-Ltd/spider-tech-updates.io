<?php
session_start();
require('connect.php');
require('form_builder.php');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../register-program.php");
  exit();
}

if (isset($_POST['register'])) {
  $program_id = isset($_POST['program_id']) ? intval($_POST['program_id']) : 0;
  $program_name = isset($_POST['program_name']) ? htmlspecialchars($_POST['program_name'], ENT_QUOTES) : 'Program';

  // Fetch custom form fields for this program
  $select_fields = $conn->prepare("SELECT * FROM `training_form_fields` WHERE program_id = ? ORDER BY field_order ASC");
  $select_fields->execute([$program_id]);
  $form_fields = $select_fields->fetchAll(PDO::FETCH_ASSOC);

  $errors = [];
  $user_data = [];

  if (!empty($form_fields)) {
    // Validate dynamic inputs
    $validation = validate_dynamic_inputs($form_fields, $_POST, $_FILES);
    $errors = $validation['errors'];
    $user_data = $validation['data'];

    // Handle file uploads
    foreach ($form_fields as $field) {
        if ($field['field_type'] === 'file' && isset($_FILES[$field['field_name']]) && $_FILES[$field['field_name']]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$field['field_name']];
            $filename = time() . '_' . basename($file['name']);
            $upload_dir = '../images/registrations/';

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
    // Fallback logic if no custom fields defined
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : '';
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : '';
    $phone = isset($_POST['phone_no']) ? htmlspecialchars($_POST['phone_no'], ENT_QUOTES) : '';

    if (empty($firstname)) $errors[] = "First name is required.";
    if (empty($lastname)) $errors[] = "Last name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($phone)) $errors[] = "Phone is required.";

    $user_data = ['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'phone' => $phone];
  }

  // ===== ERROR HANDLING =====
  if (!empty($errors)) {
    $_SESSION['registration_error'] = implode("<br>", $errors);
    header("Location: ../register-program.php?id=" . $program_id);
    exit();
  }

  // ===== INSERT INTO DATABASE =====
  try {
    $user_data_json = json_encode($user_data);
    $insert_stmt = $conn->prepare("
            INSERT INTO `training_registrations` (program_id, user_data)
            VALUES (?, ?)
        ");

    $result = $insert_stmt->execute([$program_id, $user_data_json]);

    if ($result) {
      $_SESSION['registration_success'] = "Thank you for registering! We have received your application for " . $program_name . ".";
      header("Location: ../register-program.php?id=" . $program_id);
      exit();
    } else {
      $_SESSION['registration_error'] = "An error occurred while processing your registration.";
      header("Location: ../register-program.php?id=" . $program_id);
      exit();
    }
  } catch (PDOException $e) {
    error_log("Registration Error: " . $e->getMessage());
    $_SESSION['registration_error'] = "A database error occurred. Please try again later.";
    header("Location: ../register-program.php?id=" . $program_id);
    exit();
  }
} else {
  header("Location: ../register-program.php");
  exit();
}
