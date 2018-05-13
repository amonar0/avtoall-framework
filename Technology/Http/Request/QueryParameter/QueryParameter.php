<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;

abstract class QueryParameter implements QueryParameterInterface
{

    public function __construct()
    {

    }

    public function key(): string
    {
        $staticClass = ReflectionClassHelper::onlyClassName(static::class);
        $staticId = preg_replace('/Parameter$/', '', $staticClass);
        $controllerId = crc32($this->controllerClass());

        return $staticId . $controllerId;
    }

    public function accessData()
    {
        $key = $this->key();

        if (!$this->method()->issetParameter($key) && $this->optional()) {
            return null;
        }

        return $this->method()->accessParameter($key);
    }

    abstract protected function controllerClass(): string;
}
