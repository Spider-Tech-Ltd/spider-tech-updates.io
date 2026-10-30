<?php 
require('superadmin_functions.php');
require('secured-login.php');

if (!isset($_SESSION['testimonial']) || empty($_SESSION['testimonial'])) {
    header('location: all_testimonials.php');
    exit();
}

$testimonial_id_clean = mysqli_real_escape_string($spider_tech_db, $_SESSION['testimonial']);
$testimonial_query = mysqli_query($spider_tech_db, "SELECT * FROM testimonials_tb WHERE id = '$testimonial_id_clean'") or die(mysqli_error($spider_tech_db));
$testimonial_row = mysqli_fetch_assoc($testimonial_query);

if (!$testimonial_row) {
    header('location: all_testimonials.php');
    exit();
}
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
								<div class="page-title">Edit Testimonial: <?= htmlspecialchars(stripslashes($testimonial_row['name'])); ?></div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_testimonials.php">Testimonials</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Edit Testimonial</li>
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

					<form id="edit_testimonial_form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="testimonial_id" value="<?= htmlspecialchars(stripslashes($testimonial_row['id'])); ?>">

						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">format_quote</i> Testimonial Statement</h2>
										<span class="form-label-tag">ID #<?= htmlspecialchars($testimonial_row['id']); ?></span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="testimonial">
												<span>Client Review / Endorsement Statement <span class="required-star">*</span></span>
											</label>
											<textarea id="testimonial" name="testimonial" 
												rows="6"
												class="form-control-modern" 
												placeholder="Enter detailed feedback from client..." 
												required><?php echo htmlspecialchars(stripslashes($testimonial_row['testimonial'])); ?></textarea>
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
												placeholder="Enter name"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($testimonial_row['name'])); ?>" 
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
												placeholder="Enter organization"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($testimonial_row['organization'])); ?>" 
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
												placeholder="E.g. CEO"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($testimonial_row['title'])); ?>" 
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
										<span class="admin-dim-badge">Square</span>
									</div>
									<div class="form-card-body">
										<!-- Current Image Display -->
										<?php 
										$picPath = $testimonial_row['image'];
										if (!empty($picPath)):
											$displayPath = (file_exists($picPath) || file_exists('../' . $picPath)) ? $picPath : $picPath;
										?>
											<div class="admin-current-asset-card">
												<span class="asset-badge"><i class="material-icons" style="font-size: 14px;">check_circle</i> Current Live Photo</span>
												<img src="<?= htmlspecialchars($displayPath); ?>" alt="Current Testimonial Photo" class="admin-current-asset-thumbnail" onerror="this.src='../images/logo/logo.png'">
											</div>
										<?php endif; ?>

										<!-- Replace Image Dropzone (Optional) -->
										<label class="form-label-modern" style="margin-top: 10px;">
											<span>Replace Photo</span>
											<span class="form-help-modern">Optional</span>
										</label>
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to choose new</span> or drag here</div>
												<div class="admin-dropzone-desc">Leave empty to keep existing photo</div>
												<input type="file" name="img" accept="image/*">
											</div>

											<div class="admin-preview-container" style="display: none;">
												<img class="admin-preview-img" src="" alt="Selected Preview">
												<div class="admin-preview-meta">
													<span class="admin-preview-filename"></span>
													<button type="button" class="admin-preview-remove">
														<i class="material-icons">close</i> Cancel Replacement
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
										<h3 class="form-card-title"><i class="material-icons">save</i> Actions</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="edit_testimonial" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Update Testimonial
										</button>
										<a href="all_testimonials.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to Testimonials
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
