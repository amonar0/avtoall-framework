<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use AutoAlliance\Domain\Authentication\Login;
use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use AutoAlliance\Domain\PhoneNumber;
use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\Technology\Helper\Assert;
use AutoAlliance\Technology\Repository\UserIdentityRepository;

final class AuthenticateByPhoneStrategy implements AuthenticateByLoginPasswordStrategyInterface
{
    /**
     * @var AuthenticateByEmailStrategy
     */
    private $emailStrategy;
    /**
     * @var UserIdentityRepository
     */
    private $userIdentityRepository;
    /**
     * @var AuthenticateMessageCreator
     */
    private $messageCreator;

    public function __construct(
        AuthenticateByEmailStrategy $emailStrategy,
        UserIdentityRepository $userIdentityRepository,
        AuthenticateMessageCreator $messageCreator
    ) {
        $this->emailStrategy = $emailStrategy;
        $this->userIdentityRepository = $userIdentityRepository;
        $this->messageCreator = $messageCreator;
    }

    public function authenticate(/*PhoneNumber*/
        LoginInterface $phone,
        Password $password
    ): array {
        Assert::instancesOf(PhoneNumber::class, $phone);

        $email = $this->userIdentityRepository->byPhone($phone)->find()
            ->email();

        list ($authenticated, , $identity) = $this->emailStrategy->authenticate($email, $password);
        $message = $this->messageCreator->createMessage($identity->errorCode, 'Неверный телефон');

        return [$authenticated, $message, $identity];
    }
}