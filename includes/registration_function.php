<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to the registration page if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../spidertechempower.php");
    exit();
}

require('connect.php');

if (isset($_POST['send'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $email = htmlspecialchars($_POST['email']);
    $phone_no = htmlspecialchars($_POST['phone_no']);
    $age = htmlspecialchars($_POST['age']);
    //$reason = htmlspecialchars($_POST['reason']);
    $gender = htmlspecialchars($_POST['gender']);
    $business_name = htmlspecialchars($_POST['business_name']);
    if(isset($_POST['reason'])) {
        for($j = 0; $j < count($_POST['reason']) ; $j++)
        {
         $reason = $_POST['reason'];
        }
    }

    $secretKey  = "6Lfl_gsqAAAAAPUCfHlm5hVVOGFrFi2QC5jXMKwl";
    $lastnameError = "";
    $firstnameError = "";  
    $emailError = "";  
    $phone_noError = "";
    $ageError = "";
    $genderError = "";
    $reasonsError = "";
    $error_msg = "";
    $success_msg = "";
    $error = 0;

    
    if(empty($lastname))
{
	$lastnameError = '<font color="#FF0000">Last name is required!</font>';
	$error = 1;
	}

    if (empty($firstname)) {
        $firstnameError = "<font color='#FF0000'>First Name is required!</font>";
        $error = 1;
    }

    if (empty($email)) {
        $emailError = "<font color='#FF0000'>Email is required!</font>";
        $error = 1;
    }

    if(!empty($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $emailError='<font color="#FF0000">Invalid email address!</font>';
        $error = 1;
	}

    if (empty($phone_no)) {
        $phone_noError = "<font color='#FF0000'>Phone number is required!</font>";
        $error = 1;
    }

    if (!empty($phone_no) && strlen($phone_no) > 11) {
        $phone_noError = "<font color='#FF0000'>Invalid phone number!</font>";
        $error = 1;
    }

    if (empty($age)) {
        $ageError = "<font color='#FF0000'>Age is required!</font>";
        $error = 1;
    }

    if (empty($reason)) {
        $reasonsError = "<font color='#FF0000'>Reason is required!</font>";
        $error = 1;
        echo $reasonsError;
    }

    if (empty($gender)) {
        $genderError = "<font color='#FF0000'>Gender is required!</font>";
        $error = 1;
    }

    if ($error == 0) {
        if($gender == "Male")
        {
            $error_msg = "<div class='alert alert-danger'>Sorry, this bootcamp is for young women only!</div>";
            echo $error_msg;
        }
        else
        {
            if(($age < 18) || ($age > 35))
            {
                $error_msg = "<div class='alert alert-danger'>Sorry, Only young women between the age of 18 and 35 are eligible to apply!</div>";
                echo $error_msg;
            }
            else
            {
                $duplicate_email = $conn->prepare("SELECT * FROM `bootcamp_application` WHERE email = ? ");
                $duplicate_email->execute([$email]);
                if($duplicate_email->rowcount() > 0 ){
                    $error_msg = "<div class='alert alert-danger'>Warning, record found. You can't register more than once!</div>";
                    echo $error_msg;
                }
                else{

                    $duplicate_phone = $conn->prepare("SELECT * FROM `bootcamp_application` WHERE phone_no = ? ");
                    $duplicate_phone->execute([$phone_no]);
                    if($duplicate_phone->rowcount() > 0 ){
                        $error_msg = "<div class='alert alert-danger'>Warning, record found. You can't register more than once!</div>";
                        echo $error_msg;
                    }
                    else{
                        $reasons = "";
                        foreach($reason as $value)
                        {
                            $reasons.=$value.',';
                        }
                        $reason = trim($reasons,',');
                        //var_dump($reason);
                        if(!empty($_POST['g-recaptcha-response'])){  
                            // Google reCAPTCHA verification API Request  
                            $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
                            $remoteServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_URL);
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
                            if(!empty($responseData) && $responseData->success){  
                                
                                $insert_message = $conn->prepare("INSERT INTO `bootcamp_application` (lastname, firstname, middlename, email, phone_no, age, gender, business_name, reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                $insert_message->execute([$lastname, $firstname, $middlename, $email, $phone_no, $age, $gender, $business_name, $reason]);
                                $success_msg = "<div class='alert alert-success'>Success, your application has been successful. Check your email later for invitation.</div>";
                                echo $success_msg;

                            }else{ 
                                echo (!empty($api_error)?$api_error:"<div class='alert alert-danger'>The reCAPTCHA verification failed, please try again.</div>"); 
                            } 
                        }else{ 
                            echo "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>"; 
                        } 
                    }
                }
            }
        }
        
    }
}



