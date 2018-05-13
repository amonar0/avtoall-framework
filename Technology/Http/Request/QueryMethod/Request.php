<?php

namespace AutoAlliance\Technology\Http\Request\QueryMethod;

final class Request extends QueryMethod
{

    protected function queryArray(): array
    {
        return $_REQUEST;
    }
}
