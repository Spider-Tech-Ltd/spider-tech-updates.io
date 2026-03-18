<?php
    require('includes/connect.php');
    $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
    $contact_details->execute();
    $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <?php require('head-section.html'); ?>
</head>
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
                  <h2>FAQ</h2>
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
                          <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                      </ol>
                  </nav>
              </div>
          </div>
      </div>
  </section>
  <!-- ====== Banner End ====== --> 

  <!-- ====== Faq's Start ====== -->
  <section id="faq">
      <div class="container">
          <div class="col-md-12">
              <?php
                  $s = 1;
                  $select_faq = $conn->prepare("SELECT * FROM `faq_tb`");
                  $select_faq->execute();
                  if ($select_faq->rowCount() > 0) {
                      while ($fetch_faq = $select_faq->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <div id="accordion">
                  <div class="card">
                      <div class="card-header" id="heading<?php echo $s ?>">
                          <h5 class="mb-0">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $s ?>"
                                      aria-expanded="<?php echo $s === 1 ? 'true' : 'false' ?>"
                                      aria-controls="collapse<?php echo $s ?>">
                                  <span class="s_no"><?php echo $s ?> </span><?php echo stripslashes($fetch_faq['faq_question']); ?>
                              </button>
                          </h5>
                      </div>
                      <div id="collapse<?php echo $s ?>"
                           class="collapse <?php echo $s === 1 ? 'show' : '' ?>"
                           aria-labelledby="heading<?php echo $s ?>" data-parent="#accordion">
                          <div class="card-body">
                              <p><?php echo stripslashes($fetch_faq['faq_answer']); ?></p>
                          </div>
                      </div>
                  </div>
              </div>
              <?php
                  $s++;
                      }
                  } else {
                      echo '<p class="empty">No FAQ found!</p>';
                  }
              ?>
          </div>
      </div>

      <div class="col-md-12">
          <div class="chat-id text-center">
              <p>If you do not find the answer to your question listed within our FAQ's, you can always contact us directly at 
              <span><?php echo stripslashes($fetch_contact['contact_email']); ?></span></p>
          </div>
      </div>
  </section>
  <!-- ====== Faq's End ====== -->

  </div>
  <!-- ====== Footer Start ====== -->
  <?php require('footer-section.php'); ?>
  <!-- ====== Footer End ====== -->

  <!-- popper js--> 
  <?php require('javascript-section.html'); ?>
</body>

</html>
