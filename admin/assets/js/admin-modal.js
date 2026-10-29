/**
 *  Spider Tech Admin Console - Custom Branded Confirmation Modal
 *  Replaces native browser confirm() with an accessible frosted modal dialog.
 **/
$(document).ready(function () {
    // Inject modal DOM if not already present
    if ($('#adminConfirmModal').length === 0) {
        var modalHtml = 
            '<div id="adminConfirmModal" class="admin-modal-backdrop" style="display: none;">' +
                '<div class="admin-modal-dialog">' +
                    '<div class="admin-modal-icon-wrap">' +
                        '<i class="fa fa-exclamation-triangle"></i>' +
                    '</div>' +
                    '<h3 class="admin-modal-title">Confirm Deletion</h3>' +
                    '<p class="admin-modal-text">Are you sure you want to permanently delete <strong id="adminModalItemName">this record</strong>? This action cannot be reversed.</p>' +
                    '<div class="admin-modal-actions">' +
                        '<button type="button" class="admin-modal-btn admin-modal-btn-cancel" id="adminModalCancelBtn">Cancel</button>' +
                        '<a href="#" class="admin-modal-btn admin-modal-btn-confirm" id="adminModalConfirmBtn">Delete Permanently</a>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('body').append(modalHtml);
    }

    // Modal Control Functions
    window.openDeleteModal = function (deleteUrl, itemName) {
        var displayName = itemName ? '"' + itemName + '"' : 'this record';
        $('#adminModalItemName').text(displayName);
        $('#adminModalConfirmBtn').attr('href', deleteUrl);
        $('#adminConfirmModal').fadeIn(180);
    };

    window.closeDeleteModal = function () {
        $('#adminConfirmModal').fadeOut(140);
    };

    // Event delegation for trigger buttons
    $(document).on('click', '.trigger-delete-modal', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-delete-url') || $(this).attr('href');
        var name = $(this).attr('data-item-name') || $(this).data('item-name') || '';
        window.openDeleteModal(url, name);
    });

    // Close on cancel click
    $(document).on('click', '#adminModalCancelBtn', function (e) {
        e.preventDefault();
        window.closeDeleteModal();
    });

    // Close on backdrop click
    $(document).on('click', '#adminConfirmModal', function (e) {
        if (e.target === this) {
            window.closeDeleteModal();
        }
    });

    // Close on Escape key press
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $('#adminConfirmModal').is(':visible')) {
            window.closeDeleteModal();
        }
    });
});
