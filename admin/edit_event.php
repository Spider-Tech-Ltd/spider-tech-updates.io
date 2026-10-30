<?php 
require('superadmin_functions.php');
require('secured-login.php');

if (!isset($_SESSION['event_id']) || empty($_SESSION['event_id'])) {
    header('location: all_events.php');
    exit();
}

$event_id_clean = mysqli_real_escape_string($spider_tech_db, $_SESSION['event_id']);
$event_query = mysqli_query($spider_tech_db, "SELECT * FROM events WHERE event_id = '$event_id_clean'") or die(mysqli_error($spider_tech_db));
$event_row = mysqli_fetch_assoc($event_query);

if (!$event_row) {
    header('location: all_events.php');
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
								<div class="page-title">Edit Event: <?= htmlspecialchars(stripslashes($event_row['event_title'])); ?></div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_events.php">Events</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Edit Event</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($event_error_counter)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= strip_tags($event_error_counter); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($event_success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= strip_tags($event_success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="edit_event_form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="event_id" value="<?= htmlspecialchars(stripslashes($event_row['event_id'])); ?>" />

						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">edit_calendar</i> Event Details & Agenda</h2>
										<span class="form-label-tag">ID #<?= htmlspecialchars($event_row['event_id']); ?></span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="event_title">
												<span>Event Title <span class="required-star">*</span></span>
											</label>
											<input type="text" id="event_title" name="event_title" 
												placeholder="Enter event title"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_title'])); ?>" 
												required />
											<?php if(!empty($event_titleErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_titleErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_content">
												<span>Brief Executive Excerpt</span>
											</label>
											<input type="text" id="event_content" name="event_content" 
												placeholder="Short summary..."
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_content'])); ?>" />
											<?php if(!empty($event_contentErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_contentErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Comprehensive Agenda & Registration Details <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="event_detail" required><?php 
												echo stripslashes($event_row['event_detail']);
											?></textarea>
											<?php if(!empty($event_detailErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_detailErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<!-- Logistics & Schedule -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">schedule</i> Schedule & Venue</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="event_status">
												<span>Event Status <span class="required-star">*</span></span>
											</label>
											<select id="event_status" class="form-control-modern" name="event_status" required>
												<?php $currentStatus = strtolower(trim($event_row['event_status'] ?? '')); ?>
												<option value="Upcoming" <?= $currentStatus === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
												<option value="Ongoing" <?= $currentStatus === 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
												<option value="Past" <?= $currentStatus === 'past' ? 'selected' : ''; ?>>Past / Completed</option>
											</select>
											<?php if(!empty($event_statusErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_statusErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_date">
												<span>Start Date <span class="required-star">*</span></span>
											</label>
											<input type="text" id="event_date" name="event_date" 
												placeholder="YYYY-MM-DD or Month DD, YYYY"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_date'])); ?>" 
												required />
											<?php if(!empty($event_dateErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_dateErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_date2">
												<span>End Date</span>
												<span class="form-help-modern">Optional</span>
											</label>
											<input type="text" id="event_date2" name="event_date2" 
												placeholder="Optional end date..."
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_date2'] ?? '')); ?>" />
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_time">
												<span>Event Time / Hours <span class="required-star">*</span></span>
											</label>
											<input type="text" id="event_time" name="event_time" 
												placeholder="E.g. 10:00 AM - 02:00 PM"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_time'])); ?>" 
												required />
											<?php if(!empty($event_timeErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_timeErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_address">
												<span>Location / Venue <span class="required-star">*</span></span>
											</label>
											<input type="text" id="event_address" name="event_address" 
												placeholder="Enter address"
												class="form-control-modern" 
												value="<?= htmlspecialchars(stripslashes($event_row['event_address'])); ?>" 
												required />
											<?php if(!empty($event_addressErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_addressErr); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Featured Poster Upload -->
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">image</i> Event Banner</h3>
										<span class="admin-dim-badge">900 × 590</span>
									</div>
									<div class="form-card-body">
										<!-- Current Image Display -->
										<?php 
										$picPath = $event_row['event_img'];
										if (!empty($picPath)):
											$displayPath = (file_exists($picPath) || file_exists('../' . $picPath)) ? $picPath : $picPath;
										?>
											<div class="admin-current-asset-card">
												<span class="asset-badge"><i class="material-icons" style="font-size: 14px;">check_circle</i> Current Live Banner</span>
												<img src="<?= htmlspecialchars($displayPath); ?>" alt="Current Event Banner" class="admin-current-asset-thumbnail" onerror="this.src='../images/logo/logo.png'">
											</div>
										<?php endif; ?>

										<!-- Replace Image Dropzone (Optional) -->
										<label class="form-label-modern" style="margin-top: 10px;">
											<span>Replace Banner</span>
											<span class="form-help-modern">Optional</span>
										</label>
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to choose new</span> or drag here</div>
												<div class="admin-dropzone-desc">Leave empty to keep existing banner</div>
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
										<?php if(!empty($event_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">save</i> Actions</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="edit_event" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Update Event
										</button>
										<a href="all_events.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to Events
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
