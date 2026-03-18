<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete_id'])){
        $delete_id = $_GET['delete_id'];
        $stmt = $conn->prepare("DELETE FROM events WHERE event_id = :id");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        if($stmt->execute()){
            $_SESSION['message'] = "Event has been deleted.";
            header('location:events.php');
            exit();
        } else {
            $_SESSION['message'] = "Failed to delete events.";
        }
    }

    $stmt = $conn->query("SELECT * FROM events");
    

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
                <h2 class="heading">Events List</h2>

                <div class="flex-items">
                <a href="add_events.php" class="add">Add</a>
              </div>
              
              <div class="testimonial">
              
              <?php
              if(isset($_SESSION['message'])){
              echo "<script>alert('".$_SESSION['message']."');</script>";
              unset($_SESSION['message']); // Clear the message after displaying it
              }
              ?>
              
              <table class="table" id="exportTable">
                 <thead>
                     <th width="2%">S/N</th>
                     <th width="15%">Title</th>
                     <th width="25%">Content</th>
                     <th width="4%">Date</th>
                     <th width="4%">Time</th>
                     <th width="10%">Address</th>
                     <th width="5%">Status</th>
                     <th width="15%">Image</th>
                     <th width="15%">Media</th>
                     <th width="5%">Action</th>
                </thead>
                 <?php $s=1;
                   while($record=$stmt->fetch(PDO::FETCH_ASSOC)){
                     ?>
                     <tr>
                     <td><?php echo $s?></td>
                     <td><?php echo stripslashes($record['event_title'])?></td>
                     <td><?php echo stripslashes($record['event_content'])?></td>
                     <td><?php echo stripslashes($record['event_date'])?></td>
                     <td><?php echo stripslashes($record['event_time'])?></td>
                     <td><?php echo stripslashes($record['event_address'])?></td>
                     <td><?php echo stripslashes($record['event_status'])?></td>
                     <td><img src="../images/events/<?= $record['event_img'] ?>" alt="" class="image" style="max-height:140px;maxwidth:150px;"></td>
                     <td><a href="add_media.php?id=<?php echo stripslashes($record['event_id'])?>">add</a>
                         <a href="view_media.php?id=<?php echo stripslashes($record['event_id'])?>"><i class="fas fa-eye icons"></i></a>
                         <a href="update_media.php?id=<?php echo stripslashes($record['event_id'])?>">update</a>
                    </td>
                     <td>
                         <a href="view_event.php?id=<?php echo stripslashes($record['event_id'])?>"><i class="fas fa-eye icons"></i></a>
                         <a href="update_event.php?id=<?php echo stripslashes($record['event_id'])?>"><i class="fas fa-pen icons"></i></a>
                         <a href="events.php?delete_id=<?php echo stripslashes($record['event_id']) ?>" onclick="return confirm('Are you sure you want to delete this event?');"><i class="fas fa-trash icons"></i></a>
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