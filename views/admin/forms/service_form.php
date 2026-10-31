<!-- Service Form — Add / Edit Service Offering -->
<div class="dashboard-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/services" class="btn-action btn-back-header me-3 mr-3" title="Back to Services">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="dashboard-title"><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Service</h1>
            <p class="dashboard-subtitle"><?= ($mode == 'add') ? 'Create a new service offering for Spider Tech website & catalog.' : 'Update existing service details, priority, and visual branding.' ?></p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card" x-data="{
            iconClass: '<?= htmlspecialchars($item['service_icon'] ?? 'fas fa-laptop-code') ?>',
            setIcon(cls) { this.iconClass = cls; }
        }">
            <div class="admin-card-header">
                <h2 class="admin-card-title"><?= ($mode == 'add') ? 'Create Service Offering' : 'Update Service #' . ($item['id'] ?? '') ?></h2>
            </div>
            <div class="admin-card-body p-4">
                <form onsubmit="submitForm(event, 'service', 'serviceRedirect')" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="service">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Service Name <span class="text-danger">*</span></label>
                        <input type="text" name="service_name" class="form-control-custom" value="<?= htmlspecialchars($item['service_name'] ?? '') ?>" placeholder="e.g. Software Development" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Service Icon Class (FontAwesome / Vector) <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="service-icon-badge" style="width: 48px; height: 48px; font-size: 22px;">
                                <i :class="iconClass || 'fas fa-cog'"></i>
                            </div>
                            <div class="flex-grow-1">
                                <input type="text" name="service_icon" class="form-control-custom" x-model="iconClass" placeholder="e.g. fas fa-laptop-code" required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-muted d-block mb-1" style="font-size: 0.72rem; font-weight: 600;">Quick Icon Suggestions:</span>
                            <div class="d-flex flex-wrap gap-1">
                                <?php
                                $suggestions = [
                                    'fas fa-laptop-code' => 'Code',
                                    'fas fa-database' => 'Database',
                                    'fas fa-mobile-screen' => 'Mobile',
                                    'fas fa-network-wired' => 'Network',
                                    'fas fa-users' => 'Training',
                                    'fas fa-handshake' => 'Consultancy',
                                    'fas fa-bullhorn' => 'Marketing',
                                    'fas fa-boxes-packing' => 'Procurement',
                                    'fas fa-chart-line' => 'Monitoring',
                                    'fas fa-lightbulb' => 'Innovation'
                                ];
                                foreach ($suggestions as $cls => $label): ?>
                                    <button type="button" @click="setIcon('<?= $cls ?>')" class="btn btn-sm btn-light py-1 px-2" style="font-size: 0.72rem; border-radius: 50px;">
                                        <i class="<?= $cls ?> me-1 text-orange"></i> <?= $label ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Homepage Showcase</label>
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-600 d-block" style="font-size: 0.84rem;">Feature on Homepage</span>
                                    <span class="text-muted" style="font-size: 0.72rem;">Showcase in public home services grid</span>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input type="hidden" name="show_on_home" value="0">
                                    <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="showOnHomeSwitch" <?= (!isset($item) || $item['show_on_home']) ? 'checked' : '' ?> style="cursor: pointer; width: 40px; height: 22px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Display Priority Order</label>
                            <input type="number" name="sort_order" class="form-control-custom" value="<?= $item['sort_order'] ?? 0 ?>" min="0" placeholder="0 = Default">
                            <span class="text-muted" style="font-size: 0.72rem;">Lower numbers appear first in catalog listings.</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary Description <span class="text-danger">*</span></label>
                        <textarea name="service_description" class="form-control-custom" rows="3" placeholder="Provide a concise 1-2 sentence overview for cards and listings..." required><?= htmlspecialchars($item['service_description'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Comprehensive Details (Rich Text Overview)</label>
                        <textarea name="service_detail" class="form-control-custom rich-editor" rows="7" placeholder="Detailed service methodology, capabilities, deliverables..."><?= htmlspecialchars($item['service_detail'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="<?= BASE_URL ?>/admin/services" class="btn-admin-cancel px-4">Cancel</a>
                        <button type="submit" class="btn-primary-custom px-4">
                            <span class="material-symbols-outlined" style="font-size: 18px;">check</span>
                            <span><?= ($mode == 'add') ? 'Create Service' : 'Save Changes' ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function serviceRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/services';
}
</script>
