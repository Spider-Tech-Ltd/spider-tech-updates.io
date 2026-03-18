<?php 
require('superadmin_functions.php');
require('secured-login.php');


// Query trainings
$applicants_query = mysqli_query($spider_tech_db, "SELECT * FROM dse_application") or die(mysqli_error($spider_tech_db));
$applicants_row = mysqli_fetch_assoc($applicants_query);


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
                                <div class="page-title">All Applicants</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">Training</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Applicants List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Applicants Table</header>
                                </div>
                                <div class="card-body" id="bar-parent">
                                    
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <div class="btn-group">
                                                <a href="add_trainings.php" id="addRow" class="btn btn-info">
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
                                                        <th>Last Name</th>
                                                        <th>First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Email</th>
                                                        <th>Phone No.</th>
                                                        <th>Age</th>
                                                        <th>Gender</th>
                                                        <th>Business Name</th>
                                                        <th>Business Sector</th>
                                                        <th>CAC_no</th>
                                                        <th>SMEDAN</th>
                                                        <th>Years of Opr</th>
                                                        <th>Business Location</th>
                                                        <th>Apply Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows($applicants_query) == 0) {
                                                        echo '<tr><td colspan="4" class="text-center">No applications yet.</td></tr>';
                                                    } else {
                                                        $no = 1; 
                                                    do {
                                                        $applicants_id = $applicants_row['id'];
                                                        echo
                                                        '<tr>
                                                            <td>'.$no.'</td>
                                                            <td>'.$applicants_row['lastname'].'</td>
                                                            <td>'.$applicants_row['firstname'].'</td>
                                                            <td>'.$applicants_row['middlename'].'</td>
                                                            <td><a href="mailto:'.$applicants_row['email'].'">'.$applicants_row['email'].'</a></td>
															<td><a href="tel:'.$applicants_row['phone_no'].'">'.$applicants_row['phone_no'].'</a></td>
                                                            <td>'.$applicants_row['age'].'</td>
                                                            <td>'.$applicants_row['gender'].'</td>
                                                            <td>'.$applicants_row['business_name'].'</td>
                                                            <td>'.$applicants_row['business_sector'].'</td>
                                                            <td>'.$applicants_row['cac_no'].'</td>
                                                            <td>'.$applicants_row['smedan'].'</td>
                                                            <td>'.$applicants_row['years'].'</td>
                                                            <td>'.$applicants_row['business_location'].'</td>
                                                            <td>'.$applicants_row['apply_date'].'</td>
                                                            
                                                        </tr>';
                                                        $no++;
                                                    } while($applicants_row = mysqli_fetch_assoc($applicants_query));
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
