<!-- Newsletter Component Styles -->
<link rel="stylesheet" href="<?= BASE_URL ?>/css/newsletter.css" />

<!-- ====== Newsletter / Call to Action Section ====== -->
<section class="newsletter-wrapper" aria-labelledby="newsletterHeading">
    <div class="container">
        <div class="newsletter-section">
            <div class="row align-items-center news-content">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 id="newsletterHeading" class="news-title">Stay <span>Connected</span></h2>
                    <p class="news-subtitle mb-0">Get the latest tech updates and community news delivered to your inbox.</p>
                </div>
                <div class="col-lg-6">
                    <form id="subscribeForm" class="news-form" novalidate>
                        <label for="newsletterEmailInput" class="sr-only">Email address</label>
                        <div class="news-input-group">
                            <input type="email"
                                   id="newsletterEmailInput"
                                   name="email"
                                   class="news-input"
                                   placeholder="Enter your email address"
                                   aria-label="Enter your email address"
                                   autocomplete="email"
                                   required>
                            <button type="submit" class="btn-pill btn-orange news-submit-btn" id="subscribeBtn">
                                <span>Subscribe</span>
                                <span class="material-symbols-outlined" aria-hidden="true">mail</span>
                            </button>
                        </div>
                    </form>
                    <div id="subscribeMessage" class="mt-2" role="status" aria-live="polite"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Logic -->
<script>
$(document).ready(function() {
    $("#subscribeForm").submit(function(e) {
        e.preventDefault();
        var btn = $("#subscribeBtn");
        var msg = $("#subscribeMessage");
        btn.prop('disabled', true).html('<span>Submitting...</span>');
        $.ajax({
            url: '<?= BASE_URL ?>/includes/subscribe_function.php',
            type: 'POST',
            data: $(this).serialize() + '&subscribe=1',
            success: function(data) {
                btn.prop('disabled', false).html('<span>Subscribe</span> <span class="material-symbols-outlined" aria-hidden="true">mail</span>');
                msg.html(data).fadeIn();
                if(data.indexOf('alert-success') !== -1) {
                    $("#subscribeForm")[0].reset();
                }
            }
        });
    });
});
</script>