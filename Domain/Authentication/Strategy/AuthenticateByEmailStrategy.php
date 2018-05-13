<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use AutoAlliance\Technology\Email\Email;
use AutoAlliance\Technology\Helper\Assert;
use UserIdentity; //@uses

class AuthenticateByEmailStrategy implements AuthenticateByLoginPasswordStrategyInterface
{
    /**
     * @var AuthenticateMessageCreator
     */
    private $messageCreator;

    public function __construct(AuthenticateMessageCreator $messageCreator)
    {
        $this->messageCreator = $messageCreator;
    }

    public function authenticate(/*Email*/
        LoginInterface $email,
        Password $password
    ): array {
        Assert::instancesOf(Email::class, $email);

        $identity = new UserIdentity((string)$email, (string)$password);
        $authenticated = $identity->authenticate();
        $message = $this->messageCreator->createMessage($identity->errorCode,
            'Неверная почта');

        return [$authenticated, $message, $identity];
    }
}