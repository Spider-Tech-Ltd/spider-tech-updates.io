<?php 
require('superadmin_functions.php');
require('secured-login.php');
//query schools
$sql_total_sales = mysqli_query($en_klave_db, "SELECT s.reservation_id, reservation_name, reservation_type, arrival_date, departure_date, total_amount, total_amount_paid,
outstanding_balance, payment_date, no_of_adults, no_of_children FROM sales_tb s, reservation_tb r WHERE s.reservation_id = r.reservation_id 
AND reservation_status = 'Confirmed' AND r.reservation_id = '".$_SESSION['receipt_id']."' ORDER BY arrival_date DESC ") or die(mysqli_error($en_klave_db));
$record_total_sales = mysqli_fetch_assoc($sql_total_sales);

$contact_query = mysqli_query($en_klave_db, "SELECT * FROM contact_details ") or die(mysqli_error($en_klave_db));
$contact_row = mysqli_fetch_assoc($contact_query);

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
		<?php require'header-section.php'; ?>
		<!-- end header -->
		<!-- start color quick setting -->
		<?php require'setting-section.html'; ?>
		<!-- end color quick setting -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php require'side-menu-section.php'; ?>
			<!-- end sidebar menu -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Reservation Invoice</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								<li><a class="parent-item" href="confirmed_reservations.php">Confirmed Reservations</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Receipt</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="white-box">
								<h3><b>PAYMENT RECEIPT</b> <span class="pull-right"></span></h3>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="pull-left">
											<address>
												<img src="../images/icon/lr-home.png" alt="logo"
													class="logo-default" />
												<p class="text-muted m-l-5">
                                                   Address: <br/> <?php echo stripslashes($contact_row['contact_address']); ?>
												</p>
											</address>
										</div>
										<div class="pull-right text-right">
											<address>
												<p class="addr-font-h3">To,</p>
												<p class="font-bold addr-font-h4"><?php echo stripslashes($record_total_sales['reservation_name']); ?></p>
												<!--
                                                <p class="text-muted m-l-30">
													207, Prem Sagar Appt., <br> Near Income Tax Office, <br>
													Ashram Road, <br> Ahmedabad - 380057
												</p>-->
												<p class="m-t-30">
													<b> Date :</b> <i class="fa fa-calendar"></i> <?php echo date('d M, Y', strtotime($record_total_sales['payment_date'])); ?>
												</p>
												<p>
													<b>Reservation Type :</b> <?php echo stripslashes($record_total_sales['reservation_type']); ?>
												</p>
											</address>
										</div>
									</div>
									<div class="col-md-12">
										<div class="table-responsive m-t-40">
											<table class="table table-hover">
												<thead>
													<tr>
														<th class="text-center">#</th>
                                                        <th class="text-right">Service Paid for</th>
														<th class="text-right">Arrival Date</th>
														<th class="text-right">Departure Date</th>
														<th class="text-right">No of Adults</th>
														<th class="text-right">No of Children</th>
														
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-center">1</td>
														<td class="text-right"><?php echo stripslashes($record_total_sales['reservation_type']); ?></td>
														<td class="text-right"><?php echo stripslashes($record_total_sales['arrival_date']); ?></td>
														<td class="text-right"><?php echo stripslashes($record_total_sales['departure_date']); ?></td>
														<td class="text-right"><?php echo stripslashes($record_total_sales['no_of_adults']); ?></td>
														<td class="text-right"><?php echo stripslashes($record_total_sales['no_of_children']); ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-12">
										<div class="pull-right m-t-30 text-right">
											<p>Total amount paid: <?php echo stripslashes($record_total_sales['total_amount_paid']); ?></p>
											<p>Outstanding Balance : <?php echo stripslashes($record_total_sales['outstanding_balance']); ?> </p>
											<hr>
											<h3><b>Total :</b> <?php echo stripslashes($record_total_sales['total_amount']); ?></h3>
										</div>
										<div class="clearfix"></div>
										<hr>
										<div class="text-right">
											<!--<button class="btn btn-danger" type="submit"> Proceed to payment </button>-->
											<button onclick="javascript:window.print();"
												class="btn btn-default btn-outline" type="button"> <span><i
														class="fa fa-print"></i> Print</span> </button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<?php require'setting_and_chat_section.php';?>
			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php require'footer-section.html'; ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
    <?php require'js-section.html'; ?>
	<!-- end js include path -->
</body>

</html>