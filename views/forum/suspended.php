<div class="container py-5 mt-5 pt-5" x-data="suspensionPage(<?= $isUnderReview ? 'true' : 'false' ?>)">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10 col-xl-9">

            <!-- 1. Account Under Review Block -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden"
                 style="border: 1px solid rgba(244, 130, 31, 0.1) !important;"
                 x-show="state === 'under_review'" x-cloak x-transition>
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

            <!-- 2. Account Suspended Block -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden"
                 style="border: 1px solid rgba(220, 53, 69, 0.1) !important;"
                 x-show="state === 'suspended'" x-transition>
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

                    <div class="bg-light p-4 rounded-4 mb-4 text-start border-start border-danger border-4">
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
                            <button @click="state = 'appealing'"
                                    class="btn btn-outline-dark py-3 rounded-pill fw-bold w-100 d-flex align-items-center justify-content-center">
                                <span class="material-symbols-outlined me-2">rate_review</span>
                                <span>Request a Review</span>
                            </button>
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

            <!-- 3. Appeal Form Block -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden"
                 x-show="state === 'appealing'" x-cloak x-transition>
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <button @click="state = 'suspended'" class="btn btn-light rounded-circle me-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <h2 class="fw-bold text-dark mb-0">Submit an Appeal</h2>
                    </div>

                    <div class="bg-light p-4 rounded-4 border-0 shadow-sm mb-4" style="background-color: #fff9f2 !important; border-left: 4px solid #f48221 !important;">
                        <p class="text-muted mb-0">If you believe your account was suspended by mistake, please provide a brief explanation below. Our moderators will review your request shortly.</p>
                    </div>

                    <form @submit.prevent="submitReview">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark fs-09">Why should your account be reinstated?</label>
                            <textarea name="reason" class="form-control rounded-4 border p-3 shadow-sm" rows="6" required placeholder="Describe your situation..." style="resize: none;"></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <button type="button" @click="state = 'suspended'" class="btn btn-light py-3 rounded-pill fw-bold w-100 border">Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary-custom py-3 rounded-pill fw-bold w-100 shadow-sm" :disabled="loading">
                                    <span x-show="!loading" class="d-flex align-items-center justify-content-center gap-2">
                                        <span>Submit Appeal</span>
                                        <span class="material-symbols-outlined">send</span>
                                    </span>
                                    <span x-show="loading">Submitting...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 4. Result Block (Success/Error) -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden"
                 x-show="state === 'result'" x-cloak x-transition>
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <span class="material-symbols-outlined"
                              :class="result.type === 'success' ? 'text-success' : 'text-danger'"
                              style="font-size: 100px;"
                              x-text="result.type === 'success' ? 'check_circle' : 'error'"></span>
                    </div>
                    <h2 class="fw-bold mb-3" x-text="result.title"></h2>
                    <p class="text-muted mb-5 fs-5" x-text="result.message"></p>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button @click="handleResultAction"
                                    class="btn py-3 rounded-pill fw-bold w-100 shadow-sm"
                                    :class="result.type === 'success' ? 'btn-primary-custom' : 'btn-dark'">
                                <span x-text="result.type === 'success' ? 'Continue' : 'Try Again'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('suspensionPage', (initialReviewState) => ({
        state: initialReviewState ? 'under_review' : 'suspended',
        loading: false,
        result: {
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
                const data = await response.json();

                if (data.status === 'success') {
                    this.result = {
                        type: 'success',
                        title: 'Request Received',
                        message: data.message
                    };
                    e.target.reset();
                } else {
                    this.result = {
                        type: 'error',
                        title: 'Submission Failed',
                        message: data.message
                    };
                }
            } catch (error) {
                this.result = {
                    type: 'error',
                    title: 'System Error',
                    message: 'An unexpected error occurred while processing your request.'
                };
            } finally {
                this.loading = false;
                this.state = 'result';
            }
        },

        handleResultAction() {
            if (this.result.type === 'success') {
                this.state = 'under_review';
            } else {
                this.state = 'appealing';
            }
        }
    }));
});
</script>
