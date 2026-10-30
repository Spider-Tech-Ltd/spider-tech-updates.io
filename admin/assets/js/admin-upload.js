/**
 * Spider Tech Admin - Interactive Image Upload & Dropzone Controller
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        // Handle drag and drop feedback
        $(document).on('dragover dragenter', '.admin-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('is-dragover');
        });

        $(document).on('dragleave dragend drop', '.admin-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('is-dragover');
        });

        // Handle drop event
        $(document).on('drop', '.admin-dropzone', function (e) {
            var files = e.originalEvent.dataTransfer.files;
            if (files && files.length > 0) {
                var fileInput = $(this).find('input[type="file"]')[0];
                if (fileInput) {
                    fileInput.files = files;
                    $(fileInput).trigger('change');
                }
            }
        });

        // Handle click on dropzone to trigger hidden input
        $(document).on('click', '.admin-dropzone', function (e) {
            if ($(e.target).is('input[type="file"]') || $(e.target).closest('.admin-preview-remove').length) {
                return;
            }
            $(this).find('input[type="file"]').trigger('click');
        });

        // Handle file change
        $(document).on('change', '.admin-dropzone input[type="file"], input[data-upload-preview]', function () {
            var input = this;
            var dropzone = $(this).closest('.admin-dropzone-wrap');
            var previewContainer = dropzone.find('.admin-preview-container');
            var previewImg = previewContainer.find('.admin-preview-img');
            var filenameSpan = previewContainer.find('.admin-preview-filename');

            if (input.files && input.files[0]) {
                var file = input.files[0];

                // Validate file type
                var validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, or WebP).');
                    input.value = '';
                    return;
                }

                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Image size exceeds 5MB limit. Please choose a smaller image.');
                    input.value = '';
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.attr('src', e.target.result);
                    if (filenameSpan.length) {
                        var sizeKb = Math.round(file.size / 1024);
                        filenameSpan.text(file.name + ' (' + sizeKb + ' KB)');
                    }
                    previewContainer.slideDown(200);
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle remove preview
        $(document).on('click', '.admin-preview-remove', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var dropzone = $(this).closest('.admin-dropzone-wrap');
            var input = dropzone.find('input[type="file"]');
            var previewContainer = dropzone.find('.admin-preview-container');
            var previewImg = previewContainer.find('.admin-preview-img');

            input.val('');
            previewImg.attr('src', '');
            previewContainer.slideUp(150);
        });
    });
})(jQuery);
