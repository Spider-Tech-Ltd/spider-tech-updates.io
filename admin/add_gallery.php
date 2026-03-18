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

<body
	class="<?php require('body-tag-css.html'); ?>">
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
							<div class=" pull-left">
								<div class="page-title">Manage Gallery</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_gallery.php">Gallery</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add Gallery</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Add Event Media</header>
									<?php 
                                    // Check if event_id is set in the URL
                                    if(isset($_GET['event'])) {
                                        // Sanitize event_id to prevent SQL injection
                                        $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['event']);

                                        // Join events_media and events tables to fetch event_title
                                        $event_media_query = mysqli_query($spider_tech_db, "
											SELECT e.event_id, e.event_title 
											FROM events e 
											WHERE e.event_id = '" . $event_id . "'
										") or die(mysqli_error($spider_tech_db));

                                        $event_media_row = mysqli_fetch_assoc($event_media_query);

                                        // Check if the query returned any result
                                        if (!$event_media_row) {
                                            echo '<div class="alert alert-warning">No event media found for the given event ID.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger">No event ID provided.</div>';
                                    }
                                    ?>
								</div>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($event_media_error_counter)) {
												    echo $event_media_error_counter; 
												}
												if(!empty($media_success_msg)) {
												    echo $media_success_msg;
												}
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Gallery Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
												    <!-- Only display if $event_media_row is set -->
                                                    <?php if (isset($event_media_row)): ?>
                                                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                                                    <input type="text" name="event_media_name" placeholder="Enter event media Name"
                                                        class="form-control input-height" value="<?php echo stripslashes($event_media_row['event_title']); ?>" readonly />
                                                    <?php endif; ?>
                                                </div>
                                            </div>
											
											<div class="form-group row">
												<label class="control-label col-md-3">Gallery Picture <span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="file" class="default" name="img" required>
                                                    <div><span class="help-block text-green">900x590 dimention is be best picture</span></div>
                                                    <?php if(isset($_POST['add_event_media'])) {echo '<div>'.$mediaErr.'</div>'; }?>
												</div>
											</div>
											
                                            
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_event_media">Submit</button>
														<button type="button" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<?php require'setting_and_chat_section.php';?>
			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php require'footer-section.html'; ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
	<?php require'js-section.html'; ?>
	<!-- end js include path -->
</body>

</html>