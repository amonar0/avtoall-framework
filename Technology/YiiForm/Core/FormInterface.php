<?php

namespace AutoAlliance\Technology\YiiForm\Core;

interface FormInterface
{
    public function hasErrors(/*string*/ $attribute = null): bool;

    public function ifValid(array $attributeMap, callable $onValidCallback);//: void
}