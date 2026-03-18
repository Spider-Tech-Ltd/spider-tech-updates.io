<?php
   
  require('includes/connect.php');

  $get_id = 11;

  $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
  $contact_details->execute();
  $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

  
  $events = $conn->prepare("SELECT * FROM `events` WHERE event_id = ?");
   $events->execute([$get_id]);
   $fetch_event = $events->fetch(PDO::FETCH_ASSOC);
          

?>   

<!DOCTYPE html>
<html lang="en">

<!-- head section begin-->
<head>
<?php require('head-section.html'); ?>
</head>
<!-- head section close-->

<body>
<!-- ====== Preloader ====== -->
<?php require('includes/preloader.html'); ?>
<div class="wraper"> 
    <!-- ====== Header Starts ====== -->
    <?php require('header-section.php'); ?>
    <!-- ====== Header End ====== --> 
    <!-- ====== Banner Start ====== -->
    <section id="inner-banner" class="index-2">
        <div class="container">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="inner-heading">
                    <h2><?php echo stripslashes($fetch_event['event_title']); ?></h2>
                    <div class="separator left-align">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php" title="Home">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php" title="Events">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Event Registration</li>
                    </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Content begin ====== --> 
    <section id="about-us-inner" class="index-3">
        <div class="container">
            <h4 class="mb-4 section_heading">Registration Form</h4>
            <div class="col-lg-10 col-md-8 col-sm-6 col-xs-12 mx-auto">
                <form method="POST" action="" id="registrationForm">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="firstname" value="<?php if (isset($_POST['send']) && 
                        !empty($firstname)) { echo $firstname; } ?>" id="firstname" class="form-control" placeholder="First Name" />
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="middlename" value="<?php if (isset($_POST['send']) && !empty($middlename))
                        { echo $middlename; } ?>" id="middlename" class="form-control" placeholder="Middle Name if Any">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="lastname" value="<?php if (isset($_POST['send']) && 
                        !empty($lastname)) { echo $lastname; } ?>" id="lastname" class="form-control" placeholder="Last Name" />
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="email" value="<?php if (isset($_POST['send']) && !empty($email)) 
                        { echo $email; } ?>" id="email" class="form-control" placeholder="Email Address">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="phone" value="<?php if (isset($_POST['send']) && !empty($phone_no)) 
                        { echo $phone_no; } ?>" id="phone" class="form-control" placeholder="Phone Number">
                    </div>
                        
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="number" name="age" value="<?php if (isset($_POST['send']) && !empty($age))
                        { echo $age; } ?>" id="age" class="form-control" placeholder="Age Number">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <select name="gender" class="form-control" id="gender">
                            <option value="">Gender</option>
                            <option value="Female" <?php if (isset($_POST['send']) && !empty($gender) && $gender == 'Female') { echo "selected"; }?>>Female</option>
                            <option value="Male" <?php if (isset($_POST['send']) && !empty($gender) && $gender == 'Male') { echo "selected"; }?>>Male</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" name="business_name" value="<?php if (isset($_POST['send']) && !empty($business_name))
                        { echo $business_name; } ?>" id="business_name" class="form-control" placeholder="Business Name">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" id="business_sector" name="business_sector">
                            <option value="">Business Sector</option>
                            <option value="Fashion" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Fashion') { echo "selected"; }?>>Fashion</option>
                            <option value="Catering" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Catering') { echo "selected"; }?>>Catering</option>
                            <option value="Education" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Education') { echo "selected"; }?>>Education</option>
                            <option value="Health" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Health') { echo "selected"; }?>>Health</option>
                            <option value="Manufacturing" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Manufacturing') { echo "selected"; }?>>Manufacturing</option>
                            <option value="Retail" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Retail') { echo "selected"; }?>>Retail</option>
                            <option value="Agriculture" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Agriculture') { echo "selected"; }?>>Agriculture</option>
                            <option value="Other" <?php if (isset($_POST['send']) && !empty($business_sector) && $business_sector == 'Other') { echo "selected"; }?>>Other</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" id="registration_type" name="registration_type">
                            <option value="">Registration Type</option>
                            <option value="CAC" <?php if (isset($_POST['send']) && !empty($registration_type) && $registration_type == 'CAC') { echo "selected"; }?>>CAC</option>
                            <option value="SMEDAN" <?php if (isset($_POST['send']) && !empty($registration_type) && $registration_type == 'SMEDAN') { echo "selected"; }?>>SMEDAN</option>
                            <option value="Both" <?php if (isset($_POST['send']) && !empty($registration_type) && $registration_type == 'Both') { echo "selected"; }?>>Both</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="number" name="years" id="years" placeholder="Years of business operation?"
                        value="<?php if (isset($_POST['send']) && !empty($years)) { echo $years; } ?>" class="form-control">
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="text" class="form-control" id="business_location" placeholder="Business Address (Kano address only)"
                        name="business_location" value="<?php if (isset($_POST['send']) && !empty($business_location)) { echo $business_location; } ?>">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" id="digital_transformation" name="digital_transformation">
                            <option value="">Are you ready to digitally transform your business?</option>
                            <option value="Yes" <?php if (isset($_POST['send']) && !empty($digital_transformation) && $digital_transformation == 'CAC') { echo "selected"; }?>>Yes</option>
                            <option value="No" <?php if (isset($_POST['send']) && !empty($digital_transformation) && $digital_transformation == 'SMEDAN') { echo "selected"; }?>>No</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="g-recaptcha" data-sitekey="6Lf26gsqAAAAAEdNYT1p-Tk_T57BSgWV9ukgSuSS"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button style="background-color: #f48221; color: #fff" id="submit_registration" name="send" type="submit" class="btn">Submit Registration</button>
                    </div>
                    <div id="ajaxMessage" class="col-lg-12 col-md-6 mb10">
                        <?php if(!empty($error_msg)) { echo $error_msg; } ?>
                        <?php if(!empty($success_msg)) { echo $success_msg; } ?>
                    </div>
                </form>
                <!--
                <form name="registrationForm" id="registrationForm" class="position-relative z1000" method="post">
                    <div class="row">
                        <div id="ajaxMessage" class="col-lg-12 col-md-6 mb10">
                            <?php if(!empty($error_msg)) { echo $error_msg; } ?>
                            <?php if(!empty($success_msg)) { echo $success_msg; } ?>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="firstname" value="<?php if (isset($_POST['send']) && 
                            !empty($firstname)) { echo $firstname; } ?>" id="firstname" class="form-control" placeholder="Enter First Name" />
                            <?php if (isset($_POST['send'])) { echo $firstnameError; } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="middlename" value="<?php if (isset($_POST['send']) && !empty($middlename))
                            { echo $middlename; } ?>" id="middlename" class="form-control" placeholder="Enter Middle Name if Any">
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="lastname" value="<?php if (isset($_POST['send']) && 
                            !empty($lastname)) { echo $lastname; } ?>" id="lastname" class="form-control" placeholder="Enter Last Name" />
                            <?php if (isset($_POST['send'])) { echo $lastnameError; } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="email" value="<?php if (isset($_POST['send']) && !empty($email)) 
                            { echo $email; } ?>" id="email" class="form-control" placeholder="Enter Email">
                            <?php if (isset($_POST['send'])) { echo $emailError; } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="phone_no" value="<?php if (isset($_POST['send']) && !empty($phone_no))
                            { echo $phone_no; } ?>" id="phone" class="form-control" placeholder="Enter Phone Number">
                            <?php if (isset($_POST['send'])) { echo $phone_noError; } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <select name="gender" class="form-control" id="gender">
                                <option value="">Select gender</option>
                                <option value="Female" <?php if (isset($_POST['send']) && !empty($gender) && $gender == 'Female') { echo "selected"; }?>>Female</option>
                                <option value="Male" <?php if (isset($_POST['send']) && !empty($gender) && $gender == 'Male') { echo "selected"; }?>>Male</option>
                            </select>
                            <?php if (isset($_POST['send'])) { echo $genderError; } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="number" name="age" id="age" value="<?php if (isset($_POST['send']) && !empty($age)) { echo $age; } ?>" class="form-control" placeholder="Enter Age">
                            <?php if (isset($_POST['send'])) { echo $ageError; } ?>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="business_name" value="<?php if (isset($_POST['send']) 
                            && !empty($business_name)) { echo $business_name; } ?>" id="business_name" class="form-control" placeholder="Enter Business Name if Any">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                            <span class="d-label">Reasons For Joining</span></br>
                            <input type="checkbox" name="reason[]" value="Advertise My Business" <?php if(isset($_POST['send']) && isset($_POST['reason']) && (in_array('Advertise My Business', $_POST['reason'])) ) {echo 'checked="checked"'; }?>> Advertise My Business</br>
                            <input type="checkbox" name="reason[]" value="Advertise for Others" <?php if(isset($_POST['send']) && isset($_POST['reason']) && (in_array('Advertise for Others', $_POST['reason'])) ) {echo 'checked="checked"'; }?>> Advertise for Others</br>
                            <input type="checkbox" name="reason[]" value="Improve Sales" <?php if(isset($_POST['send']) && isset($_POST['reason']) && (in_array('Improve Sales', $_POST['reason'])) ) {echo 'checked="checked"'; }?>> Improve Sales</br>
                            <input type="checkbox" name="reason[]" value="Boost Productivity" <?php if(isset($_POST['send']) && isset($_POST['reason']) && (in_array('Boost Productivity', $_POST['reason'])) ) {echo 'checked="checked"'; }?>> Boost Productivity</br>
                            <-- Error message will display here ->
                            <label id="reason[]-error" class="error" for="reason[]"></label>
                            <?php if (isset($_POST['send'])) { echo $reasonsError; } ?>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="g-recaptcha" data-sitekey="6Lfl_gsqAAAAABRSBy90ezX53ZwoZZDScFsJieVg"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4">
                            <button style="background-color: #f48221; color: #fff" class="btn btn-md p-2 px-4" type='submit' name="send" id='send_message'>Submit</button>
                        </div>
                    </div>
                </form>
                -->
            </div> 
        </div>
    </section>
</div>         
<!-- content close -->
<!-- ====== Footer Start ====== -->
<?php require('footer-section.php'); ?>
<!-- ====== Footer End ====== --> 

<?php require('javascript-section.html'); ?>
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script type="text/javascript">
    /**
    $(document).ready(function() {
        $("#registrationForm").validate({
            rules: {
                firstname: { required: true },
                lastname: { required: true },
                email: { required: true },          
                phone_no: { required: true },
                gender: { required: true },
                age: { required: true },
                "reason[]": {
                    required: function() {
                        return $("input[name='reason[]']:checked").length == 0;
                    }
                },
            },
            messages: {
                firstname: { required: "<font color='#FF0000'>First name is required!</font>" },
                lastname: { required: "<font color='#FF0000'>Last name is required!</font>" },
                email: { required: "<font color='#FF0000'>Email is required!</font>" },
                phone_no: { required: "<font color='#FF0000'>Phone number is required!</font>" },
                gender: { required: "<font color='#FF0000'>Gender is required!</font>" },
                age: { required: "<font color='#FF0000'>Age is required!</font>" },
                "reason[]": { required: "<font color='#FF0000'>Select at least one reason!</font>" },                    
            },
            submitHandler: function(form) {
                var submitButton = $("#send_message");
                var msg = $('#ajaxMessage');

                // Disable button and show sending state
                submitButton.prop('disabled', true).html('Submitting...');

                $.ajax({
                    url: 'includes/registration_function',
                    type: 'POST',
                    dataType: 'html',
                    data: $(form).serialize(),
                    success: function(data) {    
                        alert(data);        
                        if(data == "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>")
                        {
                            // Show the success message after the "Submitting..." text has been displayed for 1.5 seconds
                            setTimeout(function() {
                                // Reset the button text
                                submitButton.prop('disabled', false).html('Submit');
                                
                                // Show the success message and hide it after 3 seconds
                                msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                                
                                // Reset the form
                                //form.reset();
                            }, 100); // Delay of 1 second
                        }
                        else
                        {
                            // Reinitialize recaptcha widget
                            grecaptcha.reset();
                            // Show the success message after the "Submitting..." text has been displayed for 1.5 seconds
                            setTimeout(function() {
                                // Reset the button text
                                submitButton.prop('disabled', false).html('Submit');
                                
                                // Show the success message and hide it after 3 seconds
                                msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                                
                                // Reset the form
                                form.reset();
                            }, 100); // Delay of 1 second
                        }
                    },
                    error: function(e) {
                        console.log("AJAX call failed. Error: " + e);
                        msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                        submitButton.prop('disabled', false).html('Submit');
                    }
                    // Reinitialize recaptcha widget
                    //grecaptcha.reset();
                });
                return false; // Prevent the default form submission
            }
        });
    });
    */
    $(document).ready(function() {
        $("#registrationForm").validate({
            rules: {
                firstname: { required: true },
                lastname: { required: true },
                email: { required: true, email: true },          
                phone: { required: true },
                gender: { required: true },
                age: { required: true, digits: true, min: 18 },
                business_name: { required: true },
                business_sector: { required: true },
                registration_type: { required: true },
                years: { required: true, min: 3 },
                business_location: { required: true },
                digital_transformation: {required: true}
            },
            messages: {
                firstname: { required: "<font color='#FF0000'>First name is required!</font>" },
                lastname: { required: "<font color='#FF0000'>Last name is required!</font>" },
                email: { required: "<font color='#FF0000'>Email is required!</font>", email: "<font color='#FF0000'>Invalid email format!</font>" },
                phone: { required: "<font color='#FF0000'>Phone number is required!</font>" },
                gender: { required: "<font color='#FF0000'>Gender is required!</font>" },
                age: { required: "<font color='#FF0000'>Age is required!</font>", digits: "<font color='#FF0000'>Only digits are allowed!</font>", min: "<font color='#FF0000'>You must be 18 and above to apply!</font>" },
                business_name: { required: "<font color='#FF0000'>Business name is required!</font>" },
                business_sector: { required: "<font color='#FF0000'>Business sector is required!</font>" },
                registration_type: { required: "<font color='#FF0000'>Business registration type is required!</font>" },
                years: { required: "<font color='#FF0000'>Years of business operation is required!</font>" },
                business_location: { required: "<font color='#FF0000'>Business location is required!</font>" },
                digital_transformation: { required: "<font color='#FF0000'>This field is required!</font>" }
            },
            submitHandler: function(form) {
                var submitButton = $("#submit_registration");
                var msg = $('#ajaxMessage');

                // Disable button and show submitting state
                submitButton.prop('disabled', true).html('Submitting...');

                $.ajax({
                    url: 'includes/submit_registration',
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(data) {        
                        if(data == "<div class='alert alert-danger'>Please check the reCAPTCHA checkbox.</div>")
                        {
                            // Show the success message after the "Submitting..." text has been displayed for 1.5 seconds
                            setTimeout(function() {
                                // Reset the button text
                                submitButton.prop('disabled', false).html('Submit');
                                
                                // Show the success message and hide it after 3 seconds
                                msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                                
                                // Reset the form
                                //form.reset();
                            }, 100); // Delay of 1 second
                        }
                        else
                        {
                            // Reinitialize recaptcha widget
                            grecaptcha.reset();
                            // Show the success message after the "Submitting..." text has been displayed for 1.5 seconds
                            setTimeout(function() {
                                // Reset the button text
                                submitButton.prop('disabled', false).html('Submit');
                                
                                // Show the success message and hide it after 3 seconds
                                msg.html(data).fadeIn().delay(5000).fadeOut("slow");
                                
                                // Reset the form
                                form.reset();
                            }, 100); // Delay of 1 second
                        }
                    },
                    error: function(e) {
                        console.log("AJAX call failed. Error: " + e);
                        msg.html('<p class="text-center text-danger">An error occurred. Please try again later.</p>').fadeIn();
                        submitButton.prop('disabled', false).html('Submit');
                    }
                });
                return false; // Prevent default form submission
            }
        });
    });
</script>
    <!-- Javascript Files
    ================================================== -->
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script src="js/recaptcha.js"></script>
</body>

</html>