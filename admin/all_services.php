<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['deleted']) ? 'Service deleted successfully.' : (isset($_GET['success']) ? $_GET['success'] : '');

// Handle delete action
if (isset($_GET['delete_service'])) {
    $service_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_service']);
    
    // Delete the service from the database
    $delete_query = "DELETE FROM services_tb WHERE id = '$service_id' LIMIT 1";
    if (mysqli_query($spider_tech_db, $delete_query)) {
        header('Location: all_services.php?deleted=1');
        exit();
    } else {
        die('Error deleting service: ' . mysqli_error($spider_tech_db));
    }
}

// Query services
$service_query = mysqli_query($spider_tech_db, "SELECT * FROM services_tb ORDER BY id ASC") or die(mysqli_error($spider_tech_db));

if (isset($_GET['service'])) {
    $service_id = mysqli_real_escape_string($spider_tech_db, $_GET['service']);
    $_SESSION['service'] = $service_id;
    header('location:edit_services.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php require('head-section.html'); ?>
</head>

<body class="<?php require('body-tag-css.html'); ?>">
	<div class="page-wrapper">
		<!-- Header -->
		<?php require('header-section.php'); ?>

		<div class="page-container">
			<!-- Sidebar -->
			<?php require('side-menu-section.php'); ?>

			<!-- Page Content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					
					<div class="page-bar">
						<h1 class="page-title">Active Services</h1>
						<ol class="page-breadcrumb">
							<li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
							<li><a href="all_services.php">Services</a>&nbsp;<i class="fa fa-angle-right"></i></li>
							<li class="active">Service List</li>
						</ol>
					</div>

					<!-- Success Alerts -->
					<?php if (!empty($success_message)): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;">
							<i class="fa fa-check-circle m-r-10"></i> <?= htmlspecialchars($success_message); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>All Published Services</header>
									<div class="tools">
										<a href="add_services.php" class="btn btn-primary">
											<i class="fa fa-plus"></i> Add New Service
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-scrollable">				
										<table id="exportTable" class="display nowrap table-hover" style="width:100%">
											<thead>
												<tr>
													<th style="width: 50px;">#</th>
													<th style="width: 70px;">Icon</th>
													<th>Service Name</th>
													<th>Short Overview</th>
													<th>Content Breakdown</th>
													<th class="text-right" style="width: 210px;">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($service_query && mysqli_num_rows($service_query) > 0): ?>
													<?php 
													$no = 1;
													while ($row = mysqli_fetch_assoc($service_query)): 
														$sId = (int)$row['id'];
														$sName = stripslashes($row['service_name']);
														$sIcon = stripslashes($row['service_icon'] ?? 'flaticon-technical-support');
														$sDesc = stripslashes($row['service_description'] ?? '');
														$sDetail = strip_tags(stripslashes($row['service_detail'] ?? ''));
														$sDetailShort = mb_strimwidth($sDetail, 0, 50, '...');
													?>
														<tr>
															<td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $no++; ?></td>
															<td>
																<div class="table-img-fallback" style="color: var(--admin-primary); font-size: 1.25rem;">
																	<i class="<?= htmlspecialchars($sIcon); ?>"></i>
																</div>
															</td>
															<td>
																<strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($sName); ?></strong>
															</td>
															<td>
																<span style="color: #475569; font-size: 0.86rem;"><?= htmlspecialchars(mb_strimwidth($sDesc, 0, 45, '...')); ?></span>
															</td>
															<td>
																<span title="<?= htmlspecialchars($sDetail); ?>" style="color: #64748b; font-size: 0.84rem;">
																	<?= htmlspecialchars($sDetailShort ?: 'Detailed specification'); ?>
																</span>
															</td>
															<td class="text-right">
																<div class="table-action-group">
																	<a href="../services/detail?id=<?= $sId; ?>" target="_blank" class="btn-action-view" title="Preview on live site">
																		<i class="fa fa-external-link"></i> View
																	</a>
																	<a href="all_services.php?service=<?= $sId; ?>" class="btn-action-edit" title="Edit service">
																		<i class="fa fa-pencil"></i> Edit
																	</a>
																	<a href="#" 
																	   data-delete-url="all_services.php?delete_service=<?= $sId; ?>" 
																	   data-item-name="<?= htmlspecialchars($sName); ?>" 
																	   class="btn-action-delete trigger-delete-modal" 
																	   title="Delete service">
																		<i class="fa fa-trash"></i> Delete
																	</a>
																</div>
															</td>
														</tr>
													<?php endwhile; ?>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- End Page Content -->
		</div>

		<!-- Footer -->
		<?php require('footer-section.html'); ?>
	</div>

	<!-- JS includes -->
    <?php require('js-section.html'); ?>
</body>
</html>
