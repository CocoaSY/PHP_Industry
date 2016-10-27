$(function () {
    'use strict';
    $('#fileupload').fileupload({
        xhrFields: {withCredentials: true},
        url: 'localhost/flatlab/assests/file-uploader/server/php/'
    });
    $('#fileupload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));
    if (window.location.hostname === 'blueimp.github.io') {
        $('#fileupload').fileupload('option', {
            url: 'localhost/flatlab/assests/file-uploader/server/php/',
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        if ($.support.cors) {
            $.ajax({url: 'localhost/flatlab/assests/file-uploader/server/php/', type: 'HEAD'}).fail(function () {
                $('<div class="alert alert-danger"/>').text('Upload server currently unavailable - ' +
                new Date()).appendTo('#fileupload');
            });
        }
    } else {
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
        });
    }
});