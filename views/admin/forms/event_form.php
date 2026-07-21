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
<?php
    // Normalise video_type to lowercase so PHP selected attrs + Alpine model agree
    $normalizedVideoType = strtolower($item['video_type'] ?? 'youtube');
?>
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

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label-custom">Recap Type</label>
                            <select name="video_type" class="form-control-custom" x-model="videoType">
                                <option value="youtube"   <?= $normalizedVideoType === 'youtube'   ? 'selected' : '' ?>>YouTube Video</option>
                                <option value="instagram" <?= $normalizedVideoType === 'instagram' ? 'selected' : '' ?>>Instagram Post/Reel</option>
                                <option value="facebook"  <?= $normalizedVideoType === 'facebook'  ? 'selected' : '' ?>>Facebook Post/Video</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label-custom">Recap Link (URL)</label>
                            <input type="url" name="video_url" class="form-control-custom" value="<?= $item['video_url'] ?? '' ?>" :placeholder="recapPlaceholder">
                            <p class="text-muted small mt-1" x-text="recapHint"></p>
                        </div>
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
                        <input type="file" name="event_img" class="form-control-custom" accept="image/*" onchange="checkMainImageSize(this)">
                        <?php if (isset($item['event_img']) && !empty($item['event_img'])): ?>
                            <div class="mt-2">
                                <img src="<?= resolvePath($item['event_img']) ?>" alt="" style="height: 100px; border-radius: 8px;">
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
                                <div class="upload-zone p-5 border-2 border-dashed rounded-4 text-center bg-white"
                                     @click="$refs.galleryInput.click()"
                                     @dragover.prevent="dragOver = true"
                                     @dragleave.prevent="dragOver = false"
                                     @drop.prevent="handleDrop($event)"
                                     :class="{ 'border-primary bg-light': dragOver }">
                                    <input type="file" x-ref="galleryInput" @change="handleFileSelect" class="d-none" multiple accept="image/*">
                                    <span class="material-symbols-outlined fs-1 text-primary mb-2">cloud_upload</span>
                                    <p class="mb-0 fw-600">Click or drag images here to upload</p>
                                    <p class="text-muted small">PNG, JPG or WEBP (Max 5MB each)</p>
                                </div>
                            </div>

                            <!-- New Interactive Preview -->
                            <div class="mb-5" x-show="previews.length > 0" x-transition>
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
                                        <?php $mPath = resolvePath($m['event_pics_name']); ?>
                                        <div class="col-6 col-md-3" id="media-<?= $m['event_pics_id'] ?>">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden group">
                                                <a href="<?= $mPath ?>" data-lightbox="event-gallery-admin">
                                                    <img src="<?= $mPath ?>" class="card-img-top" style="height: 100px; object-fit: cover;">
                                                </a>
                                                <div class="position-absolute top-0 end-0 p-2">
                                                    <button type="button"
                                                            onclick="deleteGalleryImage(<?= $m['event_pics_id'] ?>)"
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
function checkMainImageSize(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSizeBytes = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSizeBytes) {
            showToast("Featured image is too large (max 5MB).", 'error');
            input.value = ''; // clear file choice
        }
    }
}

function eventForm() {
    return {
        eventStatus: '<?= $item['event_status'] ?? 'Upcoming' ?>',
        videoType: '<?= $normalizedVideoType ?>',

        get recapPlaceholder() {
            if (this.videoType === 'instagram') return 'https://www.instagram.com/p/CLP...';
            if (this.videoType === 'facebook') return 'https://www.facebook.com/username/posts/...';
            return 'https://www.youtube.com/watch?v=...';
        },

        get recapHint() {
            if (this.videoType === 'instagram') return 'Provide an Instagram post or reel link.';
            if (this.videoType === 'facebook') return 'Provide a Facebook post or video link.';
            return 'Provide a YouTube link to feature this event in the highlights section.';
        },
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
            const maxSizeBytes = 5 * 1024 * 1024; // 5MB
            files.forEach(file => {
                if (file.size > maxSizeBytes) {
                    showToast("File '" + file.name + "' is too large (max 5MB).", 'error');
                    return;
                }
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
                    // Add timestamp to prevent caching when redirecting back
                    setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/events?t=' + Date.now(), 1000);
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

                    const response = await fetch('<?= BASE_URL ?>/admin/events/media/delete', {
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
                const response = await fetch('<?= BASE_URL ?>/admin/events/media/delete', {
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
