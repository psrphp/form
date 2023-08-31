<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;
use Stringable;

class Checkbox implements Stringable
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
    <input type="checkbox" name="{$name}" value="{$value}" {if isset($title) && strlen($title)} title="{$title}"{/if}{if isset($style) && strlen($style)} style="{$style}"{/if}{if isset($required) && $required} required{/if}{if isset($disabled) && $disabled} disabled{/if}{if isset($readonly) && $readonly} readonly{/if}{if isset($autofocus) && $autofocus} autofocus{/if}{if $checked} checked{/if}>
    <span>{$label}</span>
</label>
str;
        return (new Template())->renderFromString($tpl, $this->data);
    }
}
