/**
 *  Document   : summernote-data.js
 *  Description: Comprehensive rich text editor configuration with full typography & content control
 **/
$(document).ready(function () {
    var baseToolbar = [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph', 'height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
    ];

    var styleTags = [
        'p',
        { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
        'pre',
        { title: 'Heading 1', tag: 'h1', className: '', value: 'h1' },
        { title: 'Heading 2', tag: 'h2', className: '', value: 'h2' },
        { title: 'Heading 3', tag: 'h3', className: '', value: 'h3' },
        { title: 'Heading 4', tag: 'h4', className: '', value: 'h4' },
        { title: 'Heading 5', tag: 'h5', className: '', value: 'h5' },
        { title: 'Heading 6', tag: 'h6', className: '', value: 'h6' }
    ];

    var fontNames = [
        'Open Sans', 'Poppins', 'Chakra Petch',
        'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
        'Georgia', 'Helvetica', 'Impact', 'Lucida Grande',
        'Tahoma', 'Times New Roman', 'Verdana'
    ];

    var fontSizes = ['9', '10', '11', '12', '13', '14', '15', '16', '18', '20', '22', '24', '28', '32', '36', '48'];
    var lineHeights = ['1.0', '1.2', '1.4', '1.6', '1.8', '2.0', '2.5'];

    // Primary form editor with full height
    if ($('#formsummernote').length) {
        $('#formsummernote').summernote({
            placeholder: 'Compose and format your content here (use headings, quotes, bullet/numbered lists)...',
            tabsize: 2,
            height: 480,
            minHeight: 250,
            dialogsInBody: true,
            dialogsFade: true,
            toolbar: baseToolbar,
            styleTags: styleTags,
            fontNames: fontNames,
            fontNamesIgnoreCheck: ['Open Sans', 'Poppins', 'Chakra Petch'],
            fontSizes: fontSizes,
            lineHeights: lineHeights
        });
    }

    // Secondary / compact editor
    if ($('#summernote').length) {
        $('#summernote').summernote({
            placeholder: 'Enter content...',
            tabsize: 2,
            height: 320,
            minHeight: 180,
            dialogsInBody: true,
            dialogsFade: true,
            toolbar: baseToolbar,
            styleTags: styleTags,
            fontNames: fontNames,
            fontNamesIgnoreCheck: ['Open Sans', 'Poppins', 'Chakra Petch'],
            fontSizes: fontSizes,
            lineHeights: lineHeights
        });
    }

    // Generic class-based summernote instances
    if ($('.summernote').length) {
        $('.summernote').each(function () {
            if (!$(this).data('summernote')) {
                $(this).summernote({
                    placeholder: 'Enter content...',
                    tabsize: 2,
                    height: 350,
                    minHeight: 200,
                    dialogsInBody: true,
                    dialogsFade: true,
                    toolbar: baseToolbar,
                    styleTags: styleTags,
                    fontNames: fontNames,
                    fontNamesIgnoreCheck: ['Open Sans', 'Poppins', 'Chakra Petch'],
                    fontSizes: fontSizes,
                    lineHeights: lineHeights
                });
            }
        });
    }
});
