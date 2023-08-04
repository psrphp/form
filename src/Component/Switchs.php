<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\Builder;
use PsrPHP\Form\Field\Common;

class Switchs extends Common
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->switchs = [];
    }

    public function addSwitch(SwitchItem ...$switchs): self
    {
        foreach ($switchs as $item) {
            $tmp = $this->switchs;
            array_push($tmp, [
                'label' => $item->getLabel(),
                'value' => $item->getValue(),
                'body' => $item->getBody(),
            ]);
            $this->switchs = $tmp;
        }
        return $this;
    }

    public function __toString()
    {
        $tpl = <<<'str'
<script>
    $(function() {
        $("#{$id}_handle > div > input").bind("click", function() {
            $("#" + $(this).attr('id') + "_target").removeClass('d-none').siblings().addClass('d-none')
        });
    });
</script>
<div class="mt-2">
    <label class="form-label">{$label}</label>
    <div id="{$id}_handle">
        {foreach $switchs??[] as $key=>$vo}
        <div class="form-check form-check-inline">
            {if $vo['value'] == $value}
            <input class="form-check-input" type="radio" name="{$name}" id="{$id}_{:md5($key)}" value="{$vo.value}" checked>
            {else}
            <input class="form-check-input" type="radio" name="{$name}" id="{$id}_{:md5($key)}" value="{$vo.value}">
            {/if}
            <label class="form-check-label" for="{$id}_{:md5($key)}">{$vo.label}</label>
        </div>
        {/foreach}
    </div>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>
<div>
    {foreach $switchs??[] as $key => $vo}
    <div id="{$id}_{:md5($key)}_target" class="{echo $vo['value']!=$value?'d-none':''}">
        {echo $vo['body']}
    </div>
    {/foreach}
</div>
str;
        return '<div id="' . $this->id . '">' . Builder::getTemplate()->renderFromString($tpl, $this->_data) . '</div>';
    }
}
