<?php $_id = uniqid('f_'); ?>
<div>
    <input type="text" name="{$name}" value="{$value}" id="{$_id}_field" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>
    <button type="button" id="{$_id}_trigger">上传</button>
</div>
<script>
    (function() {
        var upload_url = "{$upload_url}";
        var field = document.getElementById("{$_id}_field");
        var trigger = document.getElementById("{$_id}_trigger");
        trigger.onclick = function() {
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
            var fileinput = document.createElement("input");
            fileinput.type = "file";
            fileinput.onchange = function() {
                var files = event.target.files;
                for (const key in files) {
                    if (Object.hasOwnProperty.call(files, key)) {
                        const ele = files[key];
                        upload_by_form(upload_url, ele, function(response) {
                            if (response.errcode) {
                                alert(response.message);
                            } else {
                                field.value = response.data.src;
                            }
                        });
                    }
                }
            }
            fileinput.click();
        }
    })()
</script>