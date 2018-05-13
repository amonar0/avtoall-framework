<?php

namespace AutoAlliance\Technology\Html;

use AutoAlliance\Technology\Html\HtmlPresenterInterface;

final class TagContent implements HtmlPresenterInterface
{

    /**
     * @var string $content
     */
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function present(): string
    {
        return $this->content;
    }
}
