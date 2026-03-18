<?php 
require('../includes/connect.php');
    
session_start();

$admin_id = $_SESSION['admin_id'];

$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['save'])){
    
    $image_Error = "";
    $success_msg = "";
    $message = "";

if (isset($_POST['save'])) {
    // Check if an image is selected
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
            $select_image = $conn->prepare("SELECT * FROM `events_media` WHERE event_pics_name = ? AND event_id = ?");
            $select_image->execute([$image, $get_id]);

            if ($select_image->rowCount() > 0) {
                $message = "<span class='error'>Image name repeated!</span>";
            } else {
                // Insert the image data along with event_id into the events_media table
                $insert_event = $conn->prepare("INSERT INTO `events_media` (event_id, event_pics_name) VALUES (?, ?)");
                $insert_event->execute([$get_id, $image]);

                if ($insert_event->rowCount() > 0) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $success_msg = "<div class='alert alert-success'>Success, image sent successfully.</div>";
                } else {
                    $message = "<span class='error'>Failed to insert image into the database!</span>";
                }
            }
        }
    }
}
}

    $stmt = $conn->query("SELECT * FROM events");
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

            <div class="content">
            <div class="col-lg-12 col-md-6 mb10">
                 <?php if(!empty($success_msg)) { echo $success_msg; } ?>
              </div>
                <h2 class="heading">Add Media</h2>
                <div class="flex-items">
                    <a href="events.php" class="add">Back to List</a>
                </div>
            </div>
            <div class="content-form">
                
                <form action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="name" value="<?= $record['event_id']; ?>" />
                    <p class="blue"><?php echo stripslashes($record['event_title']); ?></p>
                    <br><hr>

                     <p class="blue">Image</p>
                     <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, 
                     image/webp" class="box">
                    <?php if(isset($_POST['save'])){ echo $image_Error;} ?>

                    <input type="submit" value="Save" name="save" class="darker-btn btn">

                </form>
            </div>
	
        </section>
    </main>
</body>

</html>