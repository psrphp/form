<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Range extends Color
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
    }

    public function setMin(int|float $min): self
    {
        $this->set('min', $min);
        return $this;
    }

    public function setMax(int|float $max): self
    {
        $this->set('max', $max);
        return $this;
    }

    public function setStep(int|float $step): self
    {
        $this->set('step', $step);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<input type="range" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" min="{$min??''}" max="{$max??''}" step="{$step??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($autocomplete) && !$autocomplete) { ?> autocomplete="off"<?php }else{ ?> autocomplete="on"<?php } ?>>
str;
    }
}
