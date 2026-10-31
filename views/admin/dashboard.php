<!-- Dashboard Header -->
<div class="dashboard-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>. Here's what's happening with Spider Tech today.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/admin/banners/add" class="btn-primary-custom">
                <span class="material-symbols-outlined">add_circle</span>
                <span>Add Banner</span>
            </a>
            <a href="<?= BASE_URL ?>/home" target="_blank" class="btn-view-site">
                <span class="material-symbols-outlined">open_in_new</span>
                <span>View Website</span>
            </a>
        </div>
    </div>
</div>

<!-- Compact, Balanced Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Members -->
    <div class="col-xl-3 col-sm-6">
        <a href="<?= BASE_URL ?>/admin/members" class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="stat-label">Total Members</span>
                <div class="stat-icon bg-soft-orange text-orange">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_members']) ?></div>
            <div class="stat-desc">Forum community users</div>
        </a>
    </div>

    <!-- Stat 2: Projects -->
    <div class="col-xl-3 col-sm-6">
        <a href="<?= BASE_URL ?>/admin/projects" class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="stat-label">Active Projects</span>
                <div class="stat-icon bg-soft-blue text-blue">
                    <span class="material-symbols-outlined">folder_special</span>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_projects']) ?></div>
            <div class="stat-desc">Completed & shipped works</div>
        </a>
    </div>

    <!-- Stat 3: Applications -->
    <div class="col-xl-3 col-sm-6">
        <a href="<?= BASE_URL ?>/admin/applications" class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="stat-label">Applications</span>
                <div class="stat-icon bg-soft-green text-green">
                    <span class="material-symbols-outlined">assignment_ind</span>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_applicants']) ?></div>
            <div class="stat-desc">Program registrations</div>
        </a>
    </div>

    <!-- Stat 4: Events & Trainings -->
    <div class="col-xl-3 col-sm-6">
        <a href="<?= BASE_URL ?>/admin/events" class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="stat-label">Events & Trainings</span>
                <div class="stat-icon bg-soft-purple text-purple">
                    <span class="material-symbols-outlined">calendar_today</span>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_events'] + $stats['total_trainings']) ?></div>
            <div class="stat-desc"><?= $stats['total_events'] ?> events &middot; <?= $stats['total_trainings'] ?> trainings</div>
        </a>
    </div>
</div>

<!-- Middle Section: Recent Members & Latest Applications -->
<div class="row g-3 mb-4">
    <!-- Recent Members -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Recent Members</h2>
                <a href="<?= BASE_URL ?>/admin/members" class="admin-card-link">View all &rarr;</a>
            </div>
            <div class="admin-card-body p-0">
                <div class="admin-list-group">
                    <?php if (!empty($recent_members)): ?>
                        <?php foreach ($recent_members as $rm):
                            $avatarPath = $rm['avatar'] ?? null;
                            $defaultAvatar = BASE_URL . '/img/default-user.svg';

                            if ($avatarPath) {
                                $avatar = (strpos($avatarPath, 'uploads/') !== false) ? BASE_URL . '/' . ltrim($avatarPath, '/') : BASE_URL . '/uploads/forum/avatars/' . $avatarPath;
                            } else {
                                $avatar = $defaultAvatar;
                            }
                        ?>
                            <div class="admin-list-item">
                                <img src="<?= $avatar ?>" class="avatar-circle" alt="<?= htmlspecialchars($rm['full_name']) ?>" onerror="this.src='<?= $defaultAvatar ?>'">
                                <div class="item-info flex-grow-1 min-w-0">
                                    <div class="item-name text-truncate"><?= htmlspecialchars($rm['full_name']) ?></div>
                                    <div class="item-sub text-truncate"><?= htmlspecialchars($rm['email']) ?></div>
                                </div>
                                <div class="item-date flex-shrink-0"><?= date('M d', strtotime($rm['created_at'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted small">No members registered yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Applications -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Latest Applications</h2>
                <a href="<?= BASE_URL ?>/admin/applications" class="admin-card-link">Review all &rarr;</a>
            </div>
            <div class="admin-card-body p-0">
                <div class="admin-list-group">
                    <?php if (!empty($recent_applications)): ?>
                        <?php foreach ($recent_applications as $app):
                            $userData = json_decode($app['user_data'], true);
                            $firstName = $userData['firstname'] ?? $userData['first_name'] ?? '';
                            $lastName = $userData['lastname'] ?? $userData['last_name'] ?? '';
                            $fullName = $userData['full_name'] ?? $userData['name'] ?? trim($firstName . ' ' . $lastName);
                            if (empty($fullName)) $fullName = 'Applicant #' . ($app['id'] ?? '—');
                            $programName = $app['type'] ?? 'Training Program';
                        ?>
                            <div class="admin-list-item">
                                <div class="stat-icon-sm bg-soft-blue text-blue me-2">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">assignment_ind</span>
                                </div>
                                <div class="item-info flex-grow-1 min-w-0">
                                    <div class="item-name text-truncate"><?= htmlspecialchars($fullName) ?></div>
                                    <div class="item-sub text-truncate text-primary" style="font-weight: 500;"><?= htmlspecialchars($programName) ?></div>
                                </div>
                                <div class="item-date flex-shrink-0"><?= date('M d', strtotime($app['created_at'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted small">No applications received yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: System Overview & Quick Actions -->
<div class="row g-3">
    <!-- Chart: System Content Distribution -->
    <div class="col-lg-8">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Content Overview</h2>
                <span class="text-muted" style="font-size: 0.8rem;">Published records</span>
            </div>
            <div class="admin-card-body p-3">
                <div style="height: 240px; position: relative;">
                    <canvas id="contentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Quick Actions</h2>
            </div>
            <div class="admin-card-body p-3">
                <div class="quick-action-list">
                    <a href="<?= BASE_URL ?>/admin/blog/add" class="quick-link-item">
                        <div class="quick-link-icon bg-soft-orange text-orange">
                            <span class="material-symbols-outlined">edit_square</span>
                        </div>
                        <div class="quick-link-text">
                            <span class="quick-link-title">Post New Article</span>
                            <span class="quick-link-sub">Publish to tech blog</span>
                        </div>
                        <span class="material-symbols-outlined quick-link-arrow">chevron_right</span>
                    </a>

                    <a href="<?= BASE_URL ?>/admin/events/add" class="quick-link-item">
                        <div class="quick-link-icon bg-soft-blue text-blue">
                            <span class="material-symbols-outlined">add_circle</span>
                        </div>
                        <div class="quick-link-text">
                            <span class="quick-link-title">Create Event</span>
                            <span class="quick-link-sub">Schedule new event</span>
                        </div>
                        <span class="material-symbols-outlined quick-link-arrow">chevron_right</span>
                    </a>

                    <a href="<?= BASE_URL ?>/admin/banners" class="quick-link-item">
                        <div class="quick-link-icon bg-soft-purple text-purple">
                            <span class="material-symbols-outlined">view_carousel</span>
                        </div>
                        <div class="quick-link-text">
                            <span class="quick-link-title">Hero Banners</span>
                            <span class="quick-link-sub">Update homepage slides</span>
                        </div>
                        <span class="material-symbols-outlined quick-link-arrow">chevron_right</span>
                    </a>

                    <a href="<?= BASE_URL ?>/admin/services" class="quick-link-item">
                        <div class="quick-link-icon bg-soft-green text-green">
                            <span class="material-symbols-outlined">design_services</span>
                        </div>
                        <div class="quick-link-text">
                            <span class="quick-link-title">Manage Services</span>
                            <span class="quick-link-sub">Update service catalog</span>
                        </div>
                        <span class="material-symbols-outlined quick-link-arrow">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('contentChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Services', 'Projects', 'Events', 'Trainings', 'Testimonials', 'FAQs'],
            datasets: [{
                label: 'Total',
                data: [
                    <?= (int)($stats['total_services'] ?? 0) ?>,
                    <?= (int)($stats['total_projects'] ?? 0) ?>,
                    <?= (int)($stats['total_events'] ?? 0) ?>,
                    <?= (int)($stats['total_trainings'] ?? 0) ?>,
                    <?= (int)($stats['total_testimonials'] ?? 0) ?>,
                    <?= (int)($stats['total_faq'] ?? 0) ?>
                ],
                backgroundColor: 'rgba(244, 130, 33, 0.85)',
                hoverBackgroundColor: 'rgba(230, 117, 28, 1)',
                borderRadius: 6,
                barPercentage: 0.5,
                categoryPercentage: 0.65
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: "'Poppins', sans-serif", size: 12, weight: '600' },
                    bodyFont: { family: "'Open Sans', sans-serif", size: 11 },
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#64748b',
                        font: { family: "'Open Sans', sans-serif", size: 11 },
                        stepSize: 2
                    },
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#334155',
                        font: { family: "'Poppins', sans-serif", size: 11, weight: '500' }
                    },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
