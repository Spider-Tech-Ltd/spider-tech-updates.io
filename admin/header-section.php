<?php
$adminUsername = $_SESSION['sname'] ?? 'Super Admin';
$adminInitial = strtoupper(substr($adminUsername, 0, 1));
?>
<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner">
		<!-- Logo start -->
		<div class="page-logo">
			<a href="dashboard.php">
				<img src="../images/spider-icon.png" width="36" height="36" alt="Spider Tech Logo" style="object-fit: contain;">
				<div class="admin-brand-title">
					Spider<span>Tech</span>
					<span class="admin-brand-badge">Admin</span>
				</div>
			</a>
		</div>
		<!-- Logo end -->

		<!-- Sidebar Toggler & Quick View Site -->
		<ul class="nav navbar-nav navbar-left in">
			<li>
				<a href="javascript:;" class="menu-toggler sidebar-toggler" title="Toggle Sidebar">
					<i class="icon-menu"></i>
				</a>
			</li>
			<li class="hidden-xs">
				<a href="../" target="_blank" class="header-view-website" title="Open live public website in new tab">
					<i class="fa fa-external-link"></i>
					<span>View Live Site</span>
				</a>
			</li>
		</ul>

		<!-- Mobile Menu Toggler -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
			<span></span>
		</a>

		<!-- Top Header Menu Right -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- Fullscreen -->
				<li>
					<a href="javascript:;" class="fullscreen-btn" title="Toggle Fullscreen">
						<i class="fa fa-arrows-alt"></i>
					</a>
				</li>

				<!-- User Account Dropdown -->
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="admin-avatar-badge"><?= $adminInitial; ?></span>
						<span class="username username-hide-on-mobile"><?= htmlspecialchars($adminUsername); ?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="admin_accounts.php">
								<i class="icon-user"></i> Admin Accounts
							</a>
						</li>
						<li>
							<a href="../" target="_blank">
								<i class="icon-globe"></i> Visit Website
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="logout.php" class="logout-link">
								<i class="icon-logout"></i> Log Out
							</a>
						</li>
					</ul>
				</li>
				<!-- End User Account Dropdown -->
			</ul>
		</div>
	</div>
</div>
