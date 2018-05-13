<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

abstract class FloatParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_float($data);
    }
}
