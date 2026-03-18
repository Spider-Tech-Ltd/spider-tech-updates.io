<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    $get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }
    
   
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
                <h2 class="heading">Our Value</h2>
                <div class="content-form read-post">
                  <?php
                      $about_value = $conn->prepare("SELECT * FROM `about_value` WHERE id=?");
                      $about_value->execute([$get_id]);
                      if($about_value->rowCount() > 0){
                          while($fetch_value = $about_value->fetch(PDO::FETCH_ASSOC)){
                      ?>
                       <form action="" method="post" class="box">
                             <div><i class="<?= stripslashes($fetch_value['icon']); ?>"></i></div>
                             <div class="title"><?= stripslashes($fetch_value['title']); ?></div>
                             <div class="details"><?= stripslashes($fetch_value['details']); ?></div>
                             <div class="flex-btn">
                                 <a href="update_value.php?id=<?php echo stripslashes($fetch_value['id']); ?>" class="edit-btn btn">Update</a>
                                 <a href="about.php" class="view-btn btn">Go back</a>
                             </div>
                         </form>
                      <?php
                               }
                          }
                      ?>
                  </div>
              </div>
            </div>
    </section>
</body>
</html>