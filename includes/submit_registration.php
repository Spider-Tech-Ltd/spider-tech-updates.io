<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to the registration page if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../training_detail.php");
    exit();
}

require('connect.php');

if (isset($_POST['send'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $email = htmlspecialchars($_POST['email']);
    $phone_no = htmlspecialchars($_POST['phone']);
    $age = htmlspecialchars($_POST['age']);
    $gender = htmlspecialchars($_POST['gender']);
    $business_name = htmlspecialchars($_POST['business_name']);
    $business_sector = htmlspecialchars($_POST['business_sector']);
    $registration_type = htmlspecialchars($_POST['registration_type']);
    $years = htmlspecialchars($_POST['years']);
    $business_website = isset($_POST['business_website']) ? htmlspecialchars($_POST['business_website']) : '';
    $business_location = htmlspecialchars($_POST['business_location']);
    $digital_transformation = htmlspecialchars($_POST['digital_transformation']);


    $secretKey  = "6Lfl_gsqAAAAAPUCfHlm5hVVOGFrFi2QC5jXMKwl";
    $error_msg = "";
    $success_msg = "";
    $error = 0;


    if (empty($lastname)) {
        echo  '<font color="#FF0000">Last name is required!</font>';
    } elseif (empty($firstname)) {
        echo "<font color='#FF0000'>First Name is required!</font>";
    } elseif (empty($email)) {
        echo "<font color='#FF0000'>Email is required!</font>";
    } elseif (!empty($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        echo '<font color="#FF0000">Invalid email address!</font>';
    } elseif (empty($phone_no)) {
        echo "<font color='#FF0000'>Phone number is required!</font>";
    } elseif (!empty($phone_no) && strlen($phone_no) > 11) {
        echo "<font color='#FF0000'>Invalid phone number!</font>";
    } elseif (empty($age)) {
        echo "<font color='#FF0000'>Age is required!</font>";
    } elseif (empty($gender)) {
        echo "<font color='#FF0000'>Gender is required!</font>";
    } elseif (empty($business_name)) {
        echo "<font color='#FF0000'>Business name is required!</font>";
    } elseif (empty($business_sector)) {
        echo "<font color='#FF0000'>Business sector is required!</font>";
    } elseif (empty($registration_type)) {
        echo "<font color='#FF0000'>Registration is required!</font>";
    } elseif (empty($years)) {
        echo "<font color='#FF0000'>Years of operation is required!</font>";
    } elseif (empty($business_location)) {
        echo "<font color='#FF0000'>Business location is required!</font>";
    } elseif (empty($digital_transformation)) {
        echo "<font color='#FF0000'>This field is required!</font>";
    } else {
        if ($gender == "Male") {
            $error_msg = "<div class='alert alert-danger'>Sorry, this training is for women only!</div>";
            echo $error_msg;
        } elseif ($years === "1-2 years" || $years === "2-3 years") {
            $error_msg = "<div class='alert alert-danger'>Sorry, years of operation has to be at least 3 years!</div>";
            echo $error_msg;
        } else {
            if ($age < 18) {
                $error_msg = "<div class='alert alert-danger'>Sorry, Only women above the age of 18 are eligible to apply!</div>";
                echo $error_msg;
            } else {
                $duplicate_email = $conn->prepare("SELECT * FROM `dse_application` WHERE email = ? ");
                $duplicate_email->execute([$email]);
                if ($duplicate_email->rowcount() > 0) {
                    $error_msg = "<div class='alert alert-danger'>Warning, record found. You can't register more than once!</div>";
                    echo $error_msg;
                } else {

                    $duplicate_phone = $conn->prepare("SELECT * FROM `dse_application` WHERE phone_no = ? ");
                    $duplicate_phone->execute([$phone_no]);
                    if ($duplicate_phone->rowcount() > 0) {
                        $error_msg = "<div class='alert alert-danger'>Warning, record found. You can't register more than once!</div>";
                        echo $error_msg;
                    }

                    if (!empty($_POST['g-recaptcha-response'])) {
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
                        if (!empty($responseData) && $responseData->success) {

                            $insert_message = $conn->prepare("INSERT INTO `dse_application` (lastname, firstname, middlename, email, phone_no, age, gender, business_name, business_sector, 
                                registration_type, years, business_website, business_location, digital_transformation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $insert_message->execute([$lastname, $firstname, $middlename, $email, $phone_no, $age, $gender, $business_name, $business_sector, $registration_type, $years, $business_website, $business_location, $digital_transformation]);
                            $success_msg = "<div class='alert alert-success'>Success, your application has been successful. Check your email later for invitation.</div>";
                            echo $success_msg;
                        } else {
                            echo (!empty($api_error) ? $api_error : "<div class='alert alert-danger'>The reCAPTCHA verification failed, please try again.</div>");
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>";
                    }
                }
            }
        }
    }
}
