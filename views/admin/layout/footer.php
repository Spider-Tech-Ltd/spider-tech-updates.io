</main> <!-- End of .admin-main-content -->
    </div> <!-- End of .admin-wrapper -->

    <script>
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

            if (toggle && sidebar) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    document.querySelector('.admin-main-content').classList.toggle('expanded');
                    document.querySelector('.admin-header').classList.toggle('expanded');
                });
            }
        });
    </script>
</body>
</html>
