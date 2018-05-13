<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use AutoAlliance\Technology\Common\AnyClassFactory;

final class AuthenticateByLoginPasswordStrategyFactory implements AuthenticateByLoginPasswordStrategyInterface
{
    /**
     * @var AnyClassFactory
     */
    private $factory;

    public function __construct(AnyClassFactory $factory)
    {
        $this->factory = $factory;
    }

    public function authenticate(LoginInterface $login, Password $password): array
    {
        $class = $login->authenticateStrategyClass();
        $authenticateStrategy = $this->factory->create($class);

        return $authenticateStrategy->authenticate($login, $password);
    }
}