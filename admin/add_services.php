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
								<div class="page-title">Add Services</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_services.php">Services</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add Services</li>
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
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($service_error_counter)) 
												   {
													 echo $service_error_counter; 
												   }
												if(!empty($service_success_msg))
												   {
													  echo $service_success_msg;
												   }
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Service Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="service_name" placeholder="Enter service name"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_service'])) 
                                                        {echo stripslashes($service_name); }?>" required /> 
                                                        <?php if(isset($_POST['add_service'])) {echo $service_nameErr; }?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Service Icon
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="service_icon" placeholder="Enter service icon"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_service'])) 
                                                        {echo stripslashes($service_icon); }?>" required /> 
                                                        <?php if(isset($_POST['add_service'])) {echo $service_iconErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Brief Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="text" name="service_description" placeholder="Enter service description"
                                                        class="form-control input-height" value="<?php if(isset($_POST['add_service'])) 
                                                        {echo stripslashes($service_description); }?>" required /> 
                                                        <?php if(isset($_POST['add_service'])) {echo $service_descriptionErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Service Details
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Content"
                                                        class="form-control-textarea" rows="3" name="service_details" required><?php if(isset($_POST['add_service'])) 
                                                        {echo stripslashes($_POST['service_details']); }?></textarea>
                                                        <?php if(isset($_POST['add_service'])) {echo $service_detailsErr; }?>
												</div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_service">Submit</button>
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