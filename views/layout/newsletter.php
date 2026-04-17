<!-- Newsletter Component Styles -->
<style>
    .newsletter-section {
        background: #fdfdfd;
        border: 1px solid #f0f0f0;
        border-radius: 40px;
        padding: 80px 60px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.02);
    }

    .newsletter-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(244, 130, 33, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .newsletter-grid-overlay {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(#eee 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.3;
        mask-image: linear-gradient(to right, black, transparent);
        pointer-events: none;
        z-index: 0;
    }

    .news-content {
        position: relative;
        z-index: 1;
    }

    .news-input-group {
        background: #fff;
        padding: 6px;
        border-radius: 60px;
        display: flex;
        border: 1px solid #e9ecef;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .news-input-group:focus-within {
        border-color: var(--primary-orange);
        box-shadow: 0 10px 40px rgba(244, 130, 33, 0.12);
        transform: translateY(-2px);
    }

    .news-input {
        border: none !important;
        background: transparent;
        padding: 0 35px;
        flex: 1;
        outline: none !important;
        box-shadow: none !important;
        font-size: 1rem;
        color: var(--dark-bg);
        font-weight: 500;
    }

    .news-input::placeholder {
        color: #999;
        font-weight: 400;
    }

    /* Standardized Premium Button for Newsletter */
    .btn-pill {
        padding: 12px 30px; /* Refined for newsletter context */
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-orange {
        background: var(--primary-orange);
        color: #fff;
        box-shadow: 0 8px 20px rgba(244, 130, 33, 0.25);
        border: 2px solid var(--primary-orange);
    }

    .btn-orange:hover {
        background: #e6751c;
        border-color: #e6751c;
        transform: translateY(-3px);
        color: #fff;
        box-shadow: 0 10px 25px rgba(244, 130, 33, 0.35);
    }

    @media (max-width: 991px) {
        .newsletter-section { padding: 60px 30px; }
        .news-input-group { border-radius: 30px; flex-direction: column; padding: 10px; gap: 10px; }
        .news-input { padding: 15px 20px; width: 100%; text-align: center; }
        .btn-pill { width: 100%; border-radius: 25px; }
    }
</style>

<!-- ====== Newsletter Section ====== -->
<section class="section-padding">
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
