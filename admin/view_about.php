<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    $get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }
    
    $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id = 1 LIMIT 1");
    $about_info->execute();
    $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);
    $image = stripslashes($fetch_about['image']);

    $about_info2 = $conn->prepare("SELECT * FROM about_info WHERE id=2");
    $about_info2->execute();
    $fetch_about2 = $about_info2->fetch(PDO::FETCH_ASSOC);

    $about_info3 = $conn->prepare("SELECT * FROM about_info WHERE id=3");
    $about_info3->execute();
    $fetch_about3 = $about_info3->fetch(PDO::FETCH_ASSOC);

    $about_info4 = $conn->prepare("SELECT * FROM about_info WHERE id=4");
    $about_info4->execute();
    $fetch_about4 = $about_info4->fetch(PDO::FETCH_ASSOC);

    $about_info5 = $conn->prepare("SELECT * FROM about_info WHERE id=5");
    $about_info5->execute();
    $fetch_about5 = $about_info5->fetch(PDO::FETCH_ASSOC);
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
                <h2 class="heading">Who We Are</h2>
                <div class="content-form read-post" id="about">
                  <?php
                      $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id=?");
                      $about_info->execute([$get_id]);
                      if($about_info->rowCount() > 0){
                          while($fetch_about = $about_info->fetch(PDO::FETCH_ASSOC)){
                      ?>
                       <form action="" method="post" class="box">
                         
                         <div class="slideshow-box">
                            <?php if ($image) { ?>
                               <div class="slides fade">
                                   <img src="../images/timeline/<?= stripslashes($fetch_about['image']); ?>" alt="about image 1">
                               </div>
                           <?php } ?>
                           
                        
                             <div class="title"><?= stripslashes($fetch_about['title']); ?></div>
                             <div class="details"><?= stripslashes($fetch_about['details']); ?></div>
                             <div class="flex-btn">
                                 <a href="update_about.php?id=<?php echo stripslashes($fetch_about['id']); ?>" class="view-button">Update</a>
                             </div>

                             <div>
                                <div class="title"><?= stripslashes($fetch_about2['title']); ?></div>
                                <div class="details"><?= stripslashes($fetch_about2['details']); ?></div>
                                <a href="update_info.php?id=<?php echo stripslashes($fetch_about2['id']); ?>" class="view-button">Update</a>
                             </div>

                             <div>
                                <div class="title"><?= stripslashes($fetch_about3['title']); ?></div>
                                <div class="details"><?= stripslashes($fetch_about3['details']); ?></div>
                                <a href="update_info.php?id=<?php echo stripslashes($fetch_about3['id']); ?>" class="view-button">Update</a>
                             </div>

                             <div>
                                <div class="title"><?= stripslashes($fetch_about4['title']); ?></div>
                                <div class="details"><?= stripslashes($fetch_about4['details']); ?></div>
                                <a href="update_info.php?id=<?php echo stripslashes($fetch_about4['id']); ?>" class="view-button">Update</a>
                             </div>
                             <div>
                                <div class="title"><?= stripslashes($fetch_about5['title']); ?></div>
                                <div class="details"><?= stripslashes($fetch_about5['details']); ?></div>
                                <a href="update_info.php?id=<?php echo stripslashes($fetch_about5['id']); ?>" class="view-button">Update</a>
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