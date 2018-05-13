<?php

namespace AutoAlliance\Technology\Helper;

final class Strings
{

    public static function contains(string $string, string $subString): bool
    {
        return strpos($string, $subString) !== false;
    }

    public static function startsWith(string $string, string $subString): bool
    {
        $length = strlen($subString);

        return substr($string, 0, $length) === $subString;
    }

    public static function endsWith(string $string, string $subString): bool
    {
        $length = strlen($subString);
        if ($length == 0) {
            return true;
        }

        return substr($string, -$length) === $subString;
    }
}
