<?php 
require('superadmin_functions.php');
require('secured-login.php');

//query services
$about_query=mysqli_query($spider_tech_db, "SELECT * FROM about_info") or die(mysqli_error($spider_tech_db));
$about_row=mysqli_fetch_assoc($about_query);
if(isset($_GET['about_info']))
{
	$about_id = mysqli_real_escape_string($spider_tech_db, $_GET['about_info']);
	$_SESSION['about_info'] =  $about_id;
	header('location:edit_about_information.php');
	
	}

/*
if(isset($_GET['service_pictures']))
{
	$about_id = mysqli_real_escape_string($spider_tech_db, $_GET['service_pictures']);
	$_SESSION['service'] =  $about_id;
	header('location:more_pictures.php');
	
	}
*/

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
								<div class="page-title">All About Info</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">About Info</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">About Info List</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>About Info Table</header>
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
											<a href="add_about_information.php" id="addRow"
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
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Details</th>
													<th>Image</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$no = 1;
                                            do{
                                            $about_id=$about_row['id'];
                                            echo
                                                '<tr>
												   <td>'.$no++.'</td>
                                                   <td>'.stripslashes($about_row['title']).'</td>
													<td>'.substr(stripslashes(strip_tags($about_row['details'])), 0, 20).'..</td>
                                                    <td class="patient-img">
                                                        <img src="'.$about_row['image'].'"
                                                        alt="">
                                                    </td>
                                                    <td>
                                                        <a href="all_about_info.php?about_info='.$about_id.'"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }while($about_row = mysqli_fetch_assoc($about_query));
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