<?php

namespace AutoAlliance\Technology\Common;

trait JsonSerializableTrait
{
    private function proceedJsonSerializable($data)
    {
        if (is_array($data)) {
            $stringifier = function (&$item) {
                if (is_object($item) && method_exists($item, '__toString')) {
                    $item = (string)$item;
                }
            };

            array_walk_recursive($data, $stringifier);
        }

        return $data;
    }
}