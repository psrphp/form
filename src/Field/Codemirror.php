<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;

class Codemirror implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $value = '';

    private $readonly = false;
    private $disabled = false;

    private $autofocus = false;

    private $help = '';

    public function __construct(string $label, string $name, string $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function setHelp(string $help)
    {
        $this->help = $help;
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }
    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';
        $str .= <<<'str'
<link href="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/codemirror.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/php/php.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
<style>
    .codemirror-container > .CodeMirror {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0;
    }
</style>
str;
        $str .= '<div class="codemirror-container">';
        $str .= '<textarea class="form-control"';
        $str .= ' name="' . htmlspecialchars($this->name) . '"';
        if ($this->disabled) {
            $str .= ' disabled';
        }
        $str .= '>' . htmlspecialchars($this->value) . '</textarea>';

        $readonly = $this->readonly ? 'true' : 'false';
        $autofocus = $this->autofocus ? 'true' : 'false';
        $str .= <<<str
<script>
    (function() {
        var textarea = document.currentScript.previousElementSibling;
        textarea.onfocus=function(){
            CodeMirror.fromTextArea(textarea, {
                lineNumbers: true,
                matchBrackets: true,
                mode: "htmlmixed",
                indentUnit: 4,
                indentWithTabs: true,
                lineWrapping: true,
                readOnly: {$readonly},
                autofocus: {$autofocus},
            }).focus();
        }
    })()
</script>
str;
        $str .= '</div>';
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
