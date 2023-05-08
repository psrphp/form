<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <select name="{$name}" class="form-select" id="{$id}_field" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?>>
        {foreach $items??[] as $_key=>$_vo}
        {if is_array($_vo)}
            {if isset($_vo['value'])}
                {if in_array($_vo['value'], (array)$value)}
                <option value="{$_vo['value']}" selected>{$_vo['label']??$_vo['value']}</option>
                {else}
                <option value="{$_vo['value']}">{$_vo['label']??$_vo['value']}</option>
                {/if}
            {else}
            <optgroup label="{$_key}">
                {foreach $_vo as $_subkey => $_subvo}
                    {if is_array($_subvo)}
                        {if in_array($_subvo['value'], (array)$value)}
                        <option value="{$_subvo['value']}" selected>{$_subvo['label']??$_subvo['value']}</option>
                        {else}
                        <option value="{$_subvo['value']}">{$_subvo['label']??$_subvo['value']}</option>
                        {/if}
                    {else}
                        {if in_array($_subkey, (array)$value)}
                        <option value="{$_subkey}" selected>{$_subvo}</option>
                        {else}
                        <option value="{$_subkey}">{$_subvo}</option>
                        {/if}
                    {/if}
                {/foreach}
            </optgroup>
            {/if}
        {else}
            {if in_array($_key, (array)$value)}
            <option value="{$_key}" selected>{$_vo}</option>
            {else}
            <option value="{$_key}">{$_vo}</option>
            {/if}
        {/if}
        {/foreach}
    </select>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>