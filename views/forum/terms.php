<?php
/**
 * Forum Terms of Service View — Engineered Community Standards
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($title ?? 'Community Terms') ?> — Spider Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-terms.css?v=<?= filemtime(ROOT_PATH . '/css/forum-terms.css') ?>" />
</head>
<body>
<div class="container py-5">
    <div class="text-center mb-4">
        <a href="<?= BASE_URL ?>/home">
            <img src="<?= BASE_URL ?>/images/spider-tech.png" alt="Spider Tech" style="height: 42px;">
        </a>
    </div>

    <div class="terms-card">
        <div class="text-center mb-2">
            <span style="font-family: 'Chakra Petch', monospace; font-size: 0.72rem; font-weight: 700; color: #f48221; letter-spacing: 0.12em; text-transform: uppercase;">
                |– COMMUNITY STANDARDS &amp; PROTOCOL –|
            </span>
        </div>

        <h1 class="terms-heading">Community Terms &amp; Conduct</h1>
        <p class="terms-subtext">Review our engineering guidelines and standards before participating.</p>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="terms-container">
            <h4>1. Professional Conduct</h4>
            <p>The Spider Tech Community is a professional network dedicated to industrial technology, automation, and manufacturing. Members are expected to maintain a professional demeanor in all interactions. Share knowledge, ask insightful questions, and contribute positively to the collective expertise of the forum.</p>

            <h4>2. Respectful Communication &amp; Anti-Harassment</h4>
            <p>We maintain a zero-tolerance policy for harassment, bullying, or discriminatory language. Respect all members regardless of their experience level, background, or opinions. Debate ideas vigorously but remain courteous to the individuals behind them. Personal attacks will result in immediate account suspension.</p>

            <h4>3. Information Accuracy &amp; Integrity</h4>
            <p>To ensure the community remains a reliable resource, please avoid sharing vague, misleading, or unverified information. When providing technical advice, specify the context and any safety considerations. Intentional spreading of misinformation or spamming is strictly prohibited.</p>

            <h4>4. Content Ownership &amp; Moderation</h4>
            <p>By posting on the forum, you grant Spider Tech a non-exclusive right to display and distribute your content within the platform. We reserve the right to edit, move, or delete any content that violates these terms or is deemed inappropriate for the community.</p>

            <h4>5. Account Suspension &amp; Termination</h4>
            <p>Spider Tech reserves the right to suspend or terminate any account that repeatedly violates these terms or engages in conduct that is detrimental to the community's health and safety. We strive for a self-regulating community but will intervene when necessary to maintain our standards.</p>

            <h4>6. Privacy &amp; Data Protection</h4>
            <p>Your privacy is important to us. Please refer to our Privacy Policy for details on how we handle your data. Do not share sensitive personal information or proprietary corporate data in public discussions.</p>
        </div>

        <form action="<?= BASE_URL ?>/forum/terms/accept" method="POST" id="termsForm">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="agree" id="agreeCheck" required>
                <label class="form-check-label" for="agreeCheck">
                    I have read and agree to comply with the community terms and guidelines
                </label>
            </div>
            <button type="submit" class="terms-btn" id="submitBtn" disabled>
                <span>Accept Terms &amp; Join Community</span>
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/forum" style="font-size: 0.82rem; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                <span>Back to Forum</span>
            </a>
        </div>
    </div>
</div>

<script>
    const agreeCheck = document.getElementById('agreeCheck');
    const submitBtn = document.getElementById('submitBtn');

    agreeCheck.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });
</script>
</body>
</html>
