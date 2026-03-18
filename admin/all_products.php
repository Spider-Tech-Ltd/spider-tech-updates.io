<?php 
require('superadmin_functions.php');
require('secured-login.php');

//query productss
$products_query=mysqli_query($en_klave_db, "SELECT * FROM products p, services_tb s 
WHERE s.service_id = p.service_id") or die(mysqli_error($en_klave_db));
$products_row=mysqli_fetch_assoc($products_query);
if(isset($_GET['products']))
{
	$products_id = mysqli_real_escape_string($en_klave_db, $_GET['products']);
	$_SESSION['products'] =  $products_id;
	header('location:edit_products.php');
	
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
								<div class="page-title">All Service products</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">products</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Service products List</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Products Table</header>
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
                                <div class="row">
									<div class="col-md-6 col-sm-6 col-6">
										<div class="btn-group">
											<a href="all_services.php" id="addRow"
												class="btn btn-info">
												Back to Services List <i class="fa fa-arrow-left"></i>
											</a>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-6">
										<div class="btn-group">
											<a href="add_products.php" id="addRow"
												class="btn btn-info">
												Add New Service Product <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
								</div>
                                <div class="card-body">
                                    <div class="table-scrollable">				
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%" >
                                            <thead>
                                                <tr>
                                                    <th>Picture</th>
                                                    <th>products Name</th>
													<th>Service Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            do{
                                            $products_id=$products_row['product_id'];
                                            echo
                                                '<tr>
                                                    <td class="patient-img">
                                                        <img src="'.$products_row['product_picture'].'"
                                                        alt="">
                                                    </td>
                                                    <td>'.$products_row['product_name'].'</td>
													<td>'.$products_row['service_name'].'</td>
                                                    <td>
                                                        
                                                        <a href="all_products.php?products='.$products_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }while($products_row = mysqli_fetch_assoc($products_query));
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