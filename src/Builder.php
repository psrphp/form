<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;
use Stringable;

class Builder implements Stringable
{
    protected $data = [
        'body' => ''
    ];

    public function __construct(string $title, string $action = '', string $method = 'POST')
    {
        $this->data['title'] = $title;
        $this->data['action'] = $action;
        $this->data['method'] = $method;
    }

    public function setLang(string $lang)
    {
        $this->data['lang'] = $lang;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->data['body'] .= implode('', $items);
        return $this;
    }

    private function getTpl(): string
    {
        return <<<'str'
<!DOCTYPE html>
<html lang="{$lang ?? 'zh-CN'}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title ?: '表单'}</title>
    <style>html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}main{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}template{display:none}[hidden]{display:none}</style>
    <style>
        body{
            padding: 10px;
        }
    </style>
</head>

<body>
    <form action="{$action?:''}" method="{$method?:'POST'}" enctype="{$enctype??'application/x-www-form-urlencoded'}" id="form">
        <h1>{$title?:'表单'}</h1>
        <div style="display: flex;flex-direction: column;gap: 10px;">
            {echo $body}
        </div>
        <div style="margin-top: 20px;">
            <button type="submit">提交</button>
        </div>
    </form>

    <script>
        (function() {
            var form = document.getElementById("form");
            form.onsubmit = function() {
                event.preventDefault();
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open(event.target.method, event.target.action, true);
                xmlhttp.setRequestHeader("Accept", "application/json");
                xmlhttp.responseType = "json";
                xmlhttp.onerror = function(e) {};
                xmlhttp.ontimeout = function(e) {
                    alert("超时");
                };
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4) {
                        if (xmlhttp.status == 200) {
                            alert(xmlhttp.response.message);
                            if (!xmlhttp.response.errcode) {
                                window.history.go(-1);
                            }
                        } else {
                            alert("[" + xmlhttp.status + "] " + xmlhttp.statusText);
                        }
                    }
                }
                xmlhttp.send(new FormData(form));
            }
        })()
    </script>
</body>

</html>
str;
    }

    public function __toString()
    {
        return (new Template())->renderFromString($this->getTpl(), $this->data);
    }
}
