<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use IUserIdentity; //@uses Yii

//@test понять, как хорошо протестировать авторизацию и сообщения ошибок, и сделать это
interface AuthenticateByLoginPasswordStrategyInterface
{
    public function authenticate(LoginInterface $email, Password $password): array;
    /*[bool $authenticated, string $message, IUserIdentity $userIdentity]*/
}