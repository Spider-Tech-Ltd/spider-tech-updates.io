<?php
require('includes/connect.php');

$program_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch program details
$select_program = $conn->prepare("SELECT * FROM `trainings_tb` WHERE id = ? LIMIT 1");
$select_program->execute([$program_id]);
$program = $select_program->fetch(PDO::FETCH_ASSOC);

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
      min-height: 100%;
      margin: 0;
      padding: 0;
    }

    .registration-hero {
      background-color: #f4f4f4;
      padding: 70px 12px 48px;
      position: relative;
      text-align: center;
      min-height: 240px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .registration-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at center, rgba(244, 130, 33, 0.1), transparent 70%);
      pointer-events: none;
    }

    .registration-hero .registration-hero-inner {
      position: relative;
      z-index: 2;
    }

    .registration-hero-title {
      font-size: 2.25rem;
      font-weight: 800;
      color: #111;
      margin-bottom: 0.6rem;
      line-height: 1.15;
    }

    .registration-hero-subtitle {
      color: #555;
      font-size: 1rem;
      margin-bottom: 0;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .registration-intro {
      margin-top: 40px;
      padding-bottom: 60px;
      margin-bottom: 80px;
      width: 100%;
      overflow: visible;
    }

    .registration-form-wrapper {
      background: #fff;
      border: 1px solid #ebeff2;
      border-radius: 14px;
      padding: 40px;
      max-width: 700px;
      margin: 0 auto 24px auto;
    }

    .form-section-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: #111;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f48221;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #262626;
      font-size: 0.95rem;
    }

    .form-group label .required {
      color: #e74c3c;
      margin-left: 3px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 0.95rem;
      font-family: 'Poppins', sans-serif;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #f48221;
      box-shadow: 0 0 0 3px rgba(244, 130, 33, 0.1);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .registration-hero-title {
        font-size: 1.75rem;
      }

      .registration-form-wrapper {
        padding: 25px;
      }
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .program-info-box {
      background: #f9f9f9;
      border-left: 4px solid #f48221;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 4px;
    }

    .program-info-box h4 {
      color: #f48221;
      font-weight: 700;
      margin-top: 0;
      margin-bottom: 8px;
    }

    .program-info-box p {
      margin: 0;
      color: #555;
      font-size: 0.95rem;
      line-height: 1.6;
    }

    .submit-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      background: #f48221;
      color: #fff !important;
      border-radius: 50px;
      padding: 14px 40px;
      font-weight: 700;
      text-decoration: none !important;
      border: 0;
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
          <form method="POST" action="includes/submit_program_registration.php" id="registrationForm">
            <!-- Hidden fields -->
            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
            <input type="hidden" name="program_name" value="<?= cleanText($program['training_name']); ?>">

            <!-- Personal Information Section -->
            <h3 class="form-section-title">Personal Information</h3>

            <div class="form-row">
              <div class="form-group">
                <label for="firstname">
                  First Name
                  <span class="required">*</span>
                </label>
                <input type="text" id="firstname" name="firstname" required placeholder="Enter your first name">
              </div>
              <div class="form-group">
                <label for="lastname">
                  Last Name
                  <span class="required">*</span>
                </label>
                <input type="text" id="lastname" name="lastname" required placeholder="Enter your last name">
              </div>
            </div>

            <div class="form-group">
              <label for="middlename">Middle Name (Optional)</label>
              <input type="text" id="middlename" name="middlename" placeholder="Enter your middle name if any">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="email">
                  Email Address
                  <span class="required">*</span>
                </label>
                <input type="email" id="email" name="email" required placeholder="your@email.com">
              </div>
              <div class="form-group">
                <label for="phone_no">
                  Phone Number
                  <span class="required">*</span>
                </label>
                <input type="tel" id="phone_no" name="phone_no" required placeholder="+234 000 000 0000">
              </div>
            </div>

            <!-- Demographics Section -->
            <h3 class="form-section-title">Demographics</h3>

            <div class="form-row">
              <div class="form-group">
                <label for="age">Age (Optional)</label>
                <input type="number" id="age" name="age" min="18" max="120" placeholder="Enter your age">
              </div>
              <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender">
                  <option value="">-- Select Gender --</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>

            <!-- Professional Information Section -->
            <h3 class="form-section-title">Professional Information</h3>

            <div class="form-row">
              <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" id="occupation" name="occupation" placeholder="e.g., Entrepreneur, Manager, Student">
              </div>
              <div class="form-group">
                <label for="organization">Organization/Company</label>
                <input type="text" id="organization" name="organization" placeholder="Your company or organization">
              </div>
            </div>

            <div class="form-group">
              <label for="experience_level">Experience Level with this subject</label>
              <select id="experience_level" name="experience_level">
                <option value="">-- Select Experience Level --</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
                <option value="Expert">Expert</option>
              </select>
            </div>

            <!-- Program-Specific Section -->
            <h3 class="form-section-title">Learning Goals & Requirements</h3>

            <div class="form-group">
              <label for="learning_goals">What are your learning goals for this program?</label>
              <textarea id="learning_goals" name="learning_goals" placeholder="Tell us what you hope to achieve by attending this program..."></textarea>
            </div>

            <div class="form-group">
              <label for="special_requirements">Special Requirements or Accommodations</label>
              <textarea id="special_requirements" name="special_requirements" placeholder="Any accessibility needs or special requests? (Optional)"></textarea>
            </div>

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

  <script>
    // Form validation
    document.getElementById('registrationForm')?.addEventListener('submit', function(e) {
      const firstname = document.getElementById('firstname').value.trim();
      const lastname = document.getElementById('lastname').value.trim();
      const email = document.getElementById('email').value.trim();
      const phone = document.getElementById('phone_no').value.trim();

      if (!firstname || !lastname || !email || !phone) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
      }

      // Simple email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return false;
      }

      // Phone validation (basic)
      if (phone.length < 10) {
        e.preventDefault();
        alert('Please enter a valid phone number.');
        return false;
      }
    });
  </script>
</body>

</html>