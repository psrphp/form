<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Radios extends Common
{
    public function __construct(string $label)
    {
        $this->set('label', $label);
        $this->set('body', '');
    }

    public function addRadio(Radio ...$radios): self
    {
        $this->data['body'] .= implode('', $radios);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<div style="display: flex;flex-direction: row;gap: 10px;">{echo $body}</div>
str;
    }
}
