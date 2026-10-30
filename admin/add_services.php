<?php 
require('superadmin_functions.php');
require('secured-login.php');
?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
	<?php require('head-section.html'); ?>
</head>
<!-- END HEAD -->

<body class="<?php require('body-tag-css.html'); ?>">
	<div class="page-wrapper">
		<!-- start header -->
		<?php require('header-section.php'); ?>
		<!-- end header -->
		<!-- start color quick setting -->
		<?php require('setting-section.html'); ?>
		<!-- end color quick setting -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php require('side-menu-section.php'); ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class="pull-left">
								<div class="page-title">Add New Service</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_services.php">Services</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Add Service</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($service_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($service_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($service_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($service_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="service_form" method="POST" enctype="multipart/form-data">
						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">room_service</i> Service Content & Specifications</h2>
										<span class="form-label-tag">Core Details</span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="service_name">
												<span>Service Title / Name <span class="required-star">*</span></span>
												<span class="form-help-modern">E.g. Custom Software Engineering</span>
											</label>
											<input type="text" id="service_name" name="service_name" 
												placeholder="Enter service name"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_service'])) { echo htmlspecialchars(stripslashes($service_name)); } ?>" 
												required />
											<?php if(!empty($service_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($service_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="service_description">
												<span>Brief Executive Summary / Excerpt <span class="required-star">*</span></span>
												<span class="form-help-modern">Used on listing cards & hero overview</span>
											</label>
											<input type="text" id="service_description" name="service_description" 
												placeholder="High-level summary of this engineering capability..."
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_service'])) { echo htmlspecialchars(stripslashes($service_description)); } ?>" 
												required />
											<?php if(!empty($service_descriptionErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($service_descriptionErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Comprehensive Service Deliverables & Methodology <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="service_details" required><?php 
												if(isset($_POST['add_service'])) { echo htmlspecialchars(stripslashes($_POST['service_details'])); }
											?></textarea>
											<?php if(!empty($service_detailsErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($service_detailsErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<!-- Icon & Visual Styling -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">palette</i> Visual Identity</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="service_icon">
												<span>Service Icon Class / Glyph <span class="required-star">*</span></span>
											</label>
											<input type="text" id="service_icon" name="service_icon" 
												placeholder="E.g. flaticon-settings or fa fa-code"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_service'])) { echo htmlspecialchars(stripslashes($service_icon)); } else { echo 'flaticon-settings'; } ?>" 
												required />
											<span class="form-help-modern">FontAwesome, Flaticon, or Material icon identifier</span>
											<?php if(!empty($service_iconErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($service_iconErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">publish</i> Publication</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="add_service" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Publish Service
										</button>
										<a href="all_services.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Discard & Return
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<?php require('setting_and_chat_section.php');?>
			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php require('footer-section.html'); ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
	<?php require('js-section.html'); ?>
	<!-- end js include path -->
</body>
</html>
