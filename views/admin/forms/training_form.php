<?php
$isEdit = ($mode == 'edit');
$paymentsEnabledInit = ($isEdit && !empty($item['payments_enabled'])) ? true : false;
$paymentFeeInit = ($isEdit && !empty($item['payment_amount'])) ? ((float)$item['payment_amount'] / 100) : '';
?>
<style>
[x-cloak] { display: none !important; }
</style>

<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/trainings" class="btn-action btn-back-header me-3 mr-3" title="Back"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Training</h1>
            <p>Manage the training programs and educational sessions.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'training', 'trainingRedirect')" 
                      enctype="multipart/form-data"
                      x-data="{
                          paymentsEnabled: <?= $paymentsEnabledInit ? 'true' : 'false' ?>,
                          paymentFee: '<?= $paymentFeeInit !== '' ? htmlspecialchars((string)$paymentFeeInit) : '' ?>'
                      }">
                    <input type="hidden" name="type" value="training">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Name</label>
                        <input type="text" name="training_name" class="form-control-custom" value="<?= $item['training_name'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Start Date</label>
                            <input type="date" name="start_date" class="form-control-custom" value="<?= $item['start_date'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">End Date</label>
                            <input type="date" name="end_date" class="form-control-custom" value="<?= $item['end_date'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Time</label>
                        <input type="text" name="training_time" class="form-control-custom" value="<?= $item['training_time'] ?? '' ?>" placeholder="e.g. 10:00 AM - 2:00 PM">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label-custom">Icon Class</label>
                            <input type="text" name="training_icon" class="form-control-custom" value="<?= $item['training_icon'] ?? 'fas fa-graduation-cap' ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Show on Home</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="show_on_home" value="0">
                                <input type="checkbox" name="show_on_home" value="1" <?= (!isset($item) || $item['show_on_home']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Feature on homepage</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Enable Registration</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="registration_available" value="0">
                                <input type="checkbox" name="registration_available" value="1" <?= (isset($item) && $item['registration_available']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Allow enrollments</span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Certified Candidates</label>
                            <input type="number" name="certified_count" class="form-control-custom" value="<?= $item['certified_count'] ?? 0 ?>" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Display Order</label>
                            <input type="number" name="sort_order" class="form-control-custom" value="<?= $item['sort_order'] ?? 0 ?>" min="0">
                        </div>
                    </div>

                    <!-- Payment Configuration Section -->
                    <div class="mb-4 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <label class="form-label-custom mb-1 d-flex align-items-center gap-2" style="font-weight: 600;">
                                    <span class="material-symbols-outlined" style="font-size: 20px; color: var(--primary-orange);">payments</span>
                                    <span>Enable Payments</span>
                                </label>
                                <p class="text-muted mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                                    Require applicants to pay a fee when registering for this training's cohorts. When off, registration stays free.
                                </p>
                            </div>
                            <div>
                                <label class="form-switch-custom m-0">
                                    <input type="hidden" name="payments_enabled" :value="paymentsEnabled ? 1 : 0">
                                    <input type="checkbox" x-model="paymentsEnabled">
                                    <span class="fs-08 fw-semibold" :class="paymentsEnabled ? 'text-dark' : 'text-muted'" x-text="paymentsEnabled ? 'Enabled' : 'Disabled'"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Fee field revealed when enabled -->
                        <div class="mt-3 pt-3 border-top" 
                             x-show="paymentsEnabled" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             x-cloak>
                            <div class="row align-items-center g-3">
                                <div class="col-md-7">
                                    <label class="form-label-custom mb-1">
                                        Payment Fee (NGN) <span class="text-danger" x-show="paymentsEnabled">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; font-weight: 600;">₦</span>
                                        <input type="number" 
                                               name="payment_amount" 
                                               class="form-control-custom ps-2" 
                                               min="1" 
                                               step="any" 
                                               placeholder="e.g. 50000" 
                                               x-model="paymentFee" 
                                               :required="paymentsEnabled">
                                    </div>
                                    <p class="text-muted small mb-0 mt-1" style="font-size: 0.74rem;">
                                        Default fee for all cohorts of this training. Cohorts can optionally override this amount in cohort management.
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <div class="p-2 px-3 rounded-2" style="background: rgba(244, 130, 33, 0.08); border: 1px dashed rgba(244, 130, 33, 0.3);">
                                        <div class="text-muted" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Resolved Fee Preview</div>
                                        <div class="fw-bold" style="font-size: 1.15rem; color: #0f172a;" x-text="paymentFee && Number(paymentFee) > 0 ? '₦' + Number(paymentFee).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '₦0.00'">
                                            ₦0.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary</label>
                        <textarea name="training_description" class="form-control-custom" rows="3" required><?= $item['training_description'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Cover Image</label>
                        <input type="file" name="training_image" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if ($mode == 'edit' && $item['training_image']): ?>
                            <div class="mt-3 table-img-wrapper" style="width: 150px; height: 100px;">
                                <img src="<?= resolvePath($item['training_image']) ?>" alt="">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Training Details (Rich Text Editor)</label>
                        <textarea name="training_details" class="form-control-custom rich-editor" rows="8"><?= $item['training_details'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/trainings" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Create Training' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function trainingRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/trainings';
}
</script>
