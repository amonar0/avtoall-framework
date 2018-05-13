<?php

namespace AutoAlliance\Domain;

final class PassportNumber
{
    /**
     * @var string
     */
    private $passportNumber;

    public function __construct(string $passportNumber)
    {
        $this->passportNumber = $passportNumber;
    }

    public function __toString(): string
    {
        return $this->passportNumber;
    }
}