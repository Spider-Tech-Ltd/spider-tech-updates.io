<?php 
require('superadmin_functions.php');
require('secured-login.php');
//query schools
$sql_total_sales = mysqli_query($en_klave_db, "SELECT s.reservation_id, reservation_name, reservation_type, arrival_date, departure_date, total_amount, total_amount_paid,
outstanding_balance, payment_date FROM sales_tb s, reservation_tb r WHERE s.reservation_id = r.reservation_id 
AND reservation_status = 'Confirmed' ORDER BY arrival_date DESC ") or die(mysqli_error($en_klave_db));
$record_total_sales = mysqli_fetch_assoc($sql_total_sales);

//create session and store calendar id for academic calendar edit function
if(isset($_GET['view_receipt']))
{
	$reservation_id = mysqli_real_escape_string($en_klave_db, $_GET['view_receipt']);
	$_SESSION['receipt_id'] =  $reservation_id;
	header('location:payment_receipt.php');
	}

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
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Confirmed Reservations</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Reservations</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Confirmed Reservations</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header></header>
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
								<div class="card-body " id="bar-parent">
                                
                                <div class="card-body">	
                                    <div class="table-scrollable">			
									<table id="exportTable" class="display nowrap table-hover" style="width:100%" >
                                            <thead>
                                                <tr>
                                                     <th>Name</th>
                                                    <th>Reservation Type</th>
                                                    <th>Arrival Date Date</th>
                                                    <th>Amount Paid</th>
                                                    <th>Outstanding</th>
													<th>Actual Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            do{
                                            $reservation_id = $record_total_sales['reservation_id'];
                                            echo
                                                '<tr>
                                                    <td>'.$record_total_sales['reservation_name'].'</td>
													<td>'.$record_total_sales['reservation_type'].'</td>
													<td>'.$record_total_sales['arrival_date'].'</td>
													<td>'.$record_total_sales['total_amount_paid'].'</td>
                                                    <td>'.$record_total_sales['outstanding_balance'].'</td>
                                                    <td>'.$record_total_sales['total_amount'].'</td>
                                                    <td>
                                                        
                                                        <a href="confirmed_reservations.php?view_receipt='.$reservation_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-print"></i>Receipt
                                                        </a>
														<a href="confirmed_reservations.php?view_details='.$reservation_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-eye"></i>Details
                                                        </a>
														<a href="reservation_summary.php?confirm_reservation='.$reservation_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }while($record_total_sales = mysqli_fetch_assoc($sql_total_sales));
                                            ?>
                                            </tbody>
                                        </table>
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