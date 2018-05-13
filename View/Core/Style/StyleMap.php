<?php

namespace AutoAlliance\View\Core\Style;

final class StyleMap implements StyleMapInterface
{
    /**
     * @var array
     */
    private $styleMap;

    public function __construct(array $styleMap)
    {
        $this->styleMap = $styleMap;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->styleMap[$offset]);
    }


    public function offsetGet($offset)
    {
        return $this->styleMap[$offset];
    }


    public function offsetSet($offset, $value)//: void
    {
        $this->styleMap[$offset] = $value;
    }

    public function offsetUnset($offset)//: void
    {
        unset($this->styleMap[$offset]);
    }
}