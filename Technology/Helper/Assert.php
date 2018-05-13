<?php

namespace AutoAlliance\Technology\Helper;

final class Assert
{

    public static function instancesOf(string $baseClass, ...$objects)//: void 
    {
        foreach ($objects as $object) {
            assert($object instanceof $baseClass,
                Output::sprintf('%s, %s', $baseClass, $object));

        }
    }

    public static function successorsOf(string $baseClass, string ...$classes)//: void
    {
        assert(Lists::allItems($classes, function ($class) use ($baseClass) {
            return $class === $baseClass || is_subclass_of($class, $baseClass);
        }));
    }
}