<?php

namespace AutoAlliance\Technology\Http\Request\QueryParameter;

use AutoAlliance\Technology\Helper\Lists;

abstract class ListParameter extends QueryParameter
{

    public function validFor($data): bool
    {
        return is_array($data) && Lists::allItems(array_keys($data), function ($key) {
                return is_int($key);
            });
    }
}
