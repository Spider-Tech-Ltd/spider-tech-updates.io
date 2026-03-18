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
    $title = $_POST['title'];
    $details = $_POST['details'];

    if (!empty($_FILES['image']['name'])) {
        // Give random name to image
        $image_new_name = mt_rand(0, getrandmax());
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = $image_new_name . '.' . $ext;

        //$image = htmlspecialchars($_FILES['image']['name']);
        $image_size = htmlspecialchars($_FILES['image']['size']);
        $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_folder = '../images/timeline/' . $image;
    }

    $error = 0;
    $title_Error = "";
    $details_Error = "";
    $message = "";

    // Validate required fields
    if (empty($title)) {
        $title_Error .= "<span class='error'>Title is required!</span><br>";
        $error = 1;
    }
    if (empty($details)) {
        $details_Error .= "<span class='error'>Details are required!</span><br>";
        $error = 1;
    }

    if ($error == 0) {
        $update_about = $conn->prepare("UPDATE about_info SET title=?, details=? WHERE id=?");
        $update_about->execute([$title, $details, $get_id]);

        if (!empty($image)) {
            // Fetch current image
            $select_image = $conn->prepare("SELECT image FROM about_info WHERE id=?");
            $select_image->execute([$get_id]);
            $current_image = $select_image->fetchColumn();

            // Delete the old image if it exists
            if ($current_image && file_exists('../images/timeline/' . $current_image)) {
                unlink('../images/timeline/' . $current_image);
            }

            if ($image_size > 2000000) {
                $message .= "<span class='error'>Image size is too large!</span><br>";
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $update_about = $conn->prepare("UPDATE about_info SET image=? WHERE id=?");
                $update_about->execute([$image, $get_id]);
            }
        }

        if (empty($title_Error && $details_Error)) {
            $update_success = true; // Set flag to true when update is successful
        }
    }
}

if (isset($_POST['delete_image'])) {
    $empty_image = "";
    $select_image = $conn->prepare("SELECT image FROM `about_info` WHERE id=?");
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_image['image'] != '') {
        unlink('../images/timeline/' . $fetch_image['image']);
    }
    $unset_image = $conn->prepare("UPDATE `about_info` SET image=? WHERE id=?");
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
            <h2 class="heading">Update About</h2>

            <?php
            $about_info = $conn->prepare("SELECT * FROM about_info WHERE id=1");
            $about_info->execute();
            $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);

            $about_info2 = $conn->prepare("SELECT * FROM about_info WHERE id=2");
            $about_info2->execute();
            $fetch_about2 = $about_info2->fetch(PDO::FETCH_ASSOC);

            $about_info3 = $conn->prepare("SELECT * FROM about_info WHERE id=3");
            $about_info3->execute();
            $fetch_about3 = $about_info3->fetch(PDO::FETCH_ASSOC);

            $about_info4 = $conn->prepare("SELECT * FROM about_info WHERE id=4");
            $about_info4->execute();
            $fetch_about4 = $about_info4->fetch(PDO::FETCH_ASSOC);
  
            $about_info5 = $conn->prepare("SELECT * FROM about_info WHERE id=5");
            $about_info5->execute();
            $fetch_about5 = $about_info5->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Image</p>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <?php
                        if ($fetch_about['image'] != '') {
                     ?>
                     <img src="../images/timeline/<?= $fetch_about['image'] ?>" alt="" class="image">
                     <input type="submit" value="Delete image" name="delete_image" onclick="return confirm('Are you sure you want to delete this image?');">
                     <?php
                            }
                     ?>
                <?php if (isset($_POST['update'])) { echo $message; } ?>


                <p class="blue">Title <span>*</span></p>
                <input type="text" name="title" class="box" maxlength="1000" value="<?php echo stripslashes($fetch_about['title']); ?>">
                <?php if (isset($_POST['update'])) { echo $title_Error; } ?>

                <p class="blue">Details <span>*</span></p>
                <textarea name="details" class="box" maxlength="10000"><?php echo stripslashes($fetch_about['details']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $details_Error; } ?>

                
                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

           
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('About updated successfully!');
    window.location.href = 'about.php'; // Redirect to the about page after alert
</script>
<?php endif; ?>

</body>
</html>
