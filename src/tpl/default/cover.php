<?php $_id = uniqid('f_'); ?>
<div style="min-height: 100px;" id="{$_id}">
    <input type="text" style="display: none;" name="{$name}" value="{$value}">
    <div style="width: 145px;height: 100px;display: flex;flex-direction: row;justify-content: center;align-items: center;background: #eee;padding: 5px;">
        <img style="max-height:100%;max-width:100%;" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTgwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KIDwhLS0gQ3JlYXRlZCB3aXRoIE1ldGhvZCBEcmF3IC0gaHR0cDovL2dpdGh1Yi5jb20vZHVvcGl4ZWwvTWV0aG9kLURyYXcvIC0tPgogPGc+CiAgPHRpdGxlPmJhY2tncm91bmQ8L3RpdGxlPgogIDxyZWN0IGZpbGw9IiNmZmYiIGlkPSJjYW52YXNfYmFja2dyb3VuZCIgaGVpZ2h0PSI0MDIiIHdpZHRoPSI1ODIiIHk9Ii0xIiB4PSItMSIvPgogIDxnIGRpc3BsYXk9Im5vbmUiIG92ZXJmbG93PSJ2aXNpYmxlIiB5PSIwIiB4PSIwIiBoZWlnaHQ9IjEwMCUiIHdpZHRoPSIxMDAlIiBpZD0iY2FudmFzR3JpZCI+CiAgIDxyZWN0IGZpbGw9InVybCgjZ3JpZHBhdHRlcm4pIiBzdHJva2Utd2lkdGg9IjAiIHk9IjAiIHg9IjAiIGhlaWdodD0iMTAwJSIgd2lkdGg9IjEwMCUiLz4KICA8L2c+CiA8L2c+CiA8Zz4KICA8dGl0bGU+TGF5ZXIgMTwvdGl0bGU+CiAgPHRleHQgc3R5bGU9ImN1cnNvcjogbW92ZTsiIHN0cm9rZT0iIzAwMCIgdHJhbnNmb3JtPSJtYXRyaXgoNi44NjU2MTI1ODA2MjkyNjEsMCwwLDcuMjg3ODQyMzcwMDgyMjE3LC04NTQuNDIwODE1MTkxNTQ3OCwtOTg2LjEyNjIyMTA2NTUxNTgpICIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgdGV4dC1hbmNob3I9InN0YXJ0IiBmb250LWZhbWlseT0iSGVsdmV0aWNhLCBBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIyNCIgaWQ9InN2Z18xIiB5PSIxNjkuMTUyNjkiIHg9IjE0Mi4xMDY5OCIgc3Ryb2tlLXdpZHRoPSIwIiBmaWxsPSIjOTk5OTk5Ij7ml6Dlm748L3RleHQ+CiA8L2c+Cjwvc3ZnPg==">
    </div>
    <div style="margin-top: 5px;">
        <button type="button">上传图片</button>
        <button type="button">清空图片</button>
    </div>
</div>
<script>
    (function() {
        var contain = document.getElementById("{$_id}");
        var input = contain.children[0];
        var preview = contain.children[1].children[0];
        var handler = contain.children[2].children[0];
        var clearbtn = contain.children[2].children[1];
        var upload_url = "{$upload_url??''}";
        var noimg = preview.src;

        handler.onclick = function() {
            var upload_by_form = function(url, file, callback) {
                var data = new FormData();
                data.append("file", file);
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
                        alert("Error");
                    }
                });
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
                                preview.src = response.data.src;
                                preview.value = response.data.src
                            }
                        });
                    }
                }
            }
            fileinput.click();
        }
        clearbtn.onclick = function() {
            preview.src = noimg;
            input.value = "";
        }

        setTimeout(function() {
            if (input.value) {
                preview.src = input.value;
            }
        }, 100);
    })()
</script>