<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Events Management</h1>
            <p>Organize and manage upcoming and past events.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/events/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Event</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($events as $event):
                        $imagePath = str_replace('../', BASE_URL . '/', $event['event_img']);
                        $statusClass = (strtolower($event['event_status']) == 'upcoming') ? 'badge-soft-green' : 'badge-soft-muted';
                    ?>
                    <tr>
                        <td>
                            <div class="table-img-wrapper">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($event['event_title']) ?>">
                            </div>
                        </td>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($event['event_title']) ?></div>
                        </td>
                        <td><?= date('M d, Y', strtotime($event['event_date'])) ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= ucfirst($event['event_status']) ?></span></td>
                        <td>
                            <?php if ($event['is_featured']): ?>
                                <span class="badge badge-soft-orange">
                                    <span class="material-symbols-outlined fs-12">star</span> Featured
                                </span>
                            <?php else: ?>
                                <span class="text-muted fs-08">Standard</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/events/edit/<?= $event['event_id'] ?>" class="btn-action edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" onclick="deleteItem(<?= $event['event_id'] ?>, 'event')"><span class="material-symbols-outlined">delete</span></button>
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

<style>
.badge-soft-orange {
    background-color: rgba(244, 130, 33, 0.1);
    color: #f48221;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.fs-12 { font-size: 12px !important; }
</style>
