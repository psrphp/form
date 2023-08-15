<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\ItemInterface;

class Row implements ItemInterface
{
    private $body;

    public function addCol(Col ...$cols): self
    {
        $this->body .= implode('', $cols);
        return $this;
    }

    public function __toString()
    {
        return '<div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">' . $this->body . '</div>';
    }
}
