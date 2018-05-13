<?php

namespace AutoAlliance\Technology\Http\Request\QueryMethod;

final class Get extends QueryMethod
{

    protected function queryArray(): array
    {
        return $_GET;
    }
}
