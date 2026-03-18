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

    $delete_training = $conn->prepare("DELETE FROM `trainings_tb` WHERE id=?");
    $delete_training->execute([$delete_id]);

        if ($delete_training->rowCount() > 0) {
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
            <h2 class="heading">View training</h2>

                <?php
                    $select_training = $conn->prepare("SELECT * FROM `trainings_tb` WHERE id=?");
                    $select_training->execute([$get_id]);
                    if($select_training->rowCount() > 0){
                        while($fetch_training = $select_training->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                       
                    <div class="training_icon"><i class="<?= $fetch_training['training_icon'];?>"></i></div>

                        <div class="training-name"><?= stripslashes($fetch_training['training_name']); ?></div>
                        <div class="training-description"><?= stripslashes($fetch_training['training_description']); ?></div>
                        <div class="training-detail"><?= stripslashes($fetch_training['training_details']); ?></div>
                        <div class="flex-btn">
                            <a href="update_training.php?id=<?= $get_id; ?>" class="edit-btn btn">Update</a>
                            <a href="trainings.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass training ID -->
                            <input type="hidden" name="training_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this training?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:trainings.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('training deleted successfully!');
    window.location.href = 'trainings.php'; // Redirect to the trainings view page after alert
</script>
<?php endif; ?>

</body>
</html>
