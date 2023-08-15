<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<?php $_id = uniqid('f_'); ?>
<textarea style="display: none;" name="{$name}" id="{$_id}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
<script>
    (function() {
        new SimpleMDE({
            element: document.getElementById("{$_id}"),
            spellChecker: false,
            toolbar: ["bold", "italic", "strikethrough", "heading", "code", "quote", "|", "unordered-list", "ordered-list", "clean-block", "link", "image", "table", "horizontal-rule", "|", {
                name: "",
                action: function customeFunction(editor) {
                    var cm = editor.codemirror;
                    if (/editor-preview-active/.test(cm.getWrapperElement().lastChild.className)) {
                        return;
                    }
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
                            upload_by_form("{$upload_url??''}", valueOfElement, function(response) {
                                if (response.errcode) {
                                    alert(response.message);
                                } else {
                                    cm.replaceSelection("[" + response.data.src + "](" + response.data.src + ")");
                                    cm.focus();
                                }
                            });
                        });
                    }
                    fileinput.click();
                },
                className: "fa fa-upload",
                title: "文件上传"
            }, "|", "preview", "side-by-side", "fullscreen"]
        });
    })()
</script>