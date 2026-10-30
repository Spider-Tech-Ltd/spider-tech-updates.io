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
								<div class="page-title">Add New Event</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="all_events.php">Events</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Add Event</li>
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

					<form id="event_form" method="POST" enctype="multipart/form-data">
						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">event</i> Event Agenda & Specifications</h2>
										<span class="form-label-tag">Event Details</span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="event_title">
												<span>Event Title <span class="required-star">*</span></span>
												<span class="form-help-modern">Headline name of the event or conference</span>
											</label>
											<input type="text" id="event_title" name="event_title" 
												placeholder="E.g. AI & Cloud Architecture Summit 2026"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_title)); } ?>" 
												required />
											<?php if(!empty($event_titleErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_titleErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_content">
												<span>Brief Executive Excerpt</span>
												<span class="form-help-modern">Short description for cards and teasers</span>
											</label>
											<input type="text" id="event_content" name="event_content" 
												placeholder="Short 1-2 sentence overview of the event..."
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_content)); } ?>" />
											<?php if(!empty($event_contentErr)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_contentErr); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="formsummernote">
												<span>Detailed Agenda, Speakers & Registration Details <span class="required-star">*</span></span>
												<span class="form-help-modern">Full rich-text formatting supported</span>
											</label>
											<textarea id="formsummernote" name="event_detail" required><?php 
												if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($_POST['event_detail'])); }
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
										<h3 class="form-card-title"><i class="material-icons">schedule</i> Schedule & Logistics</h3>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="event_status">
												<span>Event Status <span class="required-star">*</span></span>
											</label>
											<select id="event_status" class="form-control-modern" name="event_status" required>
												<?php $s = isset($_POST['add_event']) ? strtolower(trim($event_status ?? '')) : 'upcoming'; ?>
												<option value="Upcoming" <?= $s === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
												<option value="Ongoing" <?= $s === 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
												<option value="Past" <?= $s === 'past' ? 'selected' : ''; ?>>Past / Completed</option>
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
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_date)); } ?>" 
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
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_date2)); } ?>" />
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="event_time">
												<span>Event Time / Hours <span class="required-star">*</span></span>
											</label>
											<input type="text" id="event_time" name="event_time" 
												placeholder="E.g. 09:00 AM - 04:00 PM WAT"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_time)); } ?>" 
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
												placeholder="E.g. Spider Tech Innovation Lab or Virtual Zoom"
												class="form-control-modern" 
												value="<?php if(isset($_POST['add_event'])) { echo htmlspecialchars(stripslashes($event_address)); } ?>" 
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
										<div class="admin-dropzone-wrap">
											<div class="admin-dropzone">
												<div class="admin-dropzone-icon">
													<i class="material-icons">cloud_upload</i>
												</div>
												<div class="admin-dropzone-title"><span>Click to browse</span> or drag banner</div>
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
										<?php if(!empty($event_imgErr)): ?>
											<div class="form-error-modern"><i class="material-icons">warning</i> <?= strip_tags($event_imgErr); ?></div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">publish</i> Publication</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="add_event" class="btn-admin-primary">
											<i class="material-icons">check_circle</i> Save & Publish Event
										</button>
										<a href="all_events.php" class="btn-admin-cancel">
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
