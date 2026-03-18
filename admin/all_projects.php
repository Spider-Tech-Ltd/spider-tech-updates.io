<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Check for a success message in the URL (using GET method)
$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Query services
$project_query = mysqli_query($spider_tech_db, "SELECT * FROM projects_tb p, services_tb s WHERE s.id = p.service_id") or die(mysqli_error($spider_tech_db));
$project_row = mysqli_fetch_assoc($project_query);

// Redirect to edit page if 'project' is set
if (isset($_GET['project'])) {
    $project_id = mysqli_real_escape_string($spider_tech_db, $_GET['project']);
    $_SESSION['project'] = $project_id;
    header('location:edit_projects.php');
}

// Handle delete action
if (isset($_GET['delete'])) {
    $project_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);
    
    // Fetch the project details (especially the image path)
    $project_query = mysqli_query($spider_tech_db, "SELECT project_pic FROM projects_tb WHERE project_id = '$project_id'") or die(mysqli_error($spider_tech_db));
    $project = mysqli_fetch_assoc($project_query);
    
    if ($project) {
        // Get the image path
        $image_path = $project['project_pic'];

        // Delete the project from the database
        $delete_project_query = "DELETE FROM projects_tb WHERE project_id = '$project_id' LIMIT 1";
        if (mysqli_query($spider_tech_db, $delete_project_query)) {
            // Check if the image file exists, then delete it
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
            // Redirect with a success message
            header('Location: all_projects.php?success=Project deleted successfully');
            exit();
        } else {
            // Redirect with an error message
            header('Location: all_projects.php?error=Error deleting project');
            exit();
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
                                <div class="page-title">All Projects</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">project</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Project List</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Display success or error messages -->
                    <?php if ($success_message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Project Table</header>
                                </div>
                                <div class="card-body" id="bar-parent">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="add_projects.php" id="addRow" class="btn btn-info">
                                                    Add New <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-scrollable">
                                            <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Picture</th>
                                                        <th>Project Name</th>
                                                        <th>Project Description</th>
                                                        <th>Service Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    do {
                                                        $project_id = $project_row['project_id'];
                                                        echo '<tr>
                                                                <td class="patient-img">
                                                                    <img src="' . $project_row['project_pic'] . '" alt="">
                                                                </td>
                                                                <td>' . substr(stripslashes($project_row['project_name']), 0, 20) . '</td>
                                                                <td>' . substr(stripslashes(strip_tags($project_row['project_description'])), 0, 20) . '..</td>
                                                                <td>' . stripslashes($project_row['service_name']) . '</td>
                                                                <td>
                                                                    <a href="all_projects.php?project=' . $project_id . '" class="btn btn-primary btn-xs">
                                                                        <i class="fa fa-pencil"></i>Edit
                                                                    </a>
                                                                    <a href="all_projects.php?delete=' . $project_id . '" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this project?\');">
                                                                        <i class="fa fa-trash"></i>Delete
                                                                    </a>
                                                                </td>
                                                            </tr>';
                                                    } while ($project_row = mysqli_fetch_assoc($project_query));
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
