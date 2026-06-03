</main> <!-- End of .admin-main-content -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div> <!-- End of .admin-wrapper -->

    <script>
        async function deleteItem(id, type) {
            if (!confirm(`Are you sure you want to delete this ${type}? This action cannot be undone.`)) {
                return;
            }

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `id=${id}&type=${type}`
                });

                const data = await response.json();
                console.log('Submission Response:', data);

                if (data.status === 'success') {
                    showToast(data.message);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An unexpected error occurred.', 'error');
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
