<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;

abstract class Common implements ItemInterface
{
    protected $data = [];

    protected function set($name, $value): self
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->set('help', $help);
        return $this;
    }

    abstract public function getTpl(): string;

    public function __toString()
    {
        $tpl = '<div><div style="margin-bottom: 5px;">{$label??""}</div>' . $this->getTpl() . '<div style="font-size:.8em;color:gray;">{$help??""}</div></div>';
        return (new Template)->renderFromString($tpl, $this->data);
    }
}
