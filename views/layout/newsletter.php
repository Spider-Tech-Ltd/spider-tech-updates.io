<!-- Newsletter Component Styles -->
<link rel="stylesheet" href="<?= BASE_URL ?>/css/newsletter.css" />

<!-- ====== Newsletter Section ====== -->
<section class="section-padding newsletter-wrapper">
    <div class="container">
        <div class="newsletter-section">
            <div class="newsletter-grid-overlay"></div>
            <div class="row align-items-center news-content">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title" style="margin-bottom: 0.5rem; line-height: 1.2;">Stay <span>Connected</span></h2>
                    <p class="section-subtitle mb-0" style="font-size: 1.05rem;">Get the latest tech updates and community news delivered to your inbox.</p>
                </div>
                <div class="col-lg-6">
                    <form id="subscribeForm" class="news-input-group">
                        <input type="email" name="email" class="news-input" placeholder="Enter your email address" required>
                        <button type="submit" class="btn-pill btn-orange border-0" id="subscribeBtn">
                            Subscribe
                            <span class="material-symbols-outlined" style="font-size: 1.2rem;">mail</span>
                        </button>
                    </form>
                    <div id="subscribeMessage" class="mt-3"></div>
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
        btn.prop('disabled', true).text('Submitting...');
        $.ajax({
            url: '<?= BASE_URL ?>/includes/subscribe_function.php',
            type: 'POST',
            data: $(this).serialize() + '&subscribe=1',
            success: function(data) {
                btn.prop('disabled', false).html('Subscribe <span class="material-symbols-outlined" style="font-size: 1.2rem;">mail</span>');
                msg.html(data).fadeIn();
                if(data.indexOf('alert-success') !== -1) {
                    $("#subscribeForm")[0].reset();
                }
            }
        });
    });
});
</script>
