<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;
use Stringable;

class Option implements Stringable
{
    protected $data = [];

    public function __construct(string $label, int|float|string $value, bool $selected = false, bool $disabled = false)
    {
        $this->set('label', $label);
        $this->set('value', $value);
        $this->set('selected', $selected);
        $this->set('disabled', $disabled);
    }

    protected function set($name, $value): self
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function __toString()
    {
        $tpl = <<<'str'
<option value="{$value}"{if $selected} selected{/if}{if $disabled} disabled{/if}>{$label}</option>
str;
        return (new Template())->renderFromString($tpl, $this->data);
    }
}
