<?php

namespace AutoAlliance\Technology\Php\Reflection;

final class ReflectionMethodHelper
{

    public static function namedParameters(\ReflectionMethod $method, ...$parameters): array
    {
        $namedParameters = [];

        foreach ($method->getParameters() as $parameter) {
            /* @var $parameter \ReflectionParameter */
            if (isset($parameters[$parameter->getPosition()])) {
                $namedParameters[$parameter->getName()] = $parameters[$parameter->getPosition()];
            }
        }

        return $namedParameters;
    }
}
