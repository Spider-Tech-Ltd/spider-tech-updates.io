<?php 
require('superadmin_functions.php');
require('secured-login.php');

// Check if the delete button was clicked
if(isset($_GET['delete_faq'])) {
    $faq_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete_faq']);
    
    // Delete the FAQ from the database
    $delete_query = mysqli_query($spider_tech_db, "DELETE FROM faq_tb WHERE faq_id='$faq_id'");

    if ($delete_query) {
        // Set a success message
        $delete_success_msg = '<div class="alert alert-success">FAQ deleted successfully.</div>';
    } else {
        // Set an error message if deletion failed
        $delete_error_msg = '<div class="alert alert-danger">Failed to delete FAQ.</div>';
    }
}

// Query FAQs
$faq_query = mysqli_query($spider_tech_db, "SELECT * FROM faq_tb ORDER BY faq_question") or die(mysqli_error($spider_tech_db));
$faq_row = mysqli_fetch_assoc($faq_query);

// Create session and store faq id for FAQ edit function
if(isset($_GET['faq'])) {
    $faq_id = mysqli_real_escape_string($spider_tech_db, $_GET['faq']);
    $_SESSION['faq_id'] = $faq_id;
    header('location:edit_faq.php');
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
                                <div class="page-title">All FAQ</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">FAQ</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">FAQ List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>FAQ Table</header>
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
                                                <a href="add_faq.php" id="addRow" class="btn btn-info">
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
                                                        <th>Question</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                do {
                                                    $faq = $faq_row['faq_id'];
                                                    echo
                                                    '<tr>
                                                        <td>'.$faq_row['faq_id'].'</td>
                                                        <td>'.$faq_row['faq_question'].'</td>
                                                        <td>
                                                            <a href="all_faq.php?faq='.$faq.'"
                                                                class="btn btn-primary btn-xs">
                                                                <i class="fa fa-pencil"></i>EDIT
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="all_faq.php?delete_faq='.$faq.'"
                                                                class="btn btn-danger btn-xs"
                                                                onclick="return confirm(\'Are you sure you want to delete this FAQ?\');">
                                                                <i class="fa fa-trash"></i>DELETE
                                                            </a>
                                                        </td>
                                                    </tr>';
                                                } while($faq_row = mysqli_fetch_assoc($faq_query));
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
