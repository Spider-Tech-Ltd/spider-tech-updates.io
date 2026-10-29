<?php 
require('db_function/function.php');
require('secured-login.php');

$adminUsername = $_SESSION['sname'] ?? 'Super Admin';

// Telemetry Queries
$sql_services = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_services FROM services_tb");
$record_services = mysqli_fetch_assoc($sql_services);

$sql_projects = mysqli_query($spider_tech_db, "SELECT COUNT(project_id) total_projects FROM projects_tb") or die(mysqli_error($spider_tech_db));
$record_projects = mysqli_fetch_assoc($sql_projects);

$sql_events = mysqli_query($spider_tech_db, "SELECT COUNT(event_id) total_events FROM events") or die(mysqli_error($spider_tech_db));
$record_events = mysqli_fetch_assoc($sql_events);

$sql_testimonials = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_testimonials FROM testimonials_tb") or die(mysqli_error($spider_tech_db));
$record_testimonials = mysqli_fetch_assoc($sql_testimonials);

$sql_trainings = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_trainings FROM trainings_tb") or die(mysqli_error($spider_tech_db));
$record_trainings = mysqli_fetch_assoc($sql_trainings);

$sql_faq = mysqli_query($spider_tech_db, "SELECT COUNT(faq_id) total_faq FROM faq_tb") or die(mysqli_error($spider_tech_db));
$record_faq = mysqli_fetch_assoc($sql_faq);

$sql_applicants = mysqli_query($spider_tech_db, "SELECT COUNT(id) total_applicants FROM dse_application") or die(mysqli_error($spider_tech_db));
$record_applicants = mysqli_fetch_assoc($sql_applicants);

$sql_messages = mysqli_query($spider_tech_db, "SELECT COUNT(message_id) total_messages FROM messages_tb");
$record_messages = $sql_messages ? mysqli_fetch_assoc($sql_messages) : ['total_messages' => 0];

// Fetch Recent Projects
$recent_projects = mysqli_query($spider_tech_db, "SELECT p.project_id, p.project_name, p.project_year, p.project_pic, s.service_name 
    FROM projects_tb p 
    LEFT JOIN services_tb s ON p.service_id = s.id 
    ORDER BY p.project_id DESC LIMIT 5");

// Fetch Recent Enquiries
$recent_enquiries = mysqli_query($spider_tech_db, "SELECT message_id, name, email, subject 
    FROM messages_tb 
    ORDER BY message_id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php require('head-section.html'); ?>
</head>

<body class="<?php require('body-tag-css.html'); ?>">
	<div class="page-wrapper">
		<!-- Header -->
		<?php require('header-section.php'); ?>

		<!-- Page Container -->
		<div class="page-container">
			<!-- Sidebar Menu -->
			<?php require('side-menu-section.php'); ?>

			<!-- Page Content -->
			<div class="page-content-wrapper">
				<div class="page-content">

					<!-- Page Bar & Breadcrumbs -->
					<div class="page-bar">
						<h1 class="page-title">Administrative Dashboard</h1>
						<ol class="page-breadcrumb">
							<li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i></li>
							<li class="active">Dashboard</li>
						</ol>
					</div>

					<!-- Hero Welcome Strip & Quick Actions -->
					<div class="dashboard-hero-strip">
						<div>
							<h2 class="dashboard-hero-title">Welcome back, <?= htmlspecialchars($adminUsername); ?></h2>
							<p class="dashboard-hero-subtitle">Consolidated operational telemetry, content management, and client inquiries.</p>
						</div>
						<div class="quick-actions-wrap">
							<a href="add_projects.php" class="btn-quick-action">
								<i class="fa fa-plus"></i>
								<span>Add Project</span>
							</a>
							<a href="add_services.php" class="btn-quick-action">
								<i class="fa fa-plus"></i>
								<span>Add Service</span>
							</a>
							<a href="add_trainings.php" class="btn-quick-action">
								<i class="fa fa-plus"></i>
								<span>Add Training</span>
							</a>
							<a href="add_events.php" class="btn-quick-action">
								<i class="fa fa-plus"></i>
								<span>Add Event</span>
							</a>
						</div>
					</div>

					<!-- Telemetry Stat Cards Grid -->
					<div class="row">
						<!-- Projects -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Total Projects</span>
									<span class="stat-card-number"><?= (int)($record_projects['total_projects'] ?? 0); ?></span>
									<a href="all_projects.php" class="stat-card-link">
										<span>Manage Projects</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">folder_special</i>
								</div>
							</div>
						</div>

						<!-- Services -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Active Services</span>
									<span class="stat-card-number"><?= (int)($record_services['total_services'] ?? 0); ?></span>
									<a href="all_services.php" class="stat-card-link">
										<span>Manage Services</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">design_services</i>
								</div>
							</div>
						</div>

						<!-- Trainings -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Training Programs</span>
									<span class="stat-card-number"><?= (int)($record_trainings['total_trainings'] ?? 0); ?></span>
									<a href="all_trainings.php" class="stat-card-link">
										<span>Manage Trainings</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">school</i>
								</div>
							</div>
						</div>

						<!-- Events -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Total Events</span>
									<span class="stat-card-number"><?= (int)($record_events['total_events'] ?? 0); ?></span>
									<a href="all_events.php" class="stat-card-link">
										<span>Manage Events</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">event</i>
								</div>
							</div>
						</div>

						<!-- Client Enquiries -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Client Messages</span>
									<span class="stat-card-number"><?= (int)($record_messages['total_messages'] ?? 0); ?></span>
									<a href="all_enquiries.php" class="stat-card-link">
										<span>View Enquiries</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">mail</i>
								</div>
							</div>
						</div>

						<!-- DSE Applicants -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">DSE Applicants</span>
									<span class="stat-card-number"><?= (int)($record_applicants['total_applicants'] ?? 0); ?></span>
									<a href="all_applicants.php" class="stat-card-link">
										<span>Review Applicants</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">how_to_reg</i>
								</div>
							</div>
						</div>

						<!-- Testimonials -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">Testimonials</span>
									<span class="stat-card-number"><?= (int)($record_testimonials['total_testimonials'] ?? 0); ?></span>
									<a href="all_testimonials.php" class="stat-card-link">
										<span>Manage Feedback</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">rate_review</i>
								</div>
							</div>
						</div>

						<!-- FAQ Items -->
						<div class="col-xl-3 col-md-6 col-12">
							<div class="stat-card">
								<div class="stat-card-info">
									<span class="stat-card-label">FAQ Knowledge</span>
									<span class="stat-card-number"><?= (int)($record_faq['total_faq'] ?? 0); ?></span>
									<a href="all_faq.php" class="stat-card-link">
										<span>Manage FAQs</span>
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
								<div class="stat-card-icon-wrap">
									<i class="material-icons">help_outline</i>
								</div>
							</div>
						</div>
					</div>

					<!-- Lower Operational Grid -->
					<div class="row">
						<!-- Main Activity Column (8 cols) -->
						<div class="col-xl-8 col-lg-7 col-12">
							<!-- Recent Projects Card -->
							<div class="card card-box">
								<div class="card-head">
									<header>Recent Case Studies &amp; Projects</header>
									<a href="all_projects.php" class="btn btn-default btn-sm">View All Projects</a>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="recent-table">
											<thead>
												<tr>
													<th>Project</th>
													<th>Category</th>
													<th>Year</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($recent_projects && mysqli_num_rows($recent_projects) > 0): ?>
													<?php while ($proj = mysqli_fetch_assoc($recent_projects)): ?>
														<tr>
															<td>
																<div style="display: flex; align-items: center; gap: 12px;">
																	<?php if (!empty($proj['project_pic'])): ?>
																		<img src="<?= htmlspecialchars($proj['project_pic']); ?>" alt="" class="recent-thumb">
																	<?php else: ?>
																		<div class="recent-thumb" style="display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #94a3b8;">
																			<i class="fa fa-image"></i>
																		</div>
																	<?php endif; ?>
																	<div>
																		<strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars(stripslashes($proj['project_name'])); ?></strong>
																	</div>
																</div>
															</td>
															<td>
																<span class="recent-badge-category"><?= htmlspecialchars($proj['service_name'] ?? 'General'); ?></span>
															</td>
															<td>
																<span style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= htmlspecialchars($proj['project_year']); ?></span>
															</td>
															<td class="text-right">
																<a href="all_projects.php?project=<?= (int)$proj['project_id']; ?>" class="btn btn-default btn-xs" title="Edit Project">
																	<i class="fa fa-pencil"></i> Edit
																</a>
															</td>
														</tr>
													<?php endwhile; ?>
												<?php else: ?>
													<tr>
														<td colspan="4" class="text-center py-4 text-muted">No projects found. <a href="add_projects.php">Add one now</a>.</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<!-- Recent Inquiries Card -->
							<div class="card card-box">
								<div class="card-head">
									<header>Recent Client Enquiries</header>
									<a href="all_enquiries.php" class="btn btn-default btn-sm">All Messages</a>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="recent-table">
											<thead>
												<tr>
													<th>Client</th>
													<th>Subject</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($recent_enquiries && mysqli_num_rows($recent_enquiries) > 0): ?>
													<?php while ($msg = mysqli_fetch_assoc($recent_enquiries)): ?>
														<tr>
															<td>
																<div style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars(stripslashes($msg['name'])); ?></div>
																<small class="text-muted"><?= htmlspecialchars($msg['email']); ?></small>
															</td>
															<td>
																<span><?= htmlspecialchars(stripslashes($msg['subject'] ?? 'General Consultation')); ?></span>
															</td>
															<td class="text-right">
																<a href="all_enquiries.php" class="btn btn-default btn-xs">
																	<i class="fa fa-envelope-open-o"></i> View
																</a>
															</td>
														</tr>
													<?php endwhile; ?>
												<?php else: ?>
													<tr>
														<td colspan="3" class="text-center py-4 text-muted">No new client messages.</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<!-- System Health & Quick Hub Column (4 cols) -->
						<div class="col-xl-4 col-lg-5 col-12">
							<!-- System Health Card -->
							<div class="card card-box">
								<div class="card-head">
									<header>System Telemetry</header>
								</div>
								<div class="card-body">
									<ul class="system-health-list">
										<li class="system-health-item">
											<span class="system-health-label">
												<span class="status-indicator-dot"></span>
												<span>Platform Status</span>
											</span>
											<span class="system-health-value" style="color: #10b981;">Operational</span>
										</li>
										<li class="system-health-item">
											<span class="system-health-label">
												<i class="fa fa-database text-muted"></i>
												<span>Database Engine</span>
											</span>
											<span class="system-health-value">MySQL / MariaDB</span>
										</li>
										<li class="system-health-item">
											<span class="system-health-label">
												<i class="fa fa-code text-muted"></i>
												<span>PHP Environment</span>
											</span>
											<span class="system-health-value"><?= phpversion(); ?></span>
										</li>
										<li class="system-health-item">
											<span class="system-health-label">
												<i class="fa fa-user-circle text-muted"></i>
												<span>Active Session</span>
											</span>
											<span class="system-health-value"><?= htmlspecialchars($adminUsername); ?></span>
										</li>
										<li class="system-health-item">
											<span class="system-health-label">
												<i class="fa fa-clock-o text-muted"></i>
												<span>Server Time</span>
											</span>
											<span class="system-health-value"><?= date('H:i T'); ?></span>
										</li>
									</ul>
								</div>
							</div>

							<!-- Quick Platform Access Hub -->
							<div class="card card-box">
								<div class="card-head">
									<header>Corporate Content Hub</header>
								</div>
								<div class="card-body">
									<p class="text-muted" style="font-size: 0.85rem; margin-bottom: 16px;">
										Manage strategic company statements, organizational values, and corporate disclosures.
									</p>
									<div style="display: flex; flex-direction: column; gap: 8px;">
										<a href="all_about_info.php" class="btn btn-default" style="justify-content: flex-start;">
											<i class="material-icons" style="color: var(--admin-primary); font-size: 1.1rem;">history_edu</i>
											<span>About Us &amp; Company History</span>
										</a>
										<a href="edit_mission_statement.php" class="btn btn-default" style="justify-content: flex-start;">
											<i class="material-icons" style="color: var(--admin-primary); font-size: 1.1rem;">flag</i>
											<span>Mission Statement</span>
										</a>
										<a href="edit_vision_statement.php" class="btn btn-default" style="justify-content: flex-start;">
											<i class="material-icons" style="color: var(--admin-primary); font-size: 1.1rem;">visibility</i>
											<span>Vision Statement</span>
										</a>
										<a href="edit_core_value.php" class="btn btn-default" style="justify-content: flex-start;">
											<i class="material-icons" style="color: var(--admin-primary); font-size: 1.1rem;">verified</i>
											<span>Core Values</span>
										</a>
										<a href="edit_contact_details.php" class="btn btn-default" style="justify-content: flex-start;">
											<i class="material-icons" style="color: var(--admin-primary); font-size: 1.1rem;">pin_drop</i>
											<span>Corporate Contact Details</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- End Page Content -->
		</div>
		<!-- End Page Container -->

		<!-- Footer -->
		<?php require('footer-section.html'); ?>
	</div>

	<!-- JavaScript includes -->
	<?php require('js-section.html'); ?>
</body>
</html>
