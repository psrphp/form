<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class SwitchItem
{
    protected $label;
    protected $value;
    protected $items = [];

    public function __construct(string $label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function addItem(ItemInterface ...$items): self
    {
        array_unshift($this->items, ...$items);
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getBody(): string
    {
        return implode('', $this->items);
    }
}
