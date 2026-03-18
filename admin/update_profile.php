<?php
    require('../includes/connect.php');
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_POST['update_name'])){
        $admin_name =htmlspecialchars($_POST['admin_name']);
        $admin_nameError = "";
        $user_exists = "";
        $message ="";
        $error=0;

        if(empty($admin_name)){
            $admin_nameError = "<span class='error'>Username is required!</span>";
            $error=1;
        }
        

        if($error==0){
            $select_name = $conn->prepare("SELECT * FROM `admin_tb` WHERE admin_name=?");
            $select_name->execute([$admin_name]);

            if($select_name->rowCount() > 0){
                $user_exists = "<span class='error'>Username already exists!</span>";
            }else{
                $update_name = $conn->prepare("UPDATE `admin_tb` SET admin_name=? WHERE admin_id=?");
                $update_name->execute([$admin_name,$admin_id]);
                $message = "<span class='green'>Username has been updated successfully.</span>";

            }
            

            
        }

        
    }

    if(isset($_POST['update_pass'])){
        $old_password = htmlspecialchars($_POST['old_password']);
        $new_password = htmlspecialchars($_POST['new_password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $old_passwordError = "";
        $new_passwordError = "";
        $confirm_passwordError = "";
        $message ="";
        $passwords_error = "";
        $matchingError = "";
        $error=0;

        if(empty($old_password)){
            $old_passwordError = "<span class='error'>Old password is required!</span>";
            $error=1;
        }
        if(empty($new_password)){
            $new_passwordError = "<span class='error'>New password is required!</span>";
            $error=1;
        }
        if(empty($confirm_password)){
            $confirm_passwordError = "<span class='error'>New password confirmation is required!</span>";
            $error=1;
        }

        if($error==0){
            $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
            $select_prev_pass = $conn->prepare("SELECT admin_password FROM `admin_tb` WHERE admin_id=?");
            $select_prev_pass->execute([$admin_id]);
            $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
            $prev_pass = $fetch_prev_pass['admin_password'];

            if($old_password != $prev_pass){
                $matchingError = "<span class='error'>Old password does not match!</span>";
            }else if($new_password != $confirm_password){
                $passwords_error = "<span class='error'>Confirmation not matched with new password!</span>";
            }else{
                if($new_password != $prev_pass){
                    $update_password = $conn->prepare("UPDATE `admin_tb` SET admin_password=? WHERE admin_id=?");
                    $update_password->execute([$confirm_password,$admin_id]);
                    $message = "<span class='green'>Password has been updated successfully!</span>";

                }else{
                    $message = "<span class='error'>New password should not be same as old password!</span>";
                }
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

           
            <div class="content-form">
                <h2 class="heading">Update Profile</h2>
                <form action="" method="post" enctype="multipart/form-data">
                
                    <?php if(isset($_POST['update_name'])){ echo $message;} ?>
                    <input type="text" class="box text-input" placeholder="Enter new username" maxlength="20" name="admin_name"
                    oninput="this.value = this.value.replace(/\s/g,'')">
                    <?php if(isset($_POST['update_name'])){ echo $admin_nameError;} ?>
                    <?php if(isset($_POST['update_name'])){ echo $user_exists;} ?>

                    <input type="submit" name="update_name" class="btn" value="Update Username">
                    <br><br>
                    <hr><hr><br>
                    
                    <?php if(isset($_POST['update_pass'])){ echo $message;} ?>
                    <input type="password" class="box text-input" placeholder="Enter old password" maxlength="20" name="old_password"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['update_pass'])){ echo $old_passwordError;} ?>
                    <?php if(isset($_POST['update_pass'])){ echo $matchingError;} ?>

                    <input type="password" class="box text-input" placeholder="Enter new password" maxlength="20" name="new_password"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['update_pass'])){ echo $new_passwordError;} ?>
                    
                    <input type="password" class="box text-input" placeholder="Confirm new password" maxlength="20" name="confirm_password"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['update_pass'])){ echo $confirm_passwordError;} ?>
                    <?php if(isset($_POST['update_pass'])){ echo $passwords_error;} ?>
    
                    <input type="submit" name="update_pass" class="btn" value="Update Password">
                    
                </form>
            </div>
        </section>
    </main>
</body>
</html>