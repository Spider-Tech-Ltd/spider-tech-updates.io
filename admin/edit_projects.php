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
								<div class="page-title">Edit project</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_projects.php">project</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Edit project</li>
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
                                if(isset($_SESSION['project']))
                                {
                                $project_query=mysqli_query($spider_tech_db, "SELECT * FROM projects_tb p, services_tb s
                                WHERE s.id = p.service_id AND project_id = '".$_SESSION['project']."'") or die(mysqli_error($spider_tech_db));
                                $project_row=mysqli_fetch_assoc($project_query);
                                }
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($project_success_msg))
												{
												  echo $project_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Project Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="project_id" value="<?php echo stripslashes($project_row['project_id']); ?>">
                                                    <input type="hidden" name="project_pic" value="<?php echo stripslashes($project_row['project_pic']); ?>">
													<input type="text" name="project_name" placeholder="Enter project name"
														class="form-control input-height" value="<?php echo stripslashes($project_row['project_name']); ?>" required /> 
                                                        <?php if(isset($_POST['edit_project'])) {echo $project_nameErr; }?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Project Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Description"
                                                        class="form-control-textarea" rows="3" name="project_description" required><?php 
                                                        echo stripslashes($project_row['project_description']);?></textarea>
                                                        <?php if(isset($_POST['edit_project'])) {echo $project_descriptionErr; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Subsidiary Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <select class="form-control input-height" name="service_name" required>
                                                        <?php
                                                       //query services
														$service_query = mysqli_query($spider_tech_db, "SELECT * FROM services_tb") or die(mysqli_error($spider_tech_db));
														$service_row = mysqli_fetch_assoc($service_query);
                                                        
                                                        echo
                                                        '<option value="'.$project_row['id'].'" selected>'.$project_row['service_name'].'</option>';
														do{
                                                        echo
														'<option value="'.$service_row['id'].'">'.$service_row['service_name'].'</option>';
														}while($service_row=mysqli_fetch_assoc($service_query));
                                                        ?>
                                                    </select> 
                                                        <?php if(isset($_POST['edit_project'])) {echo $service_nameErr; }?>
                                                </div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Year Awarded<span class="required"> * </span> 
												</label>
												<div class="col-md-5">
													<input type="text" class="default" name="project_year" value="<?php 
                                                        echo stripslashes($project_row['project_year']);?>" required>
                                                    <?php if(isset($_POST['edit_project'])) {echo '<div>'.$project_yearErr.'</div>'; }?>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Project Picture <span class="required"> * </span> 
												</label>
												<div class="col-md-5">
													<input type="file" class="default" name="img" required>
                                                    <?php if(isset($_POST['edit_project'])) {echo '<div>'.$project_imgErr.'</div>'; }?>
												</div>
											</div>
											 <!-- Display the current project image -->
											 <div class="form-group row">
                                                <label class="control-label col-md-3">Current Project Picture:</label>
                                                <div class="col-md-5">
                                                    <?php if (!empty($project_row['project_pic'])): ?>
                                                        <img src="<?php echo  stripslashes($project_row['project_pic']); ?>" alt="Current Project Picture" class="img-fluid" style="max-width: 100%; height: auto;"/>
                                                    <?php else: ?>
                                                        <p>No image available.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="edit_project">Submit</button>
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