<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Check for event_id
if (isset($_GET['event_id'])) {
    $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['event_id']);
} else {
    // Redirect if event_id is not set
    header('location:all_events.php');
}

// Query images for the specific event
$gallery_query = mysqli_query($spider_tech_db, "SELECT * FROM events_media WHERE event_id = '$event_id'") or die(mysqli_error($spider_tech_db));
$gallery_row = mysqli_fetch_assoc($gallery_query);

// Handle gallery edit request
if (isset($_GET['event'])) {
    $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['event']);
    $_SESSION['event'] = $event_id;
    header('location:add_gallery.php');
}

// Handle gallery edit request
if (isset($_GET['gallery'])) {
    $gallery_id = mysqli_real_escape_string($spider_tech_db, $_GET['gallery']);
    $_SESSION['gallery'] = $gallery_id;
    header('location:edit_gallery.php');
}

// Handle delete request
// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);

    // First, fetch the image path from the database
    $image_query = mysqli_query($spider_tech_db, "SELECT event_pics_name FROM events_media WHERE event_pics_id = '$delete_id'") or die(mysqli_error($spider_tech_db));
    $image_row = mysqli_fetch_assoc($image_query);
    
    if ($image_row) {
        $image_path = $image_row['event_pics_name'];

        // Delete the record from the database
        $delete_query = mysqli_query($spider_tech_db, "DELETE FROM events_media WHERE event_pics_id = '$delete_id'") or die(mysqli_error($spider_tech_db));
        if ($delete_query) {
            // Check if the file exists and delete it
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Set a success message
            $delete_success_msg = '<div class="alert alert-success">Image and associated record deleted successfully.</div>';
        } else {
            // Set an error message if deletion failed
            $delete_error_msg = '<div class="alert alert-danger">Failed to delete image record.</div>';
        }
    } else {
        // Set an error message if the image was not found
        $delete_error_msg = '<div class="alert alert-danger">Image not found in database.</div>';
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
        <!-- Start header -->
        <?php require('header-section.php'); ?>
        <!-- End header -->
        <!-- Start color quick setting -->
        <?php require('setting-section.html'); ?>
        <!-- End color quick setting -->
        <!-- Start page container -->
        <div class="page-container">
            <!-- Start sidebar menu -->
            <?php require('side-menu-section.php'); ?>
            <!-- End sidebar menu -->
            <!-- Start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class="pull-left">
                                <div class="page-title">Gallery for Event ID: <?php echo $event_id; ?></div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="all_events.php">Events</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Event Gallery List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Event Gallery Table</header>
                                </div>
                                <div class="card-body" id="bar-parent">
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
                                                <!-- Corrected Add New Button -->
                                                <a href="add_gallery.php?event=<?php echo $event_id; ?>" id="addRow" class="btn btn-info">
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
                                                        <th>Event Picture</th>
                                                        <th>Picture Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
												$s= 1;
                                                if (mysqli_num_rows($gallery_query) == 0) {
                                                    echo '<tr><td colspan="4" class="text-center">No images found for this event.</td></tr>';
                                                } else {
                                                    do {
                                                        $gallery_id = $gallery_row['event_pics_id'];
                                                        echo
                                                            '<tr>
                                                                <td>'.$s++.'</td>
                                                                <td class="patient-img">
                                                                    <img src="'.$gallery_row['event_pics_name'].'" alt="Event Image" style="width: 100px; height: auto;">
                                                                </td>
                                                                <td>'.$gallery_row['event_pics_name'].'</td>
                                                                <td>
                                                                    <!-- Edit button -->
                                                                    <a href="all_gallery.php?gallery='.$gallery_id.'" class="btn btn-primary btn-xs">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                    <!-- Delete button -->
                                                                    <a href="all_gallery.php?delete='.$gallery_id.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this picture?\')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>';
                                                    } while ($gallery_row = mysqli_fetch_assoc($gallery_query));
                                                }
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
            <!-- End page content -->
            <!-- Start chat sidebar -->
            <?php require('setting_and_chat_section.php'); ?>
            <!-- End chat sidebar -->
        </div>
        <!-- End page container -->
        <!-- Start footer -->
        <?php require('footer-section.html'); ?>
        <!-- End footer -->
    </div>
    <!-- Start js include path -->
    <?php require('js-section.html'); ?>
    <!-- End js include path -->
</body>
</html>
