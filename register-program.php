<?php
session_start();
require('includes/connect.php');
require('includes/form_builder.php');

$program_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch program details
$select_program = $conn->prepare("SELECT * FROM `trainings_tb` WHERE id = ? LIMIT 1");
$select_program->execute([$program_id]);
$program = $select_program->fetch(PDO::FETCH_ASSOC);

// Fetch custom form fields for this program grouped by section
$select_fields = $conn->prepare("SELECT * FROM `training_form_fields` WHERE program_id = ? ORDER BY field_section ASC, field_order ASC");
$select_fields->execute([$program_id]);
$form_fields = $select_fields->fetchAll(PDO::FETCH_ASSOC);

// Group fields by section for rendering
$sections = [];
foreach ($form_fields as $field) {
    $section_name = $field['field_section'] ?: 'Other Info';
    $sections[$section_name][] = $field;
}

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

    /* Restore Light Orange Hero Section */
    .registration-hero {
      background: linear-gradient(135deg, #fef4ea 0%, #fff7f0 100%);
      padding: 80px 0;
      color: #333;
      text-align: center;
      position: relative;
      border-bottom: 1px solid #fce3cc;
    }

    .registration-hero-title {
      font-size: 2.8rem;
      font-weight: 800;
      margin-bottom: 15px;
      color: #1a1a1a;
    }

    .registration-hero-subtitle {
      font-size: 1.2rem;
      color: #666;
      max-width: 600px;
      margin: 0 auto;
    }

    .registration-intro {
      padding: 60px 0 100px;
      position: relative;
      z-index: 20;
    }

    .registration-form-wrapper {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
      padding: 50px;
      max-width: 950px;
      margin: 0 auto;
      border: 1px solid #eee;
    }

    .form-section-title {
      font-size: 1.4rem;
      font-weight: 700;
      margin: 40px 0 25px;
      padding-bottom: 12px;
      border-bottom: 3px solid #f48221;
      color: #1a1a1a;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-section-title:first-child {
      margin-top: 0;
    }

    .program-info-box {
      background: #fef4ea;
      border-left: 5px solid #f48221;
      padding: 25px;
      border-radius: 0 15px 15px 0;
      margin-bottom: 40px;
    }

    .program-info-box h4 {
      color: #f48221;
      font-weight: 800;
      margin-bottom: 8px;
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
      padding: 16px 40px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    .submit-btn:hover {
      background: #e6751c;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(244, 130, 33, 0.3);
    }

    .cancel-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: #fff;
      color: #f48221;
      border: 2px solid #f48221;
      border-radius: 50px;
      padding: 14px 35px;
      font-weight: 700;
      text-decoration: none;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
    }

    .cancel-btn:hover {
      background: #fef4ea;
      text-decoration: none;
    }

    .btn-group {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 20px;
      margin-top: 40px;
      padding-top: 30px;
      border-top: 1px solid #eee;
    }

    @media (max-width: 768px) {
      .btn-group {
        grid-template-columns: 1fr;
      }
      .registration-form-wrapper {
        padding: 30px 20px;
      }
      .registration-hero-title {
        font-size: 2rem;
      }
    }

    /* Input focus effects */
    .form-control:focus, .custom-select:focus {
      border-color: #f48221 !important;
      box-shadow: 0 0 0 0.2rem rgba(244, 130, 33, 0.15) !important;
    }

    /* Dropdown fix */
    .custom-select {
        background-color: #fff;
        cursor: pointer;
        padding-right: 40px;
    }

    .required-note {
      font-size: 0.9rem;
      color: #777;
      margin-top: 25px;
      font-style: italic;
    }

    /* Ensure icons are aligned */
    .material-symbols-outlined {
        vertical-align: middle;
    }
  </style>
</head>

<body class="registration-page">
  <?php require('includes/preloader.html'); ?>

  <!-- Breadcrumb Navigation -->
  <?php require('includes/breadcrumbs.html'); ?>

  <!-- Header -->
  <?php require('header-section.php'); ?>

  <?php if (!$program) : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <h1 class="registration-hero-title">Program Not Found</h1>
        <p class="registration-hero-subtitle text-danger">The program you're trying to register for does not exist or may have been removed.</p>
        <a class="cancel-btn" href="trainings.php" style="margin-top: 30px;">Back to Programs</a>
      </div>
    </section>
  <?php else : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <div class="badge px-3 py-2 mb-3" style="background: rgba(244, 130, 33, 0.1); color: #f48221; border-radius: 50px; font-weight: 700;">REGISTRATION OPEN</div>
        <h1 class="registration-hero-title"><?= cleanText($program['training_name']); ?></h1>
        <p class="registration-hero-subtitle">Secure your spot in this industry-recognized training program. Please fill out all required details accurately.</p>
      </div>
    </section>

    <section class="registration-intro">
      <div class="container">
        <div class="registration-form-wrapper">

          <?php if (!empty($success_msg)) : ?>
            <div class="alert alert-success p-3 rounded-lg mb-4">
              <span class="material-symbols-outlined align-middle mr-2">check_circle</span>
              <strong>Success!</strong> <?= $success_msg; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($error_msg)) : ?>
            <div class="alert alert-danger p-3 rounded-lg mb-4">
              <span class="material-symbols-outlined align-middle mr-2">error</span>
              <strong>Error!</strong> <?= $error_msg; ?>
            </div>
          <?php endif; ?>

          <!-- Program Information Box -->
          <div class="program-info-box">
            <h4>About the Program</h4>
            <p class="mb-0 text-muted"><?= cleanText($program['training_description']); ?></p>
          </div>

          <!-- Registration Form -->
          <form method="POST" action="includes/submit_program_registration.php" id="registrationForm" enctype="multipart/form-data">
            <!-- Hidden fields -->
            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
            <input type="hidden" name="program_name" value="<?= cleanText($program['training_name']); ?>">

            <?php if (!empty($sections)) : ?>
              <?php foreach ($sections as $section_name => $fields) : ?>
                <h3 class="form-section-title">
                  <span class="material-symbols-outlined" style="color: #f48221;">
                    <?php
                        // Select icon based on section name
                        switch($section_name) {
                            case 'Personal Info': echo 'person'; break;
                            case 'Demographics': echo 'analytics'; break;
                            case 'Professional Info': echo 'work'; break;
                            default: echo 'info';
                        }
                    ?>
                  </span>
                  <?= $section_name; ?>
                </h3>

                <div class="row">
                  <?php foreach ($fields as $field) : ?>
                    <?= render_form_field($field); ?>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>

            <?php else : ?>
              <!-- Fallback to static fields if no custom fields defined -->
              <h3 class="form-section-title">
                <span class="material-symbols-outlined">person</span>
                Personal Information
              </h3>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" class="form-control" style="border-radius: 50px; padding: 12px 20px;" required>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" class="form-control" style="border-radius: 50px; padding: 12px 20px;" required>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" style="border-radius: 50px; padding: 12px 20px;" required>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" name="phone_no" class="form-control" style="border-radius: 50px; padding: 12px 20px;" required>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Submit Buttons -->
            <div class="btn-group">
              <button type="submit" name="register" class="submit-btn">
                <span class="material-symbols-outlined">how_to_reg</span>
                Submit Registration
              </button>
              <a href="program-detail.php?id=<?= $program_id; ?>" class="cancel-btn">
                <span class="material-symbols-outlined align-middle" style="font-size: 20px;">arrow_back</span>
                Cancel
              </a>
            </div>

            <div class="required-note">
              * By submitting this form, you agree to our terms of service and privacy policy. All your information is stored securely.
            </div>
          </form>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Main Footer -->
  <?php require('footer-section.php'); ?>

  <?php require('javascript-section.html'); ?>

  <script>
    // Enhanced File Input Styling
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', e => {
                let fileName = e.target.files[0].name;
                let nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;
            });
        });
    });
  </script>
</body>

</html>
