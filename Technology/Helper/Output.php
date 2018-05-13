<?php

namespace AutoAlliance\Technology\Helper;

final class Output
{
    public static function sprintf(string $template, ...$parameters): string
    {
        foreach ($parameters as &$parameter) {
            if (!is_scalar($parameter)) {
                $parameter = print_r($parameter, true);
            }
        }

        return sprintf($template, ...$parameters);
    }
}