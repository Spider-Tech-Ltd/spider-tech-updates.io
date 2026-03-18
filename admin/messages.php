<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete_id'])){
        $delete_id = $_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM messages_tb WHERE message_id = :id");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        if($stmt->execute()){
            $_SESSION['message'] = "message has been deleted.";
            header('location:messages.php');
            exit();
        } else {
            $_SESSION['message'] = "Failed to delete message.";
        }
    }

    $stmt = $conn->query("SELECT * FROM messages_tb");
    

?>

<!DOCTYPE html>
<html lang="en">
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

            <div class="content">
                <h2 class="heading">Contact Page Messages</h2>

                <div class="flex-items">
                <a href="add_messages.php" class="add">Add</a>
              </div>
              
              <div class="testimonial">
              
              <?php
              if(isset($_SESSION['message'])){
              echo "<script>alert('".$_SESSION['message']."');</script>";
              unset($_SESSION['message']); // Clear the message after displaying it
              }
              ?>
              
              <table class="table">
                 <thead>
                     <th width="5%">S/N</th>
                     <th width="25%">Name</th>
                     <th width="20%">Email</th>
                     <th width="10%">Phone_no</th>
                     <th width="30%">Subject</th>
                     <th width="10%">Action</th>
                </thead>
                 <?php $s=1;
                   while($record=$stmt->fetch(PDO::FETCH_ASSOC)){
                     ?>
                     <tr>
                     <td><?php echo $s?></td>
                     <td><?php echo stripslashes($record['name'])?></td>
                     <td><?php echo stripslashes($record['email'])?></td>
                     <td><?php echo stripslashes($record['phone_no'])?></td>
                     <td><?php echo stripslashes($record['subject'])?></td>
              
                     <td>
                         <a href="view_message.php?id=<?php echo stripslashes($record['message_id'])?>"><i class="fas fa-eye icons"></i></a>
                         <a href="messages.php?delete_id=<?php echo stripslashes($record['message_id']) ?>" onclick="return confirm('Are you sure you want to delete this message?');"><i class="fas fa-trash icons"></i></a>
                     </td>
                 </tr>
                 <?php
                   $s++;
                   }
                 ?>       
                 </table>
              </div>
            </div>
    </section>
</body>
</html>