<?php

namespace AutoAlliance\Domain;

use AutoAlliance\Domain\Authentication\Strategy\AuthenticateByPhoneStrategy;
use AutoAlliance\Domain\Authentication\LoginInterface;

final class PhoneNumber implements LoginInterface
{
    /**
     * @var int
     */
    private $number;

    public function __construct(/*int|string*/
        $number
    ) {
        assert(PhoneNumberCompanion::instance()->validate($number)[0], $number);

        $this->number = (int)$number;
    }

    public function __toString(): string
    {
        return (string)$this->number;
    }

    public function authenticateStrategyClass(): string
    {
        return AuthenticateByPhoneStrategy::class;
    }
}