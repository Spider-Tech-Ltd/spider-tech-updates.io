<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Check for a success or error message
$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Query projects with service name join
$project_query = mysqli_query($spider_tech_db, "SELECT p.*, s.service_name 
    FROM projects_tb p 
    LEFT JOIN services_tb s ON s.id = p.service_id 
    ORDER BY p.project_id DESC") or die(mysqli_error($spider_tech_db));

// Redirect to edit page if 'project' is set
if (isset($_GET['project'])) {
    $project_id = mysqli_real_escape_string($spider_tech_db, $_GET['project']);
    $_SESSION['project'] = $project_id;
    header('location:edit_projects.php');
    exit();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $project_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);
    
    // Fetch the project details (especially the image path)
    $fetch_project = mysqli_query($spider_tech_db, "SELECT project_pic FROM projects_tb WHERE project_id = '$project_id'") or die(mysqli_error($spider_tech_db));
    $project = mysqli_fetch_assoc($fetch_project);
    
    if ($project) {
        $image_path = $project['project_pic'];

        // Delete the project from the database
        $delete_project_query = "DELETE FROM projects_tb WHERE project_id = '$project_id' LIMIT 1";
        if (mysqli_query($spider_tech_db, $delete_project_query)) {
            if (!empty($image_path) && file_exists($image_path)) {
                @unlink($image_path);
            }
            header('Location: all_projects.php?success=' . urlencode('Project deleted successfully.'));
            exit();
        } else {
            header('Location: all_projects.php?error=' . urlencode('Error deleting project.'));
            exit();
        }
    }
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
                        <h1 class="page-title">Project Case Studies</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_projects.php">Projects</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">Project List</li>
                        </ol>
                    </div>

                    <!-- Alert Notifications -->
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
                                    <header>All Published Projects</header>
                                    <div class="tools">
                                        <a href="add_projects.php" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add New Project
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px;">Thumbnail</th>
                                                    <th>Project Name</th>
                                                    <th>Service Category</th>
                                                    <th>Year</th>
                                                    <th>Description Preview</th>
                                                    <th class="text-right" style="width: 210px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($project_query && mysqli_num_rows($project_query) > 0): ?>
                                                    <?php while ($row = mysqli_fetch_assoc($project_query)): ?>
                                                        <?php 
                                                            $pId = (int)$row['project_id'];
                                                            $pName = stripslashes($row['project_name']);
                                                            $pService = stripslashes($row['service_name'] ?? 'General');
                                                            $pYear = stripslashes($row['project_year']);
                                                            $pPic = $row['project_pic'];
                                                            $pDesc = strip_tags(stripslashes($row['project_description']));
                                                            $pDescShort = mb_strimwidth($pDesc, 0, 50, '...');
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php if (!empty($pPic) && file_exists($pPic)): ?>
                                                                    <img src="<?= htmlspecialchars($pPic); ?>" alt="" class="table-img-thumb">
                                                                <?php else: ?>
                                                                    <div class="table-img-fallback">
                                                                        <i class="fa fa-folder-o"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($pName); ?></strong>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill table-pill-orange"><?= htmlspecialchars($pService); ?></span>
                                                            </td>
                                                            <td>
                                                                <span style="font-family: 'Chakra Petch', monospace; font-weight: 600; color: #475569;"><?= htmlspecialchars($pYear); ?></span>
                                                            </td>
                                                            <td>
                                                                <span title="<?= htmlspecialchars($pDesc); ?>" style="color: #64748b; font-size: 0.85rem;">
                                                                    <?= htmlspecialchars($pDescShort); ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="table-action-group">
                                                                    <a href="../projects/detail?id=<?= $pId; ?>" target="_blank" class="btn-action-view" title="Preview on live site">
                                                                        <i class="fa fa-external-link"></i> View
                                                                    </a>
                                                                    <a href="all_projects.php?project=<?= $pId; ?>" class="btn-action-edit" title="Edit project">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <a href="#" 
                                                                       data-delete-url="all_projects.php?delete=<?= $pId; ?>" 
                                                                       data-item-name="<?= htmlspecialchars($pName); ?>" 
                                                                       class="btn-action-delete trigger-delete-modal" 
                                                                       title="Delete project">
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
