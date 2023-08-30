<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;

class Switchs implements ItemInterface
{
    protected $data = [];

    public function __construct(string $label, string $name, $value = null)
    {
        $this->data['label'] = $label;
        $this->data['name'] = $name;
        $this->data['value'] = $value;
        $this->data['switchs'] = [];
    }

    public function addSwitch(SwitchItem ...$switchs): self
    {
        foreach ($switchs as $item) {
            array_push($this->data['switchs'], [
                'label' => $item->getLabel(),
                'value' => $item->getValue(),
                'body' => $item->getBody(),
            ]);
        }
        return $this;
    }

    public function __toString()
    {
        return (new Template)->renderFromString($this->getTpl(), $this->data);
    }

    public function getTpl(): string
    {
        return <<<'str'
<?php $_id = uniqid('f_'); ?>
<div id="{$_id}">
    <div>
        <div>{$label}</div>
        <div style="display: flex;flex-direction: row;gap: 10px;margin-top: 5px;">
            {foreach $switchs??[] as $key=>$vo}
            <div>
                <label>
                    {if $vo['value'] == $value}
                    <input type="radio" name="{$name}" value="{$vo.value}" checked>
                    {else}
                    <input type="radio" name="{$name}" value="{$vo.value}">
                    {/if}
                    <span>{$vo.label}</span>
                </label>
            </div>
            {/foreach}
        </div>
        {if isset($help) && $help}
        <div style="font-size: .8em;">{echo $help}</div>
        {/if}
    </div>
    <div style="margin-top: 10px;">
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
    }
}
