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
								<div class="page-title">Confirm Reservation</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="reservation_summary.php">Reservations</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Confirm Reservation</li>
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
                                if(isset($_SESSION['confirm_reservation_id']))
                                {
                                    $sql_reservation = mysqli_query($en_klave_db, "SELECT * FROM reservation_tb 
                                    WHERE reservation_id = '".$_SESSION['confirm_reservation_id']."'") or die(mysqli_error($en_klave_db));
                                    $record_reservation = mysqli_fetch_assoc($sql_reservation);
                                
                                ?>
								<div class="card-body" id="bar-parent">
									<form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
										<div class="form-body">
											<?php 
											    if(!empty($confirm_reservation_success_msg))
												{
												  echo $confirm_reservation_success_msg;
                                                  }      
											?>
											<div class="form-group row">
												<label class="control-label col-md-3">
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                    <input type="hidden" name="reservation_id" value="<?php echo stripslashes($record_reservation['reservation_id']); ?>">
                                                    <div><?php echo stripslashes($record_reservation['reservation_name']); ?> </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                    <div><?php echo stripslashes($record_reservation['reservation_type']); ?> </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">
													<span class="required"> </span>
												</label>
												<div class="col-md-5">
                                                    <div><?php echo "From ". stripslashes($record_reservation['arrival_date'])." to ".stripslashes($record_reservation['departure_date']); ?></div> 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="control-label col-md-3">Reservation Amount
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="total_amount" class="form-control input-height" 
                                                    value="<?php if(isset($_POST['confirm_reservation'])) {echo stripslashes($_POST['total_amount']); } ?>" required /> 
                                                    <?php if(isset($_POST['confirm_reservation'])) {echo $total_amountErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Amount Paid
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <input type="text" name="amount_paid" class="form-control input-height" 
                                                    value="<?php if(isset($_POST['confirm_reservation'])) {echo stripslashes($_POST['amount_paid']); } ?>" required /> 
                                                    <?php if(isset($_POST['confirm_reservation'])) {echo $amount_paidErr; }?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
												<label class="control-label col-md-3">Reservation Status
													<span class="required"> * </span>
												</label>
												<div class="col-md-5">
                                                    <select class="form-control input-height" name="reservation_status" required>
                                                        <option value="" selected>Select status...</option>
                                                        <option value="Confirmed">Confirmed</option>
														<option value="Cancelled">Cancelled</option>
                                                    </select> 
                                                    <?php if(isset($_POST['confirm_reservation'])) {echo $reservation_statusErr; }?>
                                                </div>
											</div>                                            
											<div class="form-actions">
												<div class="row">
													<div class="offset-md-3 col-md-9">
														<button type="submit"
															class="btn btn-info m-r-20" name="confirm_reservation">Submit</button>
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