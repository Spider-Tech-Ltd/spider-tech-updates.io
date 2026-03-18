<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Query events
$event_query = mysqli_query($spider_tech_db, "SELECT * FROM events") or die(mysqli_error($spider_tech_db));
$event_row = mysqli_fetch_assoc($event_query);

// Handle event edit request
if (isset($_GET['event'])) {
    $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['event']);
    $_SESSION['event_id'] =  $event_id;
    header('location:edit_event.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head>
    <?php require 'head-section.html'; ?>
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
                                <div class="page-title">All Events</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">Events</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Events List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Events Table</header>
                                </div>
                                <div class="card-body " id="bar-parent">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="add_event.php" id="addRow" class="btn btn-info">
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
                                                        <th>Event Title</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Status</th>
                                                        <th>Event Media</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                do {
                                                    $event = $event_row['event_id'];
                                                    echo
                                                        '<tr>
                                                            <td class="patient-img">
                                                                <img src="'.$event_row['event_img'].'" alt="">
                                                            </td>
                                                            <td>'.$event_row['event_title'].'</td>
                                                            <td>'.$event_row['event_date'].'</td>
                                                            <td>'.$event_row['event_time'].'</td>
                                                            <td>'.$event_row['event_status'].'</td>
                                                            <td>
                                                                <a href="all_gallery.php?event_id='.$event.'" class="btn btn-info btn-xs">
                                                                    View Media
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="all_events.php?event='.$event.'" class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>';
                                                } while ($event_row = mysqli_fetch_assoc($event_query));
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
            <?php require 'setting_and_chat_section.php'; ?>
            <!-- End chat sidebar -->
        </div>
        <!-- End page container -->
        <!-- Start footer -->
        <?php require 'footer-section.html'; ?>
        <!-- End footer -->
    </div>
    <!-- Start js include path -->
    <?php require 'js-section.html'; ?>
    <!-- End js include path -->
</body>

</html>
