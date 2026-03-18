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

    $delete_service = $conn->prepare("DELETE FROM `services_tb` WHERE id=?");
    $delete_service->execute([$delete_id]);

        if ($delete_service->rowCount() > 0) {
            $delete_success = true;
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
            <h2 class="heading">View service</h2>

                <?php
                    $select_service = $conn->prepare("SELECT * FROM `services_tb` WHERE id=?");
                    $select_service->execute([$get_id]);
                    if($select_service->rowCount() > 0){
                        while($fetch_service = $select_service->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                       
                    <div class="service_icon"><i class="<?= $fetch_service['service_icon'];?>"></i></div>

                        <div class="service-name"><?= stripslashes($fetch_service['service_name']); ?></div>
                        <div class="service-description"><?= stripslashes($fetch_service['service_description']); ?></div>
                        <div class="service-detail"><?= stripslashes($fetch_service['service_detail']); ?></div>
                        <div class="flex-btn">
                            <a href="update_service.php?id=<?= $get_id; ?>" class="edit-btn btn">Update</a>
                            <a href="services.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass service ID -->
                            <input type="hidden" name="service_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this service?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:services.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('Service deleted successfully!');
    window.location.href = 'services.php'; // Redirect to the services view page after alert
</script>
<?php endif; ?>

</body>
</html>
