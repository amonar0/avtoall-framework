<?php

namespace AutoAlliance\Technology\Http\Request;

use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;

abstract class Fragment
{
    public function __construct()
    {

    }

    public function key(): string
    {
        $staticClass = ReflectionClassHelper::onlyClassName(static::class);
        $staticId = preg_replace('/Fragment$/', '', $staticClass);
        $viewId = crc32($this->viewClass());

        return $staticId . $viewId;
    }

    abstract protected function viewClass(): string;
}
