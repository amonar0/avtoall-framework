<?php

namespace AutoAlliance\Technology\Common;

interface ScalarValueObjectCompanionInterface
{
    public function validate($value): array;

    public function createFromScalar($scalarValue);
}