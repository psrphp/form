<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
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
                        var form = new FormData();
                        form.append("file", file);

                        var xmlhttp;
                        if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                        } else {
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.open("POST", url, true);
                        xmlhttp.setRequestHeader("Accept", "application/json");
                        xmlhttp.responseType = "json";
                        xmlhttp.onerror = function(e) {};
                        xmlhttp.ontimeout = function(e) {
                            alert("Timeout!!");
                        };
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4) {
                                if (xmlhttp.status == 200) {
                                    if (xmlhttp.response.errcode) {
                                        alert(xmlhttp.response.message);
                                    } else {
                                        callback(xmlhttp.response);
                                    }
                                } else {
                                    alert("[" + xmlhttp.status + "] " + xmlhttp.statusText);
                                }
                            }
                        }
                        xmlhttp.send(form);
                    }
                    for (const key in files) {
                        if (Object.hasOwnProperty.call(files, key)) {
                            const ele = files[key];
                            upload_by_form(upload_url, ele, function(response) {
                                if (response.errcode) {
                                    alert(response.message);
                                } else {
                                    $(textarea).summernote('insertImage', response.data.src);
                                }
                            });
                        }
                    }
                }
            }
        });
    })()
</script>