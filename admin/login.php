<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="Responsive Admin Template" />
	<meta name="author" content="RedstarHospital" />
	<title>Spider Tech | ADMIN</title>
	<!-- google font -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
		type="text/css" />
	<!-- icons -->
	<link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="assets/plugins/iconic/css/material-design-iconic-font.min.css">
	<!-- bootstrap -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- style -->
	<link rel="stylesheet" href="assets/css/pages/extra_pages.css">
	<!-- favicon -->
	<link rel="shortcut icon" href="assets/img/favicon.ico" />
</head>

<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<form class="login100-form" id="login_form" name="login_form" method="POST">
					<span class="login100-form-logo">
						<img alt="" src="../assets/img/testimonials.png">
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<div id="ajaxMessage" style="display:none;"></div>
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" id="uname" name="uname" placeholder="Username">
						
					</div>
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="password" id="pword" name="pword" placeholder="Password">
						
					</div>
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" id="submit_login" name="submit_login">
							Login
						</button>
					</div>
					<div class="text-center p-t-30">
						<a class="txt1" href="forgot_password.html">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- start js include path -->
	<script src="assets/plugins/jquery/jquery.min.js"></script>
	<script src="assets/js/jquery-validate.js"></script>
	<!-- bootstrap -->
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/pages/extra-pages/pages.js"></script>
	<!-- end js include path -->

	<script type="text/javascript">
            $(document).ready(function() {
                $("#login_form").validate({
                    rules:{
                        uname: {
                        required: true
                        },
                        pword: {
                        required: true
                    },   
                },
                    messages: {
                        uname: {
                        required: "<font color='red'>Username is required</font>",
                    },
                        pword: {
                        required: "<font color='red'>Password is required</font>",
                    },    
                },
            submitHandler: function(form) {
				var form = $("#login_form"); // contact form
				var submitButton = $("#submit_login");  // submit button
				var message = $('#ajaxMessage'); // alert div for show alert message
				$.ajax({
					url: 'login_function.php', // form action url
					type: 'POST', // form submit method get/post
					dataType: 'html', // request type html/json/xml
					data: $("#login_form").serialize(), // serialize form data
					beforeSend: function() {
					message.fadeOut();
					$("#loader").show();
					/*submitButton.html('Saving....'); */// change submit button text
					},
					success: function(data) {
						$('#ajaxMessage').fadeIn().html(data);
						/*alert("Record Saved. Click next to continue");*/
						setTimeout(function() {
						$(message);
						form.trigger('reset'); // reset form
						submitButton.html('Login'); // reset submit button text
						$("#loader").hide();
						
						});
						
					},
					error: function(e) {
						alert('error occurred')
					}
				});      
            }// end submit handler
        });              
        });
          </script>
</body>

</html>