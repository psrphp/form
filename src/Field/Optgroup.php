<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use Stringable;

class Optgroup implements Stringable
{
    private $label = '';
    private $disabled = false;
    private $body = '';

    public function __construct(string $label, bool $disabled = false)
    {
        $this->label = $label;
        $this->disabled = $disabled;
    }

    public function addOption(Option ...$options): self
    {
        foreach ($options as $vo) {
            $this->body .= $vo;
        }
        return $this;
    }

    public function __toString()
    {
        $res = '<optgroup';
        $res .= ' label="' . htmlspecialchars($this->label) . '"';
        if ($this->disabled) {
            $res .= ' disabled';
        }
        $res .= '>';
        $res .= $this->body;
        $res .= '</optgroup>';

        return $res;
    }
}
