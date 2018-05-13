<?php

namespace AutoAlliance\Technology\Common;

interface PresenterFactoryInterface
{
    public function create(string $presenterClass, ...$parameters): PresenterInterface;
}