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
    $name = $_POST['name'];
    $organization = $_POST['organization'];
    $title = $_POST['title'];
    $testimonial = $_POST['testimonial'];

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../images/testimonial/' . $image;

    $error = 0;
    $name_Error = "";
    $organization_Error = "";
    $title_Error = "";
    $testimonial_Error = "";

    if (empty($name)) {
        $name_Error .= "<span class='error'>Name is required!</span><br>";
        $error = 1;
    }

    if (empty($organization)) {
        $organization_Error .= "<span class='error'>Organization is required!</span><br>";
        $error = 1;
    }

    if (empty($title)) {
        $title_Error .= "<span class='error'>Title is required!</span><br>";
        $error = 1;
    }

    if (empty($testimonial)) {
        $testimonial_Error .= "<span class='error'>Testimonial is required!</span><br>";
        $error = 1;
    }

    if ($error == 0) {
        
        $update_post = $conn->prepare("UPDATE testimonials_tb SET name=?, organization=?, title=?, testimonial=? WHERE id=?");
        $update_post->execute([$name, $organization, $title, $testimonial, $get_id]);

        if ($image) {
            $select_image = $conn->prepare("SELECT * FROM testimonials_tb WHERE image=?");
            $select_image->execute([$image]);

            if ($select_image->rowCount() > 0 && $image != '') {
                $message .= "<span class='error'>Image name repeated!</span><br>";
            } elseif ($image_size > 2000000) {
                $message .= "<span class='error'>Image size is too large!</span><br>";
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $update_post = $conn->prepare("UPDATE testimonials_tb SET image=? WHERE id=?");
                $update_post->execute([$image, $get_id]);
            }
        }


        if (empty($name_Error && $organization_Error && $title_Error && $testimonial_Error)) {
            $update_success = true; // Set flag to true when update is successful
        }
    }
}

if(isset($_POST['delete_image'])){
    $empty_image = "";
    $select_image = $conn->prepare("SELECT * FROM `testimonials_tb` WHERE id=?");
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] !=''){
        unlink('../images/testimonial/'.$fetch_image['image']);
    }
    $unset_image = $conn->prepare("UPDATE `testimonials_tb` SET image=? WHERE id=?");
    $unset_image->execute([$empty_image, $get_id]);
    $message="<span class='green'>Image deleted!</span>";
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
            <h2 class="heading">Update Testimonial</h2>

            <?php
            $select_posts = $conn->prepare("SELECT * FROM testimonials_tb WHERE id=?");
            $select_posts->execute([$get_id]);
            if ($select_posts->rowCount() > 0) {
                $fetch_testimonial = $select_posts->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Name <span>*</span></p>
                <input type="text" name="name" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_testimonial['name']); ?>">
                <?php if (isset($_POST['update'])) { echo $name_Error; } ?>

                <p class="blue">Organization <span>*</span></p>
                <input type="text" name="organization" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_testimonial['organization']); ?>">
                <?php if (isset($_POST['update'])) { echo $organization_Error; } ?>

                <p class="blue">Title <span>*</span></p>
                <input type="text" name="title" class="box"  maxlength="1000" value="<?php echo htmlspecialchars($fetch_testimonial['title']); ?>">
                <?php if (isset($_POST['update'])) { echo $title_Error; } ?>

                <p class="blue">Testimonial <span>*</span></p>
                <textarea name="testimonial" class="box" maxlength="10000"><?php echo htmlspecialchars($fetch_testimonial['testimonial']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $testimonial_Error; } ?>

                <p class="blue">Image</p>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <?php
                        if($fetch_testimonial['image'] != ''){
                     ?>
                     <img src="../images/testimonial/<?= $fetch_testimonial['image'] ?>" alt="" class="image">
                     <input type="submit" value="Delete image" name="delete_image" onclick="return confirm('Are you sure you want to delete this image?');">
                     <?php
                            }
                     ?>
                <?php if (isset($_POST['update'])) { echo $message; } ?>

                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            } else {
                header('location:view_testimonial.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('Testimonial updated successfully!');
    window.location.href = 'testimonials.php'; // Redirect to the testimonials view page after alert
</script>
<?php endif; ?>

</body>
</html>
