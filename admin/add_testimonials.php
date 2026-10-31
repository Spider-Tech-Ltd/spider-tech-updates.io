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
								<div class="page-title">Add Client Testimonial</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_testimonials.php">Testimonials</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Add Testimonial</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($testimonial_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($testimonial_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($testimonial_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($testimonial_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="testimonial_form" method="POST" enctype="multipart/form-data">
						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">format_quote</i> Testimonial Statement</h2>
										<span class="form-label-tag">Client Feedback</span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="testimonial">
												<span>Client Review / Endorsement Statement <span class="required-star">*</span></span>
												<span class="form-help-modern">The direct quote or testimonial text</span>
											</label>
											<textarea id="testimonial" name="testimonial" 
												rows="6"
												class="form-control-modern" 
												placeholder="Enter detailed feedback from the client..." 
												required><?php if(isset($_POST['add_testimonial'])) { echo htmlspecialchars(stripslashes($_POST['testimonial'])); } ?></textarea>
											<?php if(!empty($testimonialErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($testimonialErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<!-- Attestant Information -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">person</i> Attestant Identity</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="attestant_name">
												<span>Full Name <span class="required-star">*</span></span>
											</label>
											<input type="text" id="attestant_name" name="attestant_name" 
												placeholder="E.g. Michael O. Adeyemi"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_testimonial'])) { echo htmlspecialchars(stripslashes($attestant_name)); } ?>" 
												required />
											<?php if(!empty($attestant_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($attestant_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="organisation_name">
												<span>Company / Organization <span class="required-star">*</span></span>
											</label>
											<input type="text" id="organisation_name" name="organisation_name" 
												placeholder="E.g. Zenith Global Logistics"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_testimonial'])) { echo htmlspecialchars(stripslashes($organisation_name)); } ?>" 
												required />
											<?php if(!empty($organisation_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($organisation_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="title">
												<span>Title / Position <span class="required-star">*</span></span>
											</label>
											<input type="text" id="title" name="title" 
												placeholder="E.g. Chief Technology Officer"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_testimonial'])) { echo htmlspecialchars(stripslashes($title)); } ?>" 
												required />
											<?php if(!empty($titleErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($titleErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Attestant Photo / Logo -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">portrait</i> Client Photo</h3>
										<span class="admin-dim-badge">Square / 500px</span>
									</div>
									<div class="form-card-body">
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to browse</span> or drag photo</div>
												<div class="admin-dropzone-desc">JPG, PNG up to 2MB</div>
												<input type="file" name="img" accept="image/*" required>
											</div>

											<div class="admin-preview-container" style="display: none;">
												<img class="admin-preview-img" src="" alt="Selected Preview">
												<div class="admin-preview-meta">
													<span class="admin-preview-filename"></span>
													<button type="button" class="admin-preview-remove">
														<i class="material-icons">close</i> Remove
													</button>
												</div>
											</div>
										</div>
										<?php if(!empty($testimonial_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($testimonial_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">publish</i> Publication</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="add_testimonial" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Publish Testimonial
										</button>
										<a href="all_testimonials.php" class="btn-admin-cancel">
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
