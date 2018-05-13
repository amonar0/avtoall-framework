<?php

namespace AutoAlliance\Technology\Http\Request\QueryMethod;

final class Post extends QueryMethod
{

    protected function queryArray(): array
    {
        return $_POST;
    }
}
