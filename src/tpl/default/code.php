<?php
$mode = $mode ?? 'htmlmixed';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/lib/codemirror.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/lib/codemirror.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/mode/{$mode}/{$mode}.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/mode/php/php.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.62.0/mode/xml/xml.min.js"></script>
<script>
    $(function() {
        CodeMirror.fromTextArea(document.getElementById("{$id}_field"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "{$mode}",
            indentUnit: 4,
            indentWithTabs: true,
            lineWrapping: true,
        });
        $("#{$id}_field").parent().find(".CodeMirror").height("{$height??'300px'}").css({
            padding: 0,
        });
    });
</script>
<style>
    .code-container .CodeMirror {
        border: 1px solid #ddd;
    }
</style>
<div class="mt-2 code-container">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <textarea class="d-none" id="{$id}_field" name="{$name}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>