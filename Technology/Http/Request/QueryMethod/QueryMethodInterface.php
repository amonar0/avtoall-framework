<?php

namespace AutoAlliance\Technology\Http\Request\QueryMethod;

interface QueryMethodInterface
{

    public static function instance(): self;

    public function accessParameter(string $key);

    public function issetParameter(string $key): bool;
}
