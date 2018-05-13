<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use AutoAlliance\Domain\Authentication\Login;
use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use AutoAlliance\Technology\Helper\Assert;
use UserIdentity; //@uses

class AuthenticateByLoginStrategy implements AuthenticateByLoginPasswordStrategyInterface
{
    /**
     * @var AuthenticateMessageCreator
     */
    private $messageCreator;

    public function __construct(AuthenticateMessageCreator $messageCreator)
    {
        $this->messageCreator = $messageCreator;
    }

    public function authenticate(/*Login*/
        LoginInterface $login,
        Password $password
    ): array {
        Assert::instancesOf(Login::class, $login);

        $identity = new UserIdentity($login, $password);
        $authenticated = $identity->authenticate();
        $message = $this->messageCreator->createMessage($identity->errorCode);

        return [$authenticated, $message, $identity];
    }
}