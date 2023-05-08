<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\Builder;
use PsrPHP\Form\ItemInterface;

class Tab implements ItemInterface
{

    protected $tabs = [];

    public function addTab(TabItem ...$tabs): self
    {
        foreach ($tabs as $item) {
            $this->tabs[] = [
                'label' => $item->getLabel(),
                'body' => $item->getBody(),
            ];
        }
        return $this;
    }

    public function __toString()
    {

        $tpl = <<<'str'
<?php
$_id = 'nav_' . uniqid();
?>
<div class="border mt-2">
<ul class="{$class??'nav nav-tabs'} px-2 pt-2 bg-light gap-2 " role="tablist">
    {foreach $tabs as $key => $vo}
    <li class="nav-item" role="presentation">
        <a class="nav-link {if !$key}active{/if}" id="tab_{$_id}{$key}" data-bs-toggle="tab" href="#{$_id}{$key}" role="tab" aria-controls="{$_id}{$key}" aria-selected="{if !$key}true{else}false{/if}">{$vo.label}</a>
    </li>
    {/foreach}
</ul>
<div class="tab-content p-3">
    {foreach $tabs as $key => $vo}
    <div class="tab-pane fade {if !$key}show active{/if}" id="{$_id}{$key}" role="tabpanel" aria-labelledby="{$_id}{$key}-tab">{echo $vo['body']}</div>
    {/foreach}
</div>
</div>
str;
        return Builder::getTemplate()->renderFromString($tpl, [
            'tabs' => $this->tabs,
        ]);
    }
}
