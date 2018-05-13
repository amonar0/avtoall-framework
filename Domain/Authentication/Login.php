<?php

namespace AutoAlliance\Domain\Authentication;

use AutoAlliance\Domain\Authentication\Strategy\AuthenticateByLoginStrategy;

final class Login implements LoginInterface
{
    /**
     * @var string
     */
    private $login;

    public function __construct(string $login)
    {
        assert(LoginCompanion::instance()->validate($login)[0], $login);

        $this->login = $login;
    }

    public function __toString(): string
    {
        return $this->login;
    }

    public function authenticateStrategyClass(): string
    {
        return AuthenticateByLoginStrategy::class;
    }
}