<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['subscribe'])) {
    $email = htmlspecialchars($_POST['email']);
    
    $emailError = "";  
    $success_email = "";
    $error_msg = "";
    $error = 0;
    
    if (empty($email)) {
        $emailError = "<font color='#FF0000'>Email is required!</font>";
        $error = 1;
    }
  
    if(!empty($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $emailError='<font color="#FF0000">Invalid email address!</font>';
        $error = 1;
    }
  
    if($error == 0){
        $duplicate_email = $conn->prepare("SELECT * FROM `newsletter` WHERE email = ?");
        $duplicate_email->execute([$email]);
        if($duplicate_email->rowCount() > 0){
            $error_msg = "<div class='alert alert-danger'>Warning, record found. You can't subscribe more than once!</div>";
            echo $error_msg;
        } else {
            $insert_email = $conn->prepare("INSERT INTO `newsletter` (email) VALUES (?)");
            $insert_email->execute([$email]);
            $success_email = "<div class='alert alert-success'>Thank you for subscribing!</div>";
            echo $success_email;
        }
    } else {
        echo $emailError;
    }
}
?>
