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
    $select_image = $conn->prepare("SELECT * FROM `projects_tb` WHERE project_id=?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    
    if ($fetch_image) {
        if ($fetch_image['project_pic'] != '') {
            unlink('../images/study-case/'.$fetch_image['project_pic']);
        }

        $delete_service = $conn->prepare("DELETE FROM `projects_tb` WHERE project_id=?");
        $delete_service->execute([$delete_id]);

        if ($delete_service->rowCount() > 0) {
            $delete_success = true;
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

        <div class="content-form read-post">
            <h2 class="heading">View Projects</h2>

                <?php
                    $select_project = $conn->prepare("SELECT * FROM projects_tb p INNER JOIN services_tb s ON  p.service_id = s.id WHERE project_id=?");
                    $select_project->execute([$get_id]);
                    if($select_project->rowCount() > 0){
                        while($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                        <?php
                            if($fetch_project['project_pic'] != ''){
                        ?>
                        <img src="../images/study-case/<?= stripcslashes($fetch_project['project_pic']); ?>" alt="" class="image">
                        <?php
                             }
                        ?>

                        <div class="service-name"><?= stripcslashes($fetch_project['project_name']); ?></div>
                        <div class="service-name"><?= stripcslashes($fetch_project['project_description']); ?></div>
                        <div class="service-description"><?= stripcslashes($fetch_project['service_name']); ?></div>
                        <div class="flex-btn">
                            <a href="update_project.php?id=<?= $get_id; ?>" class="edit-btn btn">Update</a>
                            <a href="projects.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass service ID -->
                            <input type="hidden" name="project_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this project?');" class="delete-btn btn">Delete</button>
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
