<?php
require('../includes/connect.php');

session_start();
$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

$image_Error = "";
$success_msg = "";
$message = "";

// Handle update functionality
if (isset($_POST['update'])) {
    $media_id = intval($_POST['media_id']);

    if (empty($_FILES['image']['name'])) {
        $image_Error = "<span class='error'>Image is required!</span>";
    } else {
        $image_new_name = mt_rand(0, getrandmax());
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = $image_new_name . '.' . $ext;

        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../images/events/' . $image;

        if ($image_size > 2000000) {
            $message = "<span class='error'>Image size is too large!</span>";
        } else {
            $select_image = $conn->prepare("SELECT event_pics_name FROM `events_media` WHERE event_pics_id = ?");
            $select_image->execute([$media_id]);
            $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);

            if ($fetch_image) {
                $old_image_path = '../images/events/' . $fetch_image['event_pics_name'];

                $update_event = $conn->prepare("UPDATE `events_media` SET event_pics_name=? WHERE event_pics_id=?");
                $update_event->execute([$image, $media_id]);

                if ($update_event->rowCount() > 0) {
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $success_msg = "<div class='alert alert-success'>Success, image updated successfully.</div>";
                } else {
                    $message = "<span class='error'>Failed to update image in the database!</span>";
                }
            }
        }
    }
}

// Handle delete functionality
if (isset($_POST['delete'])) {
    $media_id = intval($_POST['media_id']);

    // Select the image to delete it from the folder
    $select_image = $conn->prepare("SELECT event_pics_name FROM events_media WHERE event_pics_id=?");
    $select_image->execute([$media_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_image) {
        $image_path = '../images/events/' . $fetch_image['event_pics_name'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the image data from the events_media table
        $delete_image = $conn->prepare("DELETE FROM events_media WHERE event_pics_id=?");
        $delete_image->execute([$media_id]);

        if ($delete_image->rowCount() > 0) {
            $success_msg = "<div class='alert alert-success'>Success, image deleted successfully.</div>";
        } else {
            $message = "<span class='error'>Failed to delete image from the database!</span>";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM events WHERE event_id =?");
$stmt->execute([$get_id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
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

            <div class="content show-about">
                <div class="col-lg-12 col-md-6 mb10">
                    <?php if (!empty($success_msg)) { echo $success_msg; } ?>
                    <?php if (!empty($message)) { echo $message; } ?>
                </div>
                <h2 class="heading"><span>Update Media: </span><?php echo stripslashes($record['event_title']); ?></h2>
                
                <div class="about">
                    <?php 
                    $select_media = $conn->prepare("SELECT * FROM events_media WHERE event_id=?");
                    $select_media->execute([$get_id]);
                    while ($fetch_media = $select_media->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    
                    <form action="" class="box" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="media_id" value="<?= htmlspecialchars($fetch_media['event_pics_id']); ?>">
                    
                        <p class="blue">Image</p>
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
                        <?php if ($fetch_media['event_pics_name'] != '') { ?>
                            <img src="../images/events/<?= htmlspecialchars($fetch_media['event_pics_name']); ?>" alt="" class="about_img">
                        <?php } ?>

                        <?php if (isset($_POST['update']) && intval($_POST['media_id']) == $fetch_media['event_pics_id']) { echo $image_Error; } ?>

                        <input type="submit" value="Update" name="update" class="darker-btn btn">
                        <input type="submit" value="Delete" name="delete" class="darker-btn btn" onclick="return confirm('Are you sure you want to delete this image?');">
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    
    
</body>
</html>
