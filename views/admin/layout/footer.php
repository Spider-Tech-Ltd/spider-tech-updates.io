</main> <!-- End of .admin-main-content -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div> <!-- End of .admin-wrapper -->

    <!-- Global Action Confirmation Modal (Spider Tech Brand Console) -->
    <div x-data x-show="$store.actionModal.open" class="modal-custom" :class="{ 'show': $store.actionModal.open }" x-cloak>
        <div class="modal-content-custom" style="max-width: 470px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25); border: 1px solid #e2e8f0;" @click.away="$store.actionModal.open = false">
            
            <!-- Modal Header -->
            <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3"
                         :style="$store.actionModal.variant === 'danger'
                            ? 'width: 42px; height: 42px; background: rgba(220, 38, 38, 0.08); color: #dc2626; border: 1px solid rgba(220, 38, 38, 0.2);'
                            : 'width: 42px; height: 42px; background: rgba(244, 130, 33, 0.08); color: #f48221; border: 1px solid rgba(244, 130, 33, 0.2);'"
                         style="flex-shrink: 0;">
                        <span class="material-symbols-outlined fs-22" x-text="$store.actionModal.icon">delete_forever</span>
                    </div>
                    <div>
                        <h5 class="m-0 fw-700 text-dark" style="font-family: 'Poppins', sans-serif; font-size: 1.04rem;" x-text="$store.actionModal.title">Confirm Action</h5>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <span class="badge"
                                  :style="$store.actionModal.variant === 'danger'
                                    ? 'background: rgba(220, 38, 38, 0.08); color: #dc2626; font-size: 0.68rem; font-weight: 600; padding: 2px 7px; border-radius: 4px;'
                                    : 'background: rgba(244, 130, 33, 0.1); color: #f48221; font-size: 0.68rem; font-weight: 600; padding: 2px 7px; border-radius: 4px;'"
                                  x-text="$store.actionModal.variant === 'danger' ? 'Permanent Action' : 'Status Action'"></span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-action border-0 bg-transparent text-muted p-1" @click="$store.actionModal.open = false" style="cursor: pointer;" title="Close modal">
                    <span class="material-symbols-outlined fs-20">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body-custom px-4 py-3" style="background: #ffffff;">
                <div class="p-3 rounded-3 d-flex align-items-start gap-3 mb-2"
                     :style="$store.actionModal.variant === 'danger'
                        ? 'background: #fef2f2; border: 1px solid #fee2e2;'
                        : 'background: #fff7ed; border: 1px solid #ffedd5;'">
                    <span class="material-symbols-outlined flex-shrink-0 mt-0-5"
                          :class="$store.actionModal.variant === 'danger' ? 'text-danger' : 'text-orange'"
                          style="font-size: 20px;"
                          x-text="$store.actionModal.variant === 'danger' ? 'warning' : 'info'"></span>
                    <div>
                        <div class="fw-700 mb-1" style="font-size: 0.84rem;"
                             :class="$store.actionModal.variant === 'danger' ? 'text-danger' : 'text-dark'">
                            <span x-text="$store.actionModal.variant === 'danger' ? 'This action cannot be undone.' : 'Please confirm to continue.'"></span>
                        </div>
                        <p class="m-0 text-secondary" style="font-size: 0.81rem; line-height: 1.45;" x-text="$store.actionModal.message"></p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-1-5 px-1 mt-2 text-muted" style="font-size: 0.72rem;">
                    <span class="material-symbols-outlined fs-14">lock</span>
                    <span>Authenticated Administrator Request &bull; Immediate Execution</span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-custom d-flex justify-content-between align-items-center px-4 py-3 border-top" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                <button type="button" class="btn-pill-cancel px-3 py-1-5" @click="$store.actionModal.open = false" style="font-size: 0.82rem; font-weight: 600; border-radius: 8px;">
                    Cancel
                </button>
                <button type="button"
                        class="btn px-4 py-2 d-inline-flex align-items-center gap-2"
                        :class="$store.actionModal.variant === 'danger' ? 'btn-danger-brand' : 'btn-primary-custom'"
                        :disabled="$store.actionModal.loading"
                        @click="$store.actionModal.confirm()"
                        style="border-radius: 8px; font-weight: 600; font-size: 0.84rem;">
                    <span class="material-symbols-outlined fs-16" x-show="!$store.actionModal.loading" x-text="$store.actionModal.variant === 'danger' ? 'delete' : 'check'"></span>
                    <span class="spinner-border spinner-border-sm" x-show="$store.actionModal.loading"></span>
                    <span x-show="!$store.actionModal.loading" x-text="$store.actionModal.confirmText">Confirm</span>
                    <span x-show="$store.actionModal.loading">Processing...</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminNotifications', () => ({
                open: false,
                notifications: [],
                unreadCount: 0,
                filter: 'unread',
                loading: false,

                init() {
                    this.fetchNotifications();
                    // Auto-refresh every 60 seconds
                    setInterval(() => this.fetchNotifications(), 60000);
                },

                async fetchNotifications() {
                    try {
                        const response = await fetch('<?= BASE_URL ?>/admin/notifications?filter=' + this.filter);
                        const res = await response.json();
                        if (res.status === 'success') {
                            this.notifications = res.data;
                            this.unreadCount = res.unread_count;
                        }
                    } catch (error) {
                        console.error('Failed to fetch notifications:', error);
                    }
                },

                async markRead(id) {
                    try {
                        const formData = new FormData();
                        formData.append('id', id);
                        const response = await fetch('<?= BASE_URL ?>/admin/notifications/mark-read', {
                            method: 'POST',
                            body: formData
                        });
                        const res = await response.json();
                        if (res.status === 'success') {
                            this.fetchNotifications();
                        }
                    } catch (error) {
                        console.error('Failed to mark notification as read:', error);
                    }
                },

                getIcon(type) {
                    const icons = {
                        'Review Request': 'rate_review',
                        'New Member': 'person_add',
                        'New Application': 'assignment_ind',
                        'System': 'settings_suggest'
                    };
                    return icons[type] || 'notifications';
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
            }));
        });

        document.addEventListener('alpine:init', () => {
            Alpine.store('actionModal', {
                open: false,
                id: null,
                type: null,
                title: 'Are you sure?',
                message: '',
                confirmText: 'Confirm',
                variant: 'danger',
                icon: 'warning',
                loading: false,
                actionUrl: '<?= BASE_URL ?>/admin/delete',
                callback: null,

                show(options) {
                    this.id = options.id;
                    this.type = options.type || '';
                    this.title = options.title || 'Are you sure?';
                    this.message = options.message || '';
                    this.confirmText = options.confirmText || 'Confirm';
                    this.variant = options.variant || 'danger';
                    this.icon = options.icon || (options.variant === 'danger' ? 'delete_forever' : 'info');
                    this.actionUrl = options.actionUrl || '<?= BASE_URL ?>/admin/delete';
                    this.callback = options.callback || null;
                    this.loading = false;
                    this.open = true;
                },

                async confirm() {
                    this.loading = true;
                    try {
                        if (this.callback) {
                            await this.callback(this.id);
                            this.open = false;
                            this.loading = false;
                            return;
                        }

                        const formData = new URLSearchParams();
                        formData.append('id', this.id);
                        if (this.type) formData.append('type', this.type);

                        const response = await fetch(this.actionUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData.toString()
                        });

                        const data = await response.json();
                        if (data.status === 'success') {
                            showToast(data.message);
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showToast(data.message, 'error');
                            this.loading = false;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('An unexpected error occurred.', 'error');
                        this.loading = false;
                    }
                }
            });
        });

        function deleteItem(id, type) {
            if (window.Alpine && Alpine.store('actionModal')) {
                Alpine.store('actionModal').show({
                    id: id,
                    type: type,
                    title: 'Delete ' + type.charAt(0).toUpperCase() + type.slice(1),
                    message: `You are about to delete this ${type}. This action is permanent and cannot be undone.`,
                    confirmText: 'Yes, Delete',
                    variant: 'danger',
                    icon: 'warning',
                    actionUrl: '<?= BASE_URL ?>/admin/delete'
                });
            } else {
                // Wait for Alpine to initialize rather than popping native confirm
                setTimeout(() => deleteItem(id, type), 100);
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        // --- CKEditor Initializer ---
        const editors = {};
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.rich-editor').forEach(el => {
                ClassicEditor
                    .create(el, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|', 'undo', 'redo'],
                    })
                    .then(editor => {
                        editors[el.name] = editor;
                    })
                    .catch(error => {
                        console.error('CKEditor Init Error:', error);
                    });
            });
        });

        async function submitForm(event, type, callbackOrModal) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');

            if (form.dataset.submitting === 'true') return;

            // Sync CKEditor data back to textareas
            if (typeof editors !== 'undefined') {
                for (const name in editors) {
                    const textarea = form.querySelector(`[name="${name}"]`);
                    if (textarea) {
                        textarea.value = editors[name].getData();
                    }
                }
            }

            const formData = new FormData(form);

            // Disable button and show loading state
            const originalBtnContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            form.dataset.submitting = 'true';

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/store', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showToast(data.message);
                    if (typeof window[callbackOrModal] === 'function') {
                        setTimeout(() => window[callbackOrModal](), 1000);
                    } else if (document.getElementById(callbackOrModal)) {
                        closeModal(callbackOrModal);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    console.error('Error details:', data);
                    showToast(data.message || 'Validation or database error.', 'error');

                    // Reset button on error
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                    delete form.dataset.submitting;
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An unexpected error occurred.', 'error');

                // Reset button on catch
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
                delete form.dataset.submitting;
            }
        }

        function showToast(message, type = 'success') {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: type === 'success' ? "#28a745" : "#dc3545",
                stopOnFocus: true,
            }).showToast();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggle && sidebar) {
                toggle.addEventListener('click', () => {
                    if (window.innerWidth <= 991) {
                        sidebar.classList.toggle('show');
                        overlay.classList.toggle('show');
                    } else {
                        sidebar.classList.toggle('collapsed');
                        document.querySelector('.admin-main-content').classList.toggle('expanded');
                        document.querySelector('.admin-header').classList.toggle('expanded');
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>
