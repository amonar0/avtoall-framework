<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

abstract class IntegerParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_int($data);
    }
}
