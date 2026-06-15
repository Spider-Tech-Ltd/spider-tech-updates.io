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

<style>
    .training-hero {
        position: relative;
        background-color: #f4f4f4;
        padding: 140px 16px 80px;
        overflow: hidden;
        text-align: center;
    }

    .training-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(244, 130, 33, 0.08) 0%, transparent 68%);
        pointer-events: none;
        z-index: 0;
    }

    .hero-blob {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(244, 130, 33, 0.06);
        filter: blur(60px);
        pointer-events: none;
    }

    .hero-blob-left {
        width: 280px;
        height: 280px;
        top: 20%;
        left: -80px;
    }

    .hero-blob-right {
        width: 320px;
        height: 320px;
        bottom: 15%;
        right: -80px;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 18px;
        border-radius: 50px;
        background-color: rgba(244, 130, 33, 0.12);
        border: 1px solid rgba(244, 130, 33, 0.25);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #f48221;
        margin-bottom: 28px;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.1;
        margin: 0 auto 1.5rem;
        color: #111111;
        max-width: 800px;
        font-family: 'Poppins', sans-serif;
    }

    .breadcrumb-custom {
        display: flex;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #666;
        font-family: 'Open Sans', sans-serif;
        margin-top: -10px;
        margin-bottom: 20px;
    }

    .breadcrumb-custom a {
        color: #f48221;
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb-custom span {
        color: #ccc;
    }

    .registration-form-wrapper {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
        padding: 50px;
        max-width: 1000px;
        margin: -60px auto 100px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 20;
    }

    .program-info-box {
        background: #fef4ea;
        border-left: 5px solid #f48221;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 45px;
    }

    .program-info-box h4 {
        color: #111;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .form-section {
        margin-bottom: 40px;
        background: #ffffff;
    }

    .form-section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: #111;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f8f9fa;
    }

    .form-section-title .material-symbols-outlined {
        color: #f48221;
    }

    .submit-btn {
        background: #f48221;
        color: #fff !important;
        border: none;
        border-radius: 50px;
        padding: 16px 40px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(244, 130, 33, 0.25);
    }

    .submit-btn:hover {
        background: #e6751c;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 130, 33, 0.35);
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .cancel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: transparent;
        color: #777;
        border: 2px solid #eee;
        border-radius: 50px;
        padding: 14px 40px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .cancel-btn:hover {
        background: #f8f9fa;
        color: #333;
        border-color: #ddd;
    }

    .required-note {
        font-size: 0.85rem;
        color: #888;
        margin-top: 30px;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }

    /* Toast Notification */
    .pd-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 14px 28px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 10000;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .pd-toast.success {
        background: #10b981;
    }

    .pd-toast.error {
        background: #ef4444;
    }

    .pd-toast .material-symbols-outlined {
        font-size: 20px;
    }

    .form-group label {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #111;
        margin-bottom: 10px;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 5px;
        font-weight: 500;
    }

    .form-control:focus,
    .custom-select:focus,
    .auth-input:focus {
        border-color: #f48221 !important;
        box-shadow: 0 0 0 4px rgba(244, 130, 33, 0.1) !important;
        outline: none;
    }

    @media (max-width: 768px) {
        .registration-form-wrapper {
            padding: 30px 20px;
            margin-top: -40px;
        }
    }
</style>

<div x-data="registrationHandler()">
    <?php if (!$training) : ?>
        <section class="training-hero">
            <div class="container hero-inner">
                <h1 class="hero-title">Program Not Found</h1>
                <p class="hero-subtitle">The program you're trying to register for does not exist or may have been removed.</p>
                <div class="mt-4">
                    <a class="cancel-btn d-inline-block w-auto" href="<?= BASE_URL ?>/trainings">Back to Programs</a>
                </div>
            </div>
        </section>
    <?php else : ?>
        <section class="training-hero">
            <div class="hero-blob hero-blob-left"></div>
            <div class="hero-blob hero-blob-right"></div>
            <div class="container hero-inner">
                <span class="hero-eyebrow-pill">
                    <span class="material-symbols-outlined" style="font-size: 16px;">edit_note</span>
                    Registration Form
                </span>
                <h1 class="hero-title"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></h1>

                <div class="breadcrumb-custom">
                    <a href="<?= BASE_URL ?>/" title="Home">Home</a>
                    <span>/</span>
                    <a href="<?= BASE_URL ?>/trainings" title="Trainings">Trainings</a>
                    <span>/</span>
                    <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $training['id']; ?>" title="<?= htmlspecialchars(strip_tags($training['training_name'])); ?>"><?= htmlspecialchars(strip_tags($training['training_name'])); ?></a>
                    <span>/</span>
                    <span style="color: #999;">Register</span>
                </div>

                <p class="hero-subtitle">Complete the form below to apply for this program. All fields marked with * are mandatory.</p>
            </div>
        </section>

        <section class="registration-content">
            <div class="container">
                <div class="registration-form-wrapper">
                    <!-- Program Information Box -->
                    <div class="program-info-box">
                        <h4>About the Program</h4>
                        <p class="mb-0 text-muted" style="line-height: 1.6;"><?= htmlspecialchars(strip_tags($training['training_description'])); ?></p>
                    </div>

                    <!-- Registration Form -->
                    <form @submit.prevent="submitForm" id="registrationForm" enctype="multipart/form-data">
                        <input type="hidden" name="program_id" value="<?= $program_id; ?>">
                        <input type="hidden" name="registration_type" value="<?= $registration_type ?? 'training'; ?>">

                        <?php if (!empty($sections)) : ?>
                            <?php foreach ($sections as $section_name => $fields) : ?>
                                <div class="form-section">
                                    <h3 class="form-section-title">
                                        <span class="material-symbols-outlined">
                                            <?php
                                            switch ($section_name) {
                                                case 'Basic Information':
                                                    echo 'person';
                                                    break;
                                                case 'Background Information':
                                                    echo 'analytics';
                                                    break;
                                                case 'Professional Information':
                                                    echo 'work';
                                                    break;
                                                default:
                                                    echo 'info';
                                            }
                                            ?>
                                        </span>
                                        <?= htmlspecialchars($section_name); ?>
                                    </h3>

                                    <div class="row">
                                        <?php foreach ($fields as $field) : ?>
                                            <?= FormBuilder::render_form_field($field, $errors, $old_input); ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <!-- Fallback UI if no dynamic fields -->
                            <div class="form-section">
                                <h3 class="form-section-title">
                                    <span class="material-symbols-outlined">person</span>
                                    Basic Information
                                </h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="firstname" class="form-control" style="border-radius: 50px; padding: 15px 24px; height: 56px;" placeholder="Enter first name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="lastname" class="form-control" style="border-radius: 50px; padding: 15px 24px; height: 56px;" placeholder="Enter last name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" style="border-radius: 50px; padding: 15px 24px; height: 56px;" placeholder="Enter email address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="phone_no" class="form-control" style="border-radius: 50px; padding: 15px 24px; height: 56px;" placeholder="Enter phone number" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-8 mb-3">
                                <button type="submit" class="submit-btn" :disabled="loading">
                                    <template x-if="!loading">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="material-symbols-outlined">how_to_reg</span>
                                            <span>Complete Registration</span>
                                        </div>
                                    </template>
                                    <template x-if="loading">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="spinner-border spinner-border-sm" role="status"></div>
                                            <span>Processing...</span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="<?= BASE_URL ?>/trainings/detail?id=<?= $program_id; ?>" class="cancel-btn">
                                    Cancel
                                </a>
                            </div>
                        </div>

                        <div class="required-note">
                            By submitting this application, you agree to our <a href="#" class="text-orange">Terms & Conditions</a> and <a href="#" class="text-orange">Privacy Policy</a>.
                        </div>
                    </form>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Toast Component -->
    <div class="pd-toast" :class="toast.type" x-show="toast.show" x-transition style="display: none;">
        <span class="material-symbols-outlined" x-text="toast.type === 'success' ? 'check_circle' : 'error'"></span>
        <span x-text="toast.message"></span>
    </div>
</div>

<script>
    function registrationHandler() {
        return {
            loading: false,
            toast: {
                show: false,
                message: '',
                type: 'success'
            },

            init() {
                const err = '<?= addslashes($error_msg) ?>';
                const scs = '<?= addslashes($success_msg) ?>';
                if (err) this.showToast(err, 'error');
                if (scs) this.showToast(scs, 'success');
            },

            showToast(message, type = 'success') {
                this.toast.message = message;
                this.toast.type = type;
                this.toast.show = true;
                setTimeout(() => {
                    this.toast.show = false;
                }, 5000);
            },

            async submitForm(e) {
                this.loading = true;
                const form = e.target;
                const formData = new FormData(form);

                try {
                    const response = await fetch('<?= BASE_URL ?>/trainings/submit', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    // Clear previous errors
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                    if (result.success) {
                        this.showToast(result.message, 'success');
                        // Optional: Reset form or redirect
                        if (result.redirect) {
                            setTimeout(() => {
                                window.location.href = result.redirect;
                            }, 2000);
                        }
                    } else {
                        this.showToast(result.message || 'Please fix the errors below.', 'error');

                        if (result.errors) {
                            Object.keys(result.errors).forEach(key => {
                                const input = form.querySelector(`[name="${key}"]`) || form.querySelector(`[name="${key}[]"]`);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'invalid-feedback d-block';
                                    errorDiv.innerText = result.errors[key];
                                    input.closest('.form-group').appendChild(errorDiv);
                                }
                            });
                        }
                    }
                } catch (error) {
                    this.showToast('A network error occurred. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }
    }

    // File input preview enhancement
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('custom-file-input')) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            const label = e.target.nextElementSibling;
            const nameSpan = label.querySelector('.file-name-text');
            if (nameSpan) {
                nameSpan.textContent = fileName;
                nameSpan.style.color = '#111';
            }
        }
    });
</script>