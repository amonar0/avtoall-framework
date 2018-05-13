<?php

namespace AutoAlliance\Technology\Common;

trait SingletonTrait
{
    private static function proceedInstance(...$params): self
    {
        static $instance = null;

        if (!$instance) {
            $instance = new static(...$params);
        }

        return $instance;
    }
}