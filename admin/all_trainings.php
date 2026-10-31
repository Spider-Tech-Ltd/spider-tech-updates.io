<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Check if delete action triggered
if (isset($_GET['delete_training'])) {
    $training_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_training']);

    // Fetch the training image path
    $query = mysqli_query($spider_tech_db, "SELECT training_image FROM trainings_tb WHERE id='$training_id'");
    $training = mysqli_fetch_assoc($query);

    if ($training) {
        $image_path = stripslashes($training['training_image']);
        if (!empty($image_path) && file_exists($image_path)) {
            @unlink($image_path);
        }

        $delete_query = mysqli_query($spider_tech_db, "DELETE FROM trainings_tb WHERE id='$training_id' LIMIT 1");
        if ($delete_query) {
            header('Location: all_trainings.php?success=' . urlencode('Training program deleted successfully.'));
            exit();
        } else {
            header('Location: all_trainings.php?error=' . urlencode('Failed to delete training program.'));
            exit();
        }
    }
}

// Query trainings
$training_query = mysqli_query($spider_tech_db, "SELECT * FROM trainings_tb ORDER BY id DESC") or die(mysqli_error($spider_tech_db));

// Redirect to edit page
if (isset($_GET['training'])) {
    $training_id = mysqli_real_escape_string($spider_tech_db, $_GET['training']);
    $_SESSION['training'] = $training_id;
    header('location:edit_trainings.php');
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
                        <h1 class="page-title">Technical Training Programs</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_trainings.php">Trainings</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">Program List</li>
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
                                    <header>All Published Programs</header>
                                    <div class="tools">
                                        <a href="add_trainings.php" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add New Program
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px;">Thumbnail</th>
                                                    <th>Program Name</th>
                                                    <th>Category</th>
                                                    <th>Duration / Hours</th>
                                                    <th>Enrolled</th>
                                                    <th class="text-right" style="width: 210px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($training_query && mysqli_num_rows($training_query) > 0): ?>
                                                    <?php while ($row = mysqli_fetch_assoc($training_query)): ?>
                                                        <?php 
                                                            $tId = (int)$row['id'];
                                                            $tName = stripslashes($row['training_name']);
                                                            $tPic = stripslashes($row['training_image']);
                                                            $tCategory = stripslashes($row['category'] ?? 'Engineering');
                                                            $tTime = stripslashes($row['training_time'] ?? ($row['duration_minutes'] ? $row['duration_minutes'] . ' mins' : 'Flexible'));
                                                            $tEnrolled = (int)($row['students_enrolled'] ?? 0);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php if (!empty($tPic) && file_exists($tPic)): ?>
                                                                    <img src="<?= htmlspecialchars($tPic); ?>" alt="" class="table-img-thumb">
                                                                <?php else: ?>
                                                                    <div class="table-img-fallback">
                                                                        <i class="fa fa-graduation-cap"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($tName); ?></strong>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill table-pill-orange"><?= htmlspecialchars($tCategory); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #475569;"><?= htmlspecialchars($tTime); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #0f172a;"><?= $tEnrolled; ?> Students</span>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="table-action-group">
                                                                    <a href="../trainings/detail?id=<?= $tId; ?>" target="_blank" class="btn-action-view" title="Preview on live site">
                                                                        <i class="fa fa-external-link"></i> View
                                                                    </a>
                                                                    <a href="all_trainings.php?training=<?= $tId; ?>" class="btn-action-edit" title="Edit program">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <a href="#" 
                                                                       data-delete-url="all_trainings.php?delete_training=<?= $tId; ?>" 
                                                                       data-item-name="<?= htmlspecialchars($tName); ?>" 
                                                                       class="btn-action-delete trigger-delete-modal" 
                                                                       title="Delete program">
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
