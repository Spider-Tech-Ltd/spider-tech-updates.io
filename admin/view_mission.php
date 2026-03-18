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
                <h2 class="heading">Our Mission</h2>
                <div class="content-form read-post">
                  <?php
                      $about_mission = $conn->prepare("SELECT * FROM `about_mission` WHERE id=?");
                      $about_mission->execute([$get_id]);
                      if($about_mission->rowCount() > 0){
                          while($fetch_mission = $about_mission->fetch(PDO::FETCH_ASSOC)){
                      ?>
                       <form action="" method="post" class="box">
                             <div><i class="<?= stripslashes($fetch_mission['icon']); ?>"></i></div>
                             <div class="title"><?= stripslashes($fetch_mission['title']); ?></div>
                             <div class="details"><?= stripslashes($fetch_mission['details']); ?></div>
                             <div class="flex-btn">
                                 <a href="update_mission.php?id=<?php echo stripslashes($fetch_mission['id']); ?>" class="edit-btn btn">Update</a>
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