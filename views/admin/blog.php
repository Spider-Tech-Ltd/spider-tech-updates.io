<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Insights & Blog</h1>
            <p>Manage articles, news, and insights.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/blog/add" class="btn btn-primary-custom">
            <span class="material-symbols-outlined">add</span>
            <span>New Post</span>
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
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($blogs as $blog):
                        $imagePath = !empty($blog['image_path']) ? BASE_URL . '/' . ltrim($blog['image_path'], './') : BASE_URL . '/assets/img/no-image.png';
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
                        <td><?= htmlspecialchars($blog['name'] ?? 'Uncategorized') ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= ucfirst($blog['status']) ?></span></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <a href="<?= BASE_URL ?>/admin/blog/edit/<?= $blog['uuid'] ?>" class="btn-action edit"><span class="material-symbols-outlined">edit</span></a>
                                <button class="btn-action delete" onclick="deleteItem('<?= $blog['uuid'] ?>', 'blog')"><span class="material-symbols-outlined">delete</span></button>
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
        <?php include ROOT_PATH . '/views/admin/layout/pagination.php'; ?>
    </div>
</div>
