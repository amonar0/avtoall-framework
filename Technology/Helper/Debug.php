<?php

namespace AutoAlliance\Technology\Helper;

final class Debug
{

    public static function enabled(): bool
    {
        return false;
        static $enabled = null;

        if ($enabled === null) {
            $option = ini_get('zend.assertions');
            $enabled = $option === false || (int)$option === 1;
        }

        return $enabled;
    }
}
