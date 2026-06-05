<div class="container py-5 mt-5" x-data="suspensionPage(<?= $isUnderReview ? 'true' : 'false' ?>)">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <!-- 1. Account Under Review Block -->
            <div class="card border-0 shadow-sm rounded-5"
                 x-show="state === 'under_review'" x-cloak x-transition:enter="animate__animated animate__fadeIn">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                         <div class="bg-primary d-inline-flex align-items-center justify-content-center rounded-2 mb-3 shadow-sm" style="width: 80px; height: 80px; background-color: #0d6efd !important;">
                            <span class="material-symbols-outlined text-white" style="font-size: 48px;">pending_actions</span>
                        </div>
                    </div>
                    <h1 class="fw-bold text-dark mb-3 display-6 poppins">Account Under Review</h1>
                    <p class="text-muted fs-6 mb-5">
                        Thank you for your appeal. Your account status is currently being reviewed by our moderation team.
                    </p>
                    <div class="bg-light p-4 rounded-3 mb-5 border-0">
                        <p class="mb-2 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">What happens next?</p>
                        <p class="mb-0 text-muted small px-md-4">
                            We will investigate your request and get back to you via email. This process usually takes 24-48 hours. In the meantime, access to community features remains restricted.
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="<?= BASE_URL ?>/forum/logout" class="btn btn-outline-dark px-5 py-2 rounded-2 fw-semibold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5">logout</span>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Account Suspended Block -->
            <div class="card border-0 shadow-sm rounded-5"
                 x-show="state === 'suspended'" x-transition:enter="animate__animated animate__fadeIn">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="bg-danger d-inline-flex align-items-center justify-content-center rounded-2 mb-3 shadow-sm" style="width: 80px; height: 80px;">
                            <span class="material-symbols-outlined text-white" style="font-size: 48px;">block</span>
                        </div>
                    </div>

                    <h1 class="fw-bold text-dark mb-3 display-6 poppins">Account Suspended</h1>

                    <p class="text-muted fs-6 mb-5 px-md-4">
                        We noticed some activity on your account that violates our community guidelines. As a result, your access to the Spider Tech forum has been temporarily suspended.
                    </p>

                    <div class="bg-light p-4 rounded-3 mb-5 border-0">
                        <p class="mb-2 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">What does this mean?</p>
                        <p class="mb-0 text-muted small px-md-4">
                            You can no longer participate in discussions, post updates, or interact with other community members until your account is reviewed or the suspension period ends.
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
                        <button @click="state = 'appealing'"
                                class="btn btn-link text-dark fw-bold text-decoration-none">
                            Request a Review
                        </button>
                        <a href="<?= BASE_URL ?>/forum/terms" class="btn btn-outline-dark px-4 py-2 rounded-2 fw-semibold">
                            Community Guidelines
                        </a>
                    </div>

                    <div class="mt-5 d-flex justify-content-center gap-4 border-top pt-4">
                        <a href="mailto:support@spidertech.com.ng" class="text-decoration-none text-muted small d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-6">mail</span>
                            <span>Email Support</span>
                        </a>
                        <a href="<?= BASE_URL ?>/forum/logout" class="text-decoration-none text-danger small d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-6">logout</span>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Appeal Form Block -->
            <div class="card border-0 shadow-sm rounded-5"
                 x-show="state === 'appealing'" x-cloak x-transition:enter="animate__animated animate__fadeIn">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark mb-2 poppins">Submit an Appeal</h2>
                        <p class="text-muted small">Provide details about why your account should be reinstated.</p>
                    </div>

                    <form @submit.prevent="submitReview">
                        <div class="mb-4">
                            <textarea name="reason" class="form-control rounded-3 border-light bg-light p-3" rows="5" required placeholder="Describe your situation..." style="resize: none;"></textarea>
                        </div>
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary-custom py-3 rounded-2 fw-bold shadow-sm" :disabled="loading">
                                <span x-show="!loading">Submit Appeal</span>
                                <span x-show="loading">Submitting...</span>
                            </button>
                            <button type="button" @click="state = 'suspended'" class="btn btn-link text-muted text-decoration-none small">Cancel and go back</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 4. Result Block (Success/Error) -->
            <div class="card border-0 shadow-sm rounded-5"
                 x-show="state === 'result'" x-cloak x-transition:enter="animate__animated animate__fadeIn">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-3 shadow-sm"
                             :class="result.type === 'success' ? 'bg-success' : 'bg-danger'"
                             style="width: 80px; height: 80px;">
                             <span class="material-symbols-outlined text-white" style="font-size: 48px;"
                                  x-text="result.type === 'success' ? 'check_circle' : 'error'"></span>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-3 poppins" x-text="result.title"></h2>
                    <p class="text-muted mb-5 fs-6" x-text="result.message"></p>

                    <div class="d-flex justify-content-center">
                        <button @click="handleResultAction"
                                class="btn px-5 py-2 rounded-2 fw-bold shadow-sm"
                                :class="result.type === 'success' ? 'btn-primary-custom' : 'btn-dark'">
                            <span x-text="result.type === 'success' ? 'Continue' : 'Try Again'"></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .rounded-5 { border-radius: 2rem !important; }
    .bg-light { background-color: #f8f9fa !important; }
    .animate__animated { animation-duration: 0.4s; }
    .btn-primary-custom {
        background-color: #f48221;
        border-color: #f48221;
        color: white;
    }
    .btn-primary-custom:hover {
        background-color: #d9731d;
        border-color: #d9731d;
        color: white;
    }
    [x-cloak] { display: none !important; }
    .poppins { font-family: 'Poppins', sans-serif; }
</style>

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
