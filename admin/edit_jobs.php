<?php 
require('superadmin_functions.php');
require('secured-login.php');
?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head>
	<?php require'head-section.html'; ?>
</head>
<!-- END HEAD -->

<body
	class="<?php require'body-tag-css.html'; ?>">
	<div class="page-wrapper">
		<!-- start header -->
		<?php require'header-section.php'; ?>
		<!-- end header -->
		<!-- start color quick setting -->
		<?php require'setting-section.html'; ?>
		<!-- end color quick setting -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php require'side-menu-section.html'; ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Edit Jobs</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_jobs"> Jobs</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Edit Jobs</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Basic Information</header>
									<!--
                                    <button id="panel-button"
										class="mdl-button mdl-js-button mdl-button--icon pull-right"
										data-upgraded=",MaterialButton">
										<i class="material-icons">more_vert</i>
									</button>
									<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
										data-mdl-for="panel-button">
										<li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">print</i>Another action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else
											here</li>
                                    </ul>
                                    -->
                                </div>
                                <?php 
                                if(isset($_SESSION['job_id']))
                                {
                                    $job_id = $_SESSION['job_id'];
                                    $job_query=mysqli_query($srcoe_db, "SELECT * FROM jobs WHERE job_id = '$job_id'") or die(mysqli_error($srcoe_db));
                                    $job_row=mysqli_fetch_assoc($job_query);
                                }
                                
                                ?>
                                
								<div class="card-body" id="bar-parent">
                                
									<form action="#" id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="form-group row">
												<label class="control-label col-md-3">
                                                <?php 
                                                    //success notification
                                                    if(!empty($job_success_msg)) 
                                                    {
                                                        echo $job_success_msg; 
                                                        
                                                    }
                                                ?>
												</label>
												<div class="col-md-5">
                                                
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Job Title
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="job_title" placeholder="Enter job title"
                                                        class="form-control input-height" value="<?php 
                                                        echo stripslashes($job_row['job_title']); ?>" required />
                                                     <?php if(isset($_POST['edit_job'])) {echo $job_titleErr; }?>
                                                </div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Number of Openings
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="number" name="job_no_of_openings" placeholder="Enter number of openings"
                                                        class="form-control input-height" value="<?php 
                                                        echo stripslashes($job_row['job_no_of_openings']); ?>" required />
                                                     <?php if(isset($_POST['edit_job'])) {echo $job_no_of_openingsErr; }?>
                                                </div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Opening Date
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon" class="input-group datePicker">
															<input class="formDatePicker form-control" name="job_opening_date" type="text"
																placeholder="Select Date.." value="<?php  
                                                                echo stripslashes($job_row['job_opening_date']); ?>" data-input>
															<span class="dateBtn">
																<a class="input-button" title="toggle" data-toggle>
																	<i class="icon-calendar"></i>
																</a>
																<a class="input-button" title="clear" data-clear>
																	<i class="icon-close"></i>
																</a>
															</span>
														</div>
                                                    </div>
                                                    <?php if(isset($_POST['edit_job'])) {echo $job_opening_dateErr; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Job Closing Date
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon1" class="input-group datePicker">
															<input class="formDatePicker form-control" name="job_closing_date" type="text"
																placeholder="Select Date.." value="<?php 
                                                                echo stripslashes($job_row['job_closing_date']); ?>" data-input>
															<span class="dateBtn">
																<a class="input-button" title="toggle" data-toggle>
																	<i class="icon-calendar"></i>
																</a>
																<a class="input-button" title="clear" data-clear>
																	<i class="icon-close"></i>
																</a>
															</span>
														</div>
                                                    </div>
                                                    <?php if(isset($_POST['edit_job'])) {echo $job_closing_dateErr; }?>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Brief Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea placeholder="Enter Job Description"
                                                        class="form-control-textarea" rows="2" maxlength ="322"  name="job_brief_desc" required><?php 
                                                        echo stripslashes($job_row['job_brief_desc']); ?></textarea>
                                                        <?php if(isset($_POST['edit_job'])) {echo $job_brief_descErr; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Job Description
													<span class="required">  </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Job Description"
                                                        class="form-control-textarea" rows="3" name="job_description" required><?php 
                                                        echo stripslashes($job_row['job_description']); ?></textarea>
                                                        <?php if(isset($_POST['edit_job'])) {echo $job_descriptionErr; }?>
												</div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="edit_job">Submit</button>
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