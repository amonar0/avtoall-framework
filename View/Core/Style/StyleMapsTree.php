<?php

namespace AutoAlliance\View\Core\Style;

use AutoAlliance\Technology\Helper\Assert;

final class StyleMapsTree implements StyleMapInterface
{
    /**
     * @var StyleMapInterface
     */
    private $root;
    /**
     * @var array[]
     */
    private $subStyleMapMap;

    public function __construct(array $subStyleMapMap, StyleMapInterface $root = null)
    {
        Assert::instancesOf(StyleMapInterface::class, ...array_values($subStyleMapMap));

        if (!$root) {
            $root = new StyleMap([]);
        }

        $this->root = $root;
        $this->subStyleMapMap = $subStyleMapMap;
    }

    public function subStyleMap(string $id): StyleMapInterface
    {
        return $this->subStyleMapMap[$id];
    }

    public function offsetExists($offset): bool
    {
        return $this->root->offsetExists($offset);
    }


    public function offsetGet($offset)
    {
        return $this->root->offsetGet($offset);
    }


    public function offsetSet($offset, $value)//: void
    {
        $this->root->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)//: void
    {
        $this->root->offsetUnset($offset);
    }
}