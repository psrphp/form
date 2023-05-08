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
        $("#{$id}_handle").bind('click', function() {
            $(this).remove();
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
    });
</script>
{if !isset($hide) || !$hide}
<script>
    $(function() {
        $("#{$id}_handle").trigger('click');
    });
</script>
{/if}
<style>
    .code-container .CodeMirror {
        border: 1px solid #ddd;
    }
</style>
<div class="mt-2 code-container">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <textarea class="d-none" id="{$id}_field" name="{$name}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
    <div class="bg-light p-4 text-secondary" id="{$id}_handle"><svg t="1611996487173" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6178" width="18" height="18">
            <path d="M242.752 268.8l90.496 90.496-152.256 152.256 152.256 152.192-90.496 90.496L0 511.552zM780.992 268.8l-90.56 90.496 152.256 152.256-152.256 152.192 90.56 90.496 242.688-242.688z" fill="#425766" p-id="6179"></path>
            <path d="M513.024 192h128l-128 640h-128z" fill="#9AA8B3" p-id="6180"></path>
        </svg> 点此编辑</div>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>