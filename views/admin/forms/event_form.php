<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/events" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> Event</h1>
            <p>Organize and manage upcoming and past events.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'event', 'eventRedirect')" enctype="multipart/form-data">
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
                            <select name="event_status" class="form-control-custom" required>
                                <option value="Upcoming" <?= (isset($item) && $item['event_status'] == 'Upcoming') ? 'selected' : '' ?>>Upcoming</option>
                                <option value="Past" <?= (isset($item) && $item['event_status'] == 'Past') ? 'selected' : '' ?>>Past</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Show on Home</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="show_on_home" value="0">
                                <input type="checkbox" name="show_on_home" value="1" <?= (!isset($item) || (isset($item['show_on_home']) && $item['show_on_home'])) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Feature on homepage</span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Is Featured</label>
                            <label class="form-switch-custom mt-2">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" value="1" <?= (isset($item['is_featured']) && $item['is_featured']) ? 'checked' : '' ?>>
                                <span class="fs-08 text-muted">Mark as Premier Highlight</span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">YouTube Video URL</label>
                            <input type="url" name="video_url" class="form-control-custom" value="<?= $item['video_url'] ?? '' ?>" placeholder="https://www.youtube.com/watch?v=...">
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
                        <label class="form-label-custom">Event Feature Image</label>
                        <input type="file" name="event_img" class="form-control-custom" <?= ($mode == 'add') ? 'required' : '' ?>>
                        <?php if (isset($item['event_img'])): ?>
                            <div class="mt-2">
                                <img src="<?= str_replace('../', BASE_URL . '/', $item['event_img']) ?>" alt="" style="height: 100px; border-radius: 8px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Short Summary</label>
                        <textarea name="event_content" class="form-control-custom" rows="3" required><?= $item['event_content'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Full Event Details (Rich Text Editor)</label>
                        <textarea name="event_detail" class="form-control-custom rich-editor" rows="8"><?= $item['event_detail'] ?? '' ?></textarea>
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
function eventRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/events';
}
</script>
