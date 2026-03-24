<?php
session_start();
require('connect.php');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../register-program.php");
  exit();
}

if (isset($_POST['register'])) {
  // Sanitize inputs
  $program_id = isset($_POST['program_id']) ? intval($_POST['program_id']) : 0;
  $program_name = isset($_POST['program_name']) ? htmlspecialchars($_POST['program_name'], ENT_QUOTES) : '';
  $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : '';
  $middlename = isset($_POST['middlename']) ? htmlspecialchars($_POST['middlename'], ENT_QUOTES) : '';
  $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : '';
  $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : '';
  $phone_no = isset($_POST['phone_no']) ? htmlspecialchars($_POST['phone_no'], ENT_QUOTES) : '';
  $age = isset($_POST['age']) ? intval($_POST['age']) : null;
  $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender'], ENT_QUOTES) : '';
  $occupation = isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation'], ENT_QUOTES) : '';
  $organization = isset($_POST['organization']) ? htmlspecialchars($_POST['organization'], ENT_QUOTES) : '';
  $experience_level = isset($_POST['experience_level']) ? htmlspecialchars($_POST['experience_level'], ENT_QUOTES) : '';
  $learning_goals = isset($_POST['learning_goals']) ? htmlspecialchars($_POST['learning_goals'], ENT_QUOTES) : '';
  $special_requirements = isset($_POST['special_requirements']) ? htmlspecialchars($_POST['special_requirements'], ENT_QUOTES) : '';

  // Initialize error tracking
  $errors = [];

  // ===== VALIDATION =====

  // Check program ID
  if ($program_id <= 0) {
    $errors[] = "Invalid program selected.";
  } else {
    // Verify program exists
    $verify_program = $conn->prepare("SELECT id FROM `trainings_tb` WHERE id = ?");
    $verify_program->execute([$program_id]);
    if ($verify_program->rowCount() === 0) {
      $errors[] = "The selected program does not exist.";
    }
  }

  // Validate first name
  if (empty($firstname)) {
    $errors[] = "First name is required.";
  } elseif (strlen($firstname) < 2) {
    $errors[] = "First name must be at least 2 characters.";
  } elseif (strlen($firstname) > 50) {
    $errors[] = "First name cannot exceed 50 characters.";
  }

  // Validate last name
  if (empty($lastname)) {
    $errors[] = "Last name is required.";
  } elseif (strlen($lastname) < 2) {
    $errors[] = "Last name must be at least 2 characters.";
  } elseif (strlen($lastname) > 50) {
    $errors[] = "Last name cannot exceed 50 characters.";
  }

  // Validate email
  if (empty($email)) {
    $errors[] = "Email address is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  } elseif (strlen($email) > 100) {
    $errors[] = "Email address is too long.";
  }

  // Validate phone number
  if (empty($phone_no)) {
    $errors[] = "Phone number is required.";
  } elseif (strlen($phone_no) < 10) {
    $errors[] = "Phone number must be at least 10 digits.";
  } elseif (strlen($phone_no) > 20) {
    $errors[] = "Phone number is invalid.";
  }

  // Validate age if provided
  if (!empty($age)) {
    if ($age < 13 || $age > 120) {
      $errors[] = "Please enter a valid age (13-120).";
    }
  }

  // Validate gender if provided
  if (!empty($gender)) {
    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
      $errors[] = "Invalid gender selection.";
    }
  }

  // Validate experience level if provided
  if (!empty($experience_level)) {
    if (!in_array($experience_level, ['Beginner', 'Intermediate', 'Advanced', 'Expert'])) {
      $errors[] = "Invalid experience level selected.";
    }
  }

  // Check for duplicate registration (same person, same program)
  if (empty($errors)) {
    $check_duplicate = $conn->prepare("
            SELECT id FROM `program_registrations` 
            WHERE program_id = ? AND email = ? AND phone_no = ?
            LIMIT 1
        ");
    $check_duplicate->execute([$program_id, $email, $phone_no]);
    if ($check_duplicate->rowCount() > 0) {
      $errors[] = "You have already registered for this program. Please check your email for confirmation details.";
    }
  }

  // ===== ERROR HANDLING =====
  if (!empty($errors)) {
    $_SESSION['registration_error'] = implode("<br>", $errors);
    header("Location: ../register-program.php?id=" . $program_id);
    exit();
  }

  // ===== INSERT INTO DATABASE =====
  try {
    $insert_stmt = $conn->prepare("
            INSERT INTO `program_registrations` 
            (program_id, program_name, firstname, middlename, lastname, email, phone_no, 
             age, gender, occupation, organization, experience_level, learning_goals, 
             special_requirements, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
        ");

    $result = $insert_stmt->execute([
      $program_id,
      $program_name,
      $firstname,
      $middlename,
      $lastname,
      $email,
      $phone_no,
      $age,
      $gender,
      $occupation,
      $organization,
      $experience_level,
      $learning_goals,
      $special_requirements
    ]);

    if ($result) {
      // Send confirmation email
      $to = $email;
      $subject = "Registration Confirmation - " . $program_name;

      $body = "
            <html>
            <head>
                <title>Registration Confirmation</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #f48221; color: white; padding: 20px; border-radius: 5px; }
                    .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; border-radius: 5px; }
                    .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #999; }
                    .detail-row { margin-bottom: 10px; }
                    .detail-label { font-weight: bold; color: #f48221; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2 style='margin: 0;'>Registration Confirmed!</h2>
                    </div>
                    <div class='content'>
                        <p>Dear " . htmlspecialchars($firstname) . ",</p>
                        <p>Thank you for registering for our program! We're excited to have you join us.</p>
                        
                        <div class='detail-row'>
                            <span class='detail-label'>Program:</span> " . htmlspecialchars($program_name) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Registration Date:</span> " . date('F j, Y') . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Status:</span> Pending Review
                        </div>
                        
                        <p style='margin-top: 20px;'>
                            We will contact you soon at <strong>" . htmlspecialchars($phone_no) . "</strong> with further details about the program schedule, requirements, and next steps.
                        </p>
                        
                        <p>
                            If you have any questions, please feel free to reach out to us.
                        </p>
                        
                        <p style='margin-top: 20px;'>
                            Best regards,<br>
                            <strong>Spider Tech Hub</strong>
                        </p>
                    </div>
                    <div class='footer'>
                        <p>This is an automated email from Spider Tech Hub. Please do not reply directly to this email.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=UTF-8\r\n";
      $headers .= "From: noreply@spidertech.com\r\n";

      @mail($to, $subject, $body, $headers);

      // Set success message and redirect
      $_SESSION['registration_success'] = "Thank you for registering! We have received your registration and will be in touch shortly.";
      header("Location: ../register-program.php?id=" . $program_id);
      exit();
    } else {
      $_SESSION['registration_error'] = "An error occurred while processing your registration. Please try again later.";
      header("Location: ../register-program.php?id=" . $program_id);
      exit();
    }
  } catch (PDOException $e) {
    error_log("Registration Error: " . $e->getMessage());
    $_SESSION['registration_error'] = "A database error occurred. Our team has been notified. Please try again later.";
    header("Location: ../register-program.php?id=" . $program_id);
    exit();
  }
} else {
  // No registration data submitted
  header("Location: ../register-program.php");
  exit();
}
