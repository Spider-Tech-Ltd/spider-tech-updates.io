<?php
$currentPage = basename($_SERVER['PHP_SELF']);

// Helper to determine if a menu parent or item is active
function isNavActive($pages, $currentPage) {
    if (is_array($pages)) {
        return in_array($currentPage, $pages) ? 'active open' : '';
    }
    return ($currentPage === $pages) ? 'active' : '';
}

function isSubActive($page, $currentPage) {
    return ($currentPage === $page) ? 'class="active"' : '';
}
?>
<div class="sidebar-container">
	<div class="sidemenu-container navbar-collapse collapse fixed-menu">
		<div id="remove-scroll" class="left-sidemenu">
			<ul class="sidemenu page-header-fixed slimscroll-style" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				
				<!-- Overview Section -->
				<li class="sidebar-section-heading">Overview</li>
				<li class="nav-item <?= isNavActive(['dashboard.php', 'dashboard', 'index.php'], $currentPage); ?>">
					<a href="dashboard.php" class="nav-link nav-toggle">
						<i class="material-icons">dashboard</i>
						<span class="title">Dashboard</span>
					</a>
				</li>

				<!-- Core Operations Section -->
				<li class="sidebar-section-heading">Core Operations</li>

				<!-- Services -->
				<li class="nav-item <?= isNavActive(['all_services.php', 'add_services.php', 'edit_services.php', 'view_service.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">design_services</i>
						<span class="title">Services</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_services.php', $currentPage); ?>>
							<a href="all_services.php" class="nav-link"><span class="title">All Services</span></a>
						</li>
						<li <?= isSubActive('add_services.php', $currentPage); ?>>
							<a href="add_services.php" class="nav-link"><span class="title">Add New Service</span></a>
						</li>
					</ul>
				</li>

				<!-- Projects -->
				<li class="nav-item <?= isNavActive(['all_projects.php', 'add_projects.php', 'edit_projects.php', 'view_project.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">folder_special</i>
						<span class="title">Projects</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_projects.php', $currentPage); ?>>
							<a href="all_projects.php" class="nav-link"><span class="title">All Projects</span></a>
						</li>
						<li <?= isSubActive('add_projects.php', $currentPage); ?>>
							<a href="add_projects.php" class="nav-link"><span class="title">Add New Project</span></a>
						</li>
					</ul>
				</li>

				<!-- Trainings & Programs -->
				<li class="nav-item <?= isNavActive(['all_trainings.php', 'add_trainings.php', 'edit_trainings.php', 'view_training.php', 'all_applicants.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">school</i>
						<span class="title">Trainings</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_trainings.php', $currentPage); ?>>
							<a href="all_trainings.php" class="nav-link"><span class="title">All Programs</span></a>
						</li>
						<li <?= isSubActive('add_trainings.php', $currentPage); ?>>
							<a href="add_trainings.php" class="nav-link"><span class="title">Add New Program</span></a>
						</li>
						<li <?= isSubActive('all_applicants.php', $currentPage); ?>>
							<a href="all_applicants.php" class="nav-link"><span class="title">DSE Applicants</span></a>
						</li>
					</ul>
				</li>

				<!-- Events -->
				<li class="nav-item <?= isNavActive(['all_events.php', 'add_events.php', 'add_event.php', 'edit_events.php', 'edit_event.php', 'view_event.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">event</i>
						<span class="title">Events</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_events.php', $currentPage); ?>>
							<a href="all_events.php" class="nav-link"><span class="title">All Events</span></a>
						</li>
						<li <?= isSubActive(['add_event.php', 'add_events.php'], $currentPage); ?>>
							<a href="add_event.php" class="nav-link"><span class="title">Add New Event</span></a>
						</li>
					</ul>
				</li>

				<!-- Marketing & Communications -->
				<li class="sidebar-section-heading">Marketing & Communications</li>

				<!-- News / Insights -->
				<li class="nav-item <?= isNavActive(['add_news.php', 'edit_news.php'], $currentPage); ?>">
					<a href="add_news.php" class="nav-link">
						<i class="material-icons">newspaper</i>
						<span class="title">News / Insights</span>
					</a>
				</li>

				<!-- Testimonials -->
				<li class="nav-item <?= isNavActive(['all_testimonials.php', 'add_testimonials.php', 'add_testimonial.php', 'edit_testimonials.php', 'view_testimonial.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">rate_review</i>
						<span class="title">Testimonials</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_testimonials.php', $currentPage); ?>>
							<a href="all_testimonials.php" class="nav-link"><span class="title">All Testimonials</span></a>
						</li>
						<li <?= isSubActive('add_testimonials.php', $currentPage); ?>>
							<a href="add_testimonials.php" class="nav-link"><span class="title">Add Testimonial</span></a>
						</li>
					</ul>
				</li>

				<!-- Media Gallery -->
				<li class="nav-item <?= isNavActive(['all_gallery.php', 'add_media.php', 'add_gallery.php', 'edit_gallery.php', 'view_media.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">photo_library</i>
						<span class="title">Media Gallery</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_gallery.php', $currentPage); ?>>
							<a href="all_gallery.php" class="nav-link"><span class="title">All Gallery</span></a>
						</li>
						<li <?= isSubActive('add_media.php', $currentPage); ?>>
							<a href="add_media.php" class="nav-link"><span class="title">Add Media</span></a>
						</li>
					</ul>
				</li>

				<!-- Jobs & Careers -->
				<li class="nav-item <?= isNavActive(['all_jobs.php', 'add_jobs.php', 'edit_jobs.php', 'all_applicants.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">work</i>
						<span class="title">Jobs / Careers</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_jobs.php', $currentPage); ?>>
							<a href="all_jobs.php" class="nav-link"><span class="title">All Jobs</span></a>
						</li>
						<li <?= isSubActive('add_jobs.php', $currentPage); ?>>
							<a href="add_jobs.php" class="nav-link"><span class="title">Post New Job</span></a>
						</li>
					</ul>
				</li>

				<!-- Inquiries & Contact -->
				<li class="nav-item <?= isNavActive(['all_enquiries.php', 'view_enquiry.php', 'messages.php', 'view_message.php'], $currentPage); ?>">
					<a href="all_enquiries.php" class="nav-link">
						<i class="material-icons">mail</i>
						<span class="title">Enquiries</span>
					</a>
				</li>

				<!-- FAQ -->
				<li class="nav-item <?= isNavActive(['all_faq.php', 'add_faq.php', 'edit_faq.php', 'view_faq.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">help_outline</i>
						<span class="title">FAQ</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_faq.php', $currentPage); ?>>
							<a href="all_faq.php" class="nav-link"><span class="title">All FAQs</span></a>
						</li>
						<li <?= isSubActive('add_faq.php', $currentPage); ?>>
							<a href="add_faq.php" class="nav-link"><span class="title">Add FAQ</span></a>
						</li>
					</ul>
				</li>

				<!-- Company & Organization -->
				<li class="sidebar-section-heading">Company & Structure</li>

				<!-- About Page -->
				<li class="nav-item <?= isNavActive(['all_about_info.php', 'add_about_information.php', 'edit_about_information.php', 'add_mission_statement.php', 'edit_mission_statement.php', 'add_vision_statement.php', 'edit_vision_statement.php', 'add_core_value.php', 'edit_core_value.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">business</i>
						<span class="title">About Content</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_about_info.php', $currentPage); ?>>
							<a href="all_about_info.php" class="nav-link"><span class="title">Story / History</span></a>
						</li>
						<li <?= isSubActive('edit_mission_statement.php', $currentPage); ?>>
							<a href="edit_mission_statement.php" class="nav-link"><span class="title">Mission Statement</span></a>
						</li>
						<li <?= isSubActive('edit_vision_statement.php', $currentPage); ?>>
							<a href="edit_vision_statement.php" class="nav-link"><span class="title">Vision Statement</span></a>
						</li>
						<li <?= isSubActive('edit_core_value.php', $currentPage); ?>>
							<a href="edit_core_value.php" class="nav-link"><span class="title">Core Values</span></a>
						</li>
					</ul>
				</li>

				<!-- Team Members -->
				<li class="nav-item <?= isNavActive(['all_members.php', 'add_members.php', 'edit_members.php', 'team_members.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">groups</i>
						<span class="title">Team Members</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('all_members.php', $currentPage); ?>>
							<a href="all_members.php" class="nav-link"><span class="title">All Members</span></a>
						</li>
						<li <?= isSubActive('add_members.php', $currentPage); ?>>
							<a href="add_members.php" class="nav-link"><span class="title">Add Member</span></a>
						</li>
					</ul>
				</li>

				<!-- Subsidiary -->
				<li class="nav-item <?= isNavActive(['all_subsidiary.php', 'add_subsidiary.php', 'edit_subsidiary.php'], $currentPage); ?>">
					<a href="all_subsidiary.php" class="nav-link">
						<i class="material-icons">apartment</i>
						<span class="title">Subsidiaries</span>
					</a>
				</li>

				<!-- Contact Details -->
				<li class="nav-item <?= isNavActive(['add_contact_details.php', 'edit_contact_details.php'], $currentPage); ?>">
					<a href="edit_contact_details.php" class="nav-link">
						<i class="material-icons">contact_phone</i>
						<span class="title">Contact Details</span>
					</a>
				</li>

				<!-- System Administration -->
				<li class="sidebar-section-heading">System</li>

				<!-- Admin Accounts -->
				<li class="nav-item <?= isNavActive(['admin_accounts.php', 'register_admin.php'], $currentPage); ?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="material-icons">manage_accounts</i>
						<span class="title">Admin Accounts</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li <?= isSubActive('admin_accounts.php', $currentPage); ?>>
							<a href="admin_accounts.php" class="nav-link"><span class="title">All Admins</span></a>
						</li>
						<li <?= isSubActive('register_admin.php', $currentPage); ?>>
							<a href="register_admin.php" class="nav-link"><span class="title">Register Admin</span></a>
						</li>
					</ul>
				</li>

				<!-- Webmail -->
				<li class="nav-item">
					<a href="https://spidertech.com.ng/webmail.php" target="_blank" class="nav-link">
						<i class="material-icons">mark_email_read</i>
						<span class="title">Webmail</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
</div>
