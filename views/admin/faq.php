<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Frequently Asked Questions</h1>
            <p>Manage the list of FAQs displayed on the support page.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/faq/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add FAQ</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer Preview</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><span class="fw-600"><?= htmlspecialchars($faq['faq_question']) ?></span></td>
                        <td><span class="text-muted fs-09"><?= htmlspecialchars(substr(strip_tags($faq['faq_answer']), 0, 100)) ?>...</span></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/faq/edit/<?= $faq['faq_id'] ?>" class="btn-action edit" title="Edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" title="Delete" onclick="deleteItem(<?= $faq['faq_id'] ?>, 'faq')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
    </div>
</div>
