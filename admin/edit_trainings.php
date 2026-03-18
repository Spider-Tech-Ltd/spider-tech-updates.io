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
		<!-- <?php //require('header-section.php'); ?> -->
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
								<div class="page-title">Edit Training</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_trainings.php">Trainings</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Edit Training</li>
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
                                if(isset($_SESSION['training']))
                                {
                                $training_query = mysqli_query($spider_tech_db, "SELECT * FROM trainings_tb 
                                WHERE id = '".$_SESSION['training']."'") or die(mysqli_error($spider_tech_db));
                                $training_row = mysqli_fetch_assoc($training_query);
                                }
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($training_success_msg))
												{
												  echo $training_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Training Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="training_id" value="<?php echo stripslashes($training_row['id']); ?>">
                                                    <input type="text" name="training_name" placeholder="Enter Training Name"
														class="form-control input-height" value="<?php echo stripslashes($training_row['training_name']); ?>" required /> 
                                                        <?php if(isset($_POST['edit_training'])) {echo $training_nameErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Training Icon
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="training_icon" placeholder="Enter Training Icon"
														class="form-control input-height" value="<?php echo stripslashes($training_row['training_icon']); ?>" required /> 
                                                        <?php if(isset($_POST['edit_training'])) {echo $training_iconErr; }?>
                                                </div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Breif Description <span class="required"> * </span> 
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="training_description" placeholder="Enter Description"
														class="form-control input-height" value="<?php echo stripslashes($training_row['training_description']); ?>" required /> 
                                                    <?php if(isset($_POST['edit_training'])) {echo '<div>'.$training_descriptionErr.'</div>'; }?>
												</div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Training Details
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Details"
                                                        class="form-control-textarea" rows="3" name="training_details" required><?php 
                                                        echo stripslashes($training_row['training_details']);?></textarea>
                                                        <?php if(isset($_POST['edit_training'])) {echo $training_detailsErr; }?>
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
												<label class="control-label col-md-3">Training Picture <span class="required"> * </span> 
												</label>
												<div class="col-md-5">
													<input type="file" class="default" name="img" id="sdd" required>
													<div><span class="help-block text-green">900x590 dimention is be best picture</span></div>
                                                    <?php if(isset($_POST['edit_training'])) {echo '<div>'.$training_imgErr.'</div>'; }?>
												</div>
											</div>
											<!-- Display the current project image -->
											<div class="form-group row">
                                                <label class="control-label col-md-3">Current Project Picture:</label>
                                                <div class="col-md-5">
                                                    <?php if (!empty($training_row['training_image'])): ?>
                                                        <img src="<?php echo  stripslashes($training_row['training_image']); ?>" alt="Current Training Picture" class="img-fluid" style="max-width: 100%; height: auto;"/>
                                                    <?php else: ?>
                                                        <p>No image available.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="edit_training">Submit</button>
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