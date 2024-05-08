<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;

class SimpleMDE implements ItemInterface
{
    private $label;
    private $name;
    private $value = '';

    private $help = '';

    private $placeholder = '';

    private $upload_url = '';

    public function __construct(string $label, string $name, string $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setUploadUrl(string $upload_url): self
    {
        $this->upload_url = $upload_url;
        return $this;
    }

    public function __toString(): string
    {
        $name = htmlspecialchars($this->name);
        $value = htmlspecialchars($this->value);
        $placeholder = htmlspecialchars($this->placeholder);
        $upload_url = $this->upload_url;

        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $str .= <<<str
<link href="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
<textarea name="{$name}">{$value}</textarea>
<script>
    (function() {
        var upload_url = "{$upload_url}";
        var textarea = document.currentScript.previousElementSibling;
        var toolbar = ["bold", "italic", "strikethrough", "heading", "code", "quote", "|", "unordered-list",
            "ordered-list", "clean-block", "link", "image", "table", "horizontal-rule"
        ];
        if (upload_url.length) {
            toolbar.push({
                name: "uploadfile",
                title: "文件上传",
                className: "fa fa-upload",
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
                                    callback(xmlhttp.response);
                                } else {
                                    console.info(xmlhttp);
                                    alert("接口错误：" + xmlhttp.status);
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
                                    if (response !== null && response.hasOwnProperty('src')) {
                                        cm.replaceSelection("[" + response.src + "](" + response.src + ")");
                                        cm.focus();
                                    } else {
                                        alert('接口错误:' + JSON.stringify(response));
                                    }
                                });
                            }
                        }
                    }
                    fileinput.click();
                },
            });
        }
        toolbar.push("|", "preview", "side-by-side", "fullscreen", "guide");

        new SimpleMDE({
            element: textarea,
            spellChecker: false,
            toolbar: toolbar,
            placeholder: '{$placeholder}',
            status: false,
        });
    })()
</script>
str;

        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
