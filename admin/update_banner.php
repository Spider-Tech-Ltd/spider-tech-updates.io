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
    $banner_title = $_POST['title'];
    $banner_image = $_FILES['image']['name'];

    if (!empty($banner_image)) {
        // Give random name to image
        $image_new_name = mt_rand(0, getrandmax());
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = $image_new_name . '.' . $ext;

        //$image = htmlspecialchars($_FILES['image']['name']);
        $image_size = htmlspecialchars($_FILES['image']['size']);
        $image_tmp_name = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_folder = '../images/banners/' . $image;
    }

    $error = 0;
    $banner_titleError = "";
    $banner_imageError = "";
    $message = "";

    // Validate required fields
    if (empty($banner_title)) {
        $banner_titleError .= "<span class='error'>Title is required!</span><br>";
        $error = 1;
    }
    if (empty($banner_image)) {
        $banner_imageError .= "<span class='error'>Image is required!</span><br>";
        $error = 1;
    }

    if ($error == 0) {
        $update_about = $conn->prepare("UPDATE banners_tb SET banner_title=? WHERE banner_id=?");
        $update_about->execute([$banner_title, $get_id]);

        if (!empty($image)) {
            // Fetch current image
            $select_image = $conn->prepare("SELECT banner_image FROM banners_tb WHERE banner_id=?");
            $select_image->execute([$get_id]);
            $current_image = $select_image->fetchColumn();

            // Delete the old image if it exists
            if ($current_image && file_exists('../images/banners/' . $current_image)) {
                unlink('../images/banners/' . $current_image);
            }

            if ($image_size > 2000000) {
                $message .= "<span class='error'>Image size is too large!</span><br>";
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $update_about = $conn->prepare("UPDATE banners_tb SET banner_image=? WHERE banner_id=?");
                $update_about->execute([$image, $get_id]);
            }
        }

        if (empty($banner_titleError && $banner_imageError)) {
            $update_success = true; // Set flag to true when update is successful
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

        <div class="content-form">
            <h2 class="heading">Update Page Banner</h2>

            <?php
            $select_banner = $conn->prepare("SELECT * FROM banners_tb WHERE banner_id=?");
            $select_banner->execute([$get_id]);
            if ($select_banner->rowCount() > 0) {
                $fetch_banner = $select_banner->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Title <span>*</span></p>
                <input type="text" name="title" class="box" maxlength="1000" value="<?php echo stripslashes($fetch_banner['banner_title']); ?>">
                <?php if (isset($_POST['update'])) { echo $banner_titleError; } ?>

                <p class="blue">Page Banner <span>*</span></p>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <?php if($fetch_banner['banner_image'] != ''): ?>
                    <img src="../images/banners/<?php echo stripslashes($fetch_banner['banner_image']); ?>" alt="" class="image">
                <?php endif; ?>
                <?php if (isset($_POST['update'])) { echo $banner_imageError; } ?>

                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('Page banner updated successfully!');
    window.location.href = 'banners.php'; // Redirect to the banners page after alert
</script>
<?php endif; ?>

</body>
</html>
