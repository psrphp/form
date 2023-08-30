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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/lib/codemirror.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/lib/codemirror.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/mode/php/php.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@6.65.7/mode/xml/xml.min.js"></script>
<style>
    .code-container .CodeMirror {
        border: 1px solid #ddd;
        padding: 0;
        height: auto;
    }
</style>
<?php $id = uniqid('f_'); ?>
<div class="code-container" id="{$id}">
    <textarea name="{$name}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
</div>
<script>
    (function() {
        var textarea = document.getElementById("{$id}").children[0]
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
str;
    }
}
