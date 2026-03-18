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

    $delete_faq = $conn->prepare("DELETE FROM `faq_tb` WHERE faq_id=?");
    $delete_faq->execute([$delete_id]);

        if ($delete_faq->rowCount() > 0) {
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
            <h2 class="heading">View faq</h2>

                <?php
                    $select_faq = $conn->prepare("SELECT * FROM `faq_tb` WHERE faq_id=?");
                    $select_faq->execute([$get_id]);
                    if($select_faq->rowCount() > 0){
                        while($fetch_faq = $select_faq->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">

                        <div class="faq_question"><?= stripslashes($fetch_faq['faq_question']); ?></div>
                        <div class="faq_answer"><?= stripslashes($fetch_faq['faq_answer']); ?></div>
                        <div class="flex-btn">
                            <a href="update_faq.php?id=<?= $get_id; ?>" class="edit-btn btn">Update</a>
                            <a href="faq.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass faq ID -->
                            <input type="hidden" name="faq_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this faq?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:faq.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('faq deleted successfully!');
    window.location.href = 'faq.php'; // Redirect to the faq view page after alert
</script>
<?php endif; ?>

</body>
</html>
