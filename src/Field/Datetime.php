<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;

class Date implements ItemInterface
{

    private $label = '';
    private $name = '';
    private $value = '';

    private $help = '';

    private $title = '';
    private $class = 'form-control';
    private $style = '';

    private $readonly = false;
    private $required = false;
    private $disabled = false;

    private $autocomplete = false;
    private $autofocus = false;

    private $pattern = '';

    private $min = null;
    private $max = null;

    public function __construct(string $label, string $name, string $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;
        return $this;
    }

    public function setAutocomplete(bool $autocomplete = true): self
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setRequired(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }

    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setMin(int|float $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function setMax(int|float $max): self
    {
        $this->max = $max;
        return $this;
    }

    public function __toString()
    {
        $res = '';
        $res .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $res .= '<input';
        $res .= ' type="datetime-local"';
        $res .= ' name="' . htmlspecialchars($this->name) . '"';
        $res .= ' value="' . htmlspecialchars($this->value) . '"';
        if (strlen($this->title)) {
            $res .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->class)) {
            $res .= ' class="' . htmlspecialchars($this->class) . '"';
        }
        if (strlen($this->style)) {
            $res .= ' style="' . htmlspecialchars($this->style) . '"';
        }
        if (strlen($this->pattern)) {
            $res .= ' pattern="' . htmlspecialchars($this->pattern) . '"';
        }

        if (!is_null($this->min)) {
            $res .= ' min="' . $this->min . '"';
        }
        if (!is_null($this->max)) {
            $res .= ' max="' . $this->max . '"';
        }

        if ($this->required) {
            $res .= ' required';
        }
        if ($this->disabled) {
            $res .= ' disabled';
        }
        if ($this->readonly) {
            $res .= ' readonly';
        }
        if ($this->autofocus) {
            $res .= ' autofocus';
        }
        if ($this->autocomplete) {
            $res .= ' autocomplete="on"';
        }
        $res .= ' >';

        if (strlen($this->help)) {
            $res .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $res;
    }
}
