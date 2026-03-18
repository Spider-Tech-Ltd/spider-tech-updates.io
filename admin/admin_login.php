<?php
    require('../includes/connect.php');
    
    session_start();
    
    if(isset($_POST['login'])){
        $admin_name =htmlspecialchars($_POST['admin_name']);
        $admin_password = htmlspecialchars($_POST['admin_password']);
        $admin_nameError = "";
        $admin_passwordError = "";
        $input_error ="";
        $error=0;

        if(empty($admin_name)){
            $admin_nameError = "<span class='error'>Username is required!</span>";
            $error=1;
        }
        if(empty($admin_password)){
            $admin_passwordError = "<span class='error'>Password is required!</span>";
            $error=1;
        }

        if($error==0){
            $select_admin = $conn->prepare("SELECT * FROM `admin_tb` WHERE admin_name=? AND admin_password=?");
            $select_admin->execute([$admin_name, $admin_password]);

            if($select_admin->rowCount() > 0){
                $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
                $_SESSION['admin_id'] = $fetch_admin_id['admin_id'];
                header('location:dashboard.php'); 
            }else{
                $input_error = "<span class='error'>Incorrect username or password!</span>";
            $error = 1;
            }
            

            
        }

        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpiderTech — Precision and Speed</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
    <title>Login page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/admin_script.js" defer></script>

</head>
<body style="padding-left: 0;">
    <header class="header">
       <img src="../images/spider-tech.png" class="logo" alt=""> 
    </header>

    <section class="form-container">

        <form action="" method="post">

        <h3 class="heading">ADMIN LOGIN</h3>
        <input type="text" class="box text-input" placeholder="Enter your username" maxlength="20" name="admin_name"
        oninput="this.value = this.value.replace(/\s/g,'')">
        <?php if(isset($_POST['login'])){ echo $admin_nameError;} ?>

        <input type="password" class="box text-input" placeholder="Enter your password" maxlength="20" name="admin_password"
        oninput="this.value = this.value.replace(/\s/g,'')">
        <?php if(isset($_POST['login'])){ echo $admin_passwordError;} ?>
        <?php if(isset($_POST['login'])){ echo $input_error;} ?>

        <input type="submit" name="login" class="btn" value="Login">

        </form>
    
    </section>
</body>
</html>