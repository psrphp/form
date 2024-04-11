<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Code extends Common
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
    }

    public function getTpl(): string
    {
        return <<<'str'
<link href="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/codemirror.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/php/php.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
<style>
    .code-container .CodeMirror {
        border: 1px solid #ddd;
        padding: 0;
        height: auto;
    }
</style>
<div class="code-container">
    <textarea name="{$name}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
    <script>
        (function() {
            var textarea = document.currentScript.previousElementSibling
            CodeMirror.fromTextArea(textarea, {
                lineNumbers: true,
                matchBrackets: true,
                mode: "htmlmixed",
                indentUnit: 4,
                indentWithTabs: true,
                lineWrapping: true,
            });
        })()
    </script>
</div>
str;
    }
}
