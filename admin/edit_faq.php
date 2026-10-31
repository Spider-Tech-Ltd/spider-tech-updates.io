<?php 
require('superadmin_functions.php');
require('secured-login.php');

if (!isset($_SESSION['faq_id']) || empty($_SESSION['faq_id'])) {
    header('location: all_faq.php');
    exit();
}

$faq_id_clean = mysqli_real_escape_string($spider_tech_db, $_SESSION['faq_id']);
$faq_query = mysqli_query($spider_tech_db, "SELECT * FROM faq_tb WHERE faq_id = '$faq_id_clean'") or die(mysqli_error($spider_tech_db));
$faq_row = mysqli_fetch_assoc($faq_query);

if (!$faq_row) {
    header('location: all_faq.php');
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
								<div class="page-title">Edit FAQ #<?= htmlspecialchars($faq_row['faq_id']); ?></div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_faq.php">FAQs</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Edit FAQ</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($faq_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($faq_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($faq_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($faq_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="edit_faq_form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="faq_id" value="<?= htmlspecialchars(stripslashes($faq_row['faq_id'])); ?>">

						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">help_outline</i> Question & Knowledgebase Response</h2>
										<span class="form-label-tag">ID #<?= htmlspecialchars($faq_row['faq_id']); ?></span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="faq_question">
												<span>Frequently Asked Question <span class="required-star">*</span></span>
											</label>
											<input type="text" id="faq_question" name="faq_question" 
												placeholder="Enter Question"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($faq_row['faq_question'])); ?>" 
												required />
											<?php if(!empty($faq_questionErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($faq_questionErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Authoritative Answer <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="faq_answer" required><?php 
												echo stripslashes($faq_row['faq_answer']);
											?></textarea>
											<?php if(!empty($faq_answerErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($faq_answerErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">lightbulb_outline</i> FAQ Guidelines</h3>
									</div>
									<div class="form-card-body">
										<p style="font-family: 'Open Sans', sans-serif; font-size: 0.85rem; color: #64748b; line-height: 1.6; margin: 0;">
											Write concise, solution-oriented answers. Format structured terms or step-by-step procedures with numbered lists.
										</p>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">save</i> Actions</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="edit_faq" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Update FAQ
										</button>
										<a href="all_faq.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to FAQs
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
