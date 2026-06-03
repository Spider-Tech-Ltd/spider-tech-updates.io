<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Forum Members</h1>
            <p>Manage community users, verification status, and account access.</p>
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
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($members as $member):
                        $avatarPath = $member['avatar'] ?? null;
                        $defaultAvatar = BASE_URL . '/img/member_dp.jpg'; // Fallback for user icon

                        if ($avatarPath) {
                            $avatar = (strpos($avatarPath, 'uploads/') !== false) ? BASE_URL . '/' . ltrim($avatarPath, '/') : BASE_URL . '/uploads/forum/avatars/' . $avatarPath;
                        } else {
                            $avatar = $defaultAvatar;
                        }
                        $isVerified = $member['is_verified'];
                        $status = $member['status'] ?? 'Active';
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="table-img-wrapper" style="width: 40px; height: 40px; border-radius: 50%;">
                                    <img src="<?= $avatar ?>" alt="" onerror="this.src='<?= $defaultAvatar ?>'">
                                </div>
                                <div>
                                    <div class="fw-600"><?= htmlspecialchars($member['name']) ?></div>
                                    <div class="text-muted fs-07">@<?= htmlspecialchars($member['username']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($member['email']) ?></td>
                        <td>
                            <?php if ($status === 'Suspended'): ?>
                                <span class="badge badge-soft-muted">Suspended</span>
                            <?php elseif ($isVerified): ?>
                                <span class="badge badge-soft-green">Verified</span>
                            <?php else: ?>
                                <span class="badge badge-soft-orange">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('M d, Y', strtotime($member['created_at'])) ?></td>
                        <td class="text-end">
                            <div class="action-btns">
                                <button class="btn-action edit" title="View Details" onclick="viewMemberDetails(<?= $member['id'] ?>)">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <button class="btn-action delete" title="<?= $status === 'Suspended' ? 'Activate' : 'Suspend' ?>" onclick="confirmToggleStatus(<?= $member['id'] ?>, '<?= $status ?>')">
                                    <span class="material-symbols-outlined"><?= $status === 'Suspended' ? 'person' : 'person_off' ?></span>
                                </button>
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

<!-- Member Details Modal -->
<div id="memberModal" class="modal-custom">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="m-0 poppins">Member Profile</h5>
            <button class="btn-action" onclick="closeMemberModal()"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div class="modal-body-custom" id="memberDetailsContent">
            <!-- Loaded via JS -->
        </div>
        <div class="modal-footer-custom">
            <button class="btn btn-light px-4" onclick="closeMemberModal()">Close</button>
        </div>
    </div>
</div>

<script>
async function viewMemberDetails(id) {
    try {
        const response = await fetch(`<?= BASE_URL ?>/admin/members/details/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            const m = result.data;
            const defaultAvatar = '<?= BASE_URL ?>/img/member_dp.jpg';
            const avatar = m.avatar ? (m.avatar.includes('uploads/') ? `<?= BASE_URL ?>/${m.avatar.replace(/^\//, '')}` : `<?= BASE_URL ?>/uploads/forum/avatars/${m.avatar}`) : defaultAvatar;

            let html = `
                <div class="text-center mb-4">
                    <img src="${avatar}" class="avatar-sm mb-3" style="width: 100px; height: 100px;" onerror="this.src='${defaultAvatar}'">
                    <h4 class="m-0">${m.name}</h4>
                    <p class="text-muted">@${m.username}</p>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Email Address</label>
                        <div class="fs-09">${m.email}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Member ID</label>
                        <div class="fs-09">${m.id}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Joined Date</label>
                        <div class="fs-09">${new Date(m.created_at).toLocaleDateString()}</div>
                    </div>
                    <div class="col-md-6 border-bottom pb-2">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">Status</label>
                        <div class="fs-09">
                            <span class="badge ${m.status === 'Suspended' ? 'badge-soft-muted' : (m.is_verified ? 'badge-soft-green' : 'badge-soft-orange')}">
                                ${m.status === 'Suspended' ? 'Suspended' : (m.is_verified ? 'Verified' : 'Pending')}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted fs-07 fw-700 d-block text-uppercase">UUID</label>
                        <div class="fs-09 text-break">${m.uuid}</div>
                    </div>
                </div>
            `;
            document.getElementById('memberDetailsContent').innerHTML = html;
            document.getElementById('memberModal').classList.add('show');
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        showToast('Failed to fetch member details.', 'error');
    }
}

function closeMemberModal() {
    document.getElementById('memberModal').classList.remove('show');
}

function confirmToggleStatus(id, currentStatus) {
    const isSuspended = currentStatus === 'Suspended';
    const action = isSuspended ? 'activate' : 'suspend';

    if (window.Alpine && Alpine.store('actionModal')) {
        Alpine.store('actionModal').show({
            id: id,
            title: (isSuspended ? 'Activate' : 'Suspend') + ' Member',
            message: `Are you sure you want to ${action} this member's account?`,
            confirmText: 'Yes, ' + (isSuspended ? 'Activate' : 'Suspend'),
            variant: isSuspended ? 'warning' : 'danger',
            icon: isSuspended ? 'person' : 'person_off',
            actionUrl: '<?= BASE_URL ?>/admin/members/toggle-status'
        });
    } else {
        // Fallback
        if (confirm(`Are you sure you want to ${action} this member's account?`)) {
            const formData = new FormData();
            formData.append('id', id);

            fetch(`<?= BASE_URL ?>/admin/members/toggle-status`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    showToast(result.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(result.message, 'error');
                }
            })
            .catch(() => showToast('An error occurred.', 'error'));
        }
    }
}

window.onclick = function(event) {
    if (event.target == document.getElementById('memberModal')) {
        closeMemberModal();
    }
}
</script>
