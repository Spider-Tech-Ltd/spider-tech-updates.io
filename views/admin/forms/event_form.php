<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/events" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Event</h1>
            <p>Organize and manage upcoming and past events.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center" x-data="eventForm()">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form id="eventForm" @submit.prevent="handleSubmit(event)" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="event">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['event_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Event Title</label>
                        <input type="text" name="event_title" class="form-control-custom" value="<?= $item['event_title'] ?? '' ?>" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Event Date</label>
                            <input type="date" name="event_date" class="form-control-custom" value="<?= $item['event_date'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Event Time</label>
                            <input type="text" name="event_time" class="form-control-custom" value="<?= $item['event_time'] ?? '' ?>" placeholder="e.g. 10:00 AM">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Status</label>
                            <select name="event_status" class="form-control-custom" required x-model="eventStatus">
                                <option value="Upcoming" <?= (isset($item) && $item['event_status'] == 'Upcoming') ? 'selected' : '' ?>>Upcoming</option>
                                <option value="Past" <?= (isset($item) && $item['event_status'] == 'Past') ? 'selected' : '' ?>>Past</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Show on Home</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="show_on_home" value="0">
                                <input type="checkbox" name="show_on_home" value="1" <?= (!isset($item) || $item['show_on_home']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Feature on homepage</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Display Order</label>
                        <input type="number" name="sort_order" class="form-control-custom" value="<?= $item['sort_order'] ?? 0 ?>" min="0">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Location / Address</label>
                        <input type="text" name="event_address" class="form-control-custom" value="<?= $item['event_address'] ?? '' ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary</label>
                        <textarea name="event_content" class="form-control-custom" rows="3" required><?= $item['event_content'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Full Event Details (Rich Text Editor)</label>
                        <textarea name="event_detail" class="form-control-custom rich-editor" rows="8"><?= $item['event_detail'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Event Featured Image</label>
                        <input type="file" name="event_img" class="form-control-custom" accept="image/*">
                        <?php if (isset($item['event_img']) && !empty($item['event_img'])): ?>
                            <div class="mt-2">
                                <img src="<?= BASE_URL . '/' . $item['event_img'] ?>" alt="" style="height: 100px; border-radius: 8px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Gallery Section - Only for Past Events -->
                    <div class="mb-4" x-show="eventStatus === 'Past'" x-transition x-cloak>
                        <div class="p-4 border rounded-4 bg-light">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-primary">collections</span>
                                <h5 class="mb-0 fw-700">Event Gallery</h5>
                            </div>
                            <p class="text-muted fs-08 mb-4">Upload multiple images for this past event gallery.</p>

                            <div class="mb-4">
                                <label class="form-label-custom">Upload Images</label>
                                <input type="file" @change="handleFileSelect" class="form-control-custom" multiple accept="image/*" id="galleryInput">
                            </div>

                            <!-- New Interactive Preview -->
                            <div class="mb-4" x-show="previews.length > 0">
                                <label class="form-label-custom mb-3">New Images to Upload</label>
                                <div class="row g-3">
                                    <template x-for="(preview, index) in previews" :key="index">
                                        <div class="col-4 col-md-3">
                                            <div class="position-relative group">
                                                <img :src="preview" class="img-fluid rounded-3 border" style="height: 80px; width: 100%; object-fit: cover;">
                                                <button type="button"
                                                        @click="removePreview(index)"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-1 d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; opacity: 0.8;">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <?php if (!empty($media ?? [])): ?>
                                <label class="form-label-custom mb-3">Existing Gallery Images</label>
                                <div class="row g-3">
                                    <?php foreach (($media ?? []) as $m): ?>
                                        <div class="col-4 col-md-3" id="media-<?= $m['event_pics_id'] ?>">
                                            <div class="position-relative group">
                                                <img src="<?= BASE_URL . '/' . $m['event_pics_name'] ?>" class="img-fluid rounded-3 border" style="height: 80px; width: 100%; object-fit: cover;">
                                                <button type="button"
                                                        onclick="deleteGalleryImage(<?= $m['event_pics_id'] ?>)"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-1 d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; opacity: 0.8;">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/events" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Create Event' : 'Save Changes' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function eventForm() {
    return {
        eventStatus: '<?= $item['event_status'] ?? 'Upcoming' ?>',
        selectedFiles: [],
        previews: [],

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                this.selectedFiles.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previews.push(e.target.result);
                };
                reader.readAsDataURL(file);
            });
            // Clear input so same file can be selected again if removed
            event.target.value = '';
        },

        removePreview(index) {
            this.selectedFiles.splice(index, 1);
            this.previews.splice(index, 1);
        },

        async handleSubmit(event) {
            // Re-use global submitForm logic but with our custom file handling
            const form = event.target;
            const formData = new FormData(form);

            // Append our selected gallery files
            this.selectedFiles.forEach((file, i) => {
                formData.append('event_gallery[]', file);
            });

            // Use the global submitForm logic but we need to pass the enriched formData
            // Since submitForm takes (event, type, callbackOrModal) and builds its own FormData,
            // we'll have to either modify submitForm or replicate its core here.
            // For now, let's replicate the core but use our formData.

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
                    setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/events', 1000);
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

function eventRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/events';
}

async function deleteGalleryImage(mediaId) {
    if (!confirm('Are you sure you want to delete this image?')) return;

    try {
        const formData = new FormData();
        formData.append('id', mediaId);

        const response = await fetch('<?= BASE_URL ?>/admin/events/media/delete', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();
        if (data.status === 'success') {
            document.getElementById(`media-${mediaId}`).remove();
            showToast(data.message);
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('An unexpected error occurred.', 'error');
    }
}
</script>
