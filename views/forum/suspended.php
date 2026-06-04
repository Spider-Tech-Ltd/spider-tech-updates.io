<div class="container py-5 mt-5 pt-5" x-data="suspensionPage(<?= $isUnderReview ? 'true' : 'false' ?>)">
    <!-- Status Modal -->
    <div class="modal-custom" :class="{ 'show': statusModal.open }" x-cloak>
        <div class="modal-content-custom" style="max-width: 450px;">
            <div class="modal-body-custom text-center py-5">
                <div class="mb-4">
                    <span class="material-symbols-outlined"
                          :class="statusModal.type === 'success' ? 'text-success' : 'text-danger'"
                          style="font-size: 80px;"
                          x-text="statusModal.type === 'success' ? 'check_circle' : 'error'"></span>
                </div>
                <h3 class="fw-bold mb-3" x-text="statusModal.title"></h3>
                <p class="text-muted mb-4 fs-5" x-text="statusModal.message"></p>
                <button @click="statusModal.open = false; if(statusModal.type === 'success') underReview = true;" class="btn btn-primary-custom px-5 py-2 rounded-pill">Got it</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10 col-xl-9">
            <!-- Under Review Screen -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden" style="border: 1px solid rgba(244, 130, 31, 0.1) !important;" x-show="underReview" x-cloak>
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="bg-soft-blue d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 120px; height: 120px;">
                            <span class="material-symbols-outlined text-blue" style="font-size: 64px;">pending_actions</span>
                        </div>
                    </div>
                    <h1 class="fw-bold text-dark mb-3 display-5">Account Under Review</h1>
                    <p class="text-muted fs-5 mb-4">
                        Thank you for your appeal. Your account status is currently being reviewed by our moderation team.
                    </p>
                    <div class="bg-light p-4 rounded-4 border-0 shadow-sm mb-4 text-start border-start border-primary border-4">
                        <p class="mb-0 text-dark">
                            <strong>What happens next?</strong><br>
                            We will investigate your request and get back to you via email. This process usually takes 24-48 hours. In the meantime, access to community features remains restricted.
                        </p>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6">
                            <a href="<?= BASE_URL ?>/forum/logout" class="btn btn-outline-dark py-3 rounded-pill fw-bold w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">logout</span>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suspended Screen -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden" style="border: 1px solid rgba(220, 53, 69, 0.1) !important;" x-show="!underReview">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="bg-danger d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 120px; height: 120px;">
                            <span class="material-symbols-outlined text-white" style="font-size: 64px;">block</span>
                        </div>
                    </div>

                    <h1 class="fw-bold text-dark mb-3 display-5">Account Suspended</h1>

                    <p class="text-muted fs-5 mb-4">
                        We noticed some activity on your account that violates our community guidelines. As a result, your access to the Spider Tech forum has been temporarily suspended.
                    </p>

                    <div class="bg-light p-4 rounded-3 mb-4 text-start border-start border-danger border-4">
                        <p class="mb-0 text-dark">
                            <strong>What does this mean?</strong><br>
                            You can no longer participate in discussions, post updates, or interact with other community members until your account is reviewed or the suspension period ends.
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <a href="<?= BASE_URL ?>/forum/terms" class="btn btn-outline-orange py-3 rounded-pill fw-bold w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">gavel</span>
                                <span>Community Guidelines</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button @click="showReviewForm = !showReviewForm"
                                    class="btn py-3 rounded-pill fw-bold w-100 d-flex align-items-center justify-content-center"
                                    :class="showReviewForm ? 'btn-dark' : 'btn-outline-dark'">
                                <span class="material-symbols-outlined me-2">rate_review</span>
                                <span x-text="showReviewForm ? 'Close Appeal Form' : 'Request a Review'"></span>
                            </button>
                        </div>

                        <!-- Review Form -->
                        <div class="col-12 mt-4 text-start" x-show="showReviewForm" x-collapse x-cloak>
                            <div class="bg-light p-4 rounded-4 border-0 shadow-sm" style="background-color: #fff9f2 !important;">
                                <h5 class="fw-bold mb-3 text-dark">Submit an Appeal</h5>
                                <p class="text-muted small mb-4">If you believe your account was suspended by mistake, please provide a brief explanation below. Our moderators will review your request shortly.</p>
                                <form @submit.prevent="submitReview">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark fs-09">Why should your account be reinstated?</label>
                                        <textarea name="reason" class="form-control rounded-4 border-0 shadow-sm p-3" rows="4" required placeholder="Describe your situation..."></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary-custom px-5 py-2 rounded-pill shadow-sm" :disabled="loading">
                                            <span x-show="!loading" class="d-flex align-items-center gap-2">
                                                <span>Submit Appeal</span>
                                                <span class="material-symbols-outlined fs-1rem">send</span>
                                            </span>
                                            <span x-show="loading">Submitting...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <a href="mailto:support@spidertech.com.ng" class="btn btn-light py-3 rounded-pill fw-bold w-100 border d-flex align-items-center justify-content-center bg-white shadow-sm">
                                <span class="material-symbols-outlined me-2 text-orange">mail</span>
                                <span>Email Support</span>
                            </a>
                        </div>
                        <div class="col-md-6 mt-4">
                            <a href="<?= BASE_URL ?>/forum/logout" class="btn btn-danger py-3 rounded-pill fw-bold shadow-sm w-100 d-flex align-items-center justify-content-center">
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
    Alpine.data('suspensionPage', (initialReviewState) => ({
        showReviewForm: false,
        loading: false,
        underReview: initialReviewState,
        statusModal: {
            open: false,
            type: 'success',
            title: '',
            message: ''
        },

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
                    this.statusModal = {
                        open: true,
                        type: 'success',
                        title: 'Request Received',
                        message: result.message
                    };
                    this.showReviewForm = false;
                    e.target.reset();
                } else {
                    this.statusModal = {
                        open: true,
                        type: 'error',
                        title: 'Submission Failed',
                        message: result.message
                    };
                }
            } catch (error) {
                this.statusModal = {
                    open: true,
                    type: 'error',
                    title: 'System Error',
                    message: 'An unexpected error occurred while processing your request.'
                };
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
