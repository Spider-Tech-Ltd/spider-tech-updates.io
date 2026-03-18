<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }
    
    if(isset($_POST['delete'])){
        $delete_admin = $conn->prepare("DELETE FROM `admin_tb` WHERE admin_id=?");
        $delete_admin->execute([$admin_id]);
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

            <div class="accounts content">

                <h2 class="heading">Admin Accounts</h2>

                <div class="box-container">

                    <div class="box" style="order: -2;">
                        <p>Register new admin</p>
                        <a href="register_admin.php" class="btn">register now</a>
                    </div>

                    <?php
                       $select_account = $conn->prepare("SELECT * FROM `admin_tb`");
                       $select_account->execute();
                       if($select_account->rowCount() > 0){
                          while($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
                            
                    ?>
                    <div class="box" style="<?php if($fetch_account['admin_id'] == $admin_id ){
                        echo 'order: -1;';
                    }?>">
                        <p>id : <span><?= $fetch_account['admin_id']; ?></span></p>
                        <p>Adminname : <span><?= $fetch_account['admin_name']; ?></span></p>
                        <?php
                           if($fetch_account['admin_id'] == $admin_id ){

                           
                        ?>
                          <div class="flex-btn">
                              <a href="update_profile.php" class="btn">Update</a>
                              <form action="" method="post">
                                <button type="submit" class="delete-btn btn" onclick="return confirm('delete the account?')"
                                 name="delete" >Delete</button>
                              </form>
                          </div>
                        <?php
                          }
                        ?>
                    </div>

                    <?php
                       }
                    }else{
                       echo '<p class="empty">No accounts found!</p>';
                    }
                    ?>
                </div>
            </div>
    </section>
</body>
</html>