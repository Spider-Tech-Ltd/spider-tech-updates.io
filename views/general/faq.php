<section id="inner-banner" class="index-2">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="inner-heading">
        <h2>FAQ's</h2>
        <div class="separator left-align"><ul><li></li><li></li><li></li></ul></div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" title="Home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<section id="faq" class="index-2 padding">
  <div class="container">
    <div class="section_heading">
      <h2>Frequently <span>Asked Questions</span></h2>
      <div class="separator"><ul><li></li><li></li><li></li></ul></div>
    </div>
    <div class="col-lg-12">
      <?php if (!empty($faqs)): ?>
          <?php foreach ($faqs as $faq): ?>
          <div class="faq-item mb-4">
              <h5 class="faq-question"><?= htmlspecialchars($faq['faq_question']); ?></h5>
              <div class="faq-answer">
                  <?= stripslashes($faq['faq_answer']); ?>
              </div>
          </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p class="text-center">No questions found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
