<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

abstract class BoolParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_bool($data);
    }
}
