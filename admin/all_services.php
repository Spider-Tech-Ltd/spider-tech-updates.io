<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Handle delete action
if (isset($_GET['delete_service'])) {
    $service_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_service']);
    
    // Delete the service from the database
    $delete_query = "DELETE FROM services_tb WHERE id = '$service_id'";
    if (mysqli_query($spider_tech_db, $delete_query)) {
        // Successfully deleted
        header('Location: all_services.php?deleted=1');
        exit();
    } else {
        die('Error deleting service: ' . mysqli_error($spider_tech_db));
    }
}

// Query services
$service_query = mysqli_query($spider_tech_db, "SELECT * FROM services_tb") or die(mysqli_error($spider_tech_db));
$service_row = mysqli_fetch_assoc($service_query);

if (isset($_GET['service'])) {
    $service_id = mysqli_real_escape_string($spider_tech_db, $_GET['service']);
    $_SESSION['service'] = $service_id;
    header('location:edit_services.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head>
	<?php require('head-section.html'); ?>
</head>
<!-- END HEAD -->

<body class="<?php require('body-tag-css.html'); ?>">
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
								<div class="page-title">All Services</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="">Services</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Service List</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Services Table</header>
								</div>
								<div class="card-body" id="bar-parent">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="add_services.php" id="addRow" class="btn btn-info">Add New <i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-scrollable">				
                                            <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Service Icon</th>
                                                        <th>Service Name</th>
                                                        <th>Service Description</th>
                                                        <th>Service Details</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $no = 1;
                                                do {
                                                    $service_id = $service_row['id'];
                                                    echo
                                                        '<tr>
                                                           <td>' . $no++ . '</td>
                                                           <td class="patient-img"><i class="' . stripslashes($service_row['service_icon']) . '"></i></td>
                                                           <td>' . stripslashes($service_row['service_name']) . '</td>
                                                           <td>' . substr(stripslashes($service_row['service_description']), 0, 20) . '</td>
                                                           <td>' . substr(stripslashes(strip_tags($service_row['service_detail'])), 0, 20) . '..</td>
                                                           <td>
                                                               <a href="all_services.php?service=' . $service_id . '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                                               <a href="all_services.php?delete_service=' . $service_id . '" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this service?\');"><i class="fa fa-trash"></i> Delete</a>
                                                           </td>
                                                        </tr>';
                                                } while ($service_row = mysqli_fetch_assoc($service_query));
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
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<?php require('setting_and_chat_section.php'); ?>
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
