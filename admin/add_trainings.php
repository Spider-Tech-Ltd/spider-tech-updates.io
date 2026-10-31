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
								<div class="page-title">Add New Training Program</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_trainings.php">Trainings</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Add Training</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($training_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($training_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($training_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($training_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="training_form" method="POST" enctype="multipart/form-data">
						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">school</i> Curriculum & Course Specifications</h2>
										<span class="form-label-tag">Course Details</span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="training_name">
												<span>Training Program Title <span class="required-star">*</span></span>
												<span class="form-help-modern">Public course / bootcamp title</span>
											</label>
											<input type="text" id="training_name" name="training_name" 
												placeholder="E.g. Professional Full Stack Software Engineering"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_training'])) { echo htmlspecialchars(stripslashes($training_name)); } ?>" 
												required />
											<?php if(!empty($training_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="training_description">
												<span>Brief Executive Summary / Excerpt <span class="required-star">*</span></span>
												<span class="form-help-modern">Target audience, duration, or key learning outcome</span>
											</label>
											<input type="text" id="training_description" name="training_description" 
												placeholder="Short summary for program cards..."
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_training'])) { echo htmlspecialchars(stripslashes($training_description)); } ?>" 
												required />
											<?php if(!empty($training_descriptionErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_descriptionErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Comprehensive Syllabus, Modules & Requirements <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="training_details" required><?php 
												if(isset($_POST['add_training'])) { echo htmlspecialchars(stripslashes($_POST['training_details'])); }
											?></textarea>
											<?php if(!empty($training_detailsErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_detailsErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<!-- Icon Identifier -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">category</i> Program Identity</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="training_icon">
												<span>Program Icon Class <span class="required-star">*</span></span>
											</label>
											<input type="text" id="training_icon" name="training_icon" 
												placeholder="E.g. fa fa-graduation-cap or flaticon-coding"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_training'])) { echo htmlspecialchars(stripslashes($training_icon)); } else { echo 'fa fa-graduation-cap'; } ?>" 
												required />
											<span class="form-help-modern">FontAwesome or Flaticon icon identifier</span>
											<?php if(!empty($training_iconErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_iconErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Training Cover Asset -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">image</i> Cover Asset</h3>
										<span class="admin-dim-badge">900 × 590</span>
									</div>
									<div class="form-card-body">
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to browse</span> or drag cover</div>
												<div class="admin-dropzone-desc">JPG, PNG, WebP up to 3MB</div>
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
										<?php if(!empty($training_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">publish</i> Publication</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="add_training" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Publish Training
										</button>
										<a href="all_trainings.php" class="btn-admin-cancel">
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
