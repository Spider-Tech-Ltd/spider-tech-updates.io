<?php
require('includes/connect.php');

$program_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
$contact_details->execute();
$fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);

$select_program = $conn->prepare("SELECT * FROM `trainings_tb` WHERE id = ? LIMIT 1");
$select_program->execute([$program_id]);
$program = $select_program->fetch(PDO::FETCH_ASSOC);

$contact = $fetch_contact ?: [];
$contact_email = !empty($contact['email']) ? htmlspecialchars($contact['email']) : 'info@spidertech.com';
$contact_phone = !empty($contact['phone']) ? htmlspecialchars($contact['phone']) : '+234 000 000 0000';

function cleanProgramHTML($htmlValue)
{
  $allowedTags = '<h1><h2><h3><h4><h5><h6><p><br><ul><ol><li><strong><b><em><i><u><a>';
  $clean = strip_tags($htmlValue, $allowedTags);
  $clean = preg_replace('/\s+/', ' ', $clean);
  $clean = trim($clean);
  // Sanitize <a> tags to protect against javascript: links
  $clean = preg_replace_callback('#<a\s+([^>]+)>#i', function ($matches) {
    $attrs = $matches[1];
    $href = '';
    if (preg_match('/href\s*=\s*"([^"]+)"/i', $attrs, $h)) {
      $href = trim($h[1]);
    } elseif (preg_match('/href\s*=\s*\'([^\']+)\'/i', $attrs, $h)) {
      $href = trim($h[1]);
    }
    if ($href && !preg_match('/^(javascript:)/i', $href)) {
      return '<a href="' . htmlspecialchars($href) . '" rel="noopener noreferrer" target="_blank">';
    }
    return '<a>';
  }, $clean);
  return $clean;
}

$program_description = isset($program['training_description']) ? cleanProgramHTML($program['training_description']) : '';
$program_details = isset($program['training_details']) ? cleanProgramHTML($program['training_details']) : '<p>No program details available.</p>';

// Set breadcrumb for program detail page
$breadcrumb_current = isset($program['training_name']) ? htmlspecialchars(strip_tags($program['training_name'])) : 'Program Details';

?>

<!doctype html>
<html lang="en">

<head>
  <?php require('head-section.html'); ?>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <style>
    html,
    body {
      min-height: 100%;
      margin: 0;
      padding: 0;
    }

    .program-hero {
      background-color: #f4f4f4;
      padding: 70px 12px 48px;
      position: relative;
      text-align: center;
      min-height: 280px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .program-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at center, rgba(244, 130, 33, 0.1), transparent 70%);
      pointer-events: none;
    }

    .program-hero .program-hero-inner {
      position: relative;
      z-index: 2;
    }

    .program-hero-title {
      font-size: 2.75rem;
      font-weight: 800;
      color: #111;
      margin-bottom: 0.8rem;
      line-height: 1.15;
    }

    .program-hero-subtitle {
      color: #555;
      font-size: 1.05rem;
      margin-bottom: 1.5rem;
      max-width: 780px;
      margin-left: auto;
      margin-right: auto;
    }

    .material-symbols-outlined.contact-icon {
      font-family: 'Material Symbols Outlined';
      font-weight: normal;
      font-size: 16px;
      vertical-align: middle;
      margin-right: 0.45rem;
    }

    .program-cta {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      background: #f48221;
      color: #fff !important;
      border-radius: 50px;
      padding: 12px 24px;
      font-weight: 700;
      text-decoration: none !important;
      border: 0;
      transition: all 0.3s ease;
    }

    .program-cta:hover {
      background: #e6751c;
      color: #fff !important;
      text-decoration: none !important;
    }

    .program-cta:focus {
      outline: 2px solid #f48221;
      outline-offset: 2px;
      text-decoration: none !important;
    }

    .program-intro {
      margin-top: 40px;
      padding-bottom: 60px;
      margin-bottom: 80px;
      width: 100%;
      overflow: visible;
    }

    .program-block {
      background: #fff;
      border: 1px solid #ebeff2;
      border-radius: 14px;
      padding: 28px;
      margin-bottom: 24px;
      overflow-wrap: break-word;
      word-break: break-word;
    }

    .program-block h1,
    .program-block h2,
    .program-block h3,
    .program-block h4,
    .program-block h5,
    .program-block h6 {
      margin: 18px 0 10px;
      font-weight: 700;
      line-height: 1.25;
    }

    .program-block p {
      margin: 0 0 14px;
      color: #4e4e4e;
      line-height: 1.75;
    }

    .program-block ul,
    .program-block ol {
      margin: 0 0 16px 1.3rem;
      padding-left: 0;
      color: #4a4a4a;
    }

    .program-block li {
      margin-bottom: 8px;
      padding-left: 0;
    }

    .program-block a {
      color: #f48221;
      text-decoration: underline;
    }

    .program-headline {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .program-list li {
      margin-bottom: 10px;
    }

    .program-sidebar .program-summary {
      background: #fff;
      border: 1px solid #ebeff2;
      border-radius: 14px;
      padding: 20px;
      margin-bottom: 24px;
      min-height: 220px;
    }

    .program-summary h5 {
      margin-bottom: 12px;
      font-weight: 700;
    }

    .program-sidebar {
      position: relative;
    }

    .program-sidebar .program-block {
      overflow: hidden;
    }

    .program-hero {
      min-height: 280px;
      display: flex;
      align-items: center;
    }

    .program-hero-subtitle {
      max-width: 640px;
      margin-left: auto;
      margin-right: auto;
      font-size: 1rem;
      line-height: 1.6;
    }

    .program-block p {
      line-height: 1.7;
      color: #555;
      word-break: break-word;
      overflow-wrap: break-word;
      margin-bottom: 0;
    }

    .program-list li {
      line-height: 1.65;
    }

    .program-summary .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      color: #555;
      font-size: 0.95rem;
    }

    .btn-secondary-ghost {
      background: #fff;
      color: #f48221;
      border: 1px solid #f48221;
      border-radius: 50px;
      padding: 12px 22px;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    .btn-secondary-ghost:hover {
      background: #fef4ea;
    }

    /* Fix footer overlap issue */
    body.program-detail-page footer,
    body.program-detail-page .home.index-2,
    footer.home.index-2 {
      margin-top: 0 !important;
      min-height: auto !important;
      position: relative;
      z-index: 1;
    }

    /* Ensure content has proper spacing */
    .program-content-wrapper {
      margin-bottom: 100px;
      position: relative;
      z-index: 2;
      background: #fff;
    }

    /* Course Stats Bar */
    .course-stats-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      background: #fff;
      border: 1px solid #ebeff2;
      border-radius: 14px;
      padding: 20px;
      margin-bottom: 24px;
    }

    .course-stats-bar .stat-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 16px;
      background: #f9f9f9;
      border-radius: 8px;
      flex: 1;
      min-width: 120px;
    }

    .course-stats-bar .stat-item .material-symbols-outlined {
      font-size: 24px;
      color: #f48221;
    }

    .course-stats-bar .stat-item div {
      display: flex;
      flex-direction: column;
    }

    .course-stats-bar .stat-item strong {
      font-size: 0.75rem;
      color: #999;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .course-stats-bar .stat-item span {
      font-size: 1rem;
      font-weight: 700;
      color: #333;
    }

    /* Program Image */
    .program-image-wrapper {
      margin-bottom: 24px;
      border-radius: 14px;
      overflow: hidden;
    }

    .program-image-wrapper img {
      width: 100%;
      height: auto;
      max-height: 400px;
      object-fit: cover;
    }

    /* Share and Bookmark buttons */
    .action-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .action-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 10px 16px;
      border: 1px solid #ebeff2;
      border-radius: 50px;
      background: #fff;
      color: #555;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .action-btn:hover {
      border-color: #f48221;
      color: #f48221;
    }

    .action-btn .material-symbols-outlined {
      font-size: 18px;
    }

    @media (max-width: 767px) {
      .program-hero-title {
        font-size: 2rem;
      }
    }
  </style>
</head>

<body>
  <?php require('includes/preloader.html'); ?>

  <!-- Breadcrumb Navigation -->
  <?php require('includes/breadcrumbs.html'); ?>

  <!-- Header -->
  <?php require('header-section.php'); ?>

  <?php if (!$program) : ?>
    <section class="program-hero">
      <div class="container program-hero-inner">
        <h1 class="program-hero-title">Program not found</h1>
        <p class="program-hero-subtitle">The requested program does not exist or may have been removed.</p>
        <a class="btn-secondary-ghost" href="trainings.php">Back to Program List</a>
      </div>
    </section>
  <?php else : ?>
    <section class="program-hero">
      <div class="container program-hero-inner">
        <h1 class="program-hero-title"><?= cleanProgramHTML($program['training_name']); ?></h1>
        <p class="program-hero-subtitle"><?= $program_description; ?></p>
        <a class="program-cta" href="register-program.php?id=<?= $program_id; ?>">Register for this program</a>
      </div>
    </section>

    <section class="program-intro">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <!-- Course Image -->
            <?php if (!empty($program['training_image'])): ?>
              <div class="program-image-wrapper">
                <img src="<?= htmlspecialchars($program['training_image']); ?>"
                  alt="<?= htmlspecialchars(strip_tags($program['training_name'])); ?>"
                  loading="lazy">
              </div>
            <?php endif; ?>

            <!-- Course Stats Bar -->
            <div class="course-stats-bar">
              <div class="stat-item">
                <span class="material-symbols-outlined">schedule</span>
                <div>
                  <strong>Duration</strong>
                  <span><?= isset($program['duration_minutes']) ? round($program['duration_minutes'] / 60, 1) . ' hours' : '2h 14min'; ?></span>
                </div>
              </div>
              <div class="stat-item">
                <span class="material-symbols-outlined">menu_book</span>
                <div>
                  <strong>Lessons</strong>
                  <span><?= isset($program['lessons_count']) ? $program['lessons_count'] : '17'; ?></span>
                </div>
              </div>
              <div class="stat-item">
                <span class="material-symbols-outlined">school</span>
                <div>
                  <strong>Students</strong>
                  <span><?= isset($program['students_enrolled']) ? number_format($program['students_enrolled']) . '+' : '41,000+'; ?></span>
                </div>
              </div>
              <div class="stat-item">
                <span class="material-symbols-outlined">star</span>
                <div>
                  <strong>Rating</strong>
                  <span><?= isset($program['rating']) ? $program['rating'] . '/5' : '4.9/5'; ?></span>
                </div>
              </div>
              <div class="stat-item">
                <span class="material-symbols-outlined">workspace_premium</span>
                <div>
                  <strong>Certificate</strong>
                  <span>Included</span>
                </div>
              </div>
            </div>

            <div class="program-block">
              <div class="program-headline">About this program</div>
              <div><?= $program_details; ?></div>
            </div>


          </div>

          <div class="col-lg-4 program-sidebar">
            <div class="program-block">
              <div class="program-headline">Apply now</div>
              <p class="mb-3">Complete the registration form and our team will reach out with next steps.</p>
              <a class="program-cta" href="register-program.php?id=<?= $program_id; ?>">Start registration</a>
            </div>

            <div class="program-block">
              <div class="program-headline">Need help?</div>
              <p class="mb-1"><span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;">email</span> <a href="mailto:<?= $contact_email; ?>"><?= $contact_email; ?></a></p>
              <p class="mb-0"><span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;">phone</span> <?= $contact_phone; ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php require('footer-section.php'); ?>
  <?php require('javascript-section.html'); ?>
</body>

</html>