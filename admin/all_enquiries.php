<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Handle delete enquiry
if (isset($_GET['delete'])) {
    $msg_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);
    $delete_query = mysqli_query($spider_tech_db, "DELETE FROM messages_tb WHERE message_id='$msg_id' LIMIT 1");
    if ($delete_query) {
        header('Location: all_enquiries.php?success=' . urlencode('Enquiry deleted successfully.'));
        exit();
    } else {
        header('Location: all_enquiries.php?error=' . urlencode('Failed to delete enquiry.'));
        exit();
    }
}

// Query enquiries from messages_tb
$enquiries_query = mysqli_query($spider_tech_db, "SELECT * FROM messages_tb ORDER BY message_id DESC") or die(mysqli_error($spider_tech_db));
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
						<h1 class="page-title">Client Enquiries &amp; Messages</h1>
						<ol class="page-breadcrumb">
							<li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
							<li><a href="all_enquiries.php">Communications</a>&nbsp;<i class="fa fa-angle-right"></i></li>
							<li class="active">Enquiries</li>
						</ol>
					</div>

					<!-- Alerts -->
					<?php if ($success_message): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;">
							<i class="fa fa-check-circle m-r-10"></i> <?= htmlspecialchars($success_message); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php elseif ($error_message): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">
							<i class="fa fa-exclamation-circle m-r-10"></i> <?= htmlspecialchars($error_message); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>All Inbound Inquiries</header>
								</div>
								<div class="card-body">
									<div class="table-scrollable">
										<table id="exportTable" class="display nowrap table-hover" style="width:100%">
											<thead>
												<tr>
													<th style="width: 50px;">#</th>
													<th>Client Name</th>
													<th>Contact Info</th>
													<th>Subject</th>
													<th>Message Preview</th>
													<th class="text-right" style="width: 120px;">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($enquiries_query && mysqli_num_rows($enquiries_query) > 0): ?>
													<?php 
													$no = 1;
													while ($row = mysqli_fetch_assoc($enquiries_query)): 
														$mId = (int)$row['message_id'];
														$mName = stripslashes($row['name']);
														$mEmail = stripslashes($row['email']);
														$mPhone = stripslashes($row['phone_no'] ?? '');
														$mSubject = stripslashes($row['subject'] ?? 'General Consultation');
														$mMsg = stripslashes($row['message'] ?? '');
														$mMsgShort = mb_strimwidth($mMsg, 0, 55, '...');
													?>
														<tr>
															<td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $no++; ?></td>
															<td>
																<strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($mName); ?></strong>
															</td>
															<td>
																<div><a href="mailto:<?= htmlspecialchars($mEmail); ?>" style="color: var(--admin-primary);"><?= htmlspecialchars($mEmail); ?></a></div>
																<?php if (!empty($mPhone)): ?>
																	<small class="text-muted"><i class="fa fa-phone"></i> <?= htmlspecialchars($mPhone); ?></small>
																<?php endif; ?>
															</td>
															<td>
																<span class="table-pill table-pill-slate"><?= htmlspecialchars($mSubject); ?></span>
															</td>
															<td>
																<span title="<?= htmlspecialchars($mMsg); ?>" style="color: #475569; font-size: 0.85rem;">
																	<?= htmlspecialchars($mMsgShort); ?>
																</span>
															</td>
															<td class="text-right">
																<div class="table-action-group">
																	<a href="#" 
																	   data-delete-url="all_enquiries.php?delete=<?= $mId; ?>" 
																	   data-item-name="<?= htmlspecialchars($mName . ' (' . $mSubject . ')'); ?>" 
																	   class="btn-action-delete trigger-delete-modal" 
																	   title="Delete enquiry">
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
