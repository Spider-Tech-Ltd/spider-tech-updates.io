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
								<div class="page-title">Enquiry</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="enquiries.php">Enquiries</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Enquiry</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Enquirer Information</header>
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
                                if(isset($_SESSION['view_enquiry_id']))
                                {
                                    $sql_enquiry = mysqli_query($en_klave_db, "SELECT * FROM enquiry_tb 
                                    WHERE enquiry_id = '".$_SESSION['view_enquiry_id']."'") or die(mysqli_error($en_klave_db));
                                    $record_enquiry = mysqli_fetch_assoc($sql_enquiry);
                                
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <div class="form-body">
											<?php 
											    if(!empty($enquiry_status_success_msg))
												{
												  echo $enquiry_status_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Name
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo stripslashes($record_enquiry['enquiry_id']); ?>">
                                                    <div><?php echo stripslashes($record_enquiry['enquirer_name']); ?> </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">
                                                    <span class="required"> </span>Phone Number
                                                </label>
                                                <div class="col-md-5">
                                                    <div><a href="tel:<?php echo $record_enquiry['enquirer_pno']; ?>"><?php echo $record_enquiry['enquirer_pno']; ?></a></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Email
                                                    <span class="required"> </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <div><a href="mailto:<?php echo $record_enquiry['enquirer_email']; ?>"><?php echo $record_enquiry['enquirer_email']; ?></a></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">
													<span class="required"> </span>Subject
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo stripslashes($record_enquiry['enquiry_id']); ?>">
                                                    <div><?php echo stripslashes($record_enquiry['enquiry_subject']); ?> </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Message
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo stripslashes($record_enquiry['enquiry_id']); ?>">
                                                    <div><?php echo stripslashes($record_enquiry['enquiry_message']); ?> </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
												<label class="control-label col-md-3">Date
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                <div><?php echo stripslashes($record_enquiry['enquiry_date']); ?> </div> 
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group row">
												<label class="control-label col-md-3">Enquiry Status
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <select class="form-control input-height" name="enquiry_status" required>
                                                        <option value="" selected>Select status...</option>
                                                        <option value="Treated">Treated</option>
														<option value="UnTreated">UnTreated</option>
                                                    </select> 
                                                    <?php if(isset($_POST['enquiry'])) {echo $enquiry_statusErr; }?>
                                                </div>
											</div>                                            
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="enquiry">Submit</button>
														<button type="button" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
                                <?php } else{ ?>
                                    <div class="card-body" id="bar-parent">
                                        <h3>Nothing has been selected</h3>
                                    </div>
                                <?php } ?>
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