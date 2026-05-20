<div class="content-header">
    <h1>Dashboard</h1>
    <p>Welcome back, <?= $_SESSION['admin_name'] ?>. Here's what's happening with Spider Tech today.</p>
</div>

<!-- Stats Grid -->
<div class="row gy-4 gx-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-soft-orange text-orange">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Members</span>
                <span class="stat-value"><?= number_format($stats['total_members']) ?></span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-soft-blue text-blue">
                <span class="material-symbols-outlined">work</span>
            </div>
            <div class="stat-info">
                <span class="stat-label">Active Projects</span>
                <span class="stat-value"><?= number_format($stats['total_projects']) ?></span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-soft-green text-green">
                <span class="material-symbols-outlined">assignment_ind</span>
            </div>
            <div class="stat-info">
                <span class="stat-label">Applications</span>
                <span class="stat-value"><?= number_format($stats['total_applicants']) ?></span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-soft-purple text-purple">
                <span class="material-symbols-outlined">calendar_month</span>
            </div>
            <div class="stat-info">
                <span class="stat-label">Events & Trainings</span>
                <span class="stat-value"><?= number_format($stats['total_events'] + $stats['total_trainings']) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Activity Chart -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">System Overview</h5>
                <span class="text-muted fs-08">Content Distribution</span>
            </div>
            <div class="card-body-custom">
                <canvas id="contentChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header-custom">
                <h5 class="m-0 poppins">Quick Actions</h5>
            </div>
            <div class="card-body-custom">
                <div class="gap-vertical-3">
                    <a href="<?= BASE_URL ?>/admin/blog/add" class="quick-action-btn">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span>Post New Article</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/events/add" class="quick-action-btn">
                        <span class="material-symbols-outlined">event_available</span>
                        <span>Create New Event</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/banners" class="quick-action-btn">
                        <span class="material-symbols-outlined">upload</span>
                        <span>Update Hero Banners</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('contentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Services', 'Projects', 'Events', 'Trainings', 'Testimonials', 'FAQs'],
            datasets: [{
                label: 'Total Records',
                data: [
                    <?= $stats['total_services'] ?>,
                    <?= $stats['total_projects'] ?>,
                    <?= $stats['total_events'] ?>,
                    <?= $stats['total_trainings'] ?>,
                    <?= $stats['total_testimonials'] ?>,
                    <?= $stats['total_faq'] ?>
                ],
                backgroundColor: 'rgba(244, 130, 33, 0.7)',
                borderColor: 'rgba(244, 130, 33, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
