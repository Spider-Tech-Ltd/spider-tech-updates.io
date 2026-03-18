<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete_id'])){
        $delete_id = $_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM faqs_tb WHERE id = :id");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        if($stmt->execute()){
            $_SESSION['message'] = "faq has been deleted.";
            header('location:faq.php');
            exit();
        } else {
            $_SESSION['message'] = "Failed to delete faq.";
        }
    }

    $stmt = $conn->query("SELECT * FROM faq_tb");
    

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
                <h2 class="heading">FAQs</h2>

                <div class="flex-items">
                <a href="add_faq.php" class="add">Add</a>
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
                     <th width="35%">Question</th>
                     <th width="55%">Answer</th>
                     <th width="5%">Action</th>
                </thead>
                 <?php $s=1;
                   while($record=$stmt->fetch(PDO::FETCH_ASSOC)){
                     ?>
                     <tr>
                     <td><?php echo $s?></td>
                     <td><?php echo stripslashes($record['faq_question'])?></td>
                     <td><?php echo stripslashes($record['faq_answer'])?></td>
              
                     <td>
                         <a href="view_faq.php?id=<?php echo stripslashes($record['faq_id'])?>"><i class="fas fa-eye icons"></i></a>
                         <a href="update_faq.php?id=<?php echo stripslashes($record['faq_id'])?>"><i class="fas fa-pen icons"></i></a>
                         <a href="faq.php?delete_id=<?php echo stripslashes($record['faq_id']) ?>" onclick="return confirm('Are you sure you want to delete this faq?');"><i class="fas fa-trash icons"></i></a>
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