<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Forum Members</h1>
            <p>Manage community users and their verification status.</p>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Verification</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($members as $member):
                        $avatarPath = $member['avatar'];
                        if ($avatarPath) {
                            $avatar = (strpos($avatarPath, 'uploads/') !== false) ? BASE_URL . '/' . ltrim($avatarPath, '/') : BASE_URL . '/uploads/forum/avatars/' . $avatarPath;
                        } else {
                            $avatar = BASE_URL . '/images/testimonials.png';
                        }
                        $isVerified = $member['is_verified'];
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= $avatar ?>" class="avatar-sm" alt="">
                                <div>
                                    <div class="fw-600"><?= htmlspecialchars($member['name']) ?></div>
                                    <div class="text-muted fs-07">UUID: <?= substr($member['uuid'], 0, 8) ?>...</div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($member['email']) ?></td>
                        <td><?= date('M d, Y', strtotime($member['created_at'])) ?></td>
                        <td>
                            <?php if ($isVerified): ?>
                                <span class="badge badge-soft-green">Verified</span>
                            <?php else: ?>
                                <span class="badge badge-soft-orange">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit" title="View Details"><span class="material-symbols-outlined">visibility</span></button>
                                <button class="btn-action delete" title="Suspend"><span class="material-symbols-outlined">person_off</span></button>
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
