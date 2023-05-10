<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <div class="input-group">
        <input type="text" name="{$name}" value="{$value}" id="{$id}_field" class="form-control" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>
        <button class="btn btn-primary" type="button" id="{$id}_trigger">上传</button>
    </div>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
    <script>
        $(document).ready(function() {
            $("#{$id}_trigger").bind('click', function() {
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
                var fileinput = document.createElement("input");
                fileinput.type = "file";
                fileinput.onchange = function() {
                    $.each(event.target.files, function(indexInArray, valueOfElement) {
                        upload_by_form("{$upload_url}", valueOfElement, function(response) {
                            if (response.errcode) {
                                alert(response.message);
                            } else {
                                $("#{$id}_field").val(response.data.src);
                            }
                        });
                    });
                }
                fileinput.click();
            });
        });
    </script>
</div>