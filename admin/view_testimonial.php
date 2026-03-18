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
    $select_image = $conn->prepare("SELECT * FROM `testimonials_tb` WHERE id=?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    
    if ($fetch_image) {
        if ($fetch_image['image'] != '') {
            unlink('../images/testimonial/'.$fetch_image['image']);
        }

        $delete_testimonial = $conn->prepare("DELETE FROM `testimonials_tb` WHERE id=?");
        $delete_testimonial->execute([$delete_id]);

        if ($delete_testimonial->rowCount() > 0) {
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
            <h2 class="heading">View Testimonial</h2>

                <?php
                    $select_testimonial = $conn->prepare("SELECT * FROM `testimonials_tb` WHERE id=?");
                    $select_testimonial->execute([$get_id]);
                    if($select_testimonial->rowCount() > 0){
                        while($fetch_testimonial = $select_testimonial->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                       
                        <?php
                            if($fetch_testimonial['image'] != ''){
                        ?>
                        <img src="../images/testimonial/<?= htmlspecialchars($fetch_testimonial['image']); ?>" alt="" class="image">
                        <?php
                             }
                        ?>

                        <div class="testimonial-name"><?= htmlspecialchars($fetch_testimonial['name']); ?></div>
                        <div class="testimonial-organization"><?= htmlspecialchars($fetch_testimonial['organization']); ?></div>
                        <div class="testimonial-title"><?= htmlspecialchars($fetch_testimonial['title']); ?></div>
                        <div class="testimonial"><?= htmlspecialchars($fetch_testimonial['testimonial']); ?></div>
                        <div class="flex-btn">
                            <a href="update_testimonial.php?id=<?= $get_id; ?>" class="edit-btn btn">Update</a>
                            <a href="testimonials.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass testimonial ID -->
                            <input type="hidden" name="testimonial_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this testimonial?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:testimonials.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('Testimonial deleted successfully!');
    window.location.href = 'testimonials.php'; // Redirect to the testimonials view page after alert
</script>
<?php endif; ?>

</body>
</html>
