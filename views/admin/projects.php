<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Project Portfolio</h1>
            <p>Manage the showcase of completed projects.</p>
        </div>
        <button class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>Add Project</span>
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
                        <th>Project Name</th>
                        <th>Service</th>
                        <th>Year</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($projects as $project):
                        $imagePath = str_replace('../', BASE_URL . '/', $project['project_pic']);
                    ?>
                    <tr>
                        <td>
                            <div class="table-img-wrapper">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($project['project_name']) ?>">
                            </div>
                        </td>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($project['project_name']) ?></div>
                        </td>
                        <td><span class="badge badge-soft-blue"><?= htmlspecialchars($project['service_name']) ?></span></td>
                        <td><?= $project['project_year'] ?></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit"><span class="material-symbols-outlined">edit</span></button>
                                <button class="btn-action delete" onclick="deleteItem(<?= $project['project_id'] ?>, 'project')"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
