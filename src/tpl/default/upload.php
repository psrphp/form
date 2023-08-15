<?php $_id = uniqid('f_'); ?>
<div>
    <input type="text" name="{$name}" value="{$value}" id="{$_id}_field" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>
    <button type="button" id="{$_id}_trigger">上传</button>
</div>
<script>
    $(document).ready(function() {
        $("#{$_id}_trigger").bind('click', function() {
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
                            $("#{$_id}_field").val(response.data.src);
                        }
                    });
                });
            }
            fileinput.click();
        });
    });
</script>