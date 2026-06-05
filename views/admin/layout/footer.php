</main> <!-- End of .admin-main-content -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div> <!-- End of .admin-wrapper -->

    <!-- Global Action Confirmation Modal (Alpine.js) -->
    <div x-data x-show="$store.actionModal.open" class="modal-custom" :class="{ 'show': $store.actionModal.open }" x-cloak>
        <div class="modal-content-custom" style="max-width: 400px;" @click.away="$store.actionModal.open = false">
            <div class="modal-body-custom text-center py-5">
                <div class="mb-4">
                    <span class="material-symbols-outlined"
                          :class="$store.actionModal.variant === 'danger' ? 'text-danger' : 'text-warning'"
                          style="font-size: 64px;"
                          x-text="$store.actionModal.icon">warning</span>
                </div>
                <h3 class="fw-700 mb-3" x-text="$store.actionModal.title">Are you sure?</h3>
                <p class="text-muted mb-4" x-text="$store.actionModal.message"></p>

                <div class="d-flex justify-content-center gap-3">
                    <button @click="$store.actionModal.open = false" class="btn btn-light px-4">Cancel</button>
                    <button @click="$store.actionModal.confirm()"
                            class="btn px-4"
                            :class="$store.actionModal.variant === 'danger' ? 'btn-danger' : 'btn-primary-custom'"
                            :disabled="$store.actionModal.loading">
                        <span x-show="!$store.actionModal.loading" x-text="$store.actionModal.confirmText">Confirm</span>
                        <span x-show="$store.actionModal.loading">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    this.icon = options.icon || 'warning';
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
                // Fallback to traditional confirm if Alpine is not ready
                if (confirm(`Are you sure you want to delete this ${type}?`)) {
                    // This is a simplified fallback that mimics the old behavior
                    const formData = new URLSearchParams();
                    formData.append('id', id);
                    formData.append('type', type);

                    fetch('<?= BASE_URL ?>/admin/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showToast(data.message);
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showToast(data.message, 'error');
                        }
                    });
                }
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
