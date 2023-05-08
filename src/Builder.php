<?php

declare(strict_types=1);

namespace PsrPHP\Form;

use PsrPHP\Template\Template;

class Builder
{
    protected $title = '';
    protected $method = '';
    protected $action = '';
    protected $options = [];
    protected $body = '';

    public function __construct(string $title, string $action = '', string $method = 'POST', array $options = [])
    {
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
        $this->options = $options;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= implode('', $items);
        return $this;
    }

    public static function getTemplate(): Template
    {
        $template = new Template();
        $template->addPath('form-builder', __DIR__ . '/tpl');
        return $template;
    }

    public function __toString()
    {
        return self::getTemplate()->renderFromFile('index@form-builder', [
            'title' => $this->title,
            'method' => $this->method,
            'action' => $this->action,
            'options' => $this->options,
            'body' => $this->body,
        ]);
    }
}
