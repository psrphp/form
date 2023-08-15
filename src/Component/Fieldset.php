<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\ItemInterface;

class Fieldset implements ItemInterface
{
    private $legend;
    private $body;

    public function __construct(string $legend)
    {
        $this->legend = $legend;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= implode('', $items);
        return $this;
    }

    public function __toString()
    {
        return '<fieldset><legend>' . htmlspecialchars($this->legend) . '</legend><div style="display: flex;flex-direction: column;gap: 10px;">' . $this->body . '</div></fieldset>';
    }
}
