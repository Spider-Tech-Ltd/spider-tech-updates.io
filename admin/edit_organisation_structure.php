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
								<div class="page-title">Edit Organisational Structure</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="edit_organisation_structure.php">Organisational Structure</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Manage Organisational Structure</li>
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
                                <?php 
								//check if record already exist
								$retrieve_org_str = mysqli_query($en_klave_db, "SELECT * FROM about_organisational_structure ") or die (mysqli_error($en_klave_db));
								$record = mysqli_fetch_assoc($retrieve_org_str);
								?>
								<div class="card-body" id="bar-parent">
									<form action="#" id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<div class="row">
                                                <?php 
												     if(!empty($os_success_msg))
													  {
														  echo $os_success_msg;
														  }
												?>
                                                <div class="col-lg-12 p-t-20">
                                                <label class=" col-md-4">Upload Photo</label>
                                                    <div class="col-md-12">
                                                        
                                                        <input type="file" id="dropzone" class="dropzone" name="img">
                                                        <input type="hidden" name="old_img" value="<?php echo $record['organisational_structure']; ?>">
                                                        <?php if(isset($_POST['edit_organisation_structure'])) {echo '<div>'.$os_imgError.'</div>'; }?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 p-t-20">
                                                    <div class=" col-md-12">
                                                        <button type="submit"
                                                                class="btn btn-info m-r-20" name="edit_organisation_structure">Submit Changes</button>
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