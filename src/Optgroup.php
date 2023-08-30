<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Optgroup extends Common
{
    public function __construct(string $label, bool $disabled = false)
    {
        $this->set('label', $label);
        $this->set('disabled', $disabled);
        $this->set('body', '');
    }

    public function addOption(Option ...$options): self
    {
        foreach ($options as $vo) {
            $this->data['body'] .= $vo;
        }
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<optgroup label="{$label}" {if $disabled}disabled{/if}>{echo $body}</optgroup>
str;
    }
}
