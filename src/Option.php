<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Option extends Common
{
    public function __construct(string $label, int|float|string $value, bool $selected = false, bool $disabled = false)
    {
        $this->set('label', $label);
        $this->set('value', $value);
        $this->set('selected', $selected);
        $this->set('disabled', $disabled);
    }

    public function getTpl(): string
    {
        return <<<'str'
<option value="{$value}" {if $selected}selected{/if} {if $disabled}disabled{/if}>{$label}</option>
str;
    }
}
