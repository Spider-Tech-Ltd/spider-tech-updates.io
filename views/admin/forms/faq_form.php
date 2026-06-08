<div class="content-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/faq" class="btn-action"><span class="material-symbols-outlined">arrow_back</span></a>
        <div>
            <h1><?= ($mode == 'add') ? 'Add New' : 'Edit' ?> FAQ</h1>
            <p>Manage the support question and answer entries.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="admin-card">
            <div class="card-body-custom">
                <form onsubmit="submitForm(event, 'faq', 'faqRedirect')">
                    <input type="hidden" name="type" value="faq">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $item['faq_id'] ?>">
                        <input type="hidden" name="action_mode" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action_mode" value="store">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-custom">Question</label>
                        <input type="text" name="faq_question" class="form-control-custom" value="<?= $item['faq_question'] ?? '' ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Answer (Rich Text Editor)</label>
                        <textarea name="faq_answer" class="form-control-custom rich-editor" rows="10"><?= $item['faq_answer'] ?? '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?= BASE_URL ?>/admin/faq" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-5">
                            <?= ($mode == 'add') ? 'Save FAQ' : 'Update FAQ' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function faqRedirect() {
    window.location.href = '<?= BASE_URL ?>/admin/faq';
}
</script>
