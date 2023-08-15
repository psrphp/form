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
<div id="{$_id}">
    <div>
        <label>{$label}</label>
        <div>
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
        <div style="display: none;">
            {echo $vo['body']}
        </div>
        {else}
        <div>
            {echo $vo['body']}
        </div>
        {/if}
        {/foreach}
    </div>
</div>
<script>
    (function() {
        var container = document.getElementById("{$_id}");
        var tabts = container.children[0].children[1].children;
        var tabcs = container.children[1].children;
        for (const key in tabts) {
            if (Object.hasOwnProperty.call(tabts, key)) {
                const elet = tabts[key];
                elet.children[0].children[1].onclick = function() {
                    for (const index in tabcs) {
                        if (Object.hasOwnProperty.call(tabcs, index)) {
                            const elec = tabcs[index];
                            if (index == key) {
                                elec.style.display = "block";
                            } else {
                                elec.style.display = "none";
                            }
                        }
                    }
                }
            }
        }
    })()
</script>
str;
        return '<div>' . Builder::getTemplate()->renderFromString($tpl, $this->_data) . '</div>';
    }
}
