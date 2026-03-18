<?php
    require('../includes/connect.php');
    
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }
    
    if(isset($_POST['register'])){
        $admin_name =htmlspecialchars($_POST['admin_name']);
        $admin_password = htmlspecialchars($_POST['admin_password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $admin_nameError = "";
        $admin_passwordError = "";
        $confirm_passwordError = "";
        $user_exists = "";
        $message ="";
        $passwords_error = "";
        $error=0;

        if(empty($admin_name)){
            $admin_nameError = "<span class='error'>Username is required!</span>";
            $error=1;
        }
        if(empty($admin_password)){
            $admin_passwordError = "<span class='error'>Password is required!</span>";
            $error=1;
        }
        if(empty($confirm_password)){
            $confirm_passwordError = "<span class='error'>Password confirmation is required!</span>";
            $error=1;
        }

        if($error==0){
            $select_admin = $conn->prepare("SELECT * FROM `admin_tb` WHERE admin_name=?");
            $select_admin->execute([$admin_name]);

            if($select_admin->rowCount() > 0){
                $user_exists = "<span class='error'>Username already exists!</span>";
                /*header('location:dashboard.php'); */
            }else{
                if($admin_password != $confirm_password){
                    $passwords_error = "<span class='error'>Passwords do not match!</span>";
                }else{
                    $insert_admin=$conn->prepare("INSERT INTO `admin_tb` (admin_name,admin_password) VALUES (?,?)");
                    $insert_admin->execute([$admin_name,$admin_password]);
                    $message = "<span class='green'>New admin registered</span>";
                }
            }
            

            
        }

        
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
                <div class="content-form">
                <form action="" method="post">

                    <h3 class="heading">REGISTER ADMIN</h3>
                    <?php if(isset($_POST['register'])){ echo $message;} ?>
                    <input type="text" class="box text-input" placeholder="Enter username" maxlength="20" name="admin_name"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['register'])){ echo $admin_nameError;} ?>
                    <?php if(isset($_POST['register'])){ echo $user_exists;} ?>
                    
                    <input type="password" class="box text-input" placeholder="Enter password" maxlength="20" name="admin_password"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['register'])){ echo $admin_passwordError;} ?>
                    
                    <input type="password" class="box text-input" placeholder="Confirm password" maxlength="20" name="confirm_password"
                    oninput="this.value = this.value.replace(/\s/g,'')"><br>
                    <?php if(isset($_POST['register'])){ echo $confirm_passwordError;} ?>
                    <?php if(isset($_POST['register'])){ echo $passwords_error;} ?>
                    
                    <input type="submit" name="register" class="btn" value="Register">
                    
                </form>
                </div>
               
            </div>
    </section>
</body>
</html>