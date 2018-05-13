<?php

namespace AutoAlliance\Technology\Html;

use AutoAlliance\Technology\Html\HtmlPresenterInterface;
/** @uses Yii */

use CHtml;
use AutoAlliance\Technology\Helper\Lists;

class Tag implements HtmlPresenterInterface
{

    /**
     * @var string $tag
     */
    private $tag;

    /**
     * @var TagContentContainer $content
     */
    private $content;

    /**
     * @var string[] $classes
     */
    private $classes;

    /**
     * @var array $attributeMap
     */
    private $attributeMap;

    public function __construct(string $tag, $contents, $classes = [], array $attributeMap = [])
    {
        $classes = Lists::makeList($classes);

        assert(Lists::allItems($classes, 'is_string'), Lists::toString($classes));
        assert(Lists::allItems($attributeMap, 'is_string'), Lists::toString($attributeMap));

        $this->tag = $tag;
        $this->content = $this->createContent($contents);
        $this->classes = $classes;
        $this->attributeMap = $attributeMap;
    }

    final public function addAttributes(array $attributes): self
    {
        $attributes = array_merge($this->attributeMap, $attributes);

        return new self($this->tag, $this->content, $this->classes, $attributes);
    }

    final public function addClasses(string ...$classes): self
    {
        $classes = array_unique(array_merge($this->classes, $classes));

        return new self($this->tag, $this->content, $classes, $this->attributeMap);
    }

    final public function setContent(...$contents): self
    {
        $content = $this->createContent($contents);

        return new self($this->tag, $content, $this->classes, $this->attributeMap);
    }

    final public function present(): string
    {
        return CHtml::tag($this->tag, $this->createHtmlOptions(), $this->content->present());
    }

    final public function __toString(): string
    {
        return $this->present();
    }

    private function createHtmlOptions(): array
    {
        return array_merge([
            'class' => join(' ', $this->classes),
        ], $this->attributeMap);
    }

    private function createContent($contents): TagContentContainer
    {
        if (!is_array($contents)) {
            $contents = [$contents];
        }

        return TagContentContainer::create(...$contents);
    }
}