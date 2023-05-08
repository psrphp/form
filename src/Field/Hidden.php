<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

class Hidden extends Common
{
    public function __construct(string $name, $value = null, array $options = [])
    {
        foreach ($options as $key => $vo) {
            $this->$key = $vo;
        }
        $this->name = $name;
        $this->value = $value;
    }
}
