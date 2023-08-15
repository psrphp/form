<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

class Input extends Common
{
    public function __construct(string $label, string $name, $value = null, array $options = [])
    {
        foreach ($options as $key => $vo) {
            $this->$key = $vo;
        }
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }
}
