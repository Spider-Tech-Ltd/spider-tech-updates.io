<?php
require('../includes/connect.php');

session_start();
$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

$update_success = false; // Flag to indicate successful update

if (isset($_POST['update'])) {
    $event_title = htmlspecialchars($_POST['event_title']);
    $event_content = htmlspecialchars($_POST['event_content']);
    $event_detail = $_POST['event_detail'];
    $event_date = htmlspecialchars($_POST['event_date']);
    $event_time = htmlspecialchars($_POST['event_time']);
    $event_address = htmlspecialchars($_POST['event_address']);
    $event_status = htmlspecialchars(isset($_POST['event_status']) ? $_POST['event_status'] : '');
    $training_id = htmlspecialchars($_POST['training_id']);

    // Handle file upload only if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        // Give random name to image
        $image_new_name = mt_rand(0, getrandmax());
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = $image_new_name . '.' . $ext;

        $image_size = htmlspecialchars($_FILES['image']['size']);
        $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_folder = '../images/events/' . $image;

        if ($image_size > 2000000) {
            $message .= "<span class='error'>Image size is too large!</span><br>";
        } else {
            // Fetch current image before updating
            $select_image = $conn->prepare("SELECT event_img FROM events WHERE event_id=?");
            $select_image->execute([$get_id]);
            $current_image = $select_image->fetchColumn();

            // Delete the old image if it exists
            if ($current_image && file_exists('../images/events/' . $current_image)) {
                unlink('../images/events/' . $current_image);
            }

            // Move new image and update the event image
            move_uploaded_file($image_tmp_name, $image_folder);
            $update_image = $conn->prepare("UPDATE events SET event_img=? WHERE event_id=?");
            $update_image->execute([$image, $get_id]);
        }
    }

    $event_titleError = "";
    $event_contentError = "";
    $event_detailError = "";
    $event_dateError = "";
    $event_timeError = "";
    $event_addressError = "";
    $event_statusError = "";
    $error = 0;

    if (empty($event_title)) {
        $event_titleError = "<span class='error'>Event title is required!</span>";
        $error = 1;
    }

    if (empty($event_content)) {
        $event_contentError = "<span class='error'>Event content is required!</span>";
        $error = 1;
    }

    if (empty($event_detail)) {
        $event_detailError = "<span class='error'>Event detail is required!</span>";
        $error = 1;
    }

    if (empty($event_date)) {
        $event_dateError = "<span class='error'>Event date is required!</span>";
        $error = 1;
    }

    if (empty($event_time)) {
        $event_timeError = "<span class='error'>Event time is required!</span>";
        $error = 1;
    }

    if (empty($event_address)) {
        $event_addressError = "<span class='error'>Event address is required!</span>";
        $error = 1;
    }

    if (empty($event_status)) {
        $event_statusError = "<span class='error'>Event status is required!</span>";
        $error = 1;
    }

    if ($error == 0) {
        // Update event details, excluding the image (handled separately)
        $update_event = $conn->prepare("UPDATE events SET event_title=?, event_content=?, event_detail=?, event_date=?, event_time=?, event_address=?, event_status=?, training_id=? WHERE event_id=?");
        $update_event->execute([$event_title, $event_content, $event_detail, $event_date, $event_time, $event_address, $event_status, $training_id, $get_id]);

        if (empty($event_titleError && $event_contentError && $event_detailError && $event_dateError && $event_timeError && $event_addressError && $event_statusError)) {
            $update_success = true; // Set flag to true when update is successful
        }
    }
}

if (isset($_POST['delete_image'])) {
    $empty_image = "";
    $select_image = $conn->prepare("SELECT * FROM `events` WHERE event_id=?");
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_image['event_img'] != '') {
        unlink('../images/events/' . $fetch_image['event_img']);
    }
    $unset_image = $conn->prepare("UPDATE `events` SET event_img=? WHERE event_id=?");
    $unset_image->execute([$empty_image, $get_id]);
    $message = "<span class='green'>Image deleted!</span>";
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

        <div class="content-form">
            <h2 class="heading">Update Event</h2>

            <?php
            $select_events = $conn->prepare("SELECT * FROM events WHERE event_id=?");
            $select_events->execute([$get_id]);
            if ($select_events->rowCount() > 0) {
                $fetch_event = $select_events->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Event Title <span>*</span></p>
                <input type="text" name="event_title" class="box" placeholder="Event Title"
                       maxlength="1000" class="box" value="<?php echo stripslashes($fetch_event['event_title']); ?>">
                <?php if (isset($_POST['update'])) { echo $event_titleError; } ?>

                <p class="blue">Event Content <span>*</span></p>
                <textarea  name="event_content" class="box form-control-textarea" rows="3" maxlength="10000"
                          placeholder="Event content..."><?php echo stripslashes($fetch_event['event_content']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $event_contentError; } ?>

                <p class="blue">Event Details <span>*</span></p>
                <textarea id="summernote"  name="event_detail"  class="box"  maxlength="10000"
                 ><?php echo stripslashes($fetch_event['event_detail']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $event_detailError; } ?>


                <p class="blue">Event Date <span>*</span></p>
                <input type="date" name="event_date" class="box" placeholder="Event Date"
                       maxlength="1000" class="box" value="<?php echo stripslashes($fetch_event['event_date']); ?>">
                <?php if (isset($_POST['update'])) { echo $event_dateError; } ?>

                <p class="blue">Event Time <span>*</span></p>
                <input type="time" name="event_time" class="box" placeholder="Event Time"
                       maxlength="1000" class="box" value="<?php echo stripslashes($fetch_event['event_time']); ?>">
                <?php if (isset($_POST['update'])) { echo $event_timeError; } ?>

                <p class="blue">Event Address <span>*</span></p>
                <input type="text" name="event_address" class="box" placeholder="Event Address"
                       maxlength="1000" class="box" value="<?php echo stripslashes($fetch_event['event_address']); ?>">
                <?php if (isset($_POST['update'])) { echo $event_addressError; } ?>

                <p class="blue">Event Status <span>*</span></p>
                <select name="event_status" class="box">
                    <option value="<?php echo stripslashes($fetch_event['event_status']); ?>" selected><?php echo stripslashes($fetch_event['event_status']); ?></option>
                    <option value="Past">Past</option>
                    <option value="Upcoming">Upcoming</option>
                </select>
                <?php if (isset($_POST['update'])) { echo $event_statusError; } ?>

                <!-- Training Selection Dropdown -->
                <p class="blue">Select Training <span>*</span></p>
                <select name="training_id" class="box">
                    <!-- Show the currently selected training -->
                    <option value="<?php echo $fetch_event['training_id']; ?>" selected>
                        <?php
                        // Fetch the name of the currently selected training based on the training_id
                        $current_training = $conn->prepare("SELECT training_name FROM `trainings_tb` WHERE id = ?");
                        $current_training->execute([$fetch_event['training_id']]);
                        $training = $current_training->fetch(PDO::FETCH_ASSOC);
                        echo $training ? $training['training_name'] : '--Select Training--';
                        ?>
                    </option>

                    <!-- Fetch and show all available trainings -->
                    <?php
                    $select_trainings = $conn->prepare("SELECT * FROM `trainings_tb`");
                    $select_trainings->execute();
                    if ($select_trainings->rowCount() > 0) {
                        while ($fetch_training = $select_trainings->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fetch_training['training_id'] . "'>" . $fetch_training['training_name'] . "</option>";
                        }
                    }
                    ?>
                </select>

                <p class="blue">Image</p>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <?php if ($fetch_event['event_img'] != '') { ?>
                    <img src="../images/events/<?= $fetch_event['event_img'] ?>" alt="" class="image">
                    <input type="submit" value="Delete image" name="delete_image" onclick="return confirm('Are you sure you want to delete this image?');">
                <?php } ?>
                <?php if (isset($_POST['update'])) { echo $message; } ?>

                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            } else {
                header('location:view_event.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('Event updated successfully!');
    window.location.href = 'events.php';
</script>
<?php endif; ?>


</body>
</html>
