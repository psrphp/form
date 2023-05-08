<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <textarea name="{$name}" class="form-control" id="{$id}_field" rows="{$rows??'3'}" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>{$value}</textarea>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>