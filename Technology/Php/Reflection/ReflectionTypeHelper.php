<?php

namespace AutoAlliance\Technology\Php\Reflection;

final class ReflectionTypeHelper
{

    public static function equal(\ReflectionType $type1, \ReflectionType $type2): bool
    {
        return (string)$type1 === (string)$type2;
    }
}
