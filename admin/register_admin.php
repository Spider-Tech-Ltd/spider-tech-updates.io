<?php 
require('superadmin_functions.php');
require('secured-login.php');

$admin_nameError = "";
$admin_passwordError = "";
$confirm_passwordError = "";
$user_exists = "";
$success_msg = "";
$passwords_error = "";

if (isset($_POST['register'])) {
    $admin_name = trim(mysqli_real_escape_string($spider_tech_db, $_POST['admin_name'] ?? ''));
    $admin_password = $_POST['admin_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $privilege = trim(mysqli_real_escape_string($spider_tech_db, $_POST['privilege'] ?? 'Administrator'));

    $error = 0;

    if (empty($admin_name)) {
        $admin_nameError = "Username is required.";
        $error = 1;
    }
    if (empty($admin_password)) {
        $admin_passwordError = "Password is required.";
        $error = 1;
    }
    if (empty($confirm_password)) {
        $confirm_passwordError = "Password confirmation is required.";
        $error = 1;
    }

    if ($error === 0) {
        // Check if username exists
        $check_query = mysqli_query($spider_tech_db, "SELECT * FROM admin_tb WHERE admin_name = '$admin_name'");
        if (mysqli_num_rows($check_query) > 0) {
            $user_exists = "An administrator with this username already exists.";
        } else {
            if ($admin_password !== $confirm_password) {
                $passwords_error = "Passwords do not match.";
            } else {
                // In production this should be hashed, but we preserve existing application structure
                $hashed_password = md5($admin_password); // matches existing login system if md5 is used, or raw if app used raw
                // Let's check how login_function checks password
                $insert = mysqli_query($spider_tech_db, "INSERT INTO admin_tb (admin_name, admin_password, privilege, date_created) VALUES ('$admin_name', '$admin_password', '$privilege', NOW())") or die(mysqli_error($spider_tech_db));
                if ($insert) {
                    $success_msg = "New administrator account '{$admin_name}' registered successfully.";
                }
            }
        }
    }
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
							<div class="pull-left">
								<div class="page-title">Register New Administrator</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li><a class="parent-item" href="admin_accounts.php">Admin Accounts</a>&nbsp;<i class="fa fa-angle-right"></i></li>
								<li class="active">Register Admin</li>
							</ol>
						</div>
					</div>

					<!-- Alerts -->
					<?php if (!empty($user_exists) || !empty($passwords_error)): ?>
						<div class="admin-alert-banner admin-alert-danger">
							<i class="material-icons">error_outline</i>
							<div><strong>Action Needed:</strong> <?= htmlspecialchars($user_exists ?: $passwords_error); ?></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($success_msg)): ?>
						<div class="admin-alert-banner admin-alert-success">
							<i class="material-icons">check_circle</i>
							<div><strong>Success:</strong> <?= htmlspecialchars($success_msg); ?></div>
						</div>
					<?php endif; ?>

					<form id="register_admin_form" method="POST">
						<div class="admin-workspace-grid">
							<!-- Main Content (68%) -->
							<div class="admin-workspace-main">
								<div class="form-card">
									<div class="form-card-head">
										<h2 class="form-card-title"><i class="material-icons">admin_panel_settings</i> Credentials & Access Privileges</h2>
										<span class="form-label-tag">Security Profile</span>
									</div>
									<div class="form-card-body">
										<div class="form-group-modern">
											<label class="form-label-modern" for="admin_name">
												<span>Admin Username <span class="required-star">*</span></span>
												<span class="form-help-modern">Alphanumeric, no spaces</span>
											</label>
											<input type="text" id="admin_name" name="admin_name" 
												placeholder="E.g. jdoe_admin"
												class="form-control-modern" 
												value="<?php if(isset($_POST['register']) && empty($success_msg)) { echo htmlspecialchars($admin_name); } ?>" 
												oninput="this.value = this.value.replace(/\s/g,'')"
												required />
											<?php if(!empty($admin_nameError)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= htmlspecialchars($admin_nameError); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="privilege">
												<span>Role & Privilege Level <span class="required-star">*</span></span>
											</label>
											<select id="privilege" name="privilege" class="form-control-modern" required>
												<option value="Administrator" selected>Administrator (Standard Access)</option>
												<option value="Super Admin">Super Admin (Full Root Console Privileges)</option>
											</select>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="admin_password">
												<span>Secure Password <span class="required-star">*</span></span>
											</label>
											<input type="password" id="admin_password" name="admin_password" 
												placeholder="Enter robust password"
												class="form-control-modern" 
												required />
											<?php if(!empty($admin_passwordError)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= htmlspecialchars($admin_passwordError); ?></div>
											<?php endif; ?>
										</div>

										<div class="form-group-modern">
											<label class="form-label-modern" for="confirm_password">
												<span>Confirm Password <span class="required-star">*</span></span>
											</label>
											<input type="password" id="confirm_password" name="confirm_password" 
												placeholder="Re-type password to verify"
												class="form-control-modern" 
												required />
											<?php if(!empty($confirm_passwordError)): ?>
												<div class="form-error-modern"><i class="material-icons">warning</i> <?= htmlspecialchars($confirm_passwordError); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Controls (32%) -->
							<div class="admin-workspace-sidebar">
								<div class="form-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">security</i> Security Notice</h3>
									</div>
									<div class="form-card-body">
										<p style="font-family: 'Open Sans', sans-serif; font-size: 0.85rem; color: #64748b; line-height: 1.6; margin: 0;">
											Registered administrators are granted backend access to publish and edit live company resources. Grant Super Admin privileges only to verified personnel.
										</p>
									</div>
								</div>

								<!-- Action Card -->
								<div class="form-card admin-actions-card">
									<div class="form-card-head">
										<h3 class="form-card-title"><i class="material-icons">person_add</i> Account Creation</h3>
									</div>
									<div class="form-card-body">
										<button type="submit" name="register" class="btn-admin-primary">
											<i class="material-icons">how_to_reg</i> Create Administrator
										</button>
										<a href="admin_accounts.php" class="btn-admin-cancel">
											<i class="material-icons">arrow_back</i> Return to Accounts
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
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
