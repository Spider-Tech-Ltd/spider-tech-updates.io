<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Handle delete
if (isset($_GET['delete_testimonial'])) {
    $testimonial_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_testimonial']);

    $query = mysqli_query($spider_tech_db, "SELECT image FROM testimonials_tb WHERE id='$testimonial_id'");
    $testimonial = mysqli_fetch_assoc($query);

    if ($testimonial) {
        $image_path = stripslashes($testimonial['image']);
        if (!empty($image_path) && file_exists($image_path)) {
            @unlink($image_path);
        }

        $delete_query = mysqli_query($spider_tech_db, "DELETE FROM testimonials_tb WHERE id='$testimonial_id' LIMIT 1");
        if ($delete_query) {
            header('Location: all_testimonials.php?success=' . urlencode('Testimonial deleted successfully.'));
            exit();
        } else {
            header('Location: all_testimonials.php?error=' . urlencode('Failed to delete testimonial.'));
            exit();
        }
    }
}

// Query testimonials
$testimonial_query = mysqli_query($spider_tech_db, "SELECT * FROM testimonials_tb ORDER BY id DESC") or die(mysqli_error($spider_tech_db));

// Redirect to edit
if (isset($_GET['testimonial'])) {
    $testimonial_id = mysqli_real_escape_string($spider_tech_db, $_GET['testimonial']);
    $_SESSION['testimonial'] = $testimonial_id;
    header('location:edit_testimonials.php');
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
                        <h1 class="page-title">Client Testimonials &amp; Endorsements</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_testimonials.php">Testimonials</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">All Testimonials</li>
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
                                    <header>Published Testimonials</header>
                                    <div class="tools">
                                        <a href="add_testimonials.php" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add Testimonial
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th style="width: 70px;">Avatar</th>
                                                    <th>Client Name</th>
                                                    <th>Organization / Firm</th>
                                                    <th>Role / Designation</th>
                                                    <th class="text-right" style="width: 170px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($testimonial_query && mysqli_num_rows($testimonial_query) > 0): ?>
                                                    <?php 
                                                    $no = 1;
                                                    while ($row = mysqli_fetch_assoc($testimonial_query)): 
                                                        $tId = (int)$row['id'];
                                                        $tName = stripslashes($row['name']);
                                                        $tOrg = stripslashes($row['organization'] ?? 'Client');
                                                        $tTitle = stripslashes($row['title'] ?? '');
                                                        $tPic = stripslashes($row['image'] ?? '');
                                                    ?>
                                                        <tr>
                                                            <td style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #64748b;"><?= $no++; ?></td>
                                                            <td>
                                                                <?php if (!empty($tPic) && file_exists($tPic)): ?>
                                                                    <img src="<?= htmlspecialchars($tPic); ?>" alt="" class="table-img-thumb" style="width: 42px; height: 42px; border-radius: 50%;">
                                                                <?php else: ?>
                                                                    <div class="table-img-fallback" style="width: 42px; height: 42px; border-radius: 50%;">
                                                                        <i class="fa fa-user-circle-o"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($tName); ?></strong>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill table-pill-slate"><?= htmlspecialchars($tOrg); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="color: #64748b; font-size: 0.85rem;"><?= htmlspecialchars($tTitle); ?></span>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="table-action-group">
                                                                    <a href="all_testimonials.php?testimonial=<?= $tId; ?>" class="btn-action-edit" title="Edit testimonial">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <a href="#" 
                                                                       data-delete-url="all_testimonials.php?delete_testimonial=<?= $tId; ?>" 
                                                                       data-item-name="<?= htmlspecialchars($tName); ?>" 
                                                                       class="btn-action-delete trigger-delete-modal" 
                                                                       title="Delete testimonial">
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
