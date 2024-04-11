<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class SimpleMDE extends Common
{
    public function __construct(string $label, string $name, $value = null, string $upload_url = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
        $this->set('upload_url', $upload_url);
    }

    public function getTpl(): string
    {
        return <<<'str'
<link href="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
<textarea style="display: none;" name="{$name}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
<script>
    (function() {
        var upload_url = "{$upload_url??''}";
        var textarea = document.currentScript.previousElementSibling;
        new SimpleMDE({
            element: textarea,
            spellChecker: false,
            toolbar: ["bold", "italic", "strikethrough", "heading", "code", "quote", "|", "unordered-list", "ordered-list", "clean-block", "link", "image", "table", "horizontal-rule", "|", {
                name: "",
                action: function customeFunction(editor) {
                    var cm = editor.codemirror;
                    if (/editor-preview-active/.test(cm.getWrapperElement().lastChild.className)) {
                        return;
                    }
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
                                        cm.replaceSelection("[" + response.data.src + "](" + response.data.src + ")");
                                        cm.focus();
                                    }
                                });
                            }
                        }
                    }
                    fileinput.click();
                },
                className: "fa fa-upload",
                title: "文件上传"
            }, "|", "preview", "side-by-side", "fullscreen"]
        });
    })()
</script>
str;
    }
}
