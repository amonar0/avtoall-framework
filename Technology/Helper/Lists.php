<?php

namespace AutoAlliance\Technology\Helper;

final class Lists
{

    public static function last(array $list)
    {
        return array_slice($list, -1)[0];
    }

    public static function makeList($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        return $value;
    }

    public static function allItems(array $list, callable $predicate): bool
    {
        foreach ($list as $item) {
            if (!$predicate($item)) {
                return false;
            }
        }

        return true;
    }

    public static function leastOneItem(array $list, callable $predicate): bool
    {
        foreach ($list as $item) {
            if (!$predicate($item)) {
                return true;
            }
        }

        return false;
    }

    public static function toString(array $list)
    {
        return json_encode($list);
    }
}
