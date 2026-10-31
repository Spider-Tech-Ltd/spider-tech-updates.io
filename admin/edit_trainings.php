<?php 
require('superadmin_functions.php');
require('secured-login.php');

if (!isset($_SESSION['training']) || empty($_SESSION['training'])) {
    header('location: all_trainings.php');
    exit();
}

$training_id_clean = mysqli_real_escape_string($spider_tech_db, $_SESSION['training']);
$training_query = mysqli_query($spider_tech_db, "SELECT * FROM trainings_tb WHERE id = '$training_id_clean'") or die(mysqli_error($spider_tech_db));
$training_row = mysqli_fetch_assoc($training_query);

if (!$training_row) {
    header('location: all_trainings.php');
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
								<div class="page-title">Edit Training: <?= htmlspecialchars(stripslashes($training_row['training_name'])); ?></div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_trainings.php">Trainings</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Edit Training</li>
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

					<form id="edit_training_form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="training_id" value="<?= htmlspecialchars(stripslashes($training_row['id'])); ?>">

						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">edit_note</i> Curriculum & Program Syllabus</h2>
										<span class="form-label-tag">ID #<?= htmlspecialchars($training_row['id']); ?></span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="training_name">
												<span>Training Title <span class="required-star">*</span></span>
											</label>
											<input type="text" id="training_name" name="training_name" 
												placeholder="Enter training name"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($training_row['training_name'])); ?>" 
												required />
											<?php if(!empty($training_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="training_description">
												<span>Brief Executive Summary / Excerpt <span class="required-star">*</span></span>
											</label>
											<input type="text" id="training_description" name="training_description" 
												placeholder="Short summary..."
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($training_row['training_description'])); ?>" 
												required />
											<?php if(!empty($training_descriptionErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_descriptionErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Full Program Syllabus, Schedule & Deliverables <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="training_details" required><?php 
												echo stripslashes($training_row['training_details']);
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
												placeholder="E.g. fa fa-graduation-cap"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($training_row['training_icon'])); ?>" 
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
										<!-- Current Image Display -->
										<?php 
										$picPath = $training_row['training_image'];
										if (!empty($picPath)):
											$displayPath = (file_exists($picPath) || file_exists('../' . $picPath)) ? $picPath : $picPath;
										?>
											<div class="admin-current-asset-card">
												<span class="asset-badge"><i class="material-icons" style="font-size: 14px;">check_circle</i> Current Live Cover</span>
												<img src="<?= htmlspecialchars($displayPath); ?>" alt="Current Training Cover" class="admin-current-asset-thumbnail" onerror="this.src='../images/logo/logo.png'">
											</div>
										<?php endif; ?>

										<!-- Replace Image Dropzone (Optional) -->
										<label class="form-label-modern" style="margin-top: 10px;">
											<span>Replace Cover</span>
											<span class="form-help-modern">Optional</span>
										</label>
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to choose new</span> or drag here</div>
												<div class="admin-dropzone-desc">Leave empty to keep existing cover</div>
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
										<?php if(!empty($training_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($training_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">save</i> Actions</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="edit_training" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Update Training
										</button>
										<a href="all_trainings.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to Trainings
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
