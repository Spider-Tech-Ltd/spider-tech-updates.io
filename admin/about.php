<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    $about_id = isset($_GET['about_id']) ? intval($_GET['about_id']) : 0;
    $mission_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $vision_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $value_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if(!isset($admin_id)){
        header('location:admin_login.php');
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
           
            <div class="content show-about">
              <h2 class="heading">About Us</h2>
               
              <div class="about">
         
              <?php
                $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id = 1 LIMIT 1");
                $about_info->execute();
                $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);
                 
                $mission = $conn->prepare("SELECT * FROM `about_mission` WHERE id = 1 LIMIT 1");
                $mission->execute();
                $fetch_mission = $mission->fetch(PDO::FETCH_ASSOC);

                $vision = $conn->prepare("SELECT * FROM `about_vision` WHERE id = 1 LIMIT 1");
                $vision->execute();
                $fetch_vision = $vision->fetch(PDO::FETCH_ASSOC);
                
                $value = $conn->prepare("SELECT * FROM `about_value` WHERE id = 1 LIMIT 1");
                $value->execute();
                $fetch_value = $value->fetch(PDO::FETCH_ASSOC);

              ?>

              <form action="" method="post" class="box">
                <h3>About</h3>
                
                <img src="../images/timeline/<?= $fetch_about['image'] ?>" class="about_img" alt="teamwork image">

                <div class="title"><?= stripslashes($fetch_about['title']); ?></div>
                <div class="details"><?= stripslashes($fetch_about['details']); ?></div>

                <div class="flex-btn">
                    
                    <a href="view_about.php?id=<?php echo stripslashes($fetch_about['id'])?>" class="view-button">View</a>
                </div>

              </form>
              
              <form action="" method="post" class="box">
                <h3>qMission</h3>
                <i class="<?= stripslashes($fetch_mission['icon']); ?>"></i>
                <div class="title"><?= stripslashes($fetch_mission['title']); ?></div>
                <div class="details"><?= stripslashes($fetch_mission['details']); ?></div>

                <div class="flex-btn">
                    <a href="update_mission.php?id=<?php echo stripslashes($fetch_mission['id'])?>" class="view-button">Update</a>
                    <a href="view_mission.php?id=<?php echo stripslashes($fetch_mission['id'])?>" class="view-button">View</a>
                </div>

              </form>

              <form action="" method="post" class="box">
                <h3>Vision</h3>
                <i class="<?= stripslashes($fetch_vision['icon']); ?>"></i>

                <div class="title"><?= stripslashes($fetch_vision['title']); ?></div>
                <div class="details"><?= stripslashes($fetch_vision['details']); ?></div>

                <div class="flex-btn">
                    <a href="update_vision.php?id=<?php echo stripslashes($fetch_vision['id']); ?>" class="view-button">Update</a>
                    <a href="view_vision.php?id=<?php echo stripslashes($fetch_vision['id'])?>" class="view-button">View</a>
                </div>

              </form>
              
              <form action="" method="post" class="box">
                <h3>Value</h3>
                <i class="<?= stripslashes($fetch_value['icon']); ?>"></i>

                <div class="title"><?= stripslashes($fetch_value['title']); ?></div>
                <div class="details"><?= stripslashes($fetch_value['details']); ?></div>

                <div class="flex-btn">
                    <a href="update_value.php?id=<?php echo stripslashes($fetch_value['id'])?>" class="view-button">Update</a>
                    <a href="view_value.php?id=<?php echo stripslashes($fetch_value['id'])?>" class="view-button">View</a>
                </div>

              </form>

              </div>
              
              
                          </div>        
                         
                      </section>
                </main>    
                </body>
              </html>