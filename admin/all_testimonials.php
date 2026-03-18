<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Check if the delete button was clicked
if(isset($_GET['delete_testimonial'])) {
    $testimonial_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_testimonial']);

    // Fetch the testimonial to get the image path
    $query = mysqli_query($spider_tech_db, "SELECT image FROM testimonials_tb WHERE id='$testimonial_id'");
    $testimonial = mysqli_fetch_assoc($query);
    $image_path = stripslashes($testimonial['image']);

    // Delete the testimonial from the database
    $delete_query = mysqli_query($spider_tech_db, "DELETE FROM testimonials_tb WHERE id='$testimonial_id'");

    if ($delete_query) {
        // Delete the image from the server if it exists
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Set a success message
        $delete_success_msg = '<div class="alert alert-success">Testimonial and associated image deleted successfully.</div>';
    } else {
        // Set an error message if deletion failed
        $delete_error_msg = '<div class="alert alert-danger">Failed to delete testimonial.</div>';
    }
}

// Query testimonials
$testimonial_query = mysqli_query($spider_tech_db, "SELECT * FROM testimonials_tb") or die(mysqli_error($spider_tech_db));
$testimonial_row = mysqli_fetch_assoc($testimonial_query);

// Redirect to edit page if testimonial is clicked
if (isset($_GET['testimonial'])) {
    $testimonial_id = mysqli_real_escape_string($spider_tech_db, $_GET['testimonial']);
    $_SESSION['testimonial'] = $testimonial_id;
    header('location:edit_testimonials.php');
    exit();
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
                                <div class="page-title">All Testimonials</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">Testimonial</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Testimonial List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Testimonial Table</header>
                                </div>
                                <div class="card-body" id="bar-parent">
                                    <!-- Display success or error message -->
                                    <?php
                                    if(isset($delete_success_msg)) {
                                        echo $delete_success_msg;
                                    } elseif (isset($delete_error_msg)) {
                                        echo $delete_error_msg;
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="add_testimonials.php" id="addRow" class="btn btn-info">
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
                                                        <th>#</th>
                                                        <th>Picture</th>
                                                        <th>Attestant's Name</th>
                                                        <th>Company/Organisation</th>
                                                        <th>Title</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1; 
                                                    do {
                                                        $testimonial_id = $testimonial_row['id'];
                                                        echo
                                                        '<tr>
                                                            <td>'.$no.'</td>
                                                            <td class="patient-img">
                                                                <img src="'.stripslashes($testimonial_row['image']).'"
                                                                alt="">
                                                            </td>
                                                            <td>'.$testimonial_row['name'].'</td>
                                                            <td>'.$testimonial_row['organization'].'</td>
                                                            <td>'.$testimonial_row['title'].'</td>
                                                            <td>
                                                                <a href="all_testimonials.php?testimonial='.$testimonial_id.'"
                                                                    class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-pencil"></i>Edit
                                                                </a>
                                                                <a href="all_testimonials.php?delete_testimonial='.$testimonial_id.'"
                                                                    class="btn btn-danger btn-xs"
                                                                    onclick="return confirm(\'Are you sure you want to delete this testimonial?\');">
                                                                    <i class="fa fa-trash"></i>Delete
                                                                </a>
                                                            </td>
                                                        </tr>';
                                                        $no++;
                                                    } while($testimonial_row = mysqli_fetch_assoc($testimonial_query));
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
