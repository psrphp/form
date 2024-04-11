<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use Stringable;

class Builder implements Stringable
{
    protected $data = [
        'body' => ''
    ];

    protected $title = '表单';
    protected $action = '';
    protected $method = 'POST';
    protected $body = '';

    public function __construct(string $title, string $action = '', string $method = 'POST')
    {
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= '<div>' . implode('</div><div>', $items) . '</div>';
        return $this;
    }

    public function __toString()
    {
        $tpl = <<<'str'
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <style>*,*::before,*::after{box-sizing:border-box;}@media (prefers-reduced-motion:no-preference){:root{scroll-behavior:smooth;}}body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0,0,0,0);}hr{margin:1rem 0;color:inherit;border:0;border-top:1px solid;opacity:0.25;}h6,h5,h4,h3,h2,h1{margin-top:0;margin-bottom:0.5rem;font-weight:500;line-height:1.2;color:inherit;}h1{font-size:calc(1.375rem + 1.5vw);}@media (min-width:1200px){h1{font-size:2.5rem;}}h2{font-size:calc(1.325rem + 0.9vw);}@media (min-width:1200px){h2{font-size:2rem;}}h3{font-size:calc(1.3rem + 0.6vw);}@media (min-width:1200px){h3{font-size:1.75rem;}}h4{font-size:calc(1.275rem + 0.3vw);}@media (min-width:1200px){h4{font-size:1.5rem;}}h5{font-size:1.25rem;}h6{font-size:1rem;}p{margin-top:0;margin-bottom:1rem;}abbr[title]{-webkit-text-decoration:underline dotted;text-decoration:underline dotted;cursor:help;-webkit-text-decoration-skip-ink:none;text-decoration-skip-ink:none;}address{margin-bottom:1rem;font-style:normal;line-height:inherit;}ol,ul{padding-left:2rem;}ol,ul,dl{margin-top:0;margin-bottom:1rem;}ol ol,ul ul,ol ul,ul ol{margin-bottom:0;}dt{font-weight:700;}dd{margin-bottom:0.5rem;margin-left:0;}blockquote{margin:0 0 1rem;}b,strong{font-weight:bolder;}small{font-size:0.875em;}mark{padding:0.1875em;color:#212529;background-color:#fff3cd;}sub,sup{position:relative;font-size:0.75em;line-height:0;vertical-align:baseline;}sub{bottom:-0.25em;}sup{top:-0.5em;}a{color:rgba(13,110,253,1);text-decoration:underline;}a:hover{color:10,88,202;}a:not([href]):not([class]),a:not([href]):not([class]):hover{color:inherit;text-decoration:none;}pre,code,kbd,samp{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em;}pre{display:block;margin-top:0;margin-bottom:1rem;overflow:auto;font-size:0.875em;}pre code{font-size:inherit;color:inherit;word-break:normal;}code{font-size:0.875em;color:#d63384;word-wrap:break-word;}a>code{color:inherit;}kbd{padding:0.1875rem 0.375rem;font-size:0.875em;color:#fff;background-color:#212529;border-radius:0.25rem;}kbd kbd{padding:0;font-size:1em;}figure{margin:0 0 1rem;}img,svg{vertical-align:middle;}table{caption-side:bottom;border-collapse:collapse;}caption{padding-top:0.5rem;padding-bottom:0.5rem;color:rgba(33,37,41,0.75);text-align:left;}th{text-align:inherit;text-align:-webkit-match-parent;}thead,tbody,tfoot,tr,td,th{border-color:inherit;border-style:solid;border-width:0;}label{display:inline-block;}button{border-radius:0;}button:focus:not(:focus-visible){outline:0;}input,button,select,optgroup,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}button,select{text-transform:none;}[role=button]{cursor:pointer;}select{word-wrap:normal;}select:disabled{opacity:1;}[list]:not([type=date]):not([type=datetime-local]):not([type=month]):not([type=week]):not([type=time])::-webkit-calendar-picker-indicator{display:none !important;}button,[type=button],[type=reset],[type=submit]{-webkit-appearance:button;}button:not(:disabled),[type=button]:not(:disabled),[type=reset]:not(:disabled),[type=submit]:not(:disabled){cursor:pointer;}::-moz-focus-inner{padding:0;border-style:none;}textarea{resize:vertical;}fieldset{min-width:0;padding:0;margin:0;border:0;}legend{float:left;width:100%;padding:0;margin-bottom:0.5rem;font-size:calc(1.275rem + 0.3vw);line-height:inherit;}@media (min-width:1200px){legend{font-size:1.5rem;}}legend+*{clear:left;}::-webkit-datetime-edit-fields-wrapper,::-webkit-datetime-edit-text,::-webkit-datetime-edit-minute,::-webkit-datetime-edit-hour-field,::-webkit-datetime-edit-day-field,::-webkit-datetime-edit-month-field,::-webkit-datetime-edit-year-field{padding:0;}::-webkit-inner-spin-button{height:auto;}[type=search]{-webkit-appearance:textfield;outline-offset:-2px;}::-webkit-search-decoration{-webkit-appearance:none;}::-webkit-color-swatch-wrapper{padding:0;}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button;}::file-selector-button{font:inherit;-webkit-appearance:button;}output{display:inline-block;}iframe{border:0;}summary{display:list-item;cursor:pointer;}progress{vertical-align:baseline;}[hidden]{display:none !important;}</style>
</head>

<body style="padding: 10px;">
    <form action="{$action}" method="{$method}" enctype="application/x-www-form-urlencoded">
        <h1>{$title}</h1>
        <div style="display: flex;flex-direction: column;gap: 10px;">
            {$body}
        </div>
        <div style="margin-top: 20px;">
            <input type="submit" value="提交" />
        </div>
        <script>
            (function() {
                var form = document.currentScript.parentNode;
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
                    xmlhttp.responseType = "JSON";
                    xmlhttp.onerror = function(e) {
                        alert("错误");
                    };
                    xmlhttp.ontimeout = function(e) {
                        alert("超时");
                    };
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4) {
                            if (xmlhttp.status == 200) {
                                if(xmlhttp.response.message){
                                    alert(xmlhttp.response.message);
                                }
                                if (!xmlhttp.response.errcode == 0) {
                                    window.history.go(-1);
                                } else {
                                    alert("错误代码：" + xmlhttp.response.errcode);
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
    </form>
</body>

</html>
str;
        return str_replace([
            '{$title}',
            '{$action}',
            '{$method}',
            '{$body}'
        ], [
            $this->title,
            $this->action,
            $this->method,
            $this->body,
        ], $tpl);
    }
}
