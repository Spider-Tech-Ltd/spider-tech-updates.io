<div class="container py-5 mt-5 pt-5" x-data="suspensionPage">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10 col-xl-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 100px; height: 100px;">
                            <span class="material-symbols-outlined text-danger" style="font-size: 56px;">block</span>
                        </div>
                    </div>

                    <h2 class="fw-bold text-dark mb-3">Account Suspended</h2>

                    <p class="text-muted fs-5 mb-4">
                        We noticed some activity on your account that violates our community guidelines. As a result, your access to the Spider Tech forum has been temporarily suspended.
                    </p>

                    <div class="bg-light p-4 rounded-3 mb-4 text-start border-start border-danger border-4">
                        <p class="mb-0 text-dark">
                            <strong>What does this mean?</strong><br>
                            You can no longer participate in discussions, post updates, or interact with other community members until your account is reviewed or the suspension period ends.
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?= BASE_URL ?>/forum/terms" class="btn btn-outline-primary py-3 rounded-3 fw-bold w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">gavel</span>
                                <span>Community Guidelines</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button @click="showReviewForm = !showReviewForm" class="btn btn-outline-dark py-3 rounded-3 fw-bold w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">rate_review</span>
                                <span>Request a Review</span>
                            </button>
                        </div>

                        <!-- Review Form -->
                        <div class="col-12 mt-4 text-start" x-show="showReviewForm" x-collapse x-cloak>
                            <div class="bg-light p-4 rounded-4 border">
                                <h5 class="fw-bold mb-3">Request Account Review</h5>
                                <p class="text-muted small mb-4">If you believe your account was suspended by mistake, please provide a brief explanation below. Our moderators will review your request.</p>
                                <form @submit.prevent="submitReview">
                                    <div class="mb-3">
                                        <label class="form-label fw-600">Why should your account be reinstated?</label>
                                        <textarea name="reason" class="form-control rounded-3" rows="4" required placeholder="Provide details here..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary-custom px-5" :disabled="loading">
                                        <span x-show="!loading">Submit Request</span>
                                        <span x-show="loading">Submitting...</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <a href="mailto:support@spidertech.com.ng" class="btn btn-light py-3 rounded-3 fw-bold w-100 border d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">mail</span>
                                <span>Email Support</span>
                            </a>
                        </div>
                        <div class="col-md-6 mt-4">
                            <a href="<?= BASE_URL ?>/forum/logout" class="btn btn-danger py-3 rounded-3 fw-bold shadow-sm w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">logout</span>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-5 text-muted small">
                        Spider Technologies Community Management
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('suspensionPage', () => ({
        showReviewForm: false,
        loading: false,

        async submitReview(e) {
            this.loading = true;
            const formData = new FormData(e.target);

            try {
                const response = await fetch('<?= BASE_URL ?>/forum/request-review', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    showToast(result.message);
                    this.showReviewForm = false;
                    e.target.reset();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                showToast('An unexpected error occurred.', 'error');
            } finally {
                this.loading = false;
            }
        }
    }));
});

function showToast(message, type = 'success') {
    if (typeof Toastify !== 'undefined') {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: type === 'success' ? "#28a745" : "#dc3545",
        }).showToast();
    } else {
        alert(message);
    }
}
</script>
