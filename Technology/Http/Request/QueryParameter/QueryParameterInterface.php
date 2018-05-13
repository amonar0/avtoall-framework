<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

use AutoAlliance\Technology\Http\Request\QueryMethod\QueryMethodInterface;

interface QueryParameterInterface
{

    public function __construct();

    public function validFor($data): bool;

    public function accessData();

    public function key(): string;

    public function method(): QueryMethodInterface;

    public function optional(): bool;
}
