<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

abstract class MapParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_array($data);
    }
}
