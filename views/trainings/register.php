<?php
/**
 * Dynamic Training Registration View
 */
$breadcrumb_current = 'Register' . (isset($training['training_name']) ? ' - ' . htmlspecialchars(strip_tags($training['training_name'])) : '');

$success_msg = "";
$error_msg = "";
$errors = $_SESSION['registration_errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];

if (isset($_SESSION['registration_success'])) {
    $success_msg = $_SESSION['registration_success'];
    unset($_SESSION['registration_success']);
}
if (isset($_SESSION['registration_error'])) {
    $error_msg = $_SESSION['registration_error'];
    unset($_SESSION['registration_error']);
}
unset($_SESSION['registration_errors']);
unset($_SESSION['old_input']);
?>

<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<style>
    /* Restore Light Orange Hero Section */
    .registration-hero {
      background: linear-gradient(135deg, #fef4ea 0%, #fff7f0 100%);
      padding: 40px 0 80px 0;
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
      padding: 60px 0 80px;
      position: relative;
      z-index: 20;
    }

    .registration-form-wrapper {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
      padding: 40px;
      max-width: 950px;
      margin: 0 auto 80px;
      border: 1px solid #eee;
      position: relative;
      z-index: 20;
    }

    .form-section-title {
      font-size: 1.4rem;
      font-weight: 700;
      margin: 0 0 0 0;
      padding: 15px 20px;
      background: #f48221;
      color: #fff !important;
      display: flex;
      align-items: center;
      gap: 10px;
      border-radius: 10px 10px 0 0;
    }

    .form-section-title .material-symbols-outlined {
      color: #fff !important;
    }

    .form-section {
      margin-top: 30px;
      border: 1px solid #eee;
      border-radius: 15px;
      background: #fafafa;
      overflow: hidden;
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

    .btn-group {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 30px;
      padding-top: 30px;
      border-top: 1px solid #eee;
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
      min-height: 56px;
    }

    .submit-btn:hover {
      background: #e6751c;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(244, 130, 33, 0.3);
    }

    .cancel-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: transparent;
      color: #f48221;
      border: 2px solid #f48221;
      border-radius: 50px;
      padding: 14px 40px;
      font-weight: 700;
      text-decoration: none;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      min-height: 56px;
      width: 100%;
    }

    .cancel-btn:hover {
      background: #fef4ea;
      color: #f48221;
      text-decoration: none;
    }

    /* Input focus effects */
    .form-control:focus,
    .custom-select:focus {
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
</style>

  <?php if (!$training) : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <h1 class="registration-hero-title">Program Not Found</h1>
        <p class="registration-hero-subtitle text-danger">The program you're trying to register for does not exist or may have been removed.</p>
        <div class="mt-4">
            <a class="cancel-btn d-inline-block w-auto" href="<?= BASE_URL ?>/trainings">Back to Programs</a>
        </div>
      </div>
    </section>
  <?php else : ?>
    <section class="registration-hero">
      <div class="container registration-hero-inner">
        <div class="badge px-3 py-2 mb-3" style="background: rgba(244, 130, 33, 0.1); color: #f48221; border-radius: 50px; font-weight: 700;">REGISTRATION OPEN</div>
        <h1 class="registration-hero-title"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></h1>
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
            <p class="mb-0 text-muted"><?= htmlspecialchars(strip_tags($training['training_description'])); ?></p>
          </div>

          <!-- Registration Form -->
          <form method="POST" action="<?= BASE_URL ?>/trainings/submit" id="registrationForm" enctype="multipart/form-data">
            <!-- Hidden fields -->
            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
            <input type="hidden" name="program_name" value="<?= htmlspecialchars(strip_tags($training['training_name'])); ?>">

            <?php if (!empty($sections)) : ?>
              <?php foreach ($sections as $section_name => $fields) : ?>
                <div class="form-section">
                  <h3 class="form-section-title">
                    <span class="material-symbols-outlined" style="color: #fff;">
                      <?php
                      switch ($section_name) {
                        case 'Basic Information': echo 'person'; break;
                        case 'Background Information': echo 'analytics'; break;
                        case 'Professional Information': echo 'work'; break;
                        case 'Additional Information': echo 'info'; break;
                        default: echo 'info';
                      }
                      ?>
                    </span>
                    <?= htmlspecialchars($section_name); ?>
                  </h3>

                  <div class="row" style="padding: 20px;">
                    <?php foreach ($fields as $field) : ?>
                      <?= FormBuilder::render_form_field($field, $errors, $old_input); ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>

            <?php else : ?>
              <!-- Fallback -->
              <h3 class="form-section-title">
                <span class="material-symbols-outlined" style="color: #fff;">person</span>
                Basic Information
              </h3>
              <div class="row" style="padding: 20px;">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" class="form-control <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>" style="border-radius: 50px; padding: 12px 20px; border: 1px solid <?= isset($errors['firstname']) ? '#dc3545' : '#ddd' ?>;" value="<?= htmlspecialchars($old_input['firstname'] ?? '') ?>" required>
                    <?php if(isset($errors['firstname'])): ?><div class="invalid-feedback d-block ml-3 mt-1"><?= $errors['firstname'] ?></div><?php endif; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" class="form-control <?= isset($errors['lastname']) ? 'is-invalid' : '' ?>" style="border-radius: 50px; padding: 12px 20px; border: 1px solid <?= isset($errors['lastname']) ? '#dc3545' : '#ddd' ?>;" value="<?= htmlspecialchars($old_input['lastname'] ?? '') ?>" required>
                    <?php if(isset($errors['lastname'])): ?><div class="invalid-feedback d-block ml-3 mt-1"><?= $errors['lastname'] ?></div><?php endif; ?>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" style="border-radius: 50px; padding: 12px 20px; border: 1px solid <?= isset($errors['email']) ? '#dc3545' : '#ddd' ?>;" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" required>
                    <?php if(isset($errors['email'])): ?><div class="invalid-feedback d-block ml-3 mt-1"><?= $errors['email'] ?></div><?php endif; ?>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="form-group">
                    <label class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" name="phone_no" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" style="border-radius: 50px; padding: 12px 20px; border: 1px solid <?= isset($errors['phone']) ? '#dc3545' : '#ddd' ?>;" value="<?= htmlspecialchars($old_input['phone_no'] ?? '') ?>" required>
                    <?php if(isset($errors['phone'])): ?><div class="invalid-feedback d-block ml-3 mt-1"><?= $errors['phone'] ?></div><?php endif; ?>
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
              <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $program_id; ?>" class="cancel-btn">
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

  <script>
    // Enhanced File Input Styling
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
          if (this.files && this.files[0]) {
            let fileName = this.files[0].name;
            let label = this.nextElementSibling;
            let nameSpan = label.querySelector('.file-name-text');
            if (nameSpan) {
              nameSpan.textContent = fileName;
              nameSpan.style.color = '#333';
            }
          }
        });
      });
    });
  </script>
