<?php

declare(strict_types=1);

namespace PsrPHP\Form\Component;

use PsrPHP\Form\Builder;
use PsrPHP\Form\ItemInterface;

class Html implements ItemInterface
{
    private $tpl = '';
    private $data = [];

    public function __construct(string $tpl, array $data = [])
    {
        $this->tpl = $tpl;
        $this->data = $data;
    }

    public function __toString()
    {
        return Builder::getTemplate()->renderFromString($this->tpl, $this->data);
    }
}
