<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Trainings & Bootcamps</h1>
            <p>Manage training programs and educational sessions.</p>
        </div>
        <button class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Training</span>
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Training Name</th>
                        <th>Icon</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($trainings as $training):
                        $imagePath = str_replace('../', BASE_URL . '/', $training['training_image']);
                    ?>
                    <tr>
                        <td>
                            <div class="table-img-wrapper">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($training['training_name']) ?>">
                            </div>
                        </td>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($training['training_name']) ?></div>
                            <div class="text-muted fs-08"><?= htmlspecialchars(substr($training['training_description'], 0, 80)) ?>...</div>
                        </td>
                        <td><i class="<?= $training['training_icon'] ?> text-orange"></i></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit"><span class="material-symbols-outlined">edit</span></button>
                                <button class="btn-action delete" onclick="deleteItem(<?= $training['id'] ?>, 'training')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
