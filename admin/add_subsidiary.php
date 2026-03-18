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
								<div class="page-title">Add Subsidiary</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="all_subsidiary.php">Subsidiary</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add Subsidiary</li>
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
											    if(!empty($subsidiary_error_counter)) 
												   {
													 echo $subsidiary_error_counter; 
												   }
												if(!empty($subsidiary_success_msg))
												   {
													  echo $subsidiary_success_msg;
												   }
											?>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Subsidiary Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<select class="form-control input-height" name="subsidiary_name" required>
                                                        <?php
                                                        if(isset($_POST['add_subsidiary']) && !empty($subsidiary_name))
                                                        {
                                                        echo
                                                        '<option value="'.$subsidiary_name.'" selected>'.$subsidiary_name.'</option>
                                                        <option value="N-Quard Farm">N-Quard Farm</option>
                                                        <option value="N-Quard Food & Beverage">N-Quard Food & Beverage</option>
                                                        <option value="N-Quard Construction & Real Estate">N-Quard Construction & Real Estate</option>';
                                                        }
                                                        else
                                                        {
                                                        echo
                                                        '<option value="" selected>Select</option>
                                                        <option value="N-Quard Farm">N-Quard Farm</option>
                                                        <option value="N-Quard Food & Beverage">N-Quard Food & Beverage</option>
                                                        <option value="N-Quard Construction & Real Estate">N-Quard Construction & Real Estate</option>';   
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if(isset($_POST['add_subsidiary'])) {echo $subsidiary_nameErr; }?>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3">Profile Picture <span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<input type="file" class="default" name="img" required>
                                                    <div><span class="help-block text-green">500x500 dimention is be best picture</span></div>
                                                    <?php if(isset($_POST['add_subsidiary'])) {echo '<div>'.$subsidiary_imgErr.'</div>'; }?>
												</div>
											</div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Brief Description
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea id="formsummernote" placeholder="Enter Content"
                                                        class="form-control-textarea" rows="3" name="subsidiary_description" required><?php if(isset($_POST['add_subsidiary'])) 
                                                        {echo stripslashes($_POST['subsidiary_description']); }?></textarea>
                                                        <?php if(isset($_POST['add_subsidiary'])) {echo $subsidiary_descriptionErr; }?>
												</div>
                                            </div>
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="add_subsidiary">Submit</button>
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