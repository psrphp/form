<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\Help\Html;
use PsrPHP\Form\ItemInterface;
use PsrPHP\Form\Layout\Flex;

class Radios implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $help = '';

    private $flex;

    public function __construct(string $label, string $name)
    {
        $this->label = $label;
        $this->name = $name;
        $this->flex = new Flex('d-flex flex-row gap-2 flex-wrap');
    }

    public function getFlex(): Flex
    {
        return $this->flex;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function addRadio(Radio ...$radios): self
    {
        foreach ($radios as $vo) {
            $vo->setName($this->name);
            $this->flex->addItem(new Html($vo));
        }
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';
        $str .= $this->flex;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
