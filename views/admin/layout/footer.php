</main> <!-- End of .admin-main-content -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div> <!-- End of .admin-wrapper -->

    <!-- Global Delete Confirmation Modal (Alpine.js) -->
    <div class="modal-custom"
         :class="{ 'show': deleteModal.open }"
         x-cloak
         @open-delete-modal.window="deleteModal.id = $event.detail.id; deleteModal.type = $event.detail.type; deleteModal.open = true;">
        <div class="modal-content-custom" style="max-width: 400px;" @click.away="deleteModal.open = false">
            <div class="modal-body-custom text-center py-5">
                <div class="mb-4">
                    <span class="material-symbols-outlined text-danger" style="font-size: 64px;">warning</span>
                </div>
                <h3 class="fw-700 mb-3">Are you sure?</h3>
                <p class="text-muted mb-4">You are about to delete this <span x-text="deleteModal.type"></span>. This action is permanent and cannot be undone.</p>

                <div class="d-flex justify-content-center gap-3">
                    <button @click="deleteModal.open = false" class="btn btn-light px-4">Cancel</button>
                    <button @click="confirmDelete()" class="btn btn-danger px-4" :disabled="deleteModal.loading">
                        <span x-show="!deleteModal.loading">Yes, Delete</span>
                        <span x-show="deleteModal.loading">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('globalUI', () => ({
                deleteModal: {
                    open: false,
                    id: null,
                    type: null,
                    loading: false
                },
                async confirmDelete() {
                    this.deleteModal.loading = true;
                    try {
                        const response = await fetch('<?= BASE_URL ?>/admin/delete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: `id=${this.deleteModal.id}&type=${this.deleteModal.type}`
                        });

                        const data = await response.json();
                        if (data.status === 'success') {
                            showToast(data.message);
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showToast(data.message, 'error');
                            this.deleteModal.loading = false;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('An unexpected error occurred.', 'error');
                        this.deleteModal.loading = false;
                    }
                }
            }));
        });

        function deleteItem(id, type) {
            // Dispatch a window event that Alpine.js is listening for
            if (window.Alpine) {
                window.dispatchEvent(new CustomEvent('open-delete-modal', {
                    detail: { id, type }
                }));
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
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An unexpected error occurred.', 'error');
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
