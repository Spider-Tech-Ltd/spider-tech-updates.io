<?php 
require('superadmin_functions.php');
require('secured-login.php');

//query subsidiarys
$subsidiary_query=mysqli_query($n_quad_db, "SELECT * FROM subsidiary_tb") or die(mysqli_error($n_quad_db));
$subsidiary_row=mysqli_fetch_assoc($subsidiary_query);
if(isset($_GET['subsidiary']))
{
	$subsidiary_id = mysqli_real_escape_string($n_quad_db, $_GET['subsidiary']);
	$_SESSION['subsidiary'] =  $subsidiary_id;
	header('location:edit_subsidiary.php');
	
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
								<div class="page-title">All subsidiary</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">subsidiary</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">subsidiary List</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>subsidiary Table</header>
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
											<a href="add_subsidiary.php" id="addRow"
												class="btn btn-info">
												Add New <i class="fa fa-plus"></i>
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
                                                    <th>subsidiary Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            do{
                                            $subsidiary_id=$subsidiary_row['subsidiary_id'];
                                            echo
                                                '<tr>
                                                    <td class="patient-img">
                                                        <img src="'.$subsidiary_row['subsidiary_picture'].'"
                                                        alt="">
                                                    </td>
                                                    <td>'.$subsidiary_row['subsidiary_name'].'</td>
                                                    <td>
                                                        
                                                        <a href="all_subsidiary.php?subsidiary='.$subsidiary_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }while($subsidiary_row = mysqli_fetch_assoc($subsidiary_query));
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