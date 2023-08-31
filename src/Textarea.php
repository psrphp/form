<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Textarea extends Common
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
    }

    public function setWrap(string $wrap): self
    {
        if (!in_array($wrap, ['soft', 'hard'])) {
            trigger_error('错误，只支持hard和soft');
        }
        $this->set('wrap', $wrap);
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->set('placeholder', $placeholder);
        return $this;
    }

    public function setMaxlength(int $maxlength): self
    {
        $this->set('maxlength', $maxlength);
        return $this;
    }

    public function setRows(int $rows): self
    {
        $this->set('rows', $rows);
        return $this;
    }

    public function setCols(int $cols): self
    {
        $this->set('cols', $cols);
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

    public function getTpl(): string
    {
        return <<<'str'
<textarea name="{$name}" {if isset($title) && strlen($title)} title="{$title}"{/if}{if isset($rows) && strlen($rows)} rows="{$rows}"{/if}{if isset($cols) && strlen($cols)} cols="{$cols}"{/if}{if isset($wrap) && strlen($wrap)} wrap="{$wrap}"{/if}{if isset($style) && strlen($style)} style="{$style}"{/if}{if isset($size) && strlen($size)} size="{$size}"{/if}{if isset($maxlength) && strlen($maxlength)} maxlength="{$maxlength}"{/if}{if isset($pattern) && strlen($pattern)} pattern="{$pattern}"{/if}{if isset($placeholder) && strlen($placeholder)} placeholder="{$placeholder}"{/if}{if isset($required) && $required} required{/if}{if isset($disabled) && $disabled} disabled{/if}{if isset($readonly) && $readonly} readonly{/if}{if isset($autofocus) && $autofocus} autofocus{/if}>{$value}</textarea>
str;
    }
}
