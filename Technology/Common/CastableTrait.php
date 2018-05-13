<?php

namespace AutoAlliance\Technology\Common;

trait CastableTrait
{
    final public static function cast(self $instance): self
    {
        $value = $instance->constructorValue();
        $class = static::class;

        return new $class($value);
    }

    /**
     * @param self[] $instances
     * @return self[]
     */
    final public static function castList(self ...$instances): array
    {
        return array_map(function ($instance) {
            return self::cast($instance);
        }, $instances);
    }

    abstract protected function constructorValue();

}