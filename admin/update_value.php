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
    $title = htmlspecialchars($_POST['title']);
    $details = htmlspecialchars($_POST['details']);
    $icon = htmlspecialchars($_POST['icon']);

    $error = 0;
    $title_Error = "";
    $details_Error = "";
    $icon_Error = "";

    // Validate required fields
    if (empty($title)) {
        $title_Error .= "<span class='error'>Title is required!</span><br>";
        $error = 1;
    }
    if (empty($details)) {
        $details_Error .= "<span class='error'>Details are required!</span><br>";
        $error = 1;
    }

    if (empty($icon)) {
        $icon_Error .= "<span class='error'>value icon is required!</span><br>";
        $error = 1;
    }

    if ($error == 0) {
        $update_value = $conn->prepare("UPDATE about_value SET title=?, details=?, icon=? WHERE id=?");
        $update_value->execute([$title, $details, $icon, $get_id]);


        if (empty($title_Error && $details_Error && $icon_Error)) {
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
            <h2 class="heading">Update Value</h2>

            <?php
            $about_value = $conn->prepare("SELECT * FROM about_value WHERE id=?");
            $about_value->execute([$get_id]);
            if ($about_value->rowCount() > 0) {
                $fetch_value = $about_value->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" enctype="multipart/form-data">

                <p class="blue">Title <span>*</span></p>
                <input type="text" name="title" class="box" maxlength="1000" value="<?php echo stripslashes($fetch_value['title']); ?>">
                <?php if (isset($_POST['update'])) { echo $title_Error; } ?>

                <p class="blue">Details <span>*</span></p>
                <textarea name="details" class="box" maxlength="10000"><?php echo stripslashes($fetch_value['details']); ?></textarea>
                <?php if (isset($_POST['update'])) { echo $details_Error; } ?>

                <p class="blue">Icon <span>*</span></p>
                <input type="text" name="icon"  class="box" maxlength="1000" value="<?php echo stripslashes($fetch_value['icon']); ?>">
                <?php if (isset($_POST['update'])) { echo $icon_Error; } ?>

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
    alert('About updated successfully!');
    window.location.href = 'about.php'; // Redirect to the about page after alert
</script>
<?php endif; ?>

</body>
</html>
