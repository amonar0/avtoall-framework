<?php

namespace AutoAlliance\Technology\Email;

use AutoAlliance\Domain\Authentication\Strategy\AuthenticateByEmailStrategy;
use AutoAlliance\Domain\Authentication\LoginInterface;

final class Email implements LoginInterface
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $validEmail)
    {
        assert(EmailCompanion::instance()->validate($validEmail)[0], $validEmail);

        $this->email = $validEmail;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function authenticateStrategyClass(): string
    {
        return AuthenticateByEmailStrategy::class;
    }
}