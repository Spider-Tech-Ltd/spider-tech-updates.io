<?php 
require('superadmin_functions.php');
require('secured-login.php');

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';

// Handle event delete
if (isset($_GET['delete'])) {
    $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['delete']);
    $fetch_event = mysqli_query($spider_tech_db, "SELECT event_img FROM events WHERE event_id = '$event_id'") or die(mysqli_error($spider_tech_db));
    $event = mysqli_fetch_assoc($fetch_event);
    
    if ($event) {
        if (!empty($event['event_img']) && file_exists($event['event_img'])) {
            @unlink($event['event_img']);
        }
        $delete_query = "DELETE FROM events WHERE event_id = '$event_id' LIMIT 1";
        if (mysqli_query($spider_tech_db, $delete_query)) {
            header('Location: all_events.php?success=' . urlencode('Event deleted successfully.'));
            exit();
        } else {
            header('Location: all_events.php?error=' . urlencode('Error deleting event.'));
            exit();
        }
    }
}

// Query events
$event_query = mysqli_query($spider_tech_db, "SELECT * FROM events ORDER BY event_id DESC") or die(mysqli_error($spider_tech_db));

// Handle event edit request
if (isset($_GET['event'])) {
    $event_id = mysqli_real_escape_string($spider_tech_db, $_GET['event']);
    $_SESSION['event_id'] = $event_id;
    header('location:edit_event.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'head-section.html'; ?>
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
                        <h1 class="page-title">Corporate &amp; Community Events</h1>
                        <ol class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Dashboard</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li><a href="all_events.php">Events</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                            <li class="active">Events List</li>
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
                                    <header>All Published Events</header>
                                    <div class="tools">
                                        <a href="add_events.php" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add New Event
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">    
                                    <div class="table-scrollable">            
                                        <table id="exportTable" class="display nowrap table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px;">Banner</th>
                                                    <th>Event Title</th>
                                                    <th>Date &amp; Time</th>
                                                    <th>Status</th>
                                                    <th>Media</th>
                                                    <th class="text-right" style="width: 210px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($event_query && mysqli_num_rows($event_query) > 0): ?>
                                                    <?php while ($row = mysqli_fetch_assoc($event_query)): ?>
                                                        <?php 
                                                            $eId = (int)$row['event_id'];
                                                            $eTitle = stripslashes($row['event_title']);
                                                            $eDate = stripslashes($row['event_date']);
                                                            $eTime = stripslashes($row['event_time']);
                                                            $eStatus = strtolower(trim($row['event_status'] ?? ''));
                                                            $ePic = $row['event_img'];

                                                            $badgeClass = 'table-pill-slate';
                                                            if (stripos($eStatus, 'upcom') !== false) {
                                                                $badgeClass = 'table-pill-orange';
                                                            } elseif (stripos($eStatus, 'ongo') !== false) {
                                                                $badgeClass = 'table-pill-green';
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php if (!empty($ePic) && file_exists($ePic)): ?>
                                                                    <img src="<?= htmlspecialchars($ePic); ?>" alt="" class="table-img-thumb">
                                                                <?php else: ?>
                                                                    <div class="table-img-fallback">
                                                                        <i class="fa fa-calendar-o"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong style="color: #0f172a; font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($eTitle); ?></strong>
                                                            </td>
                                                            <td>
                                                                <div style="font-family: 'Chakra Petch', monospace; font-size: 0.88rem; color: #0f172a;"><?= htmlspecialchars($eDate); ?></div>
                                                                <small class="text-muted"><?= htmlspecialchars($eTime); ?></small>
                                                            </td>
                                                            <td>
                                                                <span class="table-pill <?= $badgeClass; ?>"><?= htmlspecialchars(ucfirst($eStatus ?: 'Scheduled')); ?></span>
                                                            </td>
                                                            <td>
                                                                <a href="all_gallery.php?event_id=<?= $eId; ?>" class="btn btn-default btn-xs" title="Manage Event Media">
                                                                    <i class="fa fa-picture-o"></i> Media
                                                                </a>
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="table-action-group">
                                                                    <a href="../events/detail?id=<?= $eId; ?>" target="_blank" class="btn-action-view" title="Preview on live site">
                                                                        <i class="fa fa-external-link"></i> View
                                                                    </a>
                                                                    <a href="all_events.php?event=<?= $eId; ?>" class="btn-action-edit" title="Edit event">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <a href="#" 
                                                                       data-delete-url="all_events.php?delete=<?= $eId; ?>" 
                                                                       data-item-name="<?= htmlspecialchars($eTitle); ?>" 
                                                                       class="btn-action-delete trigger-delete-modal" 
                                                                       title="Delete event">
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
        <?php require 'footer-section.html'; ?>
    </div>

    <!-- JS includes -->
    <?php require 'js-section.html'; ?>
</body>
</html>
