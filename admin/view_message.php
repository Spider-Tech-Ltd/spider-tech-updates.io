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

    $delete_message = $conn->prepare("DELETE FROM `messages_tb` WHERE message_id=?");
    $delete_message->execute([$delete_id]);

        if ($delete_message->rowCount() > 0) {
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
            <h2 class="heading">View message</h2>

                <?php
                    $select_message = $conn->prepare("SELECT * FROM `messages_tb` WHERE message_id=?");
                    $select_message->execute([$get_id]);
                    if($select_message->rowCount() > 0){
                        while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="box">
                       
                        <div>Name: <?php echo stripslashes($fetch_message['name']); ?></div><br>
                        <div>Email: <?php echo stripslashes($fetch_message['email']); ?></div><br>
                        <div>Phone number: <?php echo stripslashes($fetch_message['phone_no']); ?></div><br>
                        <div>Subject: <?php echo stripslashes($fetch_message['subject']); ?></div><br>
                        <div>Message: <?php echo stripslashes($fetch_message['message']); ?></div><br>
                        <div class="flex-btn">
                            <a href="messages.php" class="view-btn btn">Go back</a>
                            <!-- Hidden input to pass message ID -->
                            <input type="hidden" name="message_id" value="<?= $get_id; ?>"> 
                            <button type="submit" name="delete" onclick="return confirm('Delete this message?');" class="delete-btn btn">Delete</button>
                        </div>
                    </form>

                    <?php
                             }
                        }else{
                            header('location:messages.php');
                    }
                    ?>
 
            </div>
    </section>
</main>

<?php if ($delete_success): ?>
<script>
    alert('Message deleted successfully!');
    //window.location.href = 'messages.php'; // Redirect to the messages view page after alert
</script>
<?php endif; ?>

</body>
</html>
