<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;

class Upload implements ItemInterface
{
    private $label;
    private $name;
    private $upload_url;
    private $value = '';

    private $help = '';

    public function __construct(string $label, string $name, string $upload_url, string $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->upload_url = $upload_url;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function __toString(): string
    {
        $name = htmlspecialchars($this->name);
        $value = htmlspecialchars($this->value);
        $upload_url = htmlspecialchars($this->upload_url);

        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $str .= <<<str
<input type="text" name="{$name}" value="{$value}">
<input type="button" value="上传" />
<script>
(function() {
    var upload_url = "{$upload_url}";
    var field = document.currentScript.previousElementSibling.previousElementSibling;
    var trigger = document.currentScript.previousElementSibling;
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
                alert("上传超时!!");
            };
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 200) {
                        callback(xmlhttp.response);
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
                        if (response !== null && response.hasOwnProperty('src')) {
                            field.value = response.src;
                        } else {
                            alert('接口错误:' + JSON.stringify(response));
                        }
                    });
                }
            }
        }
        fileinput.click();
    }
})()
</script>
str;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
