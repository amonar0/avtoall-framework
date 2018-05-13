<?php

namespace AutoAlliance\Technology\Php\Reflection;

use AutoAlliance\Technology\Php\Reflection\ReflectionTypeHelper;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;

final class ReflectionParameterHelper
{

    //@test
    public static function isInheritedFromClass(\ReflectionParameter $parameter, \ReflectionClass $ancestor): bool
    {
        $class = $parameter->getDeclaringClass();

        if (!$class || !ReflectionClassHelper::isSuccessor($class, $ancestor)) {
            return false;
        }

        $method = $parameter->getDeclaringFunction();
        $ancestorMethod = $ancestor->getMethod($method->getName());

        if (!$ancestorMethod) {
            return false;
        }

        $ancestorParameters = $ancestorMethod->getParameters();

        foreach ($ancestorParameters as $ancestorParameter) {
            /* @var $ancestorParameter \ReflectionParameter */
            if ($parameter->getName() === $ancestorParameter->getName() && ReflectionTypeHelper::equal($parameter->getType(),
                    $ancestorParameter->getType())) {
                return true;
            }
        }

        return false;
    }

    public static function isInteritedFromMethod(\ReflectionParameter $parameter, \ReflectionMethod $parentMethod): bool
    {
        return self::isInheritedFromClass($parameter, $parentMethod->getDeclaringClass());
    }
}
