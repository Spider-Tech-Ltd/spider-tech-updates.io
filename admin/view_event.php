<?php
require('../includes/connect.php');

session_start();
$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

$delete_success = false;

if(isset($_POST['delete'])){
    $delete_id = $get_id;
    $select_image = $conn->prepare("SELECT * FROM `events` WHERE event_id=?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    
    if ($fetch_image) {
        if ($fetch_image['event_img'] != '') {
            unlink('../images/events/'.$fetch_image['event_img']);
        }

        $delete_service = $conn->prepare("DELETE FROM `events` WHERE event_id=?");
        $delete_service->execute([$delete_id]);

        if ($delete_service->rowCount() > 0) {
            $delete_success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- head section begin-->
<?php include '../includes/admin_head.php'; ?>
<!-- head section close-->

<body>

<main class="main-wrapper">
    <!-- admin sidebar begin-->
    <?php include '../includes/admin_sidebar.php'; ?>
    <!-- admin sidebar close-->

    <section class="dashboard">
        <!-- header begin-->
        <?php include '../includes/admin_header.php'; ?>
        <!-- header close-->

        <div class="content-form read-post">
            <h2 class="heading">View Events</h2>

                <?php
                    $select_event = $conn->prepare("SELECT * FROM events WHERE event_id=?");
                    $select_event->execute([$get_id]);
                    if($select_event->rowCount() > 0){
                        while($fetch_event = $select_event->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                        <?php
                            if($fetch_event['event_img'] != ''){
                        ?>
                        <img src="../images/events/<?= stripslashes($fetch_event['event_img']); ?>" alt="" class="image">
                        <?php
                             }
                        ?>

                        <div class="events"><span>Title: </span><?= stripslashes($fetch_event['event_title']); ?></div>
                        <div class="events"><span>Content: </span><?= stripslashes($fetch_event['event_content']); ?></div>
                        <br>
                        <div class="events"><span>Detail: </span><?= stripslashes($fetch_event['event_detail']); ?></div>
                        <br>
                        <div class="events"><span>Date: </span><?= stripslashes($fetch_event['event_date']); ?></div>
                        <div class="events"><span>Time: </span><?= stripslashes($fetch_event['event_time']); ?></div>
                        <div class="events"><span>Address: </span><?= stripslashes($fetch_event['event_address']); ?></div>
                        <div class="events"><span>Status: </span><?= stripslashes($fetch_event['event_status']); ?></div>
                        
                        <div class="flex-btn">
                            <a href="update_event.php?id=<?php echo stripslashes($fetch_event['event_id']); ?>" class="edit-btn btn">Update</a>
                            <a href="events.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass event ID -->
                            <input type="hidden" name="event_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this event?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:events.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('Event deleted successfully!');
    window.location.href = 'events.php'; // Redirect to the services view page after alert
</script>
<?php endif; ?>

</body>
</html>
