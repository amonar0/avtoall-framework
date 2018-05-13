<?php

namespace AutoAlliance\Technology\FileSystem\File;

final class FileAssertion
{

    public static $enabled = true;

    public static function isFile(string $string): bool
    {
        if (!self::$enabled) {
            return true;
        }

        return is_file($string);
    }

    public static function isDir(string $string): bool
    {
        if (!self::$enabled) {
            return true;
        }

        return is_dir($string);
    }
}
