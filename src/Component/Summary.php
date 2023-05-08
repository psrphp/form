<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\ItemInterface;

class Summary implements ItemInterface
{
    private $label;
    private $body;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= implode('', $items);
        return $this;
    }

    public function __toString()
    {
        return '<details class="mt-2"><summary>' . htmlspecialchars($this->label) . '</summary><div class="mt-2">' . $this->body . '</div></details>';
    }
}
