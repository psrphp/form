<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Password extends Color
{
    public function __construct(string $label, string $name, $value = null)
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
    }

    public function setPattern(string $pattern): self
    {
        $this->set('pattern', $pattern);
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->set('size', $size);
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->set('placeholder', $placeholder);
        return $this;
    }

    public function setMaxLength(int $maxlength): self
    {
        $this->set('maxlength', $maxlength);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<input type="password" name="{$name}" value="{$value}" title="{$title??''}" style="{$style??''}" size="{$size??''}" maxlength="{$maxlength??''}" pattern="{$pattern??''}" placeholder="{$placeholder??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($readonly) && $readonly) { ?> readonly<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($autocomplete) && !$autocomplete) { ?> autocomplete="off"<?php }else{ ?> autocomplete="on"<?php } ?>>
str;
    }
}
