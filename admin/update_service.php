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
    $description = $_POST['description'];
    $detail = $_POST['detail'];
    $icon = $_POST['icon'];


    $error = 0;
    $name_Error = "";
    $description_Error = "";
    $detail_Error = "";
    $icon_Error = "";
    

    if (empty($name)) {
        $name_Error .= "<span class='error'>Service name is required!</span><br>";
        $error = 1;
    }

    if (empty($description)) {
        $description_Error .= "<span class='error'> Service description is required!</span><br>";
        $error = 1;
    }

    if (empty($detail)) {
        $detail_Error .= "<span class='error'> Service detail is required!</span><br>";
        $error = 1;
    }

    if (empty($icon)) {
        $icon_Error .= "<span class='error'> Service icon is required!</span><br>";
        $error = 1;
    }

    if ($error == 0) {
        
        $update_post = $conn->prepare("UPDATE services_tb SET service_name=?, service_description=?, service_detail=?, service_icon=? WHERE id=?");
        $update_post->execute([$name, $description, $detail, $icon, $get_id]);

        

        if (empty($name_Error && $description_Error && $detail_Error && $icon_Error)) {
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
            <h2 class="heading">Update Service</h2>

            <?php
            $select_posts = $conn->prepare("SELECT * FROM services_tb WHERE id=?");
            $select_posts->execute([$get_id]);
            if ($select_posts->rowCount() > 0) {
                $fetch_service = $select_posts->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p class="blue">Name <span>*</span></p>
                <input type="text" name="name" class="box"  maxlength="1000" value="<?php echo stripslashes($fetch_service['service_name']); ?>">
                <?php if (isset($_POST['update'])) { echo $name_Error; } ?>

                <p class="blue">Description <span>*</span></p>
                <textarea  name="description"  class="box"  maxlength="10000"
                     placeholder="service description... " ><?php echo stripslashes($fetch_service['service_description']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $description_Error; } ?>

                <p class="blue">Details <span>*</span></p>
                <textarea id="summernote" name="detail"  class="box"  maxlength="10000"
                     placeholder="service detail... " ><?php echo stripslashes($fetch_service['service_detail']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $detail_Error; } ?>


                <p class="blue">Icon</p>
                <input type="text" name="icon"  class="box" maxlength="1000" value="<?php echo stripslashes($fetch_service['service_icon']); ?>">
                <?php if (isset($_POST['update'])) { echo $icon_Error; } ?>

                
                <input type="submit" value="Update" name="update" class="darker-btn btn">
            </form>

            <?php
            } else {
                header('location:view_service.php');
                exit();
            }
            ?>
        </div>
    </section>
</main>

<?php if ($update_success): ?>
<script>
    alert('service updated successfully!');
    window.location.href = 'services.php'; // Redirect to the services view page after alert
</script>
<?php endif; ?>

</body>
</html>
