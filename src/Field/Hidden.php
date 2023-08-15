<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;
use PsrPHP\Template\Template;

class Hidden implements ItemInterface
{
    protected $name;
    protected $value;

    public function __construct(string $name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString()
    {
        return (new Template())->renderFromString('<input type="hidden" name="{$name}" value="{$value}">', [
            'name' => $this->name,
            'value' => $this->value,
        ]);
    }
}
