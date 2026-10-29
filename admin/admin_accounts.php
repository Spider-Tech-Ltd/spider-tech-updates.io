<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Handle delete admin
if (isset($_GET['delete'])) {
    $del_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);
    
    // Safety: prevent deleting the primary superadmin account (id=1)
    if ($del_id == '1') {
        header('Location: admin_accounts.php?error=' . urlencode('The primary root administrator cannot be deleted.'));
        exit();
    }

    $delete_query = mysqli_query($spider_tech_db, "DELETE FROM admin_tb WHERE admin_id='$del_id' LIMIT 1");
    if ($delete_query) {
        header('Location: admin_accounts.php?success=' . urlencode('Administrator account removed successfully.'));
        exit();
    } else {
        header('Location: admin_accounts.php?error=' . urlencode('Failed to delete administrator account.'));
        exit();
    }
}

// Query all admin accounts
$admin_query = mysqli_query($spider_tech_db, "SELECT * FROM admin_tb ORDER BY admin_id ASC") or die(mysqli_error($spider_tech_db));
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
                        <h1 class="page-title">Administrator Accounts &amp; Permissions</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="admin_accounts.php">System</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">Admin Accounts</li>
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
                                    <header>Authorized System Administrators</header>
                                    <div class="tools">
                                        <a href="register_admin.php" class="btn btn-primary">
                                            <i class="fa fa-user-plus"></i> Register New Admin
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th>Admin Username</th>
                                                    <th>Access Privilege</th>
                                                    <th>Last Login Timestamp</th>
                                                    <th class="text-right" style="width: 140px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($admin_query && mysqli_num_rows($admin_query) > 0): ?>
                                                    <?php while ($row = mysqli_fetch_assoc($admin_query)): ?>
                                                        <?php 
                                                            $aId = (int)$row['admin_id'];
                                                            $aName = stripslashes($row['admin_name']);
                                                            $aRole = stripslashes($row['privilege'] ?: 'Administrator');
                                                            $aLogin = $row['lastlogin'] && $row['lastlogin'] !== '0000-00-00 00:00:00' ? $row['lastlogin'] : 'Never logged in';
                                                        ?>
                                                        <tr>
                                                            <td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $aId; ?></td>
                                                            <td>
                                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                                    <div class="table-img-fallback" style="width: 36px; height: 36px; border-radius: 50%; background: var(--admin-primary-soft); color: var(--admin-primary);">
                                                                        <i class="fa fa-user-circle"></i>
                                                                    </div>
                                                                    <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($aName); ?></strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill <?= $aRole === 'Super Admin' ? 'table-pill-orange' : 'table-pill-slate'; ?>">
                                                                    <?= htmlspecialchars($aRole); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; font-size: 0.84rem; color: #475569;">
                                                                    <?= htmlspecialchars($aLogin); ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if ($aId !== 1): ?>
                                                                    <div class="table-action-group">
                                                                        <a href="#" 
                                                                           data-delete-url="admin_accounts.php?delete=<?= $aId; ?>" 
                                                                           data-item-name="<?= htmlspecialchars($aName); ?>" 
                                                                           class="btn-action-delete trigger-delete-modal" 
                                                                           title="Revoke Admin Access">
                                                                            <i class="fa fa-trash"></i> Delete
                                                                        </a>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <span class="text-muted" style="font-size: 0.78rem; font-style: italic;">Root System</span>
                                                                <?php endif; ?>
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
