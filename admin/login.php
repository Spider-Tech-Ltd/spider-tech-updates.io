<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="Spider Tech Admin Console Login" />
	<meta name="author" content="Spider Tech Limited" />
	<title>Sign In &mdash; Spider Tech Admin Console</title>
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Open+Sans:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
	<!-- Icons -->
	<link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="fonts/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<!-- Bootstrap -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Favicon -->
	<link rel="shortcut icon" href="../images/spider-icon.png" />

	<style>
		:root {
			--primary-orange: #f48221;
			--primary-hover: #e07216;
			--dark-bg: #0b0f19;
			--card-bg: #111827;
			--border-color: rgba(255, 255, 255, 0.08);
			--text-muted: #94a3b8;
		}

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'Open Sans', sans-serif;
			background-color: var(--dark-bg);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #ffffff;
			position: relative;
			overflow-x: hidden;
			background-image: 
				radial-gradient(circle at 85% 15%, rgba(244, 130, 33, 0.12) 0%, transparent 45%),
				radial-gradient(circle at 15% 85%, rgba(244, 130, 33, 0.06) 0%, transparent 40%),
				linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
				linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
			background-size: 100% 100%, 100% 100%, 36px 36px, 36px 36px;
			padding: 24px;
		}

		.login-container {
			width: 100%;
			max-width: 440px;
			z-index: 10;
		}

		.login-card {
			background: var(--card-bg);
			border: 1px solid var(--border-color);
			border-radius: 20px;
			padding: 42px 38px;
			box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45), 0 0 1px 1px rgba(255, 255, 255, 0.05);
			backdrop-filter: blur(12px);
		}

		.login-brand {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 12px;
			margin-bottom: 24px;
			text-decoration: none;
		}

		.login-brand img {
			width: 42px;
			height: 42px;
			object-fit: contain;
		}

		.login-brand-text {
			font-family: 'Poppins', sans-serif;
			font-weight: 700;
			font-size: 1.35rem;
			color: #ffffff;
			letter-spacing: -0.4px;
			line-height: 1;
		}

		.login-brand-text span {
			color: var(--primary-orange);
		}

		.login-badge {
			display: inline-block;
			background: rgba(244, 130, 33, 0.15);
			color: var(--primary-orange);
			border: 1px solid rgba(244, 130, 33, 0.3);
			font-family: 'Chakra Petch', monospace;
			font-size: 0.65rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1.2px;
			padding: 2px 7px;
			border-radius: 4px;
			margin-left: 6px;
			vertical-align: middle;
		}

		.login-header {
			text-align: center;
			margin-bottom: 28px;
		}

		.login-header h2 {
			font-family: 'Poppins', sans-serif;
			font-weight: 600;
			font-size: 1.15rem;
			color: #f1f5f9;
			margin-bottom: 6px;
		}

		.login-header p {
			font-size: 0.85rem;
			color: var(--text-muted);
			line-height: 1.5;
		}

		.form-group-custom {
			margin-bottom: 20px;
			position: relative;
		}

		.form-label-custom {
			display: block;
			font-family: 'Poppins', sans-serif;
			font-size: 0.8rem;
			font-weight: 500;
			color: #cbd5e1;
			margin-bottom: 7px;
		}

		.input-wrap {
			position: relative;
			display: flex;
			align-items: center;
		}

		.input-icon {
			position: absolute;
			left: 15px;
			color: #64748b;
			font-size: 14px;
			pointer-events: none;
			transition: color 0.2s ease;
		}

		.input-custom {
			width: 100%;
			height: 48px;
			background: rgba(15, 23, 42, 0.6);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 10px;
			padding: 0 42px 0 42px;
			font-family: 'Open Sans', sans-serif;
			font-size: 0.92rem;
			color: #ffffff;
			outline: none;
			transition: all 0.2s ease;
		}

		.input-custom::placeholder {
			color: #64748b;
			font-size: 0.88rem;
		}

		.input-custom:hover {
			border-color: rgba(255, 255, 255, 0.2);
		}

		.input-custom:focus {
			border-color: var(--primary-orange);
			background: rgba(15, 23, 42, 0.85);
			box-shadow: 0 0 0 3.5px rgba(244, 130, 33, 0.16);
		}

		.input-custom:focus + .input-icon,
		.input-wrap:focus-within .input-icon {
			color: var(--primary-orange);
		}

		.password-toggle-btn {
			position: absolute;
			right: 12px;
			background: transparent;
			border: none;
			color: #64748b;
			font-size: 14px;
			cursor: pointer;
			padding: 6px;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: color 0.2s ease;
		}

		.password-toggle-btn:hover {
			color: var(--primary-orange);
		}

		.btn-signin {
			width: 100%;
			height: 48px;
			background: var(--primary-orange);
			border: none;
			border-radius: 50px;
			font-family: 'Poppins', sans-serif;
			font-weight: 600;
			font-size: 0.92rem;
			color: #ffffff;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			box-shadow: 0 4px 14px rgba(244, 130, 33, 0.3);
			transition: all 0.2s ease;
			margin-top: 10px;
		}

		.btn-signin:hover {
			background: var(--primary-hover);
			transform: translateY(-1px);
			box-shadow: 0 6px 18px rgba(244, 130, 33, 0.4);
		}

		.btn-signin:active {
			transform: translateY(0);
		}

		.login-notice {
			margin-top: 24px;
			padding-top: 20px;
			border-top: 1px solid rgba(255, 255, 255, 0.06);
			text-align: center;
			font-size: 0.74rem;
			color: #64748b;
			line-height: 1.5;
		}

		.back-to-site {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 6px;
			margin-top: 22px;
			font-family: 'Poppins', sans-serif;
			font-size: 0.82rem;
			font-weight: 500;
			color: var(--text-muted);
			text-decoration: none;
			transition: color 0.2s ease;
		}

		.back-to-site:hover {
			color: var(--primary-orange);
			text-decoration: none;
		}

		.back-to-site i {
			font-size: 0.75rem;
		}

		/* Ajax Message Banner */
		#ajaxMessage .alert {
			border-radius: 10px;
			padding: 10px 14px;
			font-size: 0.84rem;
			margin-bottom: 20px;
			border: 1px solid rgba(239, 68, 68, 0.3);
			background-color: rgba(239, 68, 68, 0.12);
			color: #fca5a5;
		}

		.error {
			color: #f87171;
			font-size: 0.75rem;
			margin-top: 5px;
			display: block;
		}
	</style>
</head>

<body>
	<div class="login-container">
		<div class="login-card">
			<a href="../" class="login-brand" title="Spider Tech">
				<img src="../images/spider-icon.png" alt="Spider Tech">
				<div class="login-brand-text">
					Spider<span>Tech</span>
					<span class="login-badge">Admin</span>
				</div>
			</a>

			<div class="login-header">
				<h2>Administrative Console</h2>
				<p>Sign in to manage projects, services, trainings, events, and platform settings.</p>
			</div>

			<div id="ajaxMessage"></div>

			<form id="login_form" method="POST">
				<div class="form-group-custom">
					<label class="form-label-custom" for="uname">Username</label>
					<div class="input-wrap">
						<i class="icon-user input-icon"></i>
						<input class="input-custom" type="text" id="uname" name="uname" placeholder="Enter admin username" autocomplete="username" required autofocus>
					</div>
				</div>

				<div class="form-group-custom">
					<label class="form-label-custom" for="pword">Password</label>
					<div class="input-wrap">
						<i class="icon-lock input-icon"></i>
						<input class="input-custom" type="password" id="pword" name="pword" placeholder="Enter admin password" autocomplete="current-password" required>
						<button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Show or hide password">
							<i class="fa fa-eye" id="passwordIcon"></i>
						</button>
					</div>
				</div>

				<button type="submit" class="btn-signin" id="submit_login" name="submit_login">
					<span>Sign In to Console</span>
					<i class="fa fa-arrow-right"></i>
				</button>
			</form>

			<div class="login-notice">
				<i class="fa fa-shield"></i> Authorized personnel only. All access attempts are logged and monitored.
			</div>
		</div>

		<a href="../" class="back-to-site">
			<i class="fa fa-arrow-left"></i>
			<span>Back to Spider Tech Website</span>
		</a>
	</div>

	<!-- Core Scripts -->
	<script src="assets/plugins/jquery/jquery.min.js"></script>
	<script src="assets/js/jquery-validate.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			// Password visibility toggle
			$('#togglePasswordBtn').on('click', function() {
				var pwordInput = $('#pword');
				var icon = $('#passwordIcon');
				if (pwordInput.attr('type') === 'password') {
					pwordInput.attr('type', 'text');
					icon.removeClass('fa-eye').addClass('fa-eye-slash');
				} else {
					pwordInput.attr('type', 'password');
					icon.removeClass('fa-eye-slash').addClass('fa-eye');
				}
			});

			// Validation & AJAX Submission
			$("#login_form").validate({
				rules: {
					uname: { required: true },
					pword: { required: true }
				},
				messages: {
					uname: { required: "<span class='error'>Username is required</span>" },
					pword: { required: "<span class='error'>Password is required</span>" }
				},
				submitHandler: function(form) {
					var submitButton = $("#submit_login");
					var message = $('#ajaxMessage');

					$.ajax({
						url: 'login_function.php',
						type: 'POST',
						dataType: 'html',
						data: $("#login_form").serialize(),
						beforeSend: function() {
							message.fadeOut();
							submitButton.prop('disabled', true).html('<span>Authenticating...</span> <i class="fa fa-circle-o-notch fa-spin"></i>');
						},
						success: function(data) {
							$('#ajaxMessage').fadeIn().html(data);
							submitButton.prop('disabled', false).html('<span>Sign In to Console</span> <i class="fa fa-arrow-right"></i>');
						},
						error: function() {
							$('#ajaxMessage').fadeIn().html('<div class="alert alert-danger">An unexpected network error occurred. Please try again.</div>');
							submitButton.prop('disabled', false).html('<span>Sign In to Console</span> <i class="fa fa-arrow-right"></i>');
						}
					});
				}
			});
		});
	</script>
</body>
</html>
