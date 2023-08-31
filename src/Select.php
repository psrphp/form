<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Select extends Common
{
    public function __construct(string $label, string $name)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('body', '');
    }

    public function addOption(Option ...$options): self
    {
        $this->data['body'] .= implode('', $options);
        return $this;
    }

    public function addOptgroup(Optgroup ...$optgroups): self
    {
        $this->data['body'] .= implode('', $optgroups);
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->set('autofocus', $autofocus);
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

    public function setMultiple(bool $multiple = true): self
    {
        $this->set('multiple', $multiple);
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->set('size', $size);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<select name="{$name}" {if isset($title) && strlen($title)} title="{$title}"{/if}{if isset($style) && strlen($style)} style="{$style}"{/if}{if isset($size) && strlen($size)} size="{$size}"{/if}{if isset($required) && $required} required{/if}{if isset($disabled) && $disabled} disabled{/if}{if isset($autofocus) && $autofocus} autofocus{/if}{if isset($multiple) && $multiple} multiple{/if}>{echo $body}</select>
str;
    }
}
