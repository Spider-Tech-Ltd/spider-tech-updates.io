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
								<div class="page-title">Edit About Information</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_about_info.php">About Information</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Manage About Information</li>
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
                                if(isset($_SESSION['about_info']))
                                {
                                $about_query = mysqli_query($spider_tech_db, "SELECT * FROM about_info
                                WHERE id = '".$_SESSION['about_info']."'") or die(mysqli_error($spider_tech_db));
                                $about_row = mysqli_fetch_assoc($about_query);
                                }
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST">
										<div class="form-body">
											<?php 
											    if(!empty($about_success_msg))
												{
												  echo $about_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">About Title
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="about_id" value="<?php echo stripslashes($about_row['id']); ?>">
                                                    <input type="text" name="about_name" placeholder="Enter About Title"
														class="form-control input-height" value="<?php echo stripslashes($about_row['title']); ?>" required /> 
                                                        <?php if(isset($_POST['edit_about'])) {echo $about_nameError; }?>
                                                </div> 
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Brief Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Description"
                                                        class="form-control-textarea" rows="3" name="about_details" required><?php 
                                                        echo stripslashes($about_row['details']);?></textarea>
                                                        <?php if(isset($_POST['edit_about'])) {echo $about_detailsError; }?>
												</div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Disable/Enable Picture
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <select class="form-control input-height" id="mfi_4_a_i" onChange="changetextbox();">
                                                    <option value="" selected>Select...</option>    
                                                    <option value="Disable" >Disable Picture Update</option>
                                                        <option value="Enable">Enable Picture Update</option>
                                                    </select>
												</div>
											</div>  
                                            <div class="form-group row">
												<label class="control-label col-md-3">About Picture <span class="required"> * </span> 
												</label>
												<div class="col-md-5">
													<input type="file" class="default" name="img" id="sdd" required>
													<div><span class="help-block text-green">900x590 dimention is be best picture</span></div>
												</div>
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="edit_about">Submit</button>
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