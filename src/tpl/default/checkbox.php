<div style="display: flex;flex-direction: row;gap: 10px;">
    {foreach $items??[] as $_key => $_vo}
    {if is_array($_vo)}
    <div>
        <label>
            {if in_array($_vo['value'], (array)$value)}
            <input type="checkbox" name="{$name}[{$_vo['value']}]" value="{$_vo['value']}" checked>
            {else}
            <input type="checkbox" name="{$name}[{$_vo['value']}]" value="{$_vo['value']}">
            {/if}
            <span>{$_vo['label']??$_vo['value']}</span>
        </label>
    </div>
    {else}
    <div>
        <label>
            {if in_array($_key, (array)$value)}
            <input type="checkbox" name="{$name}[{$_key}]" value="{$_key}" checked>
            {else}
            <input type="checkbox" name="{$name}[{$_key}]" value="{$_key}">
            {/if}
            <span>{$_vo}</span>
        </label>
    </div>
    {/if}
    {/foreach}
</div>