<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\ItemInterface;

class Col implements ItemInterface
{
    private $body = '';

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= implode('', $items);
        return $this;
    }

    public function __toString()
    {
        return '<div style="display: flex;flex-direction: column;gap: 10px;">' . $this->body . '</div>';
    }
}
