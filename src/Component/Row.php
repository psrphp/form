<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\ItemInterface;

class Row implements ItemInterface
{
    private $class;
    private $body;

    public function __construct(string $class = 'row')
    {
        $this->class = $class;
    }

    public function addCol(Col ...$cols): self
    {
        $this->body .= implode('', $cols);
        return $this;
    }

    public function __toString()
    {
        return '<div class="' . $this->class . '">' . $this->body . '</div>';
    }
}
