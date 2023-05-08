<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

class Pics extends Common
{
    public function __construct(string $label, string $name, array $value = [], string $upload_url = null, array $options = [])
    {
        foreach ($options as $key => $vo) {
            $this->$key = $vo;
        }
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->upload_url = $upload_url;
    }
}
