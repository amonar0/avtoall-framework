<?php

namespace AutoAlliance\Technology\Html;

use AutoAlliance\Technology\Html\HtmlPresenterInterface;

final class TagContentContainer implements HtmlPresenterInterface
{

    public static function create(...$contents): self
    {
        foreach ($contents as &$content) {
            if (is_string($content)) {
                $content = new TagContent($content);
            } else {
                assert($content instanceof HtmlPresenterInterface, sprintf(
                    'Content must be string or instance of class HtmlPresenterInterface, '
                    . 'given type: %s', gettype($content)));
            }
        }

        return new self(...$contents);
    }

    /**
     * @var HtmlPresenterInterface[] $presenters
     */
    private $presenters;

    private function __construct(HtmlPresenterInterface ...$presenters)
    {
        $this->presenters = $presenters;
    }

    public function present(): string
    {
        $result = '';

        foreach ($this->presenters as $presenter) {
            $result .= $presenter->present();
        }

        return $result;
    }
}
