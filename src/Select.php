<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class Select extends Common
{
    public function __construct(string $label, string $name)
    {
        $this->set('label', $label);
        $this->set('body', '');
    }

    public function addOption(Option ...$options): self
    {
        $this->data['body'] .= implode('', $options);
        return $this;
    }

    public function addOptgroup(Optgroup ...$optgroups): self
    {
        $this->data['body'] .= implode('', $optgroups);
        return $this;
    }

    public function setAutofocus(bool $autofocus): self
    {
        $this->set('autofocus', $autofocus);
        return $this;
    }

    public function setRequired(bool $required): self
    {
        $this->set('required', $required);
        return $this;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->set('disabled', $disabled);
        return $this;
    }

    public function setMultiple(bool $multiple): self
    {
        $this->set('multiple', $multiple);
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->set('size', $size);
        return $this;
    }

    public function getTpl(): string
    {
        return <<<'str'
<select name="{$name??''}" size="{$size??''}" <?php if (isset($required) && $required) { ?> required<?php } ?><?php if (isset($disabled) && $disabled) { ?> disabled<?php } ?><?php if (isset($autofocus) && $autofocus) { ?> autofocus<?php } ?><?php if (isset($multiple) && $multiple) { ?> multiple<?php } ?>>{echo $body}</select>
str;
    }
}
