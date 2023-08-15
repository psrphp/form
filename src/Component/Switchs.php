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
<?php $_id = uniqid('f_'); ?>
<script>
    $(function() {
        $("#{$_id}_handle > div > input").bind("click", function() {
            $("#" + $(this).attr('id') + "_target").show().siblings().hide()
        });
    });
</script>
<div>
    <label>{$label}</label>
    <div id="{$_id}_handle">
        {foreach $switchs??[] as $key=>$vo}
        <div>
            <label>
                <span>{$vo.label}</span>
                {if $vo['value'] == $value}
                <input type="radio" name="{$name}" value="{$vo.value}" checked>
                {else}
                <input type="radio" name="{$name}" value="{$vo.value}">
                {/if}
            </label>
        </div>
        {/foreach}
    </div>
    {if isset($help) && $help}
    <div style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>
<div>
    {foreach $switchs??[] as $key => $vo}
    {if $vo['value']!=$value}
    <div id="{$_id}_{:md5($key)}_target" style="display: none;">
        {echo $vo['body']}
    </div>
    {else}
    <div id="{$_id}_{:md5($key)}_target">
        {echo $vo['body']}
    </div>
    {/if}
    {/foreach}
</div>
str;
        return '<div>' . Builder::getTemplate()->renderFromString($tpl, $this->_data) . '</div>';
    }
}
