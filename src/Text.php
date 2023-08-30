<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Text extends Password
{
    public function setType(string $type)
    {
        if (!in_array($type, ['email', 'tel', 'text', 'url'])) {
            trigger_error('不支持该类型');
        }
        $this->set('type', $type);
    }

    public function setList(array $datalist = []): self
    {
        $this->set('datalist', $datalist);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<?php $id = uniqid('f_'); ?>
<input list="list_{$id}" type="{$type??'text'}" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" size="{$size??''}" maxlength="{$maxlength??''}" pattern="{$pattern??''}" placeholder="{$placeholder??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($autocomplete) && !$autocomplete) { ?> autocomplete="off"<?php }else{ ?> autocomplete="on"<?php } ?>>
{if isset($datalist) && $datalist}
<datalist id="list_{$id}">
    {foreach $datalist as $key=>$vo}
    <option value="{$key}">{$vo}</option>
    {/foreach}
</datalist>
{/if}
str;
    }
}
