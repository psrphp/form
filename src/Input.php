<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;

class Input implements ItemInterface
{
    protected $data = [];

    public function __construct(string $label, string $name, $value = null, string $type = 'text')
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
        $this->setType($type);
    }

    protected function set($name, $value): self
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function __toString()
    {
        $tpl = <<<'str'
{if $type != 'hidden'}
<div>
    <div style="margin-bottom: 5px;">{$label??""}</div>
{/if}
    <?php $id = uniqid('f_'); ?>
    <input type="{$type??'text'}" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" list="list_{$id}" size="{$size??''}" min="{$min??''}" max="{$max??''}" step="{$step??''}" maxlength="{$maxlength??''}" pattern="{$pattern??''}" placeholder="{$placeholder??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($autocomplete) && !$autocomplete) { ?> autocomplete="off"<?php }else{ ?> autocomplete="on"<?php } ?>>
    {if isset($datalist) && $datalist}
    <datalist id="list_{$id}">
        {foreach $datalist as $key=>$vo}
        <option value="{$key}">{$vo}</option>
        {/foreach}
    </datalist>
    {/if}
{if $type != 'hidden'}
    <div style="font-size:.8em;color:gray;">{$help??""}</div>
</div>
{/if}
str;
        return (new Template())->renderFromString($tpl, $this->data);
    }

    public function setHelp(string $help): self
    {
        $this->set('help', $help);
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->set('title', $title);
        return $this;
    }

    public function setStyle(string $style): self
    {
        $this->set('style', $style);
        return $this;
    }

    public function setType(string $type)
    {
        $this->set('type', $type);
    }

    public function setAutocomplete(bool $autocomplete): self
    {
        $this->set('autocomplete', $autocomplete);
        return $this;
    }

    public function setAutofocus(bool $autofocus): self
    {
        $this->set('autofocus', $autofocus);
        return $this;
    }

    public function setReadonly(bool $readonly): self
    {
        $this->set('readonly', $readonly);
        return $this;
    }

    public function setRequired(bool $required): self
    {
        $this->set('required', $required);
        return $this;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->set('disabled', $disabled);
        return $this;
    }

    public function setMin(int|float $min): self
    {
        $this->set('min', $min);
        return $this;
    }

    public function setMax(int|float $max): self
    {
        $this->set('max', $max);
        return $this;
    }

    public function setStep(int|float $step): self
    {
        $this->set('step', $step);
        return $this;
    }

    public function setMaxLength(int $maxlength): self
    {
        $this->set('maxlength', $maxlength);
        return $this;
    }

    public function setPattern(string $pattern): self
    {
        $this->set('pattern', $pattern);
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->set('placeholder', $placeholder);
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->set('size', $size);
        return $this;
    }

    public function setList(array $datalist = []): self
    {
        $this->set('datalist', $datalist);
        return $this;
    }
}
