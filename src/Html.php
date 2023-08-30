<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;

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
        return (new Template())->renderFromString($this->tpl, $this->data);
    }
}
