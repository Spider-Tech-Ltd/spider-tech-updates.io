<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
        }
        .verification-card {
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            text-align: center;
            max-width: 480px;
            width: 90%;
            border: 1px solid #e9ecef;
        }
        .logo-box {
            margin-bottom: 35px;
        }
        .logo-box img {
            max-width: 180px;
            height: auto;
        }
        .icon-box {
            font-size: 64px;
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }
        .icon-box .material-symbols-outlined {
            font-size: 72px;
            font-variation-settings: 'FILL' 1;
        }
        .status-heading {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #111111;
            margin-bottom: 12px;
        }
        .status-text {
            color: #555555;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .btn-spider {
            background-color: #f48221;
            color: #ffffff;
            border-radius: 50px;
            padding: 14px 40px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(244, 130, 33, 0.3);
        }
        .btn-spider:hover {
            background-color: #e6751c;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(244, 130, 33, 0.4);
        }
        .btn-outline-spider {
            background-color: transparent;
            color: #797979;
            border-radius: 50px;
            padding: 12px 35px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1.5px solid #e9ecef;
            transition: all 0.2s ease;
            text-decoration: none !important;
        }
        .btn-outline-spider:hover {
            border-color: #f48221;
            color: #f48221;
            background-color: rgba(244, 130, 33, 0.05);
        }
        .success-icon { color: #10b981; }
        .error-icon { color: #ef4444; }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="logo-box">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech">
        </div>
        <div class="icon-box">
            <?php if ($success): ?>
                <span class="material-symbols-outlined success-icon">check_circle</span>
            <?php else: ?>
                <span class="material-symbols-outlined error-icon">cancel</span>
            <?php endif; ?>
        </div>
        <h1 class="status-heading"><?php echo $success ? 'Account Verified!' : 'Verification Error'; ?></h1>
        <p class="status-text"><?php echo $message; ?></p>
        <?php if ($success): ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-in" class="btn-spider">Sign In Now</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/forum/sign-up" class="btn-outline-spider">Back to Sign Up</a>
        <?php endif; ?>
    </div>
</body>
</html>
