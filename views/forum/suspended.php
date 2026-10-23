<div class="container py-5 mt-5" x-data="suspensionPage(<?= $isUnderReview ? 'true' : 'false' ?>)">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <!-- Main Suspension Card -->
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-body p-0">

                    <!-- 1. Account Suspended Block -->
                    <div x-show="state === 'suspended'" x-collapse x-cloak>
                        <div class="p-5 text-center">
                            <div class="mb-4">
                                <div class="bg-danger d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                    <span class="material-symbols-outlined text-white" style="font-size: 48px;">block</span>
                                </div>
                            </div>

                            <h1 class="fw-bold text-dark mb-3 display-6 poppins">Account Suspended</h1>

                            <p class="text-muted fs-6 mb-5 px-md-4">
                                We noticed some activity on your account that violates our community guidelines. As a result, your access to the Spider Tech forum has been temporarily suspended.
                            </p>

                            <div class="bg-light p-4 rounded-4 mb-5 border-0 text-start">
                                <p class="mb-2 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">What does this mean?</p>
                                <p class="mb-0 text-muted small px-md-2">
                                    You can no longer participate in discussions, post updates, or interact with other community members until your account is reviewed or the suspension period ends.
                                </p>
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                                <button @click="state = 'appealing'"
                                        class="btn btn-system-pill-primary px-4 py-2 fw-bold">
                                    Request a Review
                                </button>
                                <a href="<?= BASE_URL ?>/forum/terms" class="btn btn-system-pill-outline px-4 py-2 fw-bold">
                                    Community Rules
                                </a>
                            </div>

                            <div class="mt-5 d-flex justify-content-center gap-4 border-top pt-4">
                                <a href="mailto:support@spidertech.com.ng" class="text-decoration-none text-muted small d-flex align-items-center gap-2 hover-orange transition-all">
                                    <span class="material-symbols-outlined fs-6">mail</span>
                                    <span>Email Support</span>
                                </a>
                                <a href="<?= BASE_URL ?>/forum/logout" class="text-decoration-none text-danger small d-flex align-items-center gap-2 hover-opacity transition-all">
                                    <span class="material-symbols-outlined fs-6">logout</span>
                                    <span>Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Appeal Form Block -->
                    <div x-show="state === 'appealing'" x-collapse x-cloak>
                        <div class="p-5">
                            <div class="text-center mb-5">
                                <div class="bg-soft-orange d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 70px; height: 70px;">
                                    <span class="material-symbols-outlined text-orange" style="font-size: 36px;">rate_review</span>
                                </div>
                                <h2 class="fw-bold text-dark mb-2 poppins">Submit an Appeal</h2>
                                <p class="text-muted small">Provide details about why your account should be reinstated.</p>
                            </div>

                            <form @submit.prevent="submitReview" class="text-start">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark small">Reason for Appeal</label>
                                    <textarea name="reason" class="form-control rounded-4 border-0 bg-light p-3 shadow-none focus-orange" rows="5" required placeholder="Describe your situation..." style="resize: none;"></textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <button type="button" @click="state = 'suspended'" class="btn btn-system-pill-outline py-2 fw-bold w-100">Cancel</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-system-pill-primary py-2 fw-bold w-100" :disabled="loading">
                                            <span x-show="!loading">Submit Appeal</span>
                                            <span x-show="loading">Submitting...</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- 3. Result Block (Success/Error) -->
                    <div x-show="state === 'result'" x-collapse x-cloak>
                        <div class="p-5 text-center">
                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm"
                                     :class="result.type === 'success' ? 'bg-success' : 'bg-danger'"
                                     style="width: 80px; height: 80px;">
                                     <span class="material-symbols-outlined text-white" style="font-size: 48px;"
                                          x-text="result.type === 'success' ? 'check_circle' : 'error'"></span>
                                </div>
                            </div>
                            <h2 class="fw-bold mb-3 poppins" x-text="result.title"></h2>
                            <p class="text-muted mb-5 fs-6 px-md-4" x-text="result.message"></p>

                            <div class="d-flex justify-content-center">
                                <button @click="handleResultAction"
                                        class="btn px-5 py-2 fw-bold"
                                        :class="result.type === 'success' ? 'btn-system-pill-primary' : 'btn-system-pill-dark'">
                                    <span x-text="result.type === 'success' ? 'Continue' : 'Try Again'"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Account Under Review Block -->
                    <div x-show="state === 'under_review'" x-collapse x-cloak>
                        <div class="p-5 text-center">
                            <div class="mb-4">
                                 <div class="bg-primary d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px; background-color: #0d6efd !important;">
                                    <span class="material-symbols-outlined text-white" style="font-size: 48px;">pending_actions</span>
                                </div>
                            </div>
                            <h1 class="fw-bold text-dark mb-3 display-6 poppins">Account Under Review</h1>
                            <p class="text-muted fs-6 mb-5">
                                Thank you for your appeal. Your account status is currently being reviewed by our moderation team.
                            </p>
                            <div class="bg-light p-4 rounded-4 mb-5 border-0 text-start">
                                <p class="mb-2 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">What happens next?</p>
                                <p class="mb-0 text-muted small px-md-2">
                                    We will investigate your request and get back to you via email. This process usually takes 24-48 hours. In the meantime, access to community features remains restricted.
                                </p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="<?= BASE_URL ?>/forum/logout" class="btn btn-system-pill-outline px-5 py-2 fw-bold d-flex align-items-center gap-2">
                                    <span class="material-symbols-outlined fs-5">logout</span>
                                    <span>Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/forum-suspended.css" />

<script>
document.addEventListener('alpine:init', () => {
    if (!Alpine.data('suspensionPage')) {
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
                            title: 'Appeal Submitted',
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
    }
});
</script>
