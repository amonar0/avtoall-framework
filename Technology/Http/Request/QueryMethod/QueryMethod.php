<?php

namespace AutoAlliance\Technology\Http\Request\QueryMethod;

use AutoAlliance\Technology\Common\SingletonTrait;

abstract class QueryMethod implements QueryMethodInterface
{
    use SingletonTrait;

    public static function instance(): QueryMethodInterface//: static
    {
        return self::proceedInstance();
    }

    public function accessParameter(string $key)
    {
        assert($this->issetParameter($key), $key);

        return $this->queryArray()[$key];
    }

    public function issetParameter(string $key): bool
    {
        return isset($this->queryArray()[$key]);
    }

    abstract protected function queryArray(): array;

    private function __construct()
    {

    }
}
