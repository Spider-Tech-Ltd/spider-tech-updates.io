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
								<div class="page-title">Add Core Values</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="add_core_value.php">Core Values Statement</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Manage Core Values</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Details Here</header>
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
									<form action="#" id="form_sample_1" class="form-horizontal" method="POST">
										<div class="form-body">
											<div class="row">
                                                <?php if(!empty($cv_error_counter)) 
												         {
															 echo $cv_error_counter; 
														 }
													  if(!empty($cv_success_msg))
													  {
														  echo $cv_success_msg;
														  }
												?>
                                                <div class="col-md-12 col-sm-12">
                                                    <textarea name="cv_details" id="formsummernote" cols="30" rows="10" required>
                                                        <?php if(isset($_POST['add_core_value'])) {echo stripslashes($_POST['cv_details']); }?>
                                                    </textarea>
                                                    <?php if(isset($_POST['add_core_value'])) {echo $cv_detailsError; }?>
                                                </div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-12 col-md-12">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_core_value">Submit</button>
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