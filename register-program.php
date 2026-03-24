<?php
require('includes/connect.php');
require('includes/form_builder.php');

$program_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch program details
$select_program = $conn->prepare("SELECT * FROM `trainings_tb` WHERE id = ? LIMIT 1");
$select_program->execute([$program_id]);
$program = $select_program->fetch(PDO::FETCH_ASSOC);

// Fetch custom form fields for this program
$select_fields = $conn->prepare("SELECT * FROM `training_form_fields` WHERE program_id = ? ORDER BY field_order ASC");
$select_fields->execute([$program_id]);
$form_fields = $select_fields->fetchAll(PDO::FETCH_ASSOC);

// Fetch contact details for footer
$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

$contact = $fetch_contact ?: [];
$contact_email = !empty($contact['email']) ? htmlspecialchars($contact['email']) : 'info@spidertech.com';
$contact_phone = !empty($contact['phone']) ? htmlspecialchars($contact['phone']) : '+234 000 000 0000';

// Clean HTML output
function cleanText($text)
{
  return htmlspecialchars(strip_tags($text));
}

$success_msg = "";
$error_msg = "";

// Check if form was submitted successfully (from session)
if (isset($_SESSION['registration_success'])) {
  $success_msg = $_SESSION['registration_success'];
  unset($_SESSION['registration_success']);
}
if (isset($_SESSION['registration_error'])) {
  $error_msg = $_SESSION['registration_error'];
  unset($_SESSION['registration_error']);
}

// Set breadcrumb for registration page
$breadcrumb_current = 'Register' . (isset($program['training_name']) ? ' - ' . htmlspecialchars(strip_tags($program['training_name'])) : '');
?>

<!doctype html>
<html lang="en">

<head>
  <?php require('head-section.html'); ?>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .registration-hero {
      background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
      padding: 60px 0;
      color: #fff;
      text-align: center;
    }

    .registration-hero-title {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 10px;
    }

    .registration-hero-subtitle {
      font-size: 1.1rem;
      opacity: 0.8;
    }

    .registration-intro {
      padding: 60px 0;
    }

    .registration-form-wrapper {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      padding: 40px;
      max-width: 800px;
      margin: -100px auto 0;
      position: relative;
      z-index: 10;
    }

    .form-section-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 30px 0 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f48221;
      color: #333;
    }

    .form-group label {
      font-weight: 600;
      color: #444;
      margin-bottom: 8px;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px 15px;
      border: 1px solid #ddd;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #f48221;
      box-shadow: 0 0 0 0.2rem rgba(244, 130, 33, 0.15);
    }

    .program-info-box {
      background: #fef4ea;
      border-left: 4px solid #f48221;
      padding: 20px;
      border-radius: 0 8px 8px 0;
      margin-bottom: 30px;
    }

    .program-info-box h4 {
      color: #f48221;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .submit-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      background: #f48221;
      color: #fff !important;
      border: none;
      border-radius: 50px;
      padding: 14px 32px;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    .submit-btn:hover {
      background: #e6751c;
      color: #fff !important;
      text-decoration: none !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(244, 130, 33, 0.3);
    }

    .cancel-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      background: #fff;
      color: #f48221;
      border: 2px solid #f48221;
      border-radius: 50px;
      padding: 12px 32px;
      font-weight: 700;
      text-decoration: none;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .cancel-btn:hover {
      background: #fef4ea;
      text-decoration: none;
    }

    .btn-group {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 15px;
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .btn-group {
        grid-template-columns: 1fr;
      }
    }

    .alert-success,
    .alert-error {
      padding: 15px 20px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .required-note {
      font-size: 0.85rem;
      color: #999;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #eee;
    }
  </style>
</head>

<body>
  <?php require('includes/preloader.html'); ?>

  <!-- Breadcrumb Navigation -->
  <?php require('includes/breadcrumbs.html'); ?>

  <!-- Header -->
  <?php require('header-section.php'); ?>

  <?php if (!$program) : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <h1 class="registration-hero-title">Program Not Found</h1>
        <p class="registration-hero-subtitle">The program you're trying to register for does not exist or may have been removed.</p>
        <a class="cancel-btn" href="trainings.php" style="margin-top: 20px; display: inline-flex;">Back to Programs</a>
      </div>
    </section>
  <?php else : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <h1 class="registration-hero-title">Register for <?= cleanText($program['training_name']); ?></h1>
        <p class="registration-hero-subtitle">Complete the form below to register for this program</p>
      </div>
    </section>

    <section class="registration-intro">
      <div class="container">
        <div class="registration-form-wrapper">

          <?php if (!empty($success_msg)) : ?>
            <div class="alert-success">
              <strong>Success!</strong> <?= $success_msg; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($error_msg)) : ?>
            <div class="alert-error">
              <strong>Error!</strong> <?= $error_msg; ?>
            </div>
          <?php endif; ?>

          <!-- Program Information Box -->
          <div class="program-info-box">
            <h4><?= cleanText($program['training_name']); ?></h4>
            <p><?= cleanText($program['training_description']); ?></p>
          </div>

          <!-- Registration Form -->
          <form method="POST" action="includes/submit_program_registration.php" id="registrationForm" enctype="multipart/form-data">
            <!-- Hidden fields -->
            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
            <input type="hidden" name="program_name" value="<?= cleanText($program['training_name']); ?>">

            <?php if (!empty($form_fields)) : ?>
              <h3 class="form-section-title">Program Registration Details</h3>

              <?php foreach ($form_fields as $field) : ?>
                <?= render_form_field($field); ?>
              <?php endforeach; ?>

            <?php else : ?>
              <div class="alert alert-warning">
                No custom registration fields defined for this program. Using standard registration.
              </div>

              <!-- Fallback to static fields if no custom fields defined -->
              <h3 class="form-section-title">Personal Information</h3>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="firstname">First Name <span class="text-danger">*</span></label>
                  <input type="text" id="firstname" name="firstname" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="lastname">Last Name <span class="text-danger">*</span></label>
                  <input type="text" id="lastname" name="lastname" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email Address <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="phone_no">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" id="phone_no" name="phone_no" class="form-control" required>
              </div>
            <?php endif; ?>

            <!-- Submit Buttons -->
            <div class="btn-group">
              <button type="submit" name="register" class="submit-btn">
                <span class="material-symbols-outlined" style="font-size:20px;">check_circle</span>
                Complete Registration
              </button>
              <a href="program-detail.php?id=<?= $program_id; ?>" class="cancel-btn">Back to Program</a>
            </div>

            <div class="required-note">
              <small>* Indicates required fields. All information is kept confidential and is used only for program administration.</small>
            </div>
          </form>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php require('footer-section.php'); ?>
  <?php require('javascript-section.html'); ?>
</body>

</html>
