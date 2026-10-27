<link rel="stylesheet" href="<?= BASE_URL ?>/css/faq.css" />

<!-- ====== Page Header ====== -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-content">
                    <span class="page-header-eyebrow">
                        <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                            <rect x="4" y="5.25" width="32" height="1.5" rx="0.75" fill="rgba(244, 130, 33, 0.55)"/>
                        </svg>
                        <span>Support &amp; Clarity</span>
                        <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="5.25" width="32" height="1.5" rx="0.75" fill="rgba(244, 130, 33, 0.55)"/>
                            <rect x="33.5" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                        </svg>
                    </span>
                    <h1 class="page-title">Frequently Asked <span>Questions</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb-custom">
                            <li class="breadcrumb-item-custom"><a href="<?= BASE_URL ?>/">Home</a></li>
                            <li class="breadcrumb-item-custom active" aria-current="page">FAQs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== FAQ Section ====== -->
<section class="faq-section">
    <div class="container">
        <div class="row">
            <!-- Left Column: Intro & Support Card -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="faq-sidebar">
                    <span class="section-eyebrow">
                        <svg class="eyebrow-line-svg" width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="0" y="1.5" width="2.5" height="9" rx="0.75" fill="#f48221"/>
                            <rect x="4" y="5.25" width="32" height="1.5" rx="0.75" fill="#cbd5e1"/>
                        </svg>
                        <span>Knowledge Base</span>
                    </span>
                    <h2 class="section-title">Answers to Common <span>Inquiries</span></h2>
                    <p class="faq-intro-text">
                        Find clear answers regarding our software engineering engagements, enterprise consulting, and technical training programs.
                    </p>

                    <div class="faq-support-card">
                        <div class="faq-support-icon">
                            <span class="material-symbols-outlined">support_agent</span>
                        </div>
                        <h4 class="faq-support-title">Still have questions?</h4>
                        <p class="faq-support-desc">
                            Can't find the exact detail you're looking for? Reach out directly to our engineering and support team.
                        </p>
                        <a href="<?= BASE_URL ?>/contact" class="faq-support-btn">
                            <span>Contact Our Team</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Accordion -->
            <div class="col-lg-8">
                <?php if (!empty($faqs)): ?>
                    <div class="faq-accordion" x-data="{ activeFaq: 0 }">
                        <?php foreach ($faqs as $idx => $faq): ?>
                            <div class="faq-item-card" :class="{ 'is-open': activeFaq === <?= (int) $idx ?> }">
                                <button
                                    type="button"
                                    class="faq-question-btn"
                                    @click="activeFaq = (activeFaq === <?= (int) $idx ?> ? null : <?= (int) $idx ?>)"
                                    :aria-expanded="activeFaq === <?= (int) $idx ?>">
                                    <span class="faq-q-left">
                                        <span class="faq-num"><?= str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                        <span class="faq-question-text"><?= htmlspecialchars(stripslashes($faq['faq_question'])); ?></span>
                                    </span>
                                    <span class="faq-toggle-icon" aria-hidden="true">
                                        <span class="material-symbols-outlined" x-text="activeFaq === <?= (int) $idx ?> ? 'remove' : 'add'">add</span>
                                    </span>
                                </button>
                                <div class="faq-answer-wrap" x-show="activeFaq === <?= (int) $idx ?>" x-collapse>
                                    <div class="faq-answer-body">
                                        <?= stripslashes($faq['faq_answer']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="faq-empty-state">
                        <span class="material-symbols-outlined">help_outline</span>
                        <h4>No FAQs Available Yet</h4>
                        <p>We are currently updating our knowledge base. Please contact us directly with any questions.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/views/layout/newsletter.php'; ?>
