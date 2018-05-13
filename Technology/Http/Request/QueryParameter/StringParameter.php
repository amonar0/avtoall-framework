<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

abstract class StringParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_string($data);
    }

    public function __construct()
    {

    }
}
