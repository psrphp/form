<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Checkboxs extends Common
{
    public function __construct(string $label)
    {
        $this->set('label', $label);
        $this->set('body', '');
    }

    public function addCheckbox(Checkbox ...$checkboxs): self
    {
        $this->data['body'] .= implode('', $checkboxs);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<div style="display: flex;flex-direction: row;gap: 10px;">{echo $body}</div>
str;
    }
}
