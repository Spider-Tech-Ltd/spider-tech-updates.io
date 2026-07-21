<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/projects" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Project</h1>
            <p>Manage the project portfolio entries.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center" x-data="projectForm()">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form id="projectForm" @submit.prevent="handleSubmit(event)" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="project">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['project_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Project Name</label>
                        <input type="text" name="project_name" class="form-control-custom" value="<?= $item['project_name'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Category / Service</label>
                            <select name="service_id" class="form-control-custom" required>
                                <option value="">Select Service</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= $service['id'] ?>" <?= (isset($item) && $item['service_id'] == $service['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($service['service_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Year</label>
                            <input type="number" name="project_year" class="form-control-custom" value="<?= $item['project_year'] ?? date('Y') ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Visibility on Home</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="show_on_home" value="0">
                                <input type="checkbox" name="show_on_home" value="1" <?= (!isset($item) || $item['show_on_home']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Feature on homepage</span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Display Order</label>
                            <input type="number" name="sort_order" class="form-control-custom" value="<?= $item['sort_order'] ?? 0 ?>" min="0">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Project Main Image</label>
                        <input type="file" name="project_pic" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if (isset($item['project_pic']) && !empty($item['project_pic'])): ?>
                            <div class="mt-2">
                                <img src="<?= resolvePath($item['project_pic']) ?>" alt="" style="height: 100px; border-radius: 8px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Description (Rich Text Editor)</label>
                        <textarea name="project_description" class="form-control-custom rich-editor" rows="8"><?= $item['project_description'] ?? '' ?></textarea>
                    </div>

                    <!-- Gallery Section -->
                    <div class="mb-4">
                        <div class="p-4 border rounded-4 bg-light">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-primary">collections</span>
                                <h5 class="mb-0 fw-700">Project Gallery</h5>
                            </div>
                            <p class="text-muted fs-08 mb-4">Upload multiple images for this project gallery.</p>

                            <div class="mb-4">
                                <label class="form-label-custom">Upload Images</label>
                                <div class="upload-zone p-5 border-2 border-dashed rounded-4 text-center bg-white"
                                     @click="$refs.galleryInput.click()"
                                     @dragover.prevent="dragOver = true"
                                     @dragleave.prevent="dragOver = false"
                                     @drop.prevent="handleDrop($event)"
                                     :class="{ 'border-primary bg-light': dragOver }"
                                     style="cursor: pointer;">
                                    <input type="file" x-ref="galleryInput" @change="handleFileSelect" class="d-none" multiple accept="image/*">
                                    <span class="material-symbols-outlined fs-1 text-primary mb-2">cloud_upload</span>
                                    <p class="mb-0 fw-600">Click or drag images here to upload</p>
                                    <p class="text-muted small">PNG, JPG or WEBP (Max 5MB each)</p>
                                </div>
                            </div>

                            <!-- Interactive Preview -->
                            <div class="mb-5" x-show="previews.length > 0" x-transition x-cloak>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary rounded-pill" x-text="previews.length"></span>
                                        <label class="form-label-custom mb-0">New Images Selection</label>
                                    </div>
                                    <button type="button" @click="clearAllPreviews" class="btn btn-sm btn-outline-danger border-0">
                                        <span class="material-symbols-outlined align-middle fs-6">delete_sweep</span> Clear All
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <template x-for="(preview, index) in previews" :key="index">
                                        <div class="col-6 col-md-3">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden group">
                                                <img :src="preview" class="card-img-top" style="height: 100px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 p-2">
                                                    <button type="button"
                                                            @click="removePreview(index)"
                                                            class="btn btn-danger btn-sm rounded-circle p-1 d-flex align-items-center justify-content-center shadow"
                                                            style="width: 26px; height: 26px;">
                                                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <?php if (!empty($media ?? [])): ?>
                                <label class="form-label-custom mb-3">Existing Gallery Images</label>
                                <div class="row g-3">
                                    <?php foreach (($media ?? []) as $m): ?>
                                        <?php $mPath = resolvePath($m['project_pics_name']); ?>
                                        <div class="col-6 col-md-3" id="media-<?= $m['project_pics_id'] ?>">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden group">
                                                <a href="<?= $mPath ?>" data-lightbox="project-gallery-admin">
                                                    <img src="<?= $mPath ?>" class="card-img-top" style="height: 100px; object-fit: cover;">
                                                </a>
                                                <div class="position-absolute top-0 end-0 p-2">
                                                    <button type="button"
                                                            onclick="deleteGalleryImage(<?= $m['project_pics_id'] ?>)"
                                                            class="btn btn-danger btn-sm rounded-circle p-1 d-flex align-items-center justify-content-center shadow"
                                                            style="width: 26px; height: 26px;">
                                                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/projects" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Create Project' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function projectForm() {
    return {
        selectedFiles: [],
        previews: [],
        dragOver: false,

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.addFiles(files);
            event.target.value = '';
        },

        handleDrop(event) {
            this.dragOver = false;
            const files = Array.from(event.dataTransfer.files).filter(file => file.type.startsWith('image/'));
            this.addFiles(files);
        },

        addFiles(files) {
            files.forEach(file => {
                this.selectedFiles.push(file);
                this.previews.push(URL.createObjectURL(file));
            });
        },

        removePreview(index) {
            // Revoke object URL to free memory
            URL.revokeObjectURL(this.previews[index]);
            this.selectedFiles.splice(index, 1);
            this.previews.splice(index, 1);
        },

        clearAllPreviews() {
            this.previews.forEach(url => URL.revokeObjectURL(url));
            this.selectedFiles = [];
            this.previews = [];
        },

        async handleSubmit(event) {
            const form = event.target;
            const formData = new FormData(form);

            // Append our selected gallery files
            this.selectedFiles.forEach((file, i) => {
                formData.append('project_gallery[]', file);
            });

            const submitBtn = form.querySelector('button[type="submit"]');
            if (form.dataset.submitting === 'true') return;

            // Sync CKEditor data
            if (typeof editors !== 'undefined') {
                for (const name in editors) {
                    const textarea = form.querySelector(`[name="${name}"]`);
                    if (textarea) {
                        textarea.value = editors[name].getData();
                        formData.set(name, textarea.value);
                    }
                }
            }

            const originalBtnContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            form.dataset.submitting = 'true';

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/store', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.status === 'success') {
                    showToast(data.message);
                    // Add timestamp to prevent caching when redirecting back
                    setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/projects?t=' + Date.now(), 1000);
                } else {
                    showToast(data.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                    delete form.dataset.submitting;
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An unexpected error occurred.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
                delete form.dataset.submitting;
            }
        }
    };
}

function deleteGalleryImage(mediaId) {
    if (window.Alpine && Alpine.store('actionModal')) {
        Alpine.store('actionModal').show({
            id: mediaId,
            title: 'Delete Gallery Image',
            message: 'Are you sure you want to delete this image from the gallery? This action is permanent.',
            confirmText: 'Yes, Delete',
            variant: 'danger',
            callback: async (id) => {
                try {
                    const formData = new FormData();
                    formData.append('id', id);

                    const response = await fetch('<?= BASE_URL ?>/admin/projects/media/delete', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (data.status === 'success') {
                        document.getElementById(`media-${id}`).remove();
                        showToast(data.message);
                    } else {
                        showToast(data.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('An unexpected error occurred.', 'error');
                }
            }
        });
    } else {
        // Fallback
        if (confirm('Are you sure you want to delete this image?')) {
            (async () => {
                const formData = new FormData();
                formData.append('id', mediaId);
                const response = await fetch('<?= BASE_URL ?>/admin/projects/media/delete', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const data = await response.json();
                if (data.status === 'success') {
                    document.getElementById(`media-${mediaId}`).remove();
                    showToast(data.message);
                }
            })();
        }
    }
}
</script>
