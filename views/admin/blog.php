<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Insights & Blog</h1>
            <p>Manage articles, news, and insights.</p>
        </div>
        <button class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>New Post</span>
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
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($blogs as $blog):
                        $imagePath = BASE_URL . '/' . $blog['image_path'];
                        $statusClass = (strtolower($blog['status']) == 'published') ? 'badge-soft-green' : 'badge-soft-orange';
                    ?>
                    <tr>
                        <td>
                            <div class="table-img-wrapper">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
                            </div>
                        </td>
                        <td>
                            <div class="fw-600"><?= htmlspecialchars($blog['title']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($blog['category_name']) ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= ucfirst($blog['status']) ?></span></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit"><span class="material-symbols-outlined">edit</span></button>
                                <button class="btn-action delete"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;
                    if (empty($blogs)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <span class="text-muted">No blog posts found. Start by creating one!</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
