<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .icon-box {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #ff5722;
            color: #fff;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #e64a19;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="icon-box">
            <?php echo $success ? '✅' : '❌'; ?>
        </div>
        <h3 class="mb-3"><?php echo $success ? 'Verification Successful' : 'Verification Failed'; ?></h3>
        <p class="text-muted mb-4"><?php echo $message; ?></p>
        <?php if ($success): ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-in" class="btn btn-custom">Sign In Now</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-up" class="btn btn-outline-secondary rounded-pill px-4">Back to Sign Up</a>
        <?php endif; ?>
    </div>
</body>
</html>
