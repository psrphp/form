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
<div class="mt-2">
    <label class="form-label">{$label}</label>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-{$lang??'zh-CN'}.min.js"></script>
    <textarea name="{$name}" class="d-none" id="{$id}_field" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
    <script>
        $(document).ready(function() {
            $("#{$id}_field").summernote({
                lang: "{$lang??'zh-CN'}",
                height: "{$height??'250'}",
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
                            upload_by_form("{$upload_url??''}", valueOfElement, function(response) {
                                if (response.errcode) {
                                    alert(response.message);
                                } else {
                                    $("#{$id}_field").summernote('insertImage', response.data.src);
                                }
                            });
                        });
                    }
                }
            });
        });
    </script>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>