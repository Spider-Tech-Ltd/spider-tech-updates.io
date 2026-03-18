<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to the contact page if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $secretKey  = "6Lfl_gsqAAAAAPUCfHlm5hVVOGFrFi2QC5jXMKwl";
    $nameError = "";  
    $emailError = "";  
    $subjectError = "";
    $messageError = "";
    $success_message = "";
    $error = 0;

    if (empty($name)) {
        $nameError = "<font color='#FF0000'>Name is required!</font>";
        $error = 1;
    }

    if (empty($email)) {
        $emailError = "<font color='#FF0000'>Email is required!</font>";
        $error = 1;
    }

    if(!empty($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $emailError = '<font color="#FF0000">Invalid email address!</font>';
        $error = 1;
    }


    if (empty($subject)) {
        $subjectError = "<font color='#FF0000'>Subject is required!</font>";
        $error = 1;
    }

    if (empty($message)) {
        $messageError = "<font color='#FF0000'>Message is required!</font>";
        $error = 1;
    }

    if($error == 0){
        if(!empty($_POST['g-recaptcha-response'])){  
            // Google reCAPTCHA verification API Request  
            $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
            $resq_data = array(  
                'secret' => $secretKey,  
                'response' => $_POST['g-recaptcha-response'],  
                'remoteip' => $_SERVER['REMOTE_ADDR'] 
            );  
             
            // Initialize cURL request 
            $curlConfig = array(  
                CURLOPT_URL => $api_url,  
                CURLOPT_POST => true,  
                CURLOPT_RETURNTRANSFER => true,  
                CURLOPT_POSTFIELDS => $resq_data,  
                CURLOPT_SSL_VERIFYPEER => false  
            );  
  
            $ch = curl_init();  
            curl_setopt_array($ch, $curlConfig);  
            $response = curl_exec($ch);  
            if (curl_errno($ch)) {  
                $api_error = curl_error($ch);  
            }  
            curl_close($ch);  
           
            // Decode JSON data of API response in array  
            $responseData = json_decode($response);  
           
            // If the reCAPTCHA API response is valid  
            if(!empty($responseData) && $responseData->success){ $insert_message = $conn->prepare("INSERT INTO `messages_tb` (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $insert_message->execute([$name, $email, $subject, $message]);
                if ($insert_message) {
                    echo "<div class='alert alert-success'>Success, your message has been sent successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error, your message could not be sent.</div>";
                }
            }else{ 
                echo (!empty($api_error)?$api_error:"<div class='alert alert-danger'>The reCAPTCHA verification failed, please try again.</div>"); 
            } 
        }else{ 
            echo "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>"; 
        }
    } else {
        echo $nameError . $emailError . $subjectError . $messageError;
    }
}
?>
