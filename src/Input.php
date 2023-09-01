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
<div>
    <div style="margin-bottom: 5px;">{$label??$name}{if isset($required) && $required}<span title="必填" style="color: red;">*</span>{/if}</div>
    <?php $id = uniqid('f_'); ?>
    <input type="{$type??'text'}" name="{$name}" value="{$value}" {if isset($title) && strlen($title)} title="{$title}"{/if}{if isset($style) && strlen($style)} style="{$style}"{/if}{if isset($size) && strlen($size)} size="{$size}"{/if}{if isset($min) && strlen($min)} min="{$min}"{/if}{if isset($max) && strlen($max)} max="{$max}"{/if}{if isset($step) && strlen($step)} step="{$step}"{/if}{if isset($maxlength) && strlen($maxlength)} maxlength="{$maxlength}"{/if}{if isset($pattern) && strlen($pattern)} pattern="{$pattern}"{/if}{if isset($placeholder) && strlen($placeholder)} placeholder="{$placeholder}"{/if}{if isset($required) && $required} required{/if}{if isset($disabled) && $disabled} disabled{/if}{if isset($readonly) && $readonly} readonly{/if}{if isset($autofocus) && $autofocus} autofocus{/if}{if isset($autocomplete) && !$autocomplete} autocomplete="off"{else} autocomplete="on"{/if}>
    {if isset($datalist) && $datalist}
    <datalist id="list_{$id}">
        {foreach $datalist as $key=>$vo}
        <option value="{$key}">{$vo}</option>
        {/foreach}
    </datalist>
    {/if}
    {if isset($help) && strlen($help)}
    <div style="font-size:.8em;color:gray;">{$help}</div>
    {/if}
</div>
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

    public function setType(string $type): self
    {
        $this->set('type', $type);
        return $this;
    }

    public function setAutocomplete(bool $autocomplete = true): self
    {
        $this->set('autocomplete', $autocomplete);
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->set('autofocus', $autofocus);
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->set('readonly', $readonly);
        return $this;
    }

    public function setRequired(bool $required = true): self
    {
        $this->set('required', $required);
        return $this;
    }

    public function setDisabled(bool $disabled = true): self
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
