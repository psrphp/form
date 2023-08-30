<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;
use Stringable;

class Optgroup implements Stringable
{
    protected $data = [];

    public function __construct(string $label, bool $disabled = false)
    {
        $this->set('label', $label);
        $this->set('disabled', $disabled);
        $this->set('body', '');
    }

    protected function set($name, $value): self
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function addOption(Option ...$options): self
    {
        foreach ($options as $vo) {
            $this->data['body'] .= $vo;
        }
        return $this;
    }

    public function __toString()
    {
        $tpl = <<<'str'
<optgroup label="{$label}" {if $disabled}disabled{/if}>{echo $body}</optgroup>
str;
        return (new Template())->renderFromString($tpl, $this->data);
    }
}
