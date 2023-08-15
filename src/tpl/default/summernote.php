<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-{$lang??'zh-CN'}.min.js"></script>
<style>
    .note-editable {
        background-color: #fff;
    }

    .note-btn-group .dropdown-toggle::after {
        content: none;
        border: none;
        margin: 0;
    }
</style>
<?php $_id = uniqid('f_'); ?>
<textarea name="{$name}" id="{$_id}" style="display: none;" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
<script>
    (function() {
        var textarea = document.getElementById("{$_id}");
        var upload_url = "{$upload_url??''}";
        $(textarea).summernote({
            lang: "zh-CN",
            height: "250",
            callbacks: {
                onImageUpload: function(files) {
                    var upload_by_form = function(url, file, callback) {
                        var data = new FormData();
                        data.append('file', file);
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            cache: false,
                            processData: false,
                            contentType: false,
                            dataType: "JSON",
                            success: function(response) {
                                if (response.errcode) {
                                    alert(response.message);
                                } else {
                                    callback(response);
                                }
                            },
                            error: function() {
                                alert('Error');
                            }
                        });
                    }
                    $.each(files, function(indexInArray, valueOfElement) {
                        upload_by_form(upload_url, valueOfElement, function(response) {
                            if (response.errcode) {
                                alert(response.message);
                            } else {
                                $(textarea).summernote('insertImage', response.data.src);
                            }
                        });
                    });
                }
            }
        });
    })()
</script>