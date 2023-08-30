<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Color extends Common
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
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

    public function getTpl(): string
    {
        return <<<'str'
<input type="color" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($autocomplete) && !$autocomplete) { ?> autocomplete="off"<?php }else{ ?> autocomplete="on"<?php } ?>>
str;
    }
}
