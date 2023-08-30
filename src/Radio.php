<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;
use Stringable;

class Radio implements Stringable
{
    protected $data = [];

    public function __construct(string $label, string $name, $value = null, bool $checked = false)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
        $this->set('checked', $checked);
    }

    protected function set($name, $value): self
    {
        $this->data[$name] = $value;
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

    public function __toString()
    {
        $tpl = <<<'str'
<label>
    <input type="radio" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($checked) && $checked) { ?> checked<?php } ?>>
    <span>{$label}</span>
</label>
str;
        return (new Template())->renderFromString($tpl, $this->data);
    }
}
