<?php

namespace AutoAlliance\Domain\Authentication;

interface LoginInterface
{
    public function __toString(): string;

    public function authenticateStrategyClass(): string;
}