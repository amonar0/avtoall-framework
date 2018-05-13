<?php

namespace AutoAlliance\Technology\Helper;

final class Psr
{

    public static function isClassName($string): bool
    {
        $firstChar = substr($string, 0, 1);

        return ctype_upper($firstChar);
    }
}
