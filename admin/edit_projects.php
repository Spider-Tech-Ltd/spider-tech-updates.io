<?php 
require('superadmin_functions.php');
require('secured-login.php');

if (!isset($_SESSION['project']) || empty($_SESSION['project'])) {
    header('location: all_projects.php');
    exit();
}

$project_id_clean = mysqli_real_escape_string($spider_tech_db, $_SESSION['project']);
$project_query = mysqli_query($spider_tech_db, "SELECT * FROM projects_tb p LEFT JOIN services_tb s ON s.id = p.service_id WHERE p.project_id = '$project_id_clean'") or die(mysqli_error($spider_tech_db));
$project_row = mysqli_fetch_assoc($project_query);

if (!$project_row) {
    header('location: all_projects.php');
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
								<div class="page-title">Edit Project: <?= htmlspecialchars(stripslashes($project_row['project_name'])); ?></div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_projects.php">Projects</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Edit Project</li>
							</ol>
						</div>
					</div>

					<!-- Form Feedback Alerts -->
					<?php if (!empty($project_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($project_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($project_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($project_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="edit_project_form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="project_id" value="<?= htmlspecialchars(stripslashes($project_row['project_id'])); ?>">
						<input type="hidden" name="project_pic" value="<?= htmlspecialchars(stripslashes($project_row['project_pic'])); ?>">

						<div class="admin-workspace-grid">
							<!-- Main Content Column (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">edit_note</i> Project Narrative & Details</h2>
										<span class="form-label-tag">ID #<?= htmlspecialchars($project_row['project_id']); ?></span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="project_name">
												<span>Project Name / Title <span class="required-star">*</span></span>
												<span class="form-help-modern">Public project title</span>
											</label>
											<input type="text" id="project_name" name="project_name" 
												placeholder="Enter project name"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($project_row['project_name'])); ?>" 
												required />
											<?php if(!empty($project_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($project_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Full Project Case Study & Specifications <span class="required-star">*</span></span>
												<span class="form-help-modern">Rich-text enabled</span>
											</label>
											<textarea id="formsummernote" name="project_description" required><?php 
												echo stripslashes($project_row['project_description']);
											?></textarea>
											<?php if(!empty($project_descriptionErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($project_descriptionErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls Column (32%) -->
							<div class="admin-workspace-sidebar">
								<!-- Metadata & Classification -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">category</i> Classification</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="service_name">
												<span>Associated Service <span class="required-star">*</span></span>
											</label>
											<select id="service_name" class="form-control-modern" name="service_name" required>
												<?php
												$service_query = mysqli_query($spider_tech_db, "SELECT * FROM services_tb ORDER BY service_name ASC") or die(mysqli_error($spider_tech_db));
												while ($service_row = mysqli_fetch_assoc($service_query)):
													$isSelected = ($service_row['id'] == $project_row['service_id']) ? 'selected' : '';
												?>
													<option value="<?= $service_row['id']; ?>" <?= $isSelected; ?>>
														<?= htmlspecialchars($service_row['service_name']); ?>
													</option>
												<?php endwhile; ?>
											</select>
											<?php if(!empty($service_nameErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($service_nameErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="project_year">
												<span>Delivery Year <span class="required-star">*</span></span>
											</label>
											<input type="text" id="project_year" name="project_year" 
												placeholder="E.g. 2024"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($project_row['project_year'])); ?>" 
												required />
											<?php if(!empty($project_yearErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($project_yearErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Featured Picture Asset -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">image</i> Showcase Asset</h3>
										<span class="admin-dim-badge">790 × 436</span>
									</div>
									<div class="form-card-body">
										<!-- Current Image Display -->
										<?php 
										$picPath = $project_row['project_pic'];
										if (!empty($picPath)):
											$displayPath = (file_exists($picPath) || file_exists('../' . $picPath)) ? $picPath : $picPath;
										?>
											<div class="admin-current-asset-card">
												<span class="asset-badge"><i class="material-icons" style="font-size: 14px;">check_circle</i> Current Live Asset</span>
												<img src="<?= htmlspecialchars($displayPath); ?>" alt="Current Project Pic" class="admin-current-asset-thumbnail" onerror="this.src='../images/logo/logo.png'">
											</div>
										<?php endif; ?>

										<!-- Replace Image Dropzone (Optional) -->
										<label class="form-label-modern" style="margin-top: 10px;">
											<span>Replace Image</span>
											<span class="form-help-modern">Optional</span>
										</label>
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to choose new</span> or drag here</div>
												<div class="admin-dropzone-desc">Leave empty to keep existing image</div>
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
										<?php if(!empty($project_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($project_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Publishing Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">save</i> Actions</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="edit_project" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Update Project
										</button>
										<a href="all_projects.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to Projects
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
