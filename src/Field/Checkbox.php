<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

class Checkbox extends Common
{
    public function __construct(string $label, string $name, array $value = [], array $items = [], array $options = [])
    {
        $this->inline = true;
        foreach ($options as $key => $vo) {
            $this->$key = $vo;
        }
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->items = $items;
    }
}
