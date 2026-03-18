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
								<div class="page-title">Edit reservation</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="reservation_summary.php">Reservations</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Edit reservation</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Reservation Information</header>
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
                                if(isset($_SESSION['edit_reservation_id']))
                                {
                                    $sql_reservation = mysqli_query($en_klave_db, "SELECT * FROM reservation_tb 
                                    WHERE reservation_id = '".$_SESSION['edit_reservation_id']."'") or die(mysqli_error($en_klave_db));
                                    $record_reservation = mysqli_fetch_assoc($sql_reservation);
                                
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($reservation_edit_success_msg))
												{
												  echo $reservation_edit_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">Customer Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="reservation_id" value="<?php echo stripslashes($record_reservation['reservation_id']); ?>">
                                                    <input type="text" name="reservation_name" class="form-control input-height" 
                                                    value="<?php echo stripslashes($record_reservation['reservation_name']); ?>" required /> 
													<?php if(isset($_POST['edit_reservation'])) {echo $reservation_nameErr; }?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Customer Mobile
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="phone_number" class="form-control input-height" 
                                                    value="<?php echo stripslashes($record_reservation['phone_number']); ?>" required /> 
													<?php if(isset($_POST['edit_reservation'])) {echo $phone_numberErr; }?>
                                                </div>
                                            </div>
											<div class="form-group row">
												<label class="control-label col-md-3">Customer Email
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="email" name="email_address" class="form-control input-height" 
                                                    value="<?php echo stripslashes($record_reservation['email_address']); ?>" required /> 
													<?php if(isset($_POST['edit_reservation'])) {echo $email_addressErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Reservation type
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<select class="form-control input-height" name="reservation_type" required>
                                                        <option value="<?php echo stripslashes($record_reservation['reservation_type']); ?>" selected><?php echo stripslashes($record_reservation['reservation_type']); ?></option>
                                                        <option value="Residence">Residence</option>
														<option value="Pool">Pool</option>
														<option value="Dining">Dining</option>
                                                    </select> 
													<?php if(isset($_POST['edit_reservation'])) {echo $reservation_typeErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Arrival date
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon" class="input-group datePicker">
															<input class="formDatePicker form-control" name="arrival_date" type="text"
																placeholder="Select Date.." value="<?php echo stripslashes($record_reservation['arrival_date']); ?>" data-input>
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
                                                    <?php if(isset($_POST['edit_reservation'])) {echo $arrival_dateErr; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Departure Date
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<div class="input-append date">
														<div id="dateIcon2" class="input-group datePicker">
															<input class="formDatePicker form-control" name="departure_date" type="text"
																placeholder="Select Date.." value="<?php echo stripslashes($record_reservation['departure_date']); ?>" data-input>
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
                                                    <?php if(isset($_POST['edit_reservation'])) {echo $departure_dateErr; }?>
												</div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">No of Adults
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<select class="form-control input-height" name="no_of_adults" required>
                                                        <option value="<?php echo stripslashes($record_reservation['no_of_adults']); ?>" selected><?php echo stripslashes($record_reservation['no_of_adults']); ?></option>
                                                        <option value="0">0</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
                                                    </select> 
                                                    
                                                    <?php if(isset($_POST['edit_reservation'])) {echo $no_of_adultsErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">No of Children
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<select class="form-control input-height" name="no_of_children" required>
                                                        <option value="<?php echo stripslashes($record_reservation['no_of_children']); ?>" selected><?php echo stripslashes($record_reservation['no_of_children']); ?></option>
                                                        <option value="0">0</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
                                                    </select> 
                                                    <?php if(isset($_POST['edit_reservation'])) {echo $no_of_childrenErr; }?>
                                                </div>
                                            </div>
                                                                                        
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="edit_reservation">Submit</button>
														<button type="button" class="btn btn-default">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<?php }else{?>
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