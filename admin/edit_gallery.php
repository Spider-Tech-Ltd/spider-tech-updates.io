<?php 
require('superadmin_functions.php');
require('secured-login.php');
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
                                <div class="page-title">Edit Event Gallery</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="all_events.php">Event Gallery</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Edit Event Gallery</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Gallery Image</header>
                                </div>
                                <?php 
                                if(isset($_SESSION['gallery'])) {
                                    // Join events_media and events tables to fetch event_title
                                    $event_media_query = mysqli_query($spider_tech_db, "
                                        SELECT em.*, e.event_title 
                                        FROM events_media em 
                                        JOIN events e ON em.event_id = e.event_id 
                                        WHERE em.event_pics_id = '" . $_SESSION['gallery'] . "'
                                    ") or die(mysqli_error($spider_tech_db));
                                    $event_media_row = mysqli_fetch_assoc($event_media_query);
                                }
                                ?>
                                <div class="card-body" id="bar-parent">
                                    <form id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <?php 
                                                if(!empty($media_success_msg)) {
                                                    echo $media_success_msg;
                                                }      
                                            ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Event Media Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="hidden" name="event_pics_id" value="<?php echo stripslashes($event_media_row['event_pics_id']); ?>">
                                                    <input type="text" name="event_media_name" placeholder="Enter event_media Name"
                                                        class="form-control input-height" value="<?php echo stripslashes($event_media_row['event_title']); ?>" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Disable/Enable Picture
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select class="form-control input-height" id="mfi_4_a_i" onChange="changetextbox();">
                                                        <option value="" selected>Select...</option>    
                                                        <option value="Disable">Disable Picture Update</option>
                                                        <option value="Enable">Enable Picture Update</option>
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Event Media Picture <span class="required"> * </span> 
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" class="default" name="img" id="sdd" required>
                                                    <div><span class="help-block text-green">900x590 dimension is the best picture</span></div>
                                                    <?php if(isset($_POST['edit_event_media'])) { echo '<div>'.$mediaErr.'</div>'; } ?>
                                                </div>
                                            </div>
                                            <!-- Display the current project image -->
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Current Project Picture:</label>
                                                <div class="col-md-5">
                                                    <?php if (!empty($event_media_row['event_pics_name'])): ?>
                                                        <img src="<?php echo stripslashes($event_media_row['event_pics_name']); ?>" alt="Current event_media Picture" class="img-fluid" style="max-width: 100%; height: auto;"/>
                                                    <?php else: ?>
                                                        <p>No image available.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="offset-md-3 col-md-9">
                                                        <button type="submit"
                                                            class="btn btn-info m-r-20" name="edit_event_media">Submit</button>
                                                        <button type="button" class="btn btn-default">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page content -->
            <!-- start chat sidebar -->
            <?php require('setting_and_chat_section.php');?>
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
